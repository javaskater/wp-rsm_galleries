# My Image Gallery Plugin for Wordpress

## ID Card :

    Contributors: javaskater
    Donate link:
    Tags: imagelightbox.js, bootstrap.js
    Requires at least: 3.0.1
    Tested up to: 3.9
    Stable tag: trunk
    License: MIT
    License URI: http://opensource.org/licenses/MIT


> Responsive and touch-friendly lightbox for Wordpress.
> It uses ImageLightbox.js by Osvaldas Valutis

## General description

* Responsive and touch-friendly lightbox for Wordpress.
* That plugin commes with no admin menu _(at that time)_
* It will run on posts/pages/attachments.
  * It will NOT run on categories, archives, front page etc.

## Technical elements:

* This plugin uses the excellent [ImageLightbox.js by Osvaldas Valutis](http://osvaldas.info/image-lightbox-responsive-touch-friendly).
* this plugin is meant to display your standard post images in a dynamic and responsive way using [lighbox.js](http://osvaldas.info/image-lightbox-responsive-touch-friendly) library
* It is also meant to display standard Wordpress Galleries in the way the [Jquery Light Gallery Plugin](http://sachinchoolur.github.io/lightGallery/) makes it, the thumbss on their side are organised by the Jquery Masonry plugin, an example of it is drawn out of our [stay in Burgundy in 2015](http://rsmontreuil.fr/rando-bourgogne/)

### in the social networks branch

* I recently added the possibility to display a public Picasa Gallery this way (instead off just a simple link), an example of it is drawn out of our [first inline skating hike from Paris to London July 2015](http://rsmontreuil.fr/le-paris-londres-cest-parti/)
  * That meant adding a Picasa media button at the top of Wordpress Editor
  * Previous Joomla Galleries are also displayed the same Way, an example of it is drawn out of our [stay in Burgundy in 2014](http://rsmontreuil.fr/bourgogne-le-cru-2014/)


## How to install it :

1. Upload wp-imagelightbox to `/wp-content/plugins`
2. Activate plugin from admin interface

## TODOS:

* There is a page for that see [docs/TODO.md](docs/TODO.md)

## Frequently Asked Questions

### Where are the options?

There aren't any at the moment!

### How to change the imagelightbox type?

* At the moment there is no way to change the type of gallery plugin you want to use unless you edit the code of the plugin. Inside wp-imagelightbox.php you can edit the line containing `$type="f"`. Change the letter "f" to different types that you can see on Osvaldas Valutis' demo page.
