#Pinned Image

`PinnedImage` purpose is to create a more friendly responisive image mapping simulating a pinned map mechanism, but with any image. My main goal is to add functionalities and capabilities, but for now, will do basic functionalities.

I'm still debating if should implement JavaScript for interaction and animation, for the moment, all animations will be handle for Cascade Stylesheet methods and rules.

To manipulate or customize the funcitonality, you require to have Ruby and Sass installed and initialized on your developing system. Also this plug-in requires raphievila/xtags and raphievila/utils which are going to be install when your run:

```PHP
//The example shows as if the root directory is at the root of your system
> cd GitHub/pinned-images/composer install
```

##Basic Functionality

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
[ //should be an array
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

##Using PinnedImage Class

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

The object above will display an error if its rendered. You have to pass the image required parameters `imageURL`. You can set parameters as follow:

```PHP
$params = array(
    'imageURL' => '/your/image/url.jpg'
);

$pi = new PinnedImage($params);
```

For a full list of parameters visit [raphievila/pinned-image/wiki/Parameters](https://github.com/raphievila/pinned-image/wiki/Parameters).
 
As usual, when you use a reusable code is because you probably need to use it multiple times at time, for this you need to use the `reload` method.