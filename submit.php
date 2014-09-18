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
  function create_form_cb_section($data) {
    $section  = "<fieldset>";
    $section .= '<legend>'.$data[title].'</legend>';
    $section .= '<h3 class="visuallyhidden" id="'.$data[variable].'">'.$data[title].'</h3>';
    $section .= '<ul class="form-block radio">';

    foreach ($data['data'] as $key => $value) {
      $section .= '<li class="form-row"><span><input id="'.$key.'" name="'.$data[variable].'[]" value="'.$key.'" type="'.$data[type].'"> </span><label for="'.$key.'">'.$value.'</label></li>';
    }

    if($data[other]) {
      $section .= '<li class="form-row"><span></span><label for="'.$data[variable].'_other">Other: <input id="'.$data[variable].'_other" name="'.$data[variable].'[other]" type="text"></label></li>';
    }

    $section .= '</ul>';
    $section .= '</fieldset>';

    echo $section;
  }

$language = [
  title => "Tool language",
  data => [
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
  ],
  other => true,
  variable => 'language',
  type => 'checkbox'
];

$guideline = [
  title => "Checks for these Guidelines",
  data => [
    "wcag20" => '<strong><acronym title="Web Content Accessibility Guidelines">WCAG</acronym> 2.0 — <acronym title="World Wide Web Consortium">W3C</acronym> Web Content Accessibility Guidelines 2.0</strong>',
    "wcag10" => '<acronym title="Web Content Accessibility Guidelines">WCAG</acronym>, <acronym title="World Wide Web Consortium">W3C</acronym> Web Content Accessibility Guidelines 1.0',
    "section508" => 'Section 508, <acronym title="United States">US</acronym> federal procurement standard',
    "jis" => '<acronym title="Japanese Industry Standard">JIS</acronym>, Japanese industry standard',
    "stanca" => 'Stanca Act, Italian accessibility legislation',
    "bitv20" => '<acronym lang="de" title="Barrierefreie Informationstechnik-Verordnung 2.0">BITV 2.0</acronym>, German government standard',
    "bitv10" => '<acronym lang="de" title="Barrierefreie Informationstechnik-Verordnung">BITV</acronym></span>, German government standard'
  ],
  other => true,
  variable => 'guideline',
  type => 'checkbox'
];

$assists = [
  title => "Assists evaluations by:",
  data => [
    "report" => 'Generating reports of evaluation results',
    "wizard" => 'Providing step-by-step evaluation guidance',
    "inpage" => 'Displaying information within Web pages',
    "transformation" => 'Modifying the presentation of Web pages'
  ],
  other => true,
  variable => 'assists',
  type => 'checkbox'
];

$automated = [
  title => "Supports automated checking of:",
  data => [
    "automated" => 'Single Web pages',
    "crawl" => 'Groups of Web pages or Web sites',
    "authenticated" => 'Restricted or password protected pages'
  ],
  other => true,
  variable => 'automated',
  type => 'checkbox'
];

$repair = [
  title => "Provides these repair options:",
  data => [
    "repair" => 'Changes the code of the Web pages',
    "caption" => 'Helps caption audio or video content',
    "pdf2html" => 'Converts <acronym title="Portable Document Format">PDF</acronym> files into accessible <acronym title="Hypertext Markup Language">HTML</acronym>',
    "word2html" => 'Converts Word files into accessible <acronym title="Hypertext Markup Language">HTML</acronym>',
    "excel2html" => 'Converts Excel files into accessible <acronym title="Hypertext Markup Language">HTML</acronym>',
    "ppt2html" => 'Converts PowerPoint files into accessible <acronym title="Hypertext Markup Language">HTML</acronym>'
  ],
  other => true,
  variable => 'repair',
  type => 'checkbox'
];

$technology = [
  title => "Checks the accessibility of:",
  data => [
    "css" => '<acronym title="Cascading Style Sheets">CSS</acronym>',
    "html" => '<acronym title="Hypertext Markup Language">HTML</acronym>',
    "xhtml" => '<acronym title="Extensible Hypertext Markup Language">XHTML</acronym>',
    "svg" => '<acronym title="Scalabale Vector Grpahics">SVG</acronym>',
    "pdf" => '<acronym title="Portable Document Format">PDF</acronym>',
    "images" => 'Images',
    "SMIL" => '<acronym title="Synchronized Multimedia Integration Language">SMIL</acronym>'
  ],
  other => true,
  variable => 'technology',
  type => 'checkbox'
];

$onlineservice = [
  title => "Online service:",
  data => [
    "online" => 'Online checker',
    "hosted" => 'Hosted service',
    "server" => 'Server installation'
  ],
  other => true,
  variable => 'onlineservice',
  type => 'checkbox'
];

$desktopapp = [
  title => "Desktop application for:",
  data => [
    "windows" => 'Microsoft Windows',
    "osx" => 'Apple (Mac) OS X',
    "linux" => 'Linux',
    "solaris" => 'Solaris',
    "bsd" => '<acronym title="Berkley Shell Distribution">BSD</acronym> Unix'
  ],
  other => true,
  variable => 'desktop',
  type => 'checkbox'
];

$authoringtools = [
  title => "Authoring tool plugin for:",
  data => [
    "dreamweaver" => 'Adobe Dreamweaver',
    "flash" => 'Adobe Flash',
    "photoshop" => 'Adobe Photoshop',
    "edge" => 'Adobe Edge',
    "eclipse" => "Eclipse",
    "expressionweb" => 'Microsoft Expression Web',
    "expressionweb" => 'Microsoft Visual Studio',
    "sublimetext" => 'Sublime Text'
  ],
  other => true,
  variable => 'authoringtools',
  type => 'checkbox'
];

$browsers = [
  title => "Browser plugin for:",
  data => [
    "chrome" => 'Chrome',
    "firefox" => 'Firefox',
    "oldie" => 'Internet Explorer &le; 8',
    "ie" => 'Internet Explorer &ge; 9',
    "oldopera" => 'Opera &le; 12',
    "opera" => 'Opera &ge; 15',
    "safari" => 'Safari'
  ],
  other => true,
  variable => 'browsers',
  type => 'checkbox'
];

$runtime = [
  title => "Runtime application for:",
  data => [
    "java" => 'Java',
    "net" => '.NET',
    "flash" => 'Flash',
    "soa" => '<acronym title="Service-Oriented Architecture">SOA</acronym>'
  ],
  other => true,
  variable => 'runtime',
  type => 'checkbox'
];

$reports = [
  title => "Generates reports in:",
  data => [
    "html" => '<acronym title="Hypertext Markup Language">HTML</acronym>',
    "pdf" => '<acronym title="Portable Document Format">PDF</acronym>',
    "xml" => '<acronym title="Extensible Markup Language">XML</acronym>',
    "earl" => '<acronym title="Evaluation and Report Language">EARL</acronym>',
    "txt" => 'Text',
    "csv" => '<acronym title="Comma Separated Value">CSV</acronym>'
  ],
  other => true,
  variable => 'reports',
  type => 'checkbox'
];

$apis = [
  title => 'Provides <acronym title="Application Programming Interface">API</acronym>s for:',
  data => [
    "c" => 'C, C++, or C#',
    "java" => 'Java',
    "vbasic" => 'Visual Basic',
    "sql" => '<acronym title="Structured Query Language">SQL</acronym>',
    "web" => 'Web service (Rest API, Webhook…)'
  ],
  other => true,
  variable => 'apis',
  type => 'checkbox'
];

$license = [
  title => 'License type:',
  data => [
    "free" => 'Free Software',
    "open" => 'Open Source',
    "trial" => 'Trial or Demo',
    "commercial" => 'Commercial',
    "enterprise" => 'Enterprise'
  ],
  other => true,
  variable => 'license',
  type => 'checkbox'
];

function san($s) {
  return filter_var(trim($s), FILTER_SANITIZE_STRING);
}

function iter($input, $reference) {
  $reference_data = $reference['data'];
  $o = [];
  foreach ($input as $key => $value) {
    if ($key !== 'other') {
      $o[] = $reference_data[$value];
    } else {
      if (san($value) !== '') {
        $o[] = san($value);
      }
    }
  }
  return $o;
}

  echo '<pre>';
  if ($_POST) {

   // var_dump($_POST);

    $data->title = san($_POST['title']);
    $data->creator = san($_POST['creator']);
    $data->location = san($_POST['location']);
    $data->release = san($_POST['release']);
    $data->version = san($_POST['version']);

    $data->language = iter($_POST['language'], $language);
    $data->guidelines = iter($_POST['guidelines'], $guidelines);
    $data->assists = iter($_POST['assists'], $assists);
    $data->automated = iter($_POST['automated'], $automated);
    $data->repairs = iter($_POST['repairs'], $repairs);
    $data->technology = iter($_POST['technology'], $technology);
    $data->onlineservice = iter($_POST['onlineservice'], $onlineservice);
    $data->desktopapp = iter($_POST['desktopapp'], $desktopapp);
    $data->authoringtools = iter($_POST['authoringtools'], $authoringtools);
    $data->browsers = iter($_POST['browsers'], $browsers);
    $data->runtime = iter($_POST['runtime'], $runtime);
    $data->reports = iter($_POST['reports'], $reports);
    $data->apis = iter($_POST['apis'], $apis);
    $data->license = iter($_POST['license'], $license);


  function friendly_url($url) {
  // everything to lower and no spaces begin or end
  $url = strtolower(trim($url));

  //replace accent characters, depends your language is needed
  $url=replace_accents($url);

  // decode html maybe needed if there's html I normally don't use this
  $url = html_entity_decode($url,ENT_QUOTES,'UTF8');

  // adding - for spaces and union characters
  $find = array(' ', '&', 'rn', 'n', '+',',');
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

    if (file_put_contents('./data/'.date('YmdHis').'-'.friendly_url($data->title).'.json', json_encode($data))=== FALSE) {
      die('error, sorry');
    } else {
      echo 'thank you!';
    }
    var_dump(json_encode($data));

  } else {
      var_dump(json_decode('{
"title": "Accessibility Wizard",
"creator": "Binary Blue",
"location": "http://www.binaryblue.com.au/access_wizard/",
"release": "2003-06-24",
"version": "1.0",
"language": "English",
"guideline": ["WCAG 1: Web Content Accessibility Guidelines 1"],
"assistance": ["Step-by-step evaluations"],
"platform": ["Flash"],
"license": ["Freeware"],
"type": "Online Tool",
"desc": "The Accessibility Wizard is a tool for web developers and project teams. It breaks down the WAI Checkpoints into individual tasks for each job role in a development team. Every member of a development team is directed to implement the WAI Checkpoints at a specified conformance level (A,AA or AAA). This is a sure way of meeting accessibility conformance. A web client that supports the Flash 6 (or higher) plugin is the minimum requirement to use the wizard."
}'));
  }
  echo '</pre>';

?>
  <header role="banner">
    <div class="w3c-wai-header">
      <a href="http://w3.org/"><img alt="W3C" width="90" src="//w3c.github.io/wai-tutorials/img/w3c-796023c4.png"></a>
      <a href="http://w3.org/WAI/" class="wai"><img alt="Web Accessibility Initiative" src="//w3c.github.io/wai-tutorials/img/wai-4c28be39.png"></a>
    </div>
  </header>
  <main class="with-side-menu" role="main">
    <div class="page-title">
      Web Accessibility Evaluation Tools
    </div>
    <h1>Submit a Web Accessibility Evaluation Tool</h1>
    <form action="submit.php" method="post">

  <fieldset>
    <legend><span>Information about you</span></legend>
    <h2 class="visuallyhidden"><a name="contact" id="contact">Information about you</a></h2>
    <fieldset class="border-less"><legend><span>Role</span></legend>
      <ul class="form-block">
        <li class="form-row radio"><span><input name="role" id="vendor" value="vendor" type="radio"></span><label for="vendor">Tool developer, vendor, or owner</label></li>
        <li class="form-row radio"><span><input name="role" id="user" value="user" type="radio"></span></span><label for="user"> Tool user or product customer</label></li>
        <li class="form-row radio"><span><input name="role" id="other" value="vendor" type="radio"></span><label for="other"> Other (heard of the tool, etc)</label></li>
      </ul>
    </fieldset>
    <div class="form-block">
      <div class="form-row"><label for="name">Name</label><span><input name="name" id="name" type="text"></span></div>
      <div class="form-row"><label for="email">E-Mail</label><span><input name="email" id="email" type="email"></span></div>
    </div>
  </fieldset>

  <fieldset>
    <legend><span>Description of the tool</span></legend>
    <h2 class="visuallyhidden"><a name="features" id="features">Description of the tool</a></h2>

    <fieldset>
      <legend><span>Tool Identification</span></legend>
      <h3 class="visuallyhidden"><a name="identification" id="identification">Tool Identification</a></h3>
      <ul class="form-block">
        <li class="form-row"><label for="title">Tool name</label><span><input name="title" id="title" type="text"></span></li>
        <li class="form-row"><label for="creator">Vendor name</label><span><input name="creator" id="creator" type="text"></span></li>
        <li class="form-row"><label for="location">Web Address (<acronym title="Universal Resource Identifier">URI</acronym>)</label><span><input name="location" id="location" type="url"></span></li>
        <li class="form-row"><label for="release">Release date (format: YYYY-MM-DD)</label><span><input name="release" id="release" type="date"></span></li>
        <li class="form-row"><label for="version">Version Number</label><span><input name="version" id="version" type="text"></span></li>
        <li class="form-row"><label for="description">Tool Description (max.: 300 chars)</label><span><textarea name="description" id="description" cols="60" rows="10" max-length="300"></textarea></span></li>
      </ul>
    </fieldset>

    <?php create_form_cb_section($language); ?>

    <?php create_form_cb_section($guideline); ?>

    <?php create_form_cb_section($assists); ?>

    <?php create_form_cb_section($automated); ?>

    <?php create_form_cb_section($repair); ?>

    <?php create_form_cb_section($technology); ?>

    <fieldset>
      <legend><span>Type of tool:</span></legend>
      <h3 id="type" class="visuallyhidden">Type of tool:</h3>

      <?php create_form_cb_section($onlineservice); ?>

      <?php create_form_cb_section($desktopapp); ?>

      <?php create_form_cb_section($authoringtools); ?>

      <?php create_form_cb_section($browsers); ?>

      <?php create_form_cb_section($runtime); ?>

      <?php create_form_cb_section($reports); ?>

      <?php create_form_cb_section($apis); ?>

      <?php create_form_cb_section($license); ?>
    </fieldset>
  </fieldset>

  <p><input value="Send Information" name="send" id="send" type="submit"></p>

    </form>
  </main>
<script src="js/main.js"></script>
</body>
</html>
