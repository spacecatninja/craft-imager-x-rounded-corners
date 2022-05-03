# Rounded Corners Effect for Imager X

A plugin for rounding image corners using Imager X.   
Also, an example of 
[how to make a custom effect for Imager X](https://imager-x.spacecat.ninja/extending.html#effects).

## Requirements

This plugin requires Craft CMS 4.0.0 or later, Imagick image driver, and Imager X 4.0 or later.
 
_Please note, this plugin will not work if you're on a version of Imagick 3.4.4 
that is compiled with ImageMagick 6.x. You can use Imagick 3.4.4 compiled with
ImageMagick 7.x, or Imagick 3.4.3 with ImageMagick 6.x._   


## Installation

To install the plugin, follow these instructions:

1. Install with composer via `composer require spacecatninja/imager-x-rounded-corners` from your project directory.
2. Install the plugin in the Craft Control Panel under Settings > Plugins, or from the command line via `./craft install/plugin imager-x-rounded-corners`.


## Usage

After installing the plugin, you can use the `roundedcorners` effect as you would
any other effect in Imager X, ie:

```
{% set rounded = craft.imager.transformImage(image, { width: 600, effects: { roundedcorners: 30 } }) %}
```

The background color can be customized using the normal `bgColor` setting:

```
{% set rounded = craft.imager.transformImage(image, { width: 600, bgColor: '#e4edf6', effects: { roundedcorners: 30 } }) %}
```

If the output image is a png, the background can be transparent:

```
{% set rounded = craft.imager.transformImage(image, { width: 600, bgColor: 'transparent', format: 'png', effects: { roundedcorners: 30 } }) %}
```

If you want to use the plugin to make a completely round image, you'll notice an 
_edge case_ (such a good pun, you'll see) where the antialiasing will make the
right edge of the image appear to be cut off. This is a common problem whenever making
transparent images for the web, no matter what tool you use. In PhotoShop and similar, 
the solution is to shrink the contents and leave some transparent pixels around
the image. 

This plugin has a similar hack, which you can unlock by passing an object
as a parameter, and setting `fixEdge` to `true`, like this:

```
{% set transformed = craft.imager.transformImage(image2, { width: 600, ratio: 1, effects: { roundedcorners: { radius: 300, fixEdge: true } } }) %}
```

This will make the mask that is used to cut out the rounded image 1px smaller, ie 599x599px. 
Visually, this will fix the antialiasing issue.


Price, license and support
---
The plugin is released under the MIT license. It requires Imager X, which is a commercial 
plugin [available in the Craft plugin store](https://plugins.craftcms.com/imager-x). If you 
need help, or found a bug, please post an issue in this repo, or in Imager X' repo. 
