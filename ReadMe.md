# Pinned Image <!-- omit in toc -->

- [Summary](#summary)
  - [Note For Developers](#note-for-developers)
- [Basic Functionality](#basic-functionality)
- [Implementation](#implementation)
- [Using PinnedImage Class (PHP)](#using-pinnedimage-class-php)
  - [Required Parameters](#required-parameters)
  - [Renderign as HTML](#renderign-as-html)
    - [Standard Template (.pinned-container)](#standard-template-pinned-container)
    - [Full Template (.pinned-container-full)](#full-template-pinned-container-full)
- [TODO](#todo)

## Summary

`PinnedImage` purpose is to create a more friendly and responisive image mapping simulating a pinned map mechanism but with any image. My main goal is to add functionalities and capabilities, but for now, will do basic functionalities.

I'm still debating if should implement JavaScript for interaction and animation, for the moment, all animations will be handle using Cascade Stylesheet methods and rules, and interactions through JavaScript.

If JavaScript is disable a legend will be added under the **`.pinned-container`** DOM division. My suggestion would be for you to set the container inside a container you can control and won't break your template's look specially when on mobile, legend will be posted between a `noscript` tag unless it is forced to show up always.

```html
<div id="myPinnedImage" class="pinned-container">...</div>
<noscript>
    <div id="PinOne-legend" class="pinned-flex">
        <div class="pinned-flex-row">
            <div class="pinned-flex-item-key">...</div>
            <div class="pinned-flex-item-value">...</div>
        </div>
    </div>
</noscript>
```

### Note For Developers

To manipulate or customize the styling, you require to have Ruby and Sass installed and initialized on your developing system. Also this plug-in requires raphievila/xtags and raphievila/utils which are going to be installed when your run:

```shell
$ cd /your-project-location/composer require raphievila/pinned-image
```

Also, if you use the PinnedImage object this render the HTML with [Bootstrap](https://getbootstrap.com) classes if you would like to implement it or already implemented on your project. If so you are required by Bootstrap to use [jQuery](https://jquery.com) and [Popper](https://popper.js.org).

I tried keep the use of JavaScript to minimum to provide you with a light nicely formatted experience that is mobile and desktop friendly. But this should not stop you of letting your creativity run wild. The code is not intrusive which is made in purpose to be used as a bootstrap that you can manipulate at your own taste.

## Basic Functionality

Find `coords.json` and modify to liking, the default file would look like this:

```JSON
[
    {
        "id": "PointOne",
        "label": 1,
        "title": "Pinned One",
        "tip": "First pinned point on map",
        "uri": "#",
        "class": "extra classes",
        "x": 20,
        "y": 20
    },
    {
        "id": "PointTwo",
        "label": 2,
        "title": "Pinned Two",
        "tip": "Second pinned point on map",
        "uri": "#",
        "class": "extra classes",
        "x": 40,
        "y": 40
    }
]
```

Not all paremeters are required except: `id, tip, x and y`. The value type is explained as follow:

```JSON
[
    {
        "id": "String or Number - should comply with DOM id standards",
        "label": "[optinal] String or Number - The label will be shown when the pin is on default state",
        "title": "[optional] String - The title of the tip",
        "tip": "[required] String - Full tip description or instruction",
        "uri": "[optional] STRING URL - If tip link to anywhere, add the URL address here",
        "class": "[optional] STRING - To include special styling to overwrite code default",
        "x": "[required] NUMBER - From Left - percentage value base of container origin do not include [%]",
        "y": "[required] NUMBER - From Top - percentage value base of container origin do not include [%]"
    }
]
```

The `JSON` should be an array list with each pin item as objects ***(key => value)*** structure.

## Implementation
To use `PinnedImage` with your website you need to include the following into the `head` tag of your HTML project:
```html
<link href="location/to/you/css/dir/pinned-image.css" rel="stylesheet" type="text/css" />
```

The any where inside the `body` tag, it is recommended at the very end right before the closing '&lt;/body&gt;` tag:
```html
<script type="text/javascript" src="location/of/your/script/library/pinned-image.js"></script>
```

If this has been implemented properly your code should look something like this:
```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pinned Image Home Page</title>
    <link href="location/to/you/css/dir/pinned-image.css" rel="stylesheet" type="text/css" />
</head>
<body>

    <!-- your template goes here -->

    <script type="text/javascript" src="location/of/your/script/library/pinned-image.js"></script>
</body>
</html>
```

## Using PinnedImage Class (PHP)

The `PinnedImage` class can be loaded through Composer as:

```PHP
require 'your/composer/loader/location/vendor/autoload.php';
use raphievila\ImageTools\PinnedImage;
$pi = new PinnedImage();
```

If you have your own loader solution you can use it as:

```PHP
//Location depends where the PinnedImage src diretory is located
require 'pinned-image/src/assets/controllers/PinnedImage.php';
use raphievila\ImageTools\PinnedImage;
$pi = new PinnedImage();
```
Just remember that this object require 2 additional objects [raphievila\xtags](https://github.com/raphievila/xtags) and [raphievila\utils](https://github.com/raphievila/utils).

### Required Parameters

The object above will display an error if its rendered. You have to pass the image required parameter `imageURL` at least to be able to render using the default `JSON` file. You can set parameters as follow:

```PHP
$params = array(
    'imageURL' => '/your/image/url.jpg'
);

$pi = new PinnedImage($params);
```

For a full list of parameters visit [raphievila/pinned-image/wiki/Parameters](https://github.com/raphievila/pinned-image/wiki/Parameters).
 
As usual, when you use a reusable code is because you probably need to use it multiple times at a time, for this you need to use the `reload` method.

### Renderign as HTML

Once are parameters are set, they you an echo the final `HTML` using the `PinnedImage::render` method:

```php
echo $pi->render();
```

Depending the parameters sent the code can be rendered in two different formats: *Standard or Full Template*

#### Standard Template (.pinned-container)

When rendered this tiny piece of code will be replaced with the following structure:

```html
<!-- standard format -->
<div id="PinnedID" class="pinned-container">
    <img src="imageURL" alt="imageALT" class="pinned-image" />

    <!-- pin structure -->
    <div id="json->id" class="pinned-point" data-x="json->x%" data-y="json->x%">
        <a alt="json->label" class="pinned-point-label">
            <span>json->label</span>
        </a>
        <div class="pinned-point-tip">
            <div class="pinned-point-sticker">
                <h3 class="pinned-point-title">json->title</div>
                <p class="pinned-point-banner">json->tip</div>
            </div>
        </div>
    </div>
</div>
```

#### Full Template (.pinned-container-full)

If you set parameter `containerClass` with value `pinned-container-full`, when the render method is requested will be replaced with:

```html
<!-- standard format -->
<div id="PinnedID" class="pinned-container">
    <img src="imageURL" alt="imageALT" class="pinned-image" />

    <!-- pin structure -->
    <a alt="json->label" class="pinned-point-label" rel="json->id">
        <span>json->label</span>
    </a>
    <div id="json->id" class="pinned-point-tip">
        <div class="pinned-point-sticker">
            <h3 class="pinned-point-title">json->title</div>
            <p class="pinned-point-banner">json->tip</div>
        </div>
    </div>
</div>
```

**NOTE:** If you pay attention, and this is important when you are applying a custom styling, on the full template version each pin is not contained inside the container `.pinned-point`, this container is removed and the pin (`.pinned-point-label`) along with the tip label container (`.pinned-point-tip`) are set as childs of the main pinned image container `.pinned-container`.

For this scenario I will replace the previous parameter with the following:

```php
$params = array(
    'imageURL' => '/your/image/url.jpg',
    'containerClass' => 'pinned-container-full'
);

$pi = new PinnedImage($params);

echo $pi->render();
```

For now the containerClass parameter can only be `pinned-container` (default) or `pinned-container-full`. Only set this up for full template only. For more information see [Templating](https://github.com/raphievila/pinned-image/wiki/Templating).

## TODO
Things I need to do and will be added shortly:
1. Ajax requested PinnedImage render.
2. Automatic localization adjustment for tip blocks depending on corner proximity.
3. Color Coded Themes.
4. Pin Icons.
5. The ability to create custom pins.
6. Map-like draggable content.
7. Zoom-In / Zoom-Out. (Probably)