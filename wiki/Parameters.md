# Parameters Configurations <!-- omit in toc -->

- [Parameters for `PinnedImage` Class](#parameters-for-pinnedimage-class)
  - [Required Parameters](#required-parameters)
  - [Container Modifiers](#container-modifiers)
  - [Full Template Options](#full-template-options)
  - [No Script Options / Legend](#no-script-options--legend)
  - [Custom Pin List JSON File](#custom-pin-list-json-file)
  - [To Load Parameters](#to-load-parameters)
    - [Method One](#method-one)
    - [Method Two](#method-two)
  - [For Debugging](#for-debugging)
- [Parameters for Pin List JSON File](#parameters-for-pin-list-json-file)
  - [Required Parameters](#required-parameters-1)
  - [Optional Parameters](#optional-parameters)
  - [Pin List JSON Example](#pin-list-json-example)
___
# Parameters for `PinnedImage` Class
## Required Parameters
| key |	value format | default | options |
| :--- | :---: | :---: | :--- |
| `containerID` | String | PinnedImage | ID of container - modify if multiple containers are used |
| `imageURL` | String | null | Images url is required |
| `imageALT` | Number | null | Required by Screen Readers |
___

## Container Modifiers
| key |	value format | default | options |
| :--- | :---: | :---: | :--- |
| `containerClass` | String | pinned-container | `pinned-container-full` |
| `containerRatio` | Number | 169 | `32, 43, 169, 1610, 189, 215, 219` |
Container ratios are based on most popular standard ratios example:
| ratio | format | use | Example of Use |
| :--- | :--- | :---: | :--- |
| `3:2` | Landscape | 32 | Surface, Macbook Pro |
| `4:3` | Standard | 43 | Monitors, Old TVs |
| `16:9` | Widescreen | 169 | Monitors, Most HDTVs and Flat Screens |
| `18:9` | Wide Angle | 189 | Samsung S8, S9, Note 8, Note 9 and iPhone X |
| `21:9` | Extra Wide | 219 | Curved Monitors |
___
To use your custom ratio, check [Styling PinnedImages](Styling.md). Also available:
* 5:4 (54)
* 16:10 (1610)
* 21:5 (215)

For the moment only landscape orientation. I might add portrait orientation if requested.
___

## Full Template Options
| key |	value format | default |options |
| :--- | :--- | :--- | :--- |
| `loadOrientation` | String | bottomload | `topload, leftload, rightload` |
___

## No Script Options / Legend
| key |	value format | default |options |
| :--- | :--- | :--- | :--- |
| `ignoreNoScript` | Boolean | `false` | set to `true` to completely remove &lt;noscript/&gt; tag and its content. |
| `forceLegend` | Boolean | `false` | set to `true` to always show the legend, `ignoreNoScript` has to stay `false` for this to work. |
___

## Custom Pin List JSON File
| key |	value format | default |options |
| :--- | :--- | :--- | :--- |
| `myCoords` | URL | null | To use different pin list this have to point to a properly formatted [JSON](https://json.org) file |
| `ignoreNoScript` | Boolean | `false` | `true`, 1 - To remove noscript option from the rendering output |
___
When left blank, the class will use the default pin list JSON file located on
```shell
$ > .../raphievila/pinned-images/src/assets/scripts/coords.json
```
The above depends where your Composer files are located.

## To Load Parameters
To load parameters to render `PinnedImage::render` method you can do this in two different way:

### Method One
```php
require 'your-composer-vendor-location/vendor/autoload.php';
use raphievila\ImageTools\PinnedImage;

//Creating parameters array, if you use old version of PHP
//You might need to use $params = array(); instead.
$params = [
	'containerRatio' => '169'
	'imageURL' => 'https://example.com/img/myImage.jpg',
	'imageALT' => 'My explanation about the image'
];

//Loading parameters and creating object
$pi = new PinnedImage($params);
```

### Method Two
```php
require 'your-composer-vendor-location/vendor/autoload.php';
use raphievila\ImageTools\PinnedImage;
$pi = new PinnedImage();

//Creating parameters array, if you use old version of PHP
//You might need to use $params = array(); instead.
$params = [
	'containerRatio' => '169'
	'imageURL' => 'https://example.com/img/myImage.jpg',
	'imageALT' => 'My explanation about the image'
];

//Loading Parameters, usefull for multiple intances with different
//images and pin list JSON files
$pi->reload($params);

echo $pi->render();
```

## For Debugging
To make sure or test the parameters set are being processed correctly use `PinnedImage::check_loaded_parameters` method.
```php
var_dump($pi->check_loaded_parameters());
```
Need help? [Contact me here](mailto:rvila@revolutionvisualarts.com)

# Parameters for Pin List JSON File
`JSON` file require to be in proper formatting or it will not be parsed. For more information check [JSON official website](http://json.org/).

## Required Parameters
| key |	value format | description |
| :--- | :---: | :--- |
| `id` | String | Pin unique id |
| `tip` | String | Required by Screen Readers |
| `x` | Number | Horizontal origin location (Left to Right) |
| `y` | Number | Vertial origin location (Top to Bottom) |
___

## Optional Parameters
| key |	value format | description |
| :--- | :---: | :--- |
| `class` | String | Available to allow custom styling using [CSS](http://www.w3.org/Style/CSS/Overview.en.html) |
| `label` | String | Label text, number or image url, soon will support images |
| `title` | String | Title for the tip |
| `uri` | URL | If set the tip will show a button or link pointing to this url |
___

Other optional parameters might be added in the future for more customizations and icons. If you would like to provide icon fonts that could be distributed with this plug-in contact me by [email](mailto:rvila@revolutionvisualarts.com).

## Pin List JSON Example
```json
[
    {
        "id": "PointOne",
        "label": 1,
        "title": "Pinned One",
        "tip": "First pinned point on map",
        "uri": "#",
        "class": "extra classes",
        "x": 25,
        "y": 8
    },
    {
        "id": "PointTwo",
        "label": 2,
        "title": "Pinned Two",
        "tip": "Second pinned point on map",
        "uri": "#",
        "class": "extra classes",
        "x": 40,
        "y": 9
    }
]
```