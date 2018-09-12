<?php
date_default_timezone_set('UTC');
$demo = false;

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
	type => 'checkbox',
	explanation => array(
		"report" => 'http://www.w3.org/WAI/eval/selectingtools.html#reports',
		"wizard" => 'http://www.w3.org/WAI/eval/selectingtools.html#wizards',
		"inpage" => 'http://www.w3.org/WAI/eval/selectingtools.html#in-page',
		"transformation" => 'http://www.w3.org/WAI/eval/selectingtools.html#transformation'
	)
);

$language = array(
	title => "Tool languages:",
	data => array(
    "ar" => 'Arabic (<span lang="ar">العَرَبِيَّة</span>)',
    "ast" => 'Asturian (<span lang="ast">Asturianu</span>)',
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
		"hu" => 'Hungarian (<span lang="hu">Magyar</span>)',
		"it" => 'Italian (<span lang="it">Italiano</span>)',
		"ja" => 'Japanese (<span lang="ja">日本語</span>)',
		"ko" => 'Korean (<span lang="ko">한국어</span>)',
    "no" => 'Norwegian (<span lang="no">Norge</span>)',
		"pl" => 'Polish (<span lang="pl">Polski</span>)',
		"pt" => 'Portuguese (<span lang="pt">Português</span>)',
		"ro" => 'Romanian (<span lang="ro">Română</span>)',
    "ru" => 'Russian (<span lang="ru">Pу́сский</span>)',
		"sr" => 'Serbian (<span lang="sr">Српски</span>)',
    "es" => 'Spanish (<span lang="es">Castellano</span>)',
		"sv" => 'Swedish (<span lang="sv">Svenska</span>)',
		"tr" => 'Turkish (<span lang="tr">Türkçe</span>)',
    "uk" => 'Ukrainian (<span lang="uk">Yкраїнська</span>)'
	),
	other => true,
	variable => 'language',
	type => 'checkbox'
);

$guideline = array(
	title => "Select Guidelines that can be checked using this tool:",
	data => array(
		"wcag21" => '<strong><abbr title="Web Content Accessibility Guidelines">WCAG</abbr> 2.1 — <abbr title="World Wide Web Consortium">W3C</abbr> Web Content Accessibility Guidelines 2.1</strong>',
		"wcag20" => '<strong><abbr title="Web Content Accessibility Guidelines">WCAG</abbr> 2.0 — <abbr title="World Wide Web Consortium">W3C</abbr> Web Content Accessibility Guidelines 2.0</strong>',
		"wcag10" => '<abbr title="Web Content Accessibility Guidelines">WCAG</abbr> 1.0 — <abbr title="World Wide Web Consortium">W3C</abbr> Web Content Accessibility Guidelines 1.0',
    "epub" => 'EPUB Accessibility 1.0',
		"section508" => 'Section 508, <abbr title="United States">US</abbr> federal procurement standard',
		"bitv" => '<abbr lang="de" title="Barrierefreie Informationstechnik-Verordnung">BITV</abbr>, German government standard',
    "irit" => 'Irish National IT Accessibility Guidelines',
    "jis" => '<abbr title="Japanese Industry Standard">JIS</abbr>, Japanese industry standard',
    "rgaa" => '<abbr lang="fr" title="Référentiel Général d’Accessibilité pour les Administrations">RGAA</abbr>, French government standard',
    "stanca" => 'Stanca Act, Italian accessibility legislation'
	),
	other => true,
	variable => 'guideline',
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
		"aria" => 'WAI-ARIA',
		"css" => '<abbr title="Cascading Style Sheets">CSS</abbr>',
		"html" => '<abbr title="Hypertext Markup Language">HTML</abbr>',
		"xhtml" => '<abbr title="Extensible Hypertext Markup Language">XHTML</abbr>',
    "aria" => '<abbr title="Accessible Rich Internet Applications">WAI-ARIA</abbr>',
		"svg" => '<abbr title="Scalabale Vector Grpahics">SVG</abbr>',
		"pdf" => '<abbr title="Portable Document Format">PDF</abbr> documents',
		"images" => 'Images',
		"smil" => '<abbr title="Synchronized Multimedia Integration Language">SMIL</abbr>',
    "office" => 'Microsoft Office documents',
    "odf" => 'Open Documents Format (ODF)'
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
		"osx" => 'Apple macOS',
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
    "any" => 'Any (bookmarklet)',
		"chrome" => 'Chrome',
		"firefox" => 'Firefox',
    "ie" => 'Internet Explorer',
    "opera" => 'Opera',
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
		"api" => 'API (Application Programming Interface)',
		"online" => 'Online tool'
	),
	other => false,
	variable => 'tooltype',
	type => 'checkbox'
);

$apitype = array(
	title => 'API type:',
	data => array(
		"rest" => 'REST',
		"soap" => 'SOAP',
		"webhook" => 'Webhook',
		"js" => 'JavaScript'
	),
	other => true,
	variable => 'apitype',
	type => 'checkbox'
);

