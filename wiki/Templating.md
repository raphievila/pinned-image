# PinnedImage Templates<!-- omit in toc -->

- [Summary](#summary)
- [Default Template](#default-template)
- [Full Template](#full-template)
	- [Top Load](#top-load)
	- [Right Load](#right-load)
	- [Left Load](#left-load)

## Summary

Your pinned image can have different templates:
1. Default
2. Full Template
   1. Bottom Load
   2. Top Load
   3. Left Load
   4. Right Load

Depending what you are trying to accomplish any of these templates might be handy to you.

## Default Template
To use the default template you do not need to do anything, this would be the default state of the rendering.

The default template shows pins on top of your image depending of the cooridnates provided on the pin list JSON file. See the [Read Me Documentation](../ReadMe.md) file for more information.

When a pin is click the provided tip information will expand right along the pin. Right now the size of the expanded block can only be manipulated by [CSS Styling](http://www.w3.org/Style/CSS/Overview.en.html).

**Note**: In the future I will add color themes, for now you need to style the following elements with a CSS file.

## Full Template
The full template is a mobile friendly version. Instead of the tip block expanding close to the pin, the block will slide out from the bottom, in its default state.

To activate this configuration you only need to set the `containerClass` parameter when calling the `PinnedImage` object.

```php
$params = [
	"containerClass" => "pinned-container-full"
]

$pi = new PinnedImage($params);
```
Check [Parameters Documentation](Parameters.md) for more information.

To change the sliding behaviour you can also set the `loadOrientation` parameter which will allow you to change from which direction the tip block will slide from.

### Top Load
```php
$params  = [
	'loadOrientation' => 'topload'
];
```

### Right Load
```php
$params  = [
	'loadOrientation' => 'rightload'
];
```

### Left Load
```php
$params  = [
	'loadOrientation' => 'bottomload'
];
```

