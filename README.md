# McPlayer</br>

<img style="max-width: 100%;" src="https://i.ibb.co/7Ygsf5K/maplyer456.jpg" alt="MCPlayer" />

McPlayer is a full-width HTML5/JS/AJAX audio Player with Playlist, Plugin for WordPress.</br>

## Description</br>

McPlayer is build with JS from</br>

https://github.com/miguel-perez/smoothState.js</br>
Unobtrusive page transitions with jQuery.</br>

https://github.com/jplayer/jPlayer</br>
HTML5 Audio & Video for jQuery</br>

https://github.com/dymio/player-56s</br>
Web audio-player with playlist and minimalistic view as option.</br>

https://WordPress.org/plugins/rs-save-for-later/</br>
Simplicity Save for Later will add a button to your posts/pages/custom post types so users can save that content so they can access it later.</br>

https://github.com/cihadturhan/jquery-aim</br>
jQuery plugin anticipates on which element user is going to hover/click.</br>

https://github.com/jquery/jquery-ui</br>
Interactions and Widgets for the web. jQuery UI is a curated set of user interface interactions, effects, widgets, and themes built on top of jQuery.</br>

### Recommended plugins
https://WordPress.org/plugins/categories-images/</br>
This plugin is dependency for McPlayer-Core</br>

https://wordpress.org/plugins/search-everything/</br>
This plugin is very usefull for add searching in taxonomie and meta post</br>

## Installation

This section describes how to install the plugin and get it working.

1. Your server need to have SOX installed on it. apt-get install sox http://sox.sourceforge.net/</br>
<code>sox ' . get_attached_file($attachment_ID) . ' -r 32000 -c 1 --norm -C -1 ' . get_attached_file($attachment_ID) . '.ogg</code>
2. Upload `McPlayer.php` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Set shortcode in page ['artist_get_shortcode'] [pre_order_products per_page="50" columns="5" order="'rand" orderby="rand"]
5. Don't froget to add the player and playlist widget with the child theme.

## Screenshot

<img style="max-width: 100%;" src="https://i.ibb.co/LvxW3Z5/mcplayer1.jpg" />

<img style="max-width: 100%;" src="https://i.ibb.co/tPNyMcN/mcplayer0.jpg" />

<img style="max-width: 100%;" src="https://i.ibb.co/YXZ5cvB/mcplayer2.jpg" />

<img style="max-width: 100%;" src="https://i.ibb.co/9G1DDFm/mcplayeradmin0.jpg" />

<img style="max-width: 100%;" src="https://i.ibb.co/rdL9T5S/mcplayeradmin1.jpg" />

<img style="max-width: 100%;" src="https://i.ibb.co/LJFCh3h/mcplayeradmin2.jpg" />

## Frequently Asked Questions

Help! My $(document).ready() plugins work fine when I refresh but break on the second page load.

```js
function myFonction($) {

    $.fn.ready();
      'use strict';

      // js Code using $ as usual goes here
}

jQuery(document).ready(function($) {
  myFonction($);
});
```

https://github.com/miguel-perez/smoothState.js#faq

## Changelog

### 0.1 - iPhone/Safari is working with some few issue, no device to test with.

Init version of this plugin, a lots of QA hours have been done with Chrome and Firefox, both work great.