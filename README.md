# WAI Accessibility Evaluation Tools

## TBD

## Data format

The data is collected in a JSON file with each entry in the following format:

~~~json
{
    "title": "Title of the Tool",
    "creator": "Vendor",
    "location": "http://example.com",
    "release": "2014-08-08",
    "added": "2014-08-08",
    "version": "1.0",
    "language": ["English", "German (<span lang='de'>Deutsch</span>)"],
    "guideline": ["WCAG 2: Web Content Accessibility Guidelines 2"],
    "assistance": ["Step-by-step evaluations"],
    "platform": "Web",
    "license": ["Freeware"],
    "type": "Online Tool",
    "desc": "Description"
}
~~~

`title`, `creator`, `url`, `release`, `version` and `desc` can have only one (string)
 value. All other fields can either be one or multiple values. If a tool has multiple values, like different languages, enclose them with square brackets and separate them with a comma. If only one value is used, the brackets are optional. (a value of "English" is equivalent to ["English"]).

 Due to limitations of the tool, the values have to be the same throughout the whole data set, for example “Freeware” and “FreeWare” would be considered two different strings to filter by. This is really important for the more complex things like “WCAG 2: Web Content Accessibility Guidelines 2” or similar.
