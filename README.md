# WAI Accessibility Evaluation Tools

## Setup and Addition of Data

Data is collected in the `data` directory. There are two possibilities to use it.

### (A) Local setup & GitHub Pages 

Clone the repository to your hard disk and run

~~~bash
$ npm install
~~~

to initialize the repository and install all dependencies, like grunt. To use the data files with github pages, the files need to be compiled to one `data.js` files using the gulp script. Run

~~~bash
$ gulp watch
~~~

and add/edit the data files. The `data.json` file is automatically created.

### (B) Server setup & PHP

If you want the script to pick up files on the (PHP enabled) server automatically once they are saved into the data directory, do all steps in (A) but after running `gulp watch` edit the `javascript/script.js` file. Search for `data.json` and replace it with `data.json.php`. After you save that file a new `js/master.min.js` is created that is using this path. Now you can upload the files to the server, **whenever you upload a new file to the `data` directory it will be picked up by the tool automagically**.

### Appendix: Data format

Usually data should be entered and edited using the submission form to ensure valid JSON. The data is collected in JSON files with each entry in the following format:

~~~json
{
  "title": "<string>",
  "creator": "<string>",
  "location": "<url>",
  "release": "<date format='YYYY-MM-DD'>",
  "version": "<string>",
  "description": "<string>",
  "language": ["<array of strings>"],
  "guideline": ["<array of strings>"],
  "assists": ["<array of strings>"],
  "automated": ["<array of strings>"],
  "repairs": ["<array of strings>"],
  "technology": ["<array of strings>"],
  "onlineservice": ["<array of strings>"],
  "desktopapp": ["<array of strings>"],
  "authoringtools": ["<array of strings>"],
  "browsers": ["<array of strings>"],
  "reports": ["<array of strings>"],
  "license": ["<array of strings>"],
  "update": ["<array of strings>"],
  "type": ["<array of strings>"]
}
~~~

`title`, `creator`, `url`, `release`, `version` and `desc` can have only one (string) value. All other fields can either be one or multiple values. If a tool has multiple values, like different languages, enclose them with square brackets and separate them with a comma. If only one value is used, the brackets are optional. (a value of "English" is equivalent to ["English"]).

 Due to limitations of the tool, the values have to be the same throughout the whole data set, for example “Freeware” and “FreeWare” would be considered two different strings to filter by. This is really important for the more complex things like “WCAG 2: Web Content Accessibility Guidelines 2” or similar.
 
## Listing Form Configuration
 
The form content can easily be edited using the `config.php` file in root. It looks like this:
 
~~~php
<?php
date_default_timezone_set('UTC'); // Sets time zone, allows us to format dates from strings.
$demo = false; // If demo mode is true, data isn’t sent to the list.

$assists = array(
	title => "Assists evaluations by:", // Fieldset heading
	data => array( // Options, format: "shortname_no_spaces" => "longname"
		"report" => 'Generating reports of evaluation results', 
		"wizard" => 'Providing step-by-step evaluation guidance',
		"inpage" => 'Displaying information within web pages',
		"transformation" => 'Modifying the presentation of web pages'
	),
	other => false, // If true, a other field is displayed
	variable => 'assists', // An identifier, usually the same as the variable name
	type => 'checkbox', // or 'radio'
	explanation => array( // If items need explanations, provide it in the format "shortname" => "URI"
		"report" => 'http://www.w3.org/WAI/eval/selectingtools.html#reports',
		"wizard" => 'http://www.w3.org/WAI/eval/selectingtools.html#wizards',
		"inpage" => 'http://www.w3.org/WAI/eval/selectingtools.html#in-page',
		"transformation" => 'http://www.w3.org/WAI/eval/selectingtools.html#transformation'
	)
);

/* multiple other of those blocks for configuration */
~~~

### Adding a new block

1. Enter block data as noted above.

2. In `submission.php`: 

Around line `100`, enter a line like the following: 

~~~php
$data->assists = iter($_POST['assists'], $assists);
~~~
 
Around line `370`, enter a line like the following:
  
~~~php
<?php create_form_cb_section($assists); ?>
~~~

### Exposing as filters

To expose a new category as filters, set the repository up for local editing and run `grunt watch` as described in (A) above. Then edit the `javascript/script.js` file. Under `var settings = {` you can find a few configuration options which are taken from the `facetedsearch.js` javascript library (see [bottom of this page for an example](https://eikes.github.io/facetedsearch/)). But there have been some changes to the configuration for facets:

~~~js
facets: {
	'guideline' : {
		'title': 'Guidelines', 
		'promoted': [
			"<strong><abbr title=\"Web Content Accessibility Guidelines\">WCAG<\/abbr> 2.0 — <abbr title=\"World Wide Web Consortium\">W3C<\/abbr> Web Content Accessibility Guidelines 2.0<\/strong>", 
			"<abbr title=\"Web Content Accessibility Guidelines\">WCAG<\/abbr> 1.0 — <abbr title=\"World Wide Web Consortium\">W3C<\/abbr> Web Content Accessibility Guidelines 1.0"
		]
	},
	'language'  : {
		'title': 'Languages', 
		'collapsed': true
	},
	'a11yinfo' : {
		'title': 'Accessibility Statement', 
		'plain': true 
	}
	[…more facets…]
},
~~~

Every facet has a `title`, which is mandatory. It is the `<summary>` of the `<details>` element. If the facet should be collapsed by default, set `'collapsed': true`. If there should be no `<details>` & `<summary>` around that item, set `'plain': true`.

