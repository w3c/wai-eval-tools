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
      $section .= '<li class="form-row"><span><input id="'.$data[variable].'_'.$key.'" name="'.$data[variable].'[]" value="'.$key.'" type="'.$data[type].'"'.((isset($_POST[$data[variable]]) && in_array($key, $_POST[$data[variable]])) ? ' checked' : '').'> </span><label for="'.$data[variable].'_'.$key.'">'.$value.'</label></li>';
    }

    if($data[other]) {
      $section .= '<li class="form-row"><span></span><label for="'.$data[variable].'_other">Other: <input id="'.$data[variable].'_other" name="'.$data[variable].'[other]" type="text">'.$_POST[$data[variable]]['other'].'</label></li>';
    }

    $section .= '</ul>';
    $section .= '</fieldset>';

    echo $section;
  }

$language = array(
  title => "Tool languages:",
  data => array(
    "pt-br" => 'Brazilian Portuguese (<span lang="pt-br">Português Brasileiro</span>)',
    "bg" => 'Bulgarian (<span lang="bg">Български</span>)',
    "zh-hans" => 'Chinese, Simplified (<span lang="zh-hans">简体中文</span>)',
    "zh-hant" => 'Chinese, Traditional (<span lang="zh-hant">繁體中文</span>)',
    "cs" => 'Czech (<span lang="cs">Česky</span>)',
    "da" => 'Danish (<span lang="da">Dansk</span>)',
    "nl" => 'Dutch (<span lang="nl">Nederlands</span>)',
    "en" => 'English',
    "fi" => 'Finnish (<span lang="fi">Suomi</span>)',
    "fr" => 'French (<span lang="fr">Français</span>)',
    "gl" => 'Galician (<span lang="gl">Galego</span>)',
    "de" => 'German (<span lang="de">Deutsch</span>)',
    "it" => 'Italian (<span lang="it">Italiano</span>)',
    "ja" => 'Japanese (<span lang="ja">日本語</span>)',
    "ko" => 'Korean (<span lang="ko">한국어</span>)',
    "pl" => 'Polish (<span lang="pl">Polski</span>)',
    "pt" => 'Portuguese (<span lang="pt">Português</span>)',
    "ro" => 'Romanian (<span lang="ro">Română</span>)',
    "sr" => 'Serbian (<span lang="sr">Српски</span>)',
    "es" => 'Spanish (<span lang="es">Castellano</span>)'
  ),
  other => true,
  variable => 'language',
  type => 'checkbox'
);

$guideline = array(
  title => "Select Guidelines that can be checked using this tool:",
  data => array(
    "wcag20" => '<strong><abbr title="Web Content Accessibility Guidelines">WCAG</abbr> 2.0 — <abbr title="World Wide Web Consortium">W3C</abbr> Web Content Accessibility Guidelines 2.0</strong>',
    "wcag10" => '<abbr title="Web Content Accessibility Guidelines">WCAG</abbr> — <abbr title="World Wide Web Consortium">W3C</abbr> Web Content Accessibility Guidelines 1.0',
    "section508" => 'Section 508, <abbr title="United States">US</abbr> federal procurement standard',
    "jis" => '<abbr title="Japanese Industry Standard">JIS</abbr>, Japanese industry standard',
    "stanca" => 'Stanca Act, Italian accessibility legislation',
    "bitv20" => '<abbr lang="de" title="Barrierefreie Informationstechnik-Verordnung 2.0">BITV 2.0</abbr>, German government standard',
    "bitv10" => '<abbr lang="de" title="Barrierefreie Informationstechnik-Verordnung">BITV</abbr>, German government standard',
    "rgaa" => '<abbr lang="fr" title="Référentiel Général d’Accessibilité pour les Administrations">RGAA</abbr>, French government standard'
  ),
  other => true,
  variable => 'guideline',
  type => 'checkbox'
);

$assists = array(
  title => "Assists evaluations by:",
  data => array(
    "report" => 'Generating reports of evaluation results',
    "wizard" => 'Providing step-by-step evaluation guidance',
    "inpage" => 'Displaying information within web pages',
    "transformation" => 'Modifying the presentation of web pages'
  ),
  other => false,
  variable => 'assists',
  type => 'checkbox'
);

$automated = array(
  title => "Supports automated checking of:",
  data => array(
    "automated" => 'Single web pages',
    "crawl" => 'Groups of web pages or web sites',
    "authenticated" => 'Restricted or password protected pages'
  ),
  other => false,
  variable => 'automated',
  type => 'checkbox'
);

$repair = array(
  title => "Provides these repair options:",
  data => array(
    "repair" => 'Changes the code of the web pages',
    "caption" => 'Helps caption audio or video content',
    "pdf2html" => 'Converts <abbr title="Portable Document Format">PDF</abbr> files into accessible <abbr title="Hypertext Markup Language">HTML</abbr>',
    "word2html" => 'Converts Word files into accessible <abbr title="Hypertext Markup Language">HTML</abbr>',
    "excel2html" => 'Converts Excel files into accessible <abbr title="Hypertext Markup Language">HTML</abbr>',
    "ppt2html" => 'Converts PowerPoint files into accessible <abbr title="Hypertext Markup Language">HTML</abbr>'
  ),
  other => true,
  variable => 'repair',
  type => 'checkbox'
);

$technology = array(
  title => "Checks the accessibility of:",
  data => array(
    "css" => '<abbr title="Cascading Style Sheets">CSS</abbr>',
    "html" => '<abbr title="Hypertext Markup Language">HTML</abbr>',
    "xhtml" => '<abbr title="Extensible Hypertext Markup Language">XHTML</abbr>',
    "svg" => '<abbr title="Scalabale Vector Grpahics">SVG</abbr>',
    "pdf" => '<abbr title="Portable Document Format">PDF</abbr> documents',
    "images" => 'Images',
    "smil" => '<abbr title="Synchronized Multimedia Integration Language">SMIL</abbr>',
    "office" => 'Microsoft Office documents'
  ),
  other => true,
  variable => 'technology',
  type => 'checkbox'
);

$onlineservice = array(
  title => "Online service:",
  data => array(
    "online" => 'Online checker',
    "hosted" => 'Hosted service',
    "server" => 'Server installation'
  ),
  other => false,
  variable => 'onlineservice',
  type => 'checkbox'
);

$desktopapp = array(
  title => "Desktop application for:",
  data => array(
    "windows" => 'Microsoft Windows',
    "osx" => 'Apple (Mac) OS X',
    "linux" => 'Linux',
    "solaris" => 'Solaris',
    "bsd" => '<abbr title="Berkley Shell Distribution">BSD</abbr> Unix'
  ),
  other => true,
  variable => 'desktop',
  type => 'checkbox'
);

$mobileapp = array(
  title => "Mobile application for:",
  data => array(
    "ios" => 'Apple iOS',
    "android" => 'Android',
    "windows" => 'Microsoft Windows Phone',
    "blackberry" => 'Blackberry',
    "firefox" => 'Firefox OS'
  ),
  other => true,
  variable => 'mobile',
  type => 'checkbox'
);

$authoringtools = array(
  title => "Authoring tool plugin for:",
  data => array(
    "dreamweaver" => 'Adobe Dreamweaver',
    "flash" => 'Adobe Flash',
    "photoshop" => 'Adobe Photoshop',
    "edge" => 'Adobe Edge',
    "eclipse" => "Eclipse",
    "expressionweb" => 'Microsoft Expression Web',
    "visualstudio" => 'Microsoft Visual Studio',
    "sublimetext" => 'Sublime Text'
  ),
  other => true,
  variable => 'authoringtools',
  type => 'checkbox'
);

$browsers = array(
  title => "Browser plugin for:",
  data => array(
    "chrome" => 'Chrome',
    "firefox" => 'Firefox',
    "oldie" => 'Internet Explorer &le; 8',
    "ie" => 'Internet Explorer &ge; 9',
    "oldopera" => 'Opera &le; 12',
    "opera" => 'Opera &ge; 15',
    "safari" => 'Safari'
  ),
  other => true,
  variable => 'browsers',
  type => 'checkbox'
);

$license = array(
  title => 'License type:',
  data => array(
    "free" => 'Free Software',
    "open" => 'Open Source',
    "trial" => 'Trial or Demo',
    "commercial" => 'Commercial',
    "enterprise" => 'Enterprise'
  ),
  other => false,
  variable => 'license',
  type => 'checkbox'
);

$tooltype = array(
  title => 'Type of tool:',
  data => array(
    "desktop" => 'Desktop application',
    "mobile" => 'Mobile application',
    "cli" => 'Command line tool',
    "browserplugin" => 'Browser plugin',
    "atplugin" => 'Authoring tool plugin',
    "online" => 'Online tool'
  ),
  other => false,
  variable => 'tooltype',
  type => 'checkbox'
);

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
if ($demo == true) {
  $recipient = "ee@w3.org";//, shadi@w3.org";
} else {
  $recipient = "public-wai-ert-tools@w3.org";
}
$subject = "[eval-tools] Entry for \"".$data->title."\"";
$headers = "From: shadi+cgi@w3.org\r\nReply-To: ".san($_POST['email'])."\r\nX-Mailer: Automated Script\r\nContent-Type: multipart/mixed; boundary=\"$multipartSep\"";

 $attachment = chunk_split(base64_encode(json_encode($data)));


$o = "";
foreach($data as $key => $value) {
    $o .= "\r\n$key\r\n";
    if (is_array($value)) {
	foreach($value as $v) {
		$o .= "\t$v\r\n";
	}
    } else {
	$o .= "\t$value\r\n";
    }
}

$message = "Name: ".san($_POST['name'])." (".san($_POST['role']).") <".san($_POST['email']).">\r\n\r\n\r\n";
$body = "--$multipartSep\r\n"
        . "Content-Type: text/plain; charset=ISO-8859-1; format=flowed\r\n"
        . "Content-Transfer-Encoding: 7bit\r\n"
        . "\r\n"
        . $message.$o."\r\n"
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
    <p>This form allows you to submit information about web accessibility evaluation tools. Please fill out the form you’re a tool vendor or developer and want to add or update information on your tool. You can also use this form if you’re a tool user, or have seen or heard of a tool that is currently not listed.</p>
    <p><strong>Please note:</strong></p>
    <ul>
    	<li>There is no obligation to fill out all information especially if you are not a tool vendor or developer.</li>
    	<li>Information sent using this form will be reviewed before publishing, it usually takes around 10 business days until a tool gets published.</li>
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
      <div class="form-row required"><label for="name">Name</label><span><input name="name" id="name" type="text" value="<?php echo san($_POST[name]) ?>" required  aria-required="true"></span></div>
      <div class="form-row required"><label for="email">E-Mail</label><span><input name="email" id="email" type="email" value="<?php echo san($_POST[email]) ?>" required aria-required="true"></span></div>
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
        <li class="form-row"><label for="location_a11yinfo">Tool Accessibility Information Web Address (<abbr title="Universal Resource Identifier">URI</abbr>)</label><span><input name="location_a11yinfo" id="location_a11yinfo" type="url" value="<?php echo $data->a11yloc ?>"></span></li>
        <li class="form-row required"><label for="release">Release date (format: YYYY-MM-DD)</label><span><input name="release" id="release" type="date" value="<?php echo $data->release ?>" required aria-required="true"></span></li>
        <li class="form-row"><label for="version">Version Number</label><span><input name="version" id="version" type="text"></span></li>
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
	$('#fs-tooltype input[type="checkbox"]').on('change', function(e) {
		var theid = $(this).attr('id').replace(/tooltype_/,'')
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

	var hidefieldsets = document.querySelectorAll('#fs-desktop,#fs-mobile,#fs-authoringtools,#fs-browsers,#fs-onlineservice');
	Array.prototype.forEach.call(hidefieldsets, function(el, i){
		el.style.display = "none";
	});
</script>
</body>
</html>
