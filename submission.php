<!doctype html>
<html class="no-js no-svg" lang="en">
<head>
  <meta charset="utf-8">
  <title>Submit a Web Accessibility Evaluation Tool</title>
  <meta name="viewport" content="width=device-width">
  <link href="css/wai-act.css" media="screen" rel="stylesheet" type="text/css">
  <script src="js/modernizr.min.js" type="text/javascript"></script>
  <style>
    fieldset {border:none; padding:0 0 0 .5em; border-left: .25em solid #ccc; margin-bottom: 2em;}
    fieldset legend {font-size: 1.5em; font-weight: bold;}
    fieldset > fieldset legend {font-size: 1.25em;}
    fieldset > fieldset > fieldset legend {font-size: 1em;}
  </style>
</head>
<body class="texts">
<?php
	date_default_timezone_set('UTC');
  $demo = true;
  $mailstatus = 'none';
  function create_form_cb_section($data) {
    $section  = '<fieldset id="fs-'.$data[variable].'">';
    $section .= '<legend>'.$data[title].'</legend>';
    $section .= '<h3 class="visuallyhidden" id="'.$data[variable].'">'.$data[title].'</h3>';
    $section .= '<ul class="form-block-mini radio">';

    foreach ($data['data'] as $key => $value) {
      $section .= '<li class="form-row"><span><input data-id="'.$data[variable].'_'.$key.'" id="'.$data[variable].'_'.md5($value).'" name="'.$data[variable].'[]" value="'.$key.'" type="'.$data[type].'"'.((isset($_POST[$data[variable]]) && in_array($key, $_POST[$data[variable]])) ? ' checked' : '').'> </span><label for="'.$data[variable].'_'.md5($value).'">'.$value.'</label></li>';
    }

    if($data[other]) {
      $section .= '<li class="form-row"><span></span><label for="'.$data[variable].'_other">Other: <input id="'.$data[variable].'_other" name="'.$data[variable].'[other]" type="text">'.$_POST[$data[variable]]['other'].'</label></li>';
    }

    $section .= '</ul>';
    $section .= '</fieldset>';

    echo $section;
  }

include_once("config.php");

function san($s) {
  return filter_var(trim($s), FILTER_SANITIZE_STRING);
}

function iter($input, $reference) {
  $reference_data = $reference['data'];
  $o = array();
  if (count($input)) {
    foreach ($input as $key => $value) {
      if ($key !== 'other') {
        $o[] = $reference_data[$value];
      } else {
      	$val = san($value);
        if ($val !== '') {
          $o[] = $val;
        }
      }
    }
  }
  return $o;
}


  if ($_POST) {

    if (trim($_POST['comment'])) { die("This may be spam."); }

   // var_dump($_POST);

    $data = (object) array();

    $data->title = san($_POST['title']);
    $data->creator = san($_POST['creator']);
    $data->location = san($_POST['location']);
    $data->release = san($_POST['release']);
    $data->version = san($_POST['version']);
    $data->description = san($_POST['description']);
    $data->a11yloc = san($_POST['location_a11yinfo']);
    if ($data->a11yloc != "") {
    	$data->a11yinfo = "Tools providing accessibility information";
    } else {
    	$data->a11yinfo = "";
    }
    $data->update = san(date('Y-m-d'));

    if ($data->title == "" || $data->creator == "" || $data->location == "" || $data->release == "" || san($_POST['name']) == "" || san($_POST['email']) == "") {
      $mailstatus = false;
    }

    $data->language = iter($_POST['language'], $language);
    $data->guideline = iter($_POST['guideline'], $guideline);
    $data->assists = iter($_POST['assists'], $assists);
    $data->automated = iter($_POST['automated'], $automated);
    # $data->repairs = iter($_POST['repairs'], $repairs);
    $data->technology = iter($_POST['technology'], $technology);
    $data->type = iter($_POST['tooltype'], $tooltype);
    $data->onlineservice = iter($_POST['onlineservice'], $onlineservice);
    $data->desktop = iter($_POST['desktop'], $desktopapp);
    $data->mobile = iter($_POST['mobile'], $mobileapp);
    $data->authoringtools = iter($_POST['authoringtools'], $authoringtools);
    $data->browsers = iter($_POST['browsers'], $browsers);
    $data->license = iter($_POST['license'], $license);

if ($mailstatus !== false) {

  function friendly_url($url) {
  // everything to lower and no spaces begin or end
  $url = strtolower(trim($url));

  //replace accent characters, depends your language is needed
  $url=replace_accents($url);

  // decode html maybe needed if there's html I normally don't use this
  $url = html_entity_decode($url,ENT_QUOTES);

  // adding - for spaces and union characters
  $find = array(' ', '&', '+',',');
  $url = str_replace ($find, '-', $url);

  //delete and replace rest of special chars
  $find = array('/[^a-z0-9-<>]/', '/[-]+/', '/<[^>]*>/');
  $repl = array('', '-', '');
  $url = preg_replace ($find, $repl, $url);

  //return the friendly url
  return $url;
}


function replace_accents($var){ //replace for accents catalan spanish and more
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ');
    $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
    $var= str_replace($a, $b,$var);
    return $var;
}


$multipartSep = '-----'.md5(time()).'-----';

/* create e-mail paramters */

$recipient = san($_POST['email']);

if ($demo == true) {
  $cc = "";
} else {
  $cc = "Cc: public-wai-ert-tools@w3.org\r\n";
}

$subject = "[eval-tools] Entry for \"".$data->title."\"";
$headers = "From: shadi+cgi@w3.org\r\n".
           "Reply-To: shadi@w3.org\r\n".
           $cc.
           "X-Mailer: Automated Script\r\n".
           "Content-Type: multipart/mixed; boundary=\"$multipartSep\"";

 $attachment = chunk_split(base64_encode(json_encode($data)));


$o = "";
foreach($data as $key => $value) {
		$o .= "\r\n$key:\r\n";
    if (is_array($value)) {
	$i = 0;
    	foreach($value as $v) {
		if ($i >= (count($value)-$others[$key])) {
			$o .= "\tother: $v\r\n";
		} else {
			$o .= "\t$v\r\n";
		}
		$i++;
    	}
    } else {
    	$o .= "\t$value\r\n";
    }
}

$o .= "\r\ncomment:\r\n";
$o .= "\t".san($_POST['cmnt'])."\r\n";

if ($_POST['role']=='vendor') {

$message = <<<EOV
(This is an automatically generated message)

Thank you for providing information on “[title]”.

We will review this information and might contact you if we have any questions about it. It can take up to 10 business days until the information is published on the WAI website.

Note: You can update the information about your tool at any time using the same submission form that you used to provide this information. Attached is the data file from your submission, which you can use to load the information into the submission form to avoid re-typing it.

Below is the information that you provided:


EOV;

} else {

$message = <<<EOV
(This is an automatically generated message)

Thank you for providing information on “[title]”. We will review this information and try to contact the corresponding tool vendor. We can only publish information that is provided with consent of the vendors.

Below is the information that you provided:


EOV;

}

$message = str_replace('[title]', $data->title, $message);

$endmessage = <<<EOV


This email is also copied to a publicly archived mailing list: http://lists.w3.org/Archives/Public/public-wai-ert-tools/

Regards,
  Shadi
EOV;

$body = "--$multipartSep\r\n"
        . "Content-Type: text/plain; charset=UTF-8; format=flowed\r\n"
        . "Content-Transfer-Encoding: 7bit\r\n"
        . "\r\n"
        . $message.$o.$endmessage."\r\n"
     #   . json_encode($data)."\r\n"
        . "--$multipartSep\r\n"
        . "Content-Type: text/json\r\n"
        . "Content-Transfer-Encoding: base64\r\n"
        . "Content-Disposition: attachment; filename=\"".date('YmdHis').'-'.friendly_url($data->title).".json\"\r\n"
        . "\r\n"
        . "$attachment\r\n"
        . "--$multipartSep--";

/* send e-mail message */
$mailstatus = mail($recipient, $subject, $body, $headers);
  }
}

function mailstatus($none, $true, $false) {
  $mailstatus = $GLOBALS['mailstatus'];
  if ($mailstatus === true) {
      return $true;
    } elseif ($mailstatus === false) {
      return $false;
    } else {
      return $none;
    }
}

?>
  <header role="banner">
    <div class="w3c-wai-header">
      <a href="http://w3.org/"><img alt="W3C" width="90" src="img/w3c.png"></a>
      <a href="http://w3.org/WAI/" class="wai"><img alt="Web Accessibility Initiative" src="img/wai.png"></a>
    </div>
  </header>
  <main class="with-side-menu" role="main">
    <h1 class="page-title">
      <a href="../">Web Accessibility Evaluation Tools List</a>
    </h1>
    <p><a href="../">Back to the Evaluation Tools List</a></p>
    <h2><?php echo mailstatus('', '<mark>[Submitted]</mark> ', '<mark>[Errors]</mark> ') ?>Submit Information about a Web Accessibility Evaluation Tool</h2>
    <aside class="editbox">
			<p>Want to edit an entry? Upload the data file that was sent to you here:</p>
			<button class="btn" id="uploadbutton">Upload</button>
    	<input type="file" id="file" name="file">
    	<output id="list" aria-live="assertive"></output>
    </detail>
    </aside>
    <p>This form allows you to submit information about web accessibility evaluation tools. Please fill out the form you’re a tool vendor or developer and want to add or update information on your tool. You can also use this form if you’re a tool user, or have seen or heard of a tool that is currently not listed.</p>
    <p><strong>Please note:</strong></p>
    <ul>
    	<li>There is no obligation to fill out all information especially if you are not a tool vendor or developer.</li>
    	<li>Information sent using this form will be reviewed before publishing, it can take up to 10 business days until the information is published.</li>
    	<li>Some submitted information may be adapted to fit into the categories in the Evaluation Tools List.</li>
    	<li>If information is submitted by a user of a tool, we may follow up with the tool’s vendor before the tool is listed.</li>
    	<li>All information you provide via this form will be publicly archived on the <a href="http://lists.w3.org/Archives/Public/public-wai-ert-tools/"><abbr title="World Wide Web Consortium">W3C</abbr>/<abbr title="Web Accessibility Initiative">WAI</abbr> List of Web Accessibility Evaluation Tools mailing list</a>.</li>
    </ul>
    <p>Contact <a href="mailto:shadi@w3.org">Shadi Abou-Zahra (shadi@w3.org)</a> if you have questions or comments.</p>

  <?php
  if ($mailstatus === false) {
      $msg = array();
      if($data->title == "") {
        $msg[] = '<label for="title">Tool name is a required field.</label>';
      }
      if($data->creator == "") {
        $msg[] = '<label for="creator">Vendor name is a required field.</label>';
      }
      if($data->location == "") {
        $msg[] = '<label for="location">Web address is a required field.</label>';
      }
      if($data->release == "") {
        $msg[] = '<label for="release">Release date is a required field.</label>';
      }
      if(san($_POST['name']) == "") {
        $msg[] = '<label for="name">Name is a required field.</label>';
      }
      if(san($_POST['email']) == "") {
        $msg[] = '<label for="email">Email is a required field.</label>';
      }
      if($data->description == "") {
        $msg[] = '<label for="description">Tool description is a required field.</label>';
      }

      if (count($msg)) {
        echo '<ul><li>';
        echo implode('</li><li>', $msg);
        echo '</li></ul>';
      }

  }
  ?>

  <div id="hForm">
  <form name="submission" id="submission" method="post" action="submission.php">
  <fieldset>
    <legend><span>Information about you</span></legend>
    <h2 class="visuallyhidden">Information about you</h2>
    <div class="form-block-mini">
      <div class="form-row required"><label for="name">Your Name</label><span><input name="name" id="name" type="text" value="<?php echo san($_POST[name]) ?>" required  aria-required="true"></span></div>
      <div class="form-row required"><label for="email">Your E-Mail</label><span><input name="email" id="email" type="email" value="<?php echo san($_POST[email]) ?>" required aria-required="true"></span></div>
    </div>
    <fieldset class="border-less"><legend><span>Your Role</span></legend>
      <ul class="form-block-mini">
        <li class="form-row radio"><span><input name="role" id="vendor" value="vendor" type="radio"></span><label for="vendor">Tool developer, vendor, or owner</label></li>
        <li class="form-row radio"><span><input name="role" id="user" value="user" type="radio"></span><label for="user"> Tool user or product customer</label></li>
        <li class="form-row radio"><span><input name="role" id="other" value="vendor" type="radio"></span><label for="other"> Other (heard of the tool, etc)</label></li>
      </ul>
    </fieldset>
  </fieldset>

    <fieldset>
      <legend><span>Tool identification</span></legend>
      <h3 class="visuallyhidden">Tool identification</h3>
      <ul class="form-block-mini">
        <li class="form-row required"><label for="title">Tool name</label><span><input name="title" id="title" type="text"  value="<?php echo $data->title ?>" required aria-required="true"></span></li>
        <li class="form-row required"><label for="creator">Vendor name</label><span><input name="creator" id="creator" type="text" value="<?php echo $data->creator ?>" required aria-required="true"></span></li>
        <li class="form-row required"><label for="description">Tool Description (max.: 300 chars)</label><span><textarea name="description" id="description" cols="60" rows="10" maxlength="300" required aria-required="true" aria-describedby="descdesc"><?php echo $data->description ?></textarea><br><span id="descdesc">Please enter only plain text, no HTML is allowed. URIs won’t be linked.</span></span></li>
        <li class="form-row required"><label for="location">Web Address (<abbr title="Universal Resource Identifier">URI</abbr>)</label><span><input name="location" id="location" type="url" value="<?php echo $data->location ?>" required aria-required="true"></span></li>
        <li class="form-row required"><label for="release">Release date (format: YYYY-MM-DD)</label><span><input name="release" id="release" type="date" value="<?php echo $data->release ?>" required aria-required="true"></span></li>
        <li class="form-row"><label for="version">Version Number</label><span><input name="version" id="version" type="text"></span></li>
      </ul><br>
      <ul class="form-block-mini">
      	<li class="form-row"><label for="location_a11yinfo">Tool Web address to information about the accessibility of the tool (<abbr title="Universal Resource Identifier">URI</abbr>)</label><span><input name="location_a11yinfo" id="location_a11yinfo" type="url" value="<?php echo $data->a11yloc ?>"></span></li>
      </ul>
      <div style="display:none" aria-hidden="true">
        <label for="comment">Comment (Don’t fill out this field)</label><span><textarea name="comment" id="comment" cols="60" rows="10" maxlength="300"></textarea></span>
      </div>
    </fieldset>

    <?php create_form_cb_section($language); ?>

    <?php create_form_cb_section($guideline); ?>

    <?php create_form_cb_section($assists); ?>

    <?php create_form_cb_section($automated); ?>

    <?php # create_form_cb_section($repair); ?>

    <?php create_form_cb_section($technology); ?>

		<div class="group">

	    <?php create_form_cb_section($tooltype); ?>

	    <?php create_form_cb_section($desktopapp); ?>

	    <?php create_form_cb_section($mobileapp); ?>

			<?php create_form_cb_section($browsers); ?>

	    <?php create_form_cb_section($authoringtools); ?>

	    <?php create_form_cb_section($onlineservice); ?>

    </div>

    <?php create_form_cb_section($license); ?>

  <p><button class="btn-primary" style="float:none;" name="send" id="send" type="submit">Send Information</button></p>

    </form>
  </div>

</main>
<footer role="contentinfo">
  <h2 class="visuallyhidden">Document Information</h2>
  <p><strong>Status:</strong> Draft, approved by <a href="/WAI/EO/">EOWG</a>, October 2014</p>
  <p>Developers/Editors: <a href="http://www.w3.org/People/yatil/">Eric Eggert</a> and <a href="/People/shadi/">Shadi Abou-Zahra</a>. User Interface developed with the Education and Outreach Working Group (<a href="/WAI/EO/"><abbr title="Education and Outreach Working Group">EOWG</abbr></a>). Database maintained by the Evaluation and Repair Tools Working Group (<a href="/WAI/ER/"><abbr title="Evaluation and Repair Tools">ERT</abbr> <abbr title="Working Group">WG</abbr></a>). <a href="acknowledgements">Acknowledgements</a> lists contributors and previous editors. Developed with support from the <a href="/WAI/TIES/">WAI-TIES Project</a> in 2006, and updated with support from the <a href="/WAI/ACT/">WAI-ACT Project</a> in 2014.</p>
  <p>See <a href="#disclaimer">Important Disclaimer above</a>.</p>
  <div class="footer-nav">
		<p>[<a href="http://www.w3.org/WAI/sitemap.html">WAI Site Map</a>] [<a href="http://www.w3.org/WAI/sitehelp.html">Help with WAI Website</a>] [<a href="http://www.w3.org/WAI/search.php">Search</a>] [<a href="/WAI/contacts">Contacting WAI</a>]<br /><strong>Feedback welcome to <a href="mailto:wai-eo-editors@w3.org">wai-eo-editors@w3.org</a></strong> (a publicly archived list) or <a href="mailto:wai@w3.org">wai@w3.org</a> (a WAI staff-only list).</p>
	</div> <!-- end footer-nav -->
  <div class="copyright">
		<p>Copyright &#xA9; 2014 W3C <sup>&#xAE;</sup> (<a href="http://www.csail.mit.edu/"><abbr title="Massachusetts Institute of Technology">MIT</abbr></a>, <a href="http://www.ercim.eu/"><abbr title="European Research Consortium for Informatics and Mathematics">ERCIM</abbr></a>, <a href="http://www.keio.ac.jp/">Keio</a>, <a href="http://ev.buaa.edu.cn/">Beihang</a>) <a href="/Consortium/Legal/ipr-notice">Usage policies apply</a>.</p>
	</div><!-- end copyright -->
</footer>
<script src="js/main.js"></script>
<script>

/*
 * jQuery MD5 Plugin 1.2.1
 * https://github.com/blueimp/jQuery-MD5
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://creativecommons.org/licenses/MIT/
 *
 * Based on
 * A JavaScript implementation of the RSA Data Security, Inc. MD5 Message
 * Digest Algorithm, as defined in RFC 1321.
 * Version 2.2 Copyright (C) Paul Johnston 1999 - 2009
 * Other contributors: Greg Holt, Andrew Kepert, Ydnar, Lostinet
 * Distributed under the BSD License
 * See http://pajhome.org.uk/crypt/md5 for more info.
 */

/*jslint bitwise: true */
/*global unescape, jQuery */

(function ($) {
    'use strict';

    /*
    * Add integers, wrapping at 2^32. This uses 16-bit operations internally
    * to work around bugs in some JS interpreters.
    */
    function safe_add(x, y) {
        var lsw = (x & 0xFFFF) + (y & 0xFFFF),
            msw = (x >> 16) + (y >> 16) + (lsw >> 16);
        return (msw << 16) | (lsw & 0xFFFF);
    }

    /*
    * Bitwise rotate a 32-bit number to the left.
    */
    function bit_rol(num, cnt) {
        return (num << cnt) | (num >>> (32 - cnt));
    }

    /*
    * These functions implement the four basic operations the algorithm uses.
    */
    function md5_cmn(q, a, b, x, s, t) {
        return safe_add(bit_rol(safe_add(safe_add(a, q), safe_add(x, t)), s), b);
    }
    function md5_ff(a, b, c, d, x, s, t) {
        return md5_cmn((b & c) | ((~b) & d), a, b, x, s, t);
    }
    function md5_gg(a, b, c, d, x, s, t) {
        return md5_cmn((b & d) | (c & (~d)), a, b, x, s, t);
    }
    function md5_hh(a, b, c, d, x, s, t) {
        return md5_cmn(b ^ c ^ d, a, b, x, s, t);
    }
    function md5_ii(a, b, c, d, x, s, t) {
        return md5_cmn(c ^ (b | (~d)), a, b, x, s, t);
    }

    /*
    * Calculate the MD5 of an array of little-endian words, and a bit length.
    */
    function binl_md5(x, len) {
        /* append padding */
        x[len >> 5] |= 0x80 << ((len) % 32);
        x[(((len + 64) >>> 9) << 4) + 14] = len;

        var i, olda, oldb, oldc, oldd,
            a =  1732584193,
            b = -271733879,
            c = -1732584194,
            d =  271733878;

        for (i = 0; i < x.length; i += 16) {
            olda = a;
            oldb = b;
            oldc = c;
            oldd = d;

            a = md5_ff(a, b, c, d, x[i],       7, -680876936);
            d = md5_ff(d, a, b, c, x[i +  1], 12, -389564586);
            c = md5_ff(c, d, a, b, x[i +  2], 17,  606105819);
            b = md5_ff(b, c, d, a, x[i +  3], 22, -1044525330);
            a = md5_ff(a, b, c, d, x[i +  4],  7, -176418897);
            d = md5_ff(d, a, b, c, x[i +  5], 12,  1200080426);
            c = md5_ff(c, d, a, b, x[i +  6], 17, -1473231341);
            b = md5_ff(b, c, d, a, x[i +  7], 22, -45705983);
            a = md5_ff(a, b, c, d, x[i +  8],  7,  1770035416);
            d = md5_ff(d, a, b, c, x[i +  9], 12, -1958414417);
            c = md5_ff(c, d, a, b, x[i + 10], 17, -42063);
            b = md5_ff(b, c, d, a, x[i + 11], 22, -1990404162);
            a = md5_ff(a, b, c, d, x[i + 12],  7,  1804603682);
            d = md5_ff(d, a, b, c, x[i + 13], 12, -40341101);
            c = md5_ff(c, d, a, b, x[i + 14], 17, -1502002290);
            b = md5_ff(b, c, d, a, x[i + 15], 22,  1236535329);

            a = md5_gg(a, b, c, d, x[i +  1],  5, -165796510);
            d = md5_gg(d, a, b, c, x[i +  6],  9, -1069501632);
            c = md5_gg(c, d, a, b, x[i + 11], 14,  643717713);
            b = md5_gg(b, c, d, a, x[i],      20, -373897302);
            a = md5_gg(a, b, c, d, x[i +  5],  5, -701558691);
            d = md5_gg(d, a, b, c, x[i + 10],  9,  38016083);
            c = md5_gg(c, d, a, b, x[i + 15], 14, -660478335);
            b = md5_gg(b, c, d, a, x[i +  4], 20, -405537848);
            a = md5_gg(a, b, c, d, x[i +  9],  5,  568446438);
            d = md5_gg(d, a, b, c, x[i + 14],  9, -1019803690);
            c = md5_gg(c, d, a, b, x[i +  3], 14, -187363961);
            b = md5_gg(b, c, d, a, x[i +  8], 20,  1163531501);
            a = md5_gg(a, b, c, d, x[i + 13],  5, -1444681467);
            d = md5_gg(d, a, b, c, x[i +  2],  9, -51403784);
            c = md5_gg(c, d, a, b, x[i +  7], 14,  1735328473);
            b = md5_gg(b, c, d, a, x[i + 12], 20, -1926607734);

            a = md5_hh(a, b, c, d, x[i +  5],  4, -378558);
            d = md5_hh(d, a, b, c, x[i +  8], 11, -2022574463);
            c = md5_hh(c, d, a, b, x[i + 11], 16,  1839030562);
            b = md5_hh(b, c, d, a, x[i + 14], 23, -35309556);
            a = md5_hh(a, b, c, d, x[i +  1],  4, -1530992060);
            d = md5_hh(d, a, b, c, x[i +  4], 11,  1272893353);
            c = md5_hh(c, d, a, b, x[i +  7], 16, -155497632);
            b = md5_hh(b, c, d, a, x[i + 10], 23, -1094730640);
            a = md5_hh(a, b, c, d, x[i + 13],  4,  681279174);
            d = md5_hh(d, a, b, c, x[i],      11, -358537222);
            c = md5_hh(c, d, a, b, x[i +  3], 16, -722521979);
            b = md5_hh(b, c, d, a, x[i +  6], 23,  76029189);
            a = md5_hh(a, b, c, d, x[i +  9],  4, -640364487);
            d = md5_hh(d, a, b, c, x[i + 12], 11, -421815835);
            c = md5_hh(c, d, a, b, x[i + 15], 16,  530742520);
            b = md5_hh(b, c, d, a, x[i +  2], 23, -995338651);

            a = md5_ii(a, b, c, d, x[i],       6, -198630844);
            d = md5_ii(d, a, b, c, x[i +  7], 10,  1126891415);
            c = md5_ii(c, d, a, b, x[i + 14], 15, -1416354905);
            b = md5_ii(b, c, d, a, x[i +  5], 21, -57434055);
            a = md5_ii(a, b, c, d, x[i + 12],  6,  1700485571);
            d = md5_ii(d, a, b, c, x[i +  3], 10, -1894986606);
            c = md5_ii(c, d, a, b, x[i + 10], 15, -1051523);
            b = md5_ii(b, c, d, a, x[i +  1], 21, -2054922799);
            a = md5_ii(a, b, c, d, x[i +  8],  6,  1873313359);
            d = md5_ii(d, a, b, c, x[i + 15], 10, -30611744);
            c = md5_ii(c, d, a, b, x[i +  6], 15, -1560198380);
            b = md5_ii(b, c, d, a, x[i + 13], 21,  1309151649);
            a = md5_ii(a, b, c, d, x[i +  4],  6, -145523070);
            d = md5_ii(d, a, b, c, x[i + 11], 10, -1120210379);
            c = md5_ii(c, d, a, b, x[i +  2], 15,  718787259);
            b = md5_ii(b, c, d, a, x[i +  9], 21, -343485551);

            a = safe_add(a, olda);
            b = safe_add(b, oldb);
            c = safe_add(c, oldc);
            d = safe_add(d, oldd);
        }
        return [a, b, c, d];
    }

    /*
    * Convert an array of little-endian words to a string
    */
    function binl2rstr(input) {
        var i,
            output = '';
        for (i = 0; i < input.length * 32; i += 8) {
            output += String.fromCharCode((input[i >> 5] >>> (i % 32)) & 0xFF);
        }
        return output;
    }

    /*
    * Convert a raw string to an array of little-endian words
    * Characters >255 have their high-byte silently ignored.
    */
    function rstr2binl(input) {
        var i,
            output = [];
        output[(input.length >> 2) - 1] = undefined;
        for (i = 0; i < output.length; i += 1) {
            output[i] = 0;
        }
        for (i = 0; i < input.length * 8; i += 8) {
            output[i >> 5] |= (input.charCodeAt(i / 8) & 0xFF) << (i % 32);
        }
        return output;
    }

    /*
    * Calculate the MD5 of a raw string
    */
    function rstr_md5(s) {
        return binl2rstr(binl_md5(rstr2binl(s), s.length * 8));
    }

    /*
    * Calculate the HMAC-MD5, of a key and some data (raw strings)
    */
    function rstr_hmac_md5(key, data) {
        var i,
            bkey = rstr2binl(key),
            ipad = [],
            opad = [],
            hash;
        ipad[15] = opad[15] = undefined;
        if (bkey.length > 16) {
            bkey = binl_md5(bkey, key.length * 8);
        }
        for (i = 0; i < 16; i += 1) {
            ipad[i] = bkey[i] ^ 0x36363636;
            opad[i] = bkey[i] ^ 0x5C5C5C5C;
        }
        hash = binl_md5(ipad.concat(rstr2binl(data)), 512 + data.length * 8);
        return binl2rstr(binl_md5(opad.concat(hash), 512 + 128));
    }

    /*
    * Convert a raw string to a hex string
    */
    function rstr2hex(input) {
        var hex_tab = '0123456789abcdef',
            output = '',
            x,
            i;
        for (i = 0; i < input.length; i += 1) {
            x = input.charCodeAt(i);
            output += hex_tab.charAt((x >>> 4) & 0x0F) +
                hex_tab.charAt(x & 0x0F);
        }
        return output;
    }

    /*
    * Encode a string as utf-8
    */
    function str2rstr_utf8(input) {
        return unescape(encodeURIComponent(input));
    }

    /*
    * Take string arguments and return either raw or hex encoded strings
    */
    function raw_md5(s) {
        return rstr_md5(str2rstr_utf8(s));
    }
    function hex_md5(s) {
        return rstr2hex(raw_md5(s));
    }
    function raw_hmac_md5(k, d) {
        return rstr_hmac_md5(str2rstr_utf8(k), str2rstr_utf8(d));
    }
    function hex_hmac_md5(k, d) {
        return rstr2hex(raw_hmac_md5(k, d));
    }

    $.md5 = function (string, key, raw) {
        if (!key) {
            if (!raw) {
                return hex_md5(string);
            } else {
                return raw_md5(string);
            }
        }
        if (!raw) {
            return hex_hmac_md5(key, string);
        } else {
            return raw_hmac_md5(key, string);
        }
    };

}(typeof jQuery === 'function' ? jQuery : this));

$(document).ready(function(){
	$('#fs-tooltype input[type="checkbox"]').on('change', function(e) {
		var theid = $(this).attr('data-id').replace(/tooltype_/,'');
		switch (theid) {
			case 'cli':
			break;
			case 'browserplugin':
				$('#fs-browsers').toggle();
			break;
			case 'atplugin':
				$('#fs-authoringtools').toggle();
			break;
			case 'online':
				$('#fs-onlineservice').toggle();
			break;
			default:
				$('#fs-' + theid).toggle();
			break;
		}
	});

	$('#fs-desktop,#fs-mobile,#fs-authoringtools,#fs-browsers,#fs-onlineservice').hide();

	if (window.File && window.FileReader && window.FileList && window.Blob) {

		function clearAll() {
			$('input').each(function(){
				var el = $(this);
				if ((el.attr('type') == 'checkbox' ) || (el.attr('type') == 'radio' )) {
					el.removeAttr('checked');
				} else {
					el.val('');
				}
			});
		}

		function handleFileSelect(evt) {

			var files = evt.target.files; // FileList object

    // files is a FileList of File objects. List some properties.
    var output = [];
    for (var i = 0, f; f = files[i]; i++) {

    var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function(theFile) {
        return function(e) {
        clearAll();
        // Render thumbnail.
        JsonObj = JSON.parse(e.target.result);
        var textfields = ['creator', 'description', 'location', 'release', 'title', 'version', 'a11yloc'];


        for (var key in JsonObj) {
        	if ($.inArray(key, textfields) > -1) {
        		if (key=="a11yloc") {
        			$('#location_a11yinfo').val(JsonObj[key]);
        		} else {
							$('#' + key).val(JsonObj[key]);
						}
        	} else {

        		if(key=="type") {var repkey = 'tooltype';}

						var oel = $('#' + key + '_other');
						var oval = oel.val();
						if (Array.isArray(JsonObj[key])) {
							for (var i = JsonObj[key].length - 1; i >= 0; i--) {
								var elem = $('#' + ((repkey) ? repkey : key) + '_' + $.md5(JsonObj[key][i]));

								if(elem.length==0) {
									if (oval=="") {
										oval = JsonObj[key][i];
										oel.val(oval);
									} else {
										oval = oval + ', ' + JsonObj[key][i];
										oel.val(oval);
									}
								} else {
									elem.attr('checked', 'checked').change();
								}
							}
						} else {
							$('#' + key + '_' + $.md5(JsonObj[key])).attr('checked', 'checked').change();
						}
					}
				}
         return false;
        };
      })(f);

     reader.readAsText(files[0]);

      output = 'Data from file <strong>' + escape(f.name) + '</strong> was successfully loaded.';
    }
    document.getElementById('list').innerHTML = output;
  }

  document.getElementById('file').addEventListener('change', handleFileSelect, false);

  $('#uploadbutton').on('click', function(){
  	$('#file').click();
  });

	} else {
	  alert('The File APIs are not fully supported in this browser.');
	}

});
</script>
</body>
</html>
