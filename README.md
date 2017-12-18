=== MCPlayer ===</br>
Tags: music player, full width, playlist</br>
Requires at least: 4.9</br>
Tested up to: 4.9.1</br>
Stable tag: 4.9</br>
License: GPLv2 or later</br>
License URI: http://www.gnu.org/licenses/gpl-2.0.html</br>

MCPlayer The first full-width HTML5/JS/AJAX audio Player with Playlist, Plugin for Wordpress.

== Description ==

MCPlayer is make with JS taken from,
https://github.com/miguel-perez/smoothState.js: Unobtrusive page transitions with jQuery,</br>
https://github.com/dymio/player-56s: Web audio-player with playlist and minimalistic view as option,</br>
https://wordpress.org/plugins/rs-save-for-later/: Simplicity Save for Later will add a button to your posts/pages/custom post types so users can save that content so they can access it later.</br>

https://wordpress.org/plugins/categories-images/ is necessary with this plugin</br>

A few notes about the sections above:

*   "Contributors" is a comma separated list of wp.org/wp-plugins.org usernames
*   "Tags" is a comma separated list of tags that apply to the plugin
*   "Requires at least" is the lowest version that the plugin will work on
*   "Tested up to" is the highest version that you've *successfully used to test the plugin*. Note that it might work on
higher versions... this is just the highest one you've verified.
*   Stable tag should indicate the Subversion "tag" of the latest stable version, or "trunk," if you use `/trunk/` for
stable.

    Note that the `readme.txt` of the stable tag is the one that is considered the defining one for the plugin, so
if the `/trunk/readme.txt` file says that the stable tag is `4.3`, then it is `/tags/4.3/readme.txt` that'll be used
for displaying information about the plugin.  In this situation, the only thing considered from the trunk `readme.txt`
is the stable tag pointer.  Thus, if you develop in trunk, you can update the trunk `readme.txt` to reflect changes in
your in-development version, without having that information incorrectly disclosed about the current stable version
that lacks those changes -- as long as the trunk's `readme.txt` points to the correct stable tag.

    If no stable tag is provided, it is assumed that trunk is stable, but you should specify "trunk" if that's where
you put the stable version, in order to eliminate any doubt.

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Upload `mcplayer.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place `<?php do_action('plugin_name_hook'); ?>` in your templates

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

<img src="https://img15.hostingpics.net/pics/809953mcplayer1.jpg" alt="MCPlayer" data-canonical-src="https://img15.hostingpics.net/pics/809953mcplayer1.jpg" style="max-width:100%;">

<img src="https://img15.hostingpics.net/pics/797972mcplayer2.jpg" alt="MCPlayer" data-canonical-src="https://img15.hostingpics.net/pics/797972mcplayer2.jpg" style="max-width:100%;">

<img src="https://img15.hostingpics.net/pics/971888mcplayeradmin2.jpg" alt="MCPlayer" data-canonical-src="https://img15.hostingpics.net/pics/971888mcplayeradmin2.jpg" style="max-width:100%;">

<img src="https://img15.hostingpics.net/pics/499681mcplayeradmin1.jpg" alt="MCPlayer" data-canonical-src="https://img15.hostingpics.net/pics/499681mcplayeradmin1.jpg" style="max-width:100%;">

== Without cache ==
<img src="https://img15.hostingpics.net/pics/608363waterfall.gif" alt="No cache" data-canonical-src="https://img15.hostingpics.net/pics/608363waterfall.gif" style="max-width:100%;">

== With cache ==
<img src="https://img15.hostingpics.net/pics/713595waterfall2.gif" alt="With cache" data-canonical-src="https://img15.hostingpics.net/pics/713595waterfall2.gif" style="max-width:100%;">

<img src="https://img15.hostingpics.net/pics/323462console.png" alt="MCPlayer" data-canonical-src="https://img15.hostingpics.net/pics/323462console.png" style="max-width:100%;">

<img src="https://img15.hostingpics.net/pics/878297console2.png" alt="MCPlayer" data-canonical-src="https://img15.hostingpics.net/pics/878297console2.png" style="max-width:100%;">

== Changelog ==

= 1.0 =
* A change since the previous version.
* Another change.

= 0.5 =
* List versions from most recent at top to oldest at bottom.

== Upgrade Notice ==

= 1.0 =
Upgrade notices describe the reason a user should upgrade.  No more than 300 characters.

= 0.5 =
This version fixes a security related bug.  Upgrade immediately.

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above.  This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation."  Arbitrary sections will be shown below the built-in sections outlined above.

== A brief Markdown Example ==

Ordered list:

1. Some feature
1. Another feature
1. Something else about the plugin

Unordered list:

* something
* something else
* third thing

Here's a link to [WordPress](http://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.

[markdown syntax]: http://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up  for **strong**.

`<?php code(); // goes in backticks ?>`