# Styling PinnedImage <!-- omit in toc -->

- [Summary](#summary)
- [Recommendation](#recommendation)
- [PinnedImage CSS Structure](#pinnedimage-css-structure)
	- [Default Structure](#default-structure)
	- [Full Template Structure](#full-template-structure)

# Summary
PinnedImage main css file is located under your Composer `/vendor/` directory under:

```shell
$ > ./vendor/raphievila/pinned-image/src/assets/styles/css/pinned-image.css
```
But, if you want to manipulate this file I recommend to use [Sass](https://sass-lang.com/) a `CSS` extension language, which requires [Ruby](https://www.ruby-lang.org/en/) programming language installed on your development environment.

The `Sass` file is located:
```shell
$ > ./vendor/raphievila/pinned-image/src/assets/styles/scss/pinned-image.scss
```
When modifying remember to render the `SCSS` file by running the next command on your terminal or PowerShell:
```shell
$ > ./vendor/raphievila/pinned-image/src/assets/styles/ sass --watch scss:css
```
As previously stated, directory location depends in your directory structure and where the `pinned-image` directory is located. When deploying to your production site you can set your FTP Client to ignore the `scss` directory.

# Recommendation
The Styling of this code is not intrusive and can be overrided by an external css file as well, just make sure the custom styling file is place below the `pinned-image.css` so it takes precedence.

```html
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>PinnedImage Sample Page</title>
	<link rel="stylesheet" type="text/css" href="../assets/styles/css/pinned-image.css" />
	<!-- here should be your file -->
	<link rel="stylesheet" type="text/css" href="/the/location/of/your/css/file/" />
</head>
<body> ...
```

# PinnedImage CSS Structure
## Default Structure
The default CSS structure for the PinnedImage object is as follow
```
div.pinned-container
|---->img.pinned-image
|---->div.pinned-point //each pin
     |---->a.pinned-point-label
          |---->span
	 |---->div.pinned-point-tip
	      |---->div.pinned-point-tip-sticker
		       |---->h3.pinned-point-title
			   |---->p.pinned-point-banner
```
## Full Template Structure
The full template changes how the objects are located inside the main container, because in this case, the tips will slide from the image sides instead next to the pin.
```
div.pinned-container-full
|---->img.pinned-image
|---->a.pinned-point-label
	|---->span
|---->div.pinned-point-tip
	|---->div.pinned-point-tip-sticker
		|---->h3.pinned-point-title
		|---->p.pinned-point-banner
```
Notice that the pins are no longer enclosed under the container `.pinned-point`, each element float freely inside the main container `.pinned-container-full`.