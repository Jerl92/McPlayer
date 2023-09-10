# McPlayer</br>

<img style="max-width: 100%;" src="https://s11.gifyu.com/images/S4z1z.gif" alt="MCPlayer" />

McPlayer is a full-width HTML5/JS/AJAX audio Player with Playlist, Plugin for WordPress.</br>

## Description</br>

With McPlayer you can get your music from all arroud the wrold, from public wifi or your cellular network.</br>
Create your artist, add a banner picture, upload the album cover and add all the songs from it.</br>
Navigate through all the artists, albums and songs, add the song you want to the playlist and press play.</br>

McPlayer is build with the folloing JS</br>

Unobtrusive page transitions with jQuery.</br>
https://github.com/miguel-perez/smoothState.js</br>

HTML5 Audio & Video for jQuery</br>
https://github.com/jplayer/jPlayer</br>

Web audio-player with playlist and minimalistic view as option.</br>
https://github.com/dymio/player-56s</br>

Simplicity Save for Later will add a button to your posts/pages/custom post types so users can save that content so they can access it later.</br>
https://WordPress.org/plugins/rs-save-for-later/</br>

Interactions and Widgets for the web. jQuery UI is a curated set of user interface interactions, effects, widgets, and themes built on top of jQuery.</br>
https://github.com/jquery/jquery-ui</br>

## Depend on this theme and plugins
MCPlayer child theme based on Chichi</br>
https://github.com/Jerl92/McPlayer-Child-Theme</br>

This plugin is dependency for McPlayer-Core</br>
https://WordPress.org/plugins/categories-images/</br>

This plugin is needed if you want the scroll bar to be sticky</br>
https://wordpress.org/plugins/mystickysidebar/</br>

## Recommended plugins
This plugin is very usefull for add searching in taxonomie and meta post</br>
https://wordpress.org/plugins/search-everything/</br>

## Installation

This section describes how to install the plugin and get it working.</br>

You can have FFMPEG installed on it, to get compresed track over cellulair network. `apt-get install ffmpeg`</br>
You can have youtube-dl installed on it, to download and add album playlist. `https://github.com/ytdl-org/youtube-dl/`</br></br>
1. Upload `chichi` to the `/wp-content/themes/` directory.</br>
2. Upload `McPlayer-Child-Theme` to the `/wp-content/themes/` directory.</br>
3. Rename `McPlayer-Child-Theme` to `chichi-child`.</br>
4. Activate `chichi-child` in the theme admin menu.</br>
5. Uplaod `categories-images` to the `/wp-content/plugins/` directory.</br>
6. Activate `categories-images`  through the Plugins menu in WordPress.</br>
7. Upload `McPlayer-master` to the `/wp-content/plugins/` directory.</br>
8. Rename `McPlayer-master` to `McPlayer`.</br>
9. Activate `McPlayer` through the Plugins menu in WordPress.</br>
10. Add artist in the admin music menu.</br>
11. Upload cover and set the artist and the year, of the cover</br>
12. Add new music, set title, set mp3 file, set track number, set artist, set album.</br>
13. <b>Use the same album cover picture for all the tracks in the album.</b></br>
14. Add the player and playlist widget in the customization menu.</br>
16. Set shortcode in page.</br>
[pre_order_products per_page="50" columns="5" order="'rand" orderby="rand"]</br>
[artist_get_shortcode]</br>
[year_get_shortcode]</br>
[artist_new_get_shortcode]</br>
[pre_order_products per_page="100" columns="5" order="DESC" orderby="date"]</br>

## Screenshot

<img style="max-width: 100%;" src="https://i.ibb.co/LvxW3Z5/mcplayer1.jpg" />
<img style="max-width: 100%;" src="https://i.ibb.co/tPNyMcN/mcplayer0.jpg" />
<img style="max-width: 100%;" src="https://i.ibb.co/YXZ5cvB/mcplayer2.jpg" />
<img style="max-width: 100%;" src="https://i.ibb.co/9G1DDFm/mcplayeradmin0.jpg" />
<img style="max-width: 100%;" src="https://i.ibb.co/rdL9T5S/mcplayeradmin1.jpg" />
<img style="max-width: 100%;" src="https://i.ibb.co/LJFCh3h/mcplayeradmin2.jpg" />
<img style="max-width: 100%;" src="https://i.ibb.co/NYH1PpD/bulk-add-album.png" />

## Changelog

0.6 - Playlist can be save and load and shuffle and no-shuffle order work</br>
0.5 - Not loged user, can now browser and interact with playlist and player.</br>
0.4 - Remove sticky sidebar, use overflow scroll.</br>
0.3 - Add wake lock when the tab is active, Use FFMPEG for audio compresion.</br>
0.2 - Sortable playlist.</br>
0.1 - Init release.</br>

Init version of this plugin, a lots of QA hours have been done with Chrome and Firefox, both work great.</br>
