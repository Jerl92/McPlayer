# McPlayer

McPlayer is a full-width HTML5/CSS/PHP/JS/AJAX audio Player with Playlist, Plugin for WordPress.</br>

<img style="max-width: 100%;" src="https://i.ibb.co/rZ0tpCh/mcplayer4846157.png" alt="MCPlayer" />

## Description
With McPlayer you can get your music from all around the world, from public Wi-Fi or your cellular network.</br>
Create your artist, add a banner picture, upload the album cover and add all the songs from it.</br>
Navigate through all the artists, albums and songs, add the song you want to the playlist and press play.</br>
Working with android, it a nice way to do long drive with your custom playlist.</br>
Without any ads.</br>

In the admin panel, there a sub-page to let's do bulk add albums from music.youtube.com. Just copy and paste the playlist link and click the button and the album will download and convert to audio, and will add to the libray automatically. This make this plugin a must-have to have your private music library, without any artist you don't want, and only got what you like.</br>
Without any limitation.</br>

## Build-with
McPlayer is build with the folloing JS</br>

Unobtrusive page transitions with jQuery.</br>
https://github.com/miguel-perez/smoothState.js/</br>

HTML5 Audio & Video for jQuery</br>
https://github.com/jplayer/jPlayer/</br>

Web audio-player with playlist and minimalistic view as option.</br>
https://github.com/dymio/player-56s/</br>

Simplicity Save for Later will add a button to your posts/pages/custom post types so users can save that content so they can access it later.</br>
https://WordPress.org/plugins/rs-save-for-later/</br>

Interactions and Widgets for the web. jQuery UI is a curated set of user interface interactions, effects, widgets, and themes built on top of jQuery.</br>
https://github.com/jquery/jquery-ui/</br>

## Depend on this theme and plugins
MCPlayer child theme based on Chichi</br>
https://github.com/Jerl92/McPlayer-Child-Theme/</br>

The Categories Images Plugin allow you to add image with category</br>
https://WordPress.org/plugins/categories-images/</br>

This plugin is needed if you want the scroll bar to be sticky</br>
https://wordpress.org/plugins/mystickysidebar/</br>

This plugin is needed to avoid jQuery error</br>
https://fr-ca.wordpress.org/plugins/jquery-updater/</br>

## Installation
This plugin have been designed on:</br>
    -   Ubuntu Server</br>
    -   NGINX</br>
    -   PHP 7.4</br>

This section describes how to install the plugin and get it working.</br>

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

## Advandced installation

You can have yt-dlp installed on it, to download and add album playlist.</br>
https://github.com/yt-dlp</br>
https://github.com/yt-dlp/yt-dlp/wiki/Installation</br>
</br>
You can have FFMPEG installed on it, to covert to MP3 file.</br>
https://github.com/FFmpeg/FFmpeg/</br>

## Shortcode
To get info about how many you have in database</br>
[get_database_info]</br>
</br>
Show random song</br>
[pre_order_products per_page="50" columns="5" order="'rand" orderby="rand"]</br>
</br>
Show alphabet and artist</br>
[artist_get_shortcode]</br>
</br>
Show genres</br>
[genre_get_shortcode]</br>
</br>
Show all the years of all album</br>
[year_get_shortcode]</br>
</br>
Show the lasted added songs</br>
[get_new_shortcode]</br>
</br>
Show the most played songs</br>
[get_count_music per_page="175" columns="5" order="DESC" orderby="meta_value_num"]</br>
</br>
Show the lasted played songs</br>
[get_already_played per_page="10" columns="5" order="ASC" orderby="post__in"]</br>
</br>
Show suggested songs with the playlist songs genres</br>
[genres_products per_page="50" columns="5" order="rand" orderby="rand"]</br>

## Screenshot
<img style="max-width: 100%;" src="https://i.ibb.co/x7wRzmX/screencapture-192-168-2-110-artists-2024-02-19-11-26-22.png" />
<img style="max-width: 100%;" src="https://i.ibb.co/tPNyMcN/mcplayer0.jpg" />
<img style="max-width: 100%;" src="https://i.ibb.co/rvMtZG0/mcplayer1.jpg" />
<img style="max-width: 100%;" src="https://i.ibb.co/jRVZd5z/mcplayer3.jpg" />
<img style="max-width: 100%;" src="https://i.ibb.co/YXZ5cvB/mcplayer2.jpg" />
<img style="max-width: 100%;" src="https://i.ibb.co/ngzD0Dh/screencapture-173-179-89-179-artist-taktika-2023-11-18-00-16-55.png" />
<img style="max-width: 100%;" src="https://i.ibb.co/9G1DDFm/mcplayeradmin0.jpg" />
<img style="max-width: 100%;" src="https://i.ibb.co/rdL9T5S/mcplayeradmin1.jpg" />
<img style="max-width: 100%;" src="https://i.ibb.co/LJFCh3h/mcplayeradmin2.jpg" />
<img style="max-width: 100%;" src="https://i.ibb.co/JdDXRNb/playlist.png" />
<img style="max-width: 100%;" src="https://i.ibb.co/R6G5xTt/bulk-add-album.png" />

## Changelog
2.2 - fix various things, add Chart JS in admin taxonomy private page, add Paypal sandbox integration in admin taxonomy private page.</br>
2.0 - Add genre widget and shortcode to show suggested songs and fix various things.</br>
1.8 - Add a earn count play, add playlist time length to title, various fix.</br>
1.7 - Fix stuff in full album add to playlist and fix height of content to feel more like a webapp.</br>
1.6 - Remove artist private page, remove other stuff.</br>
1.5 - Add AJAX search and add load state on page refresh.</br>
1.4 - In shortcode for previously played show all user previously played.</br>
1.3 - Add albums in AJAX search.</br>
1.2 - Add shortcode to show the lasted played songs.</br>
1.0 - Add the paid-memberships-pro plugin to make free user have limited playing time, only 10% of a song.</br>
0.9 - Add play count song and most played shortcode.</br>
0.8 - Add in the bulk add album, Imagick cropImage, to remove border of image album.</br>
0.7 - Init version of bulk add album admin page.</br>
0.6 - Playlist can be save and load and shuffle and no-shuffle order work.</br>
0.5 - Not loged user, can now browser and interact with playlist and player.</br>
0.4 - Remove sticky sidebar, use overflow scroll.</br>
0.3 - Add wake lock when the tab is active, Use FFMPEG for audio compresion.</br>
0.2 - Sortable playlist.</br>
0.1 - Init release.</br>

Init version of this plugin, a lots of QA hours have been done with Chrome and Firefox, both work great.</br>
Work realy good with any version of Android.</br>