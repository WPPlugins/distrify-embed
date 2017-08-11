=== Distrify Embed ===
Contributors: distrify
Donate link: http://distrify.com/
Tags: video, movies, embed, share, distrify, muvies
Requires at least: 2.9.0
Tested up to: 3.9
Stable tag: trunk

Extends WordPress's Embeds allowing bloggers to easily embed movie trailers from Distrify.

== Description ==

Extends WordPress's [Embeds](http://codex.wordpress.org/Embeds "WordPress Embeds") allowing bloggers to easily embed videos from Distrify. Just go to any Distrify film page or player and copy the URL. Paste that URL in any WordPress blog and it will automatically be converted to an embedded Distrify player. If you are logged in to [distrify.com](http://distrify.com/) it will automatically add your affiliate tracking code to your embeds. Make sure you turn on Auto-embeds in your WP settings and also make sure that the URL is on its own line and not hyperlinked (clickable when viewing the post).

The plugin also extracts the still image from the film and saves it as the [Featured Image](http://codex.wordpress.org/Post_Thumbnails "WordPress Featured Images") for the post. This actually works for any Embed (not just Distrify) that you embed into your WordPress blog.

== Installation ==

This section describes how to install the plugin and get it working.

= Method 1: Quick-install via WordPress Admin =

1. From your Admin Dashboard, click on "Plugins" in the sidebar.
1. Then click "Add New" at the top of the page.
1. Type "Distrify" in the search box and click "Search Plugins"
1. Click "Install Now" under *Distrify Embed* - The plugin will download and install to your server.
1. On the next screen, click "Activate Plugin"
1. Go to [Distrify](http://distrify.com "Distrify") and to your film page and copy the URL (e.g. http://distrify.com/films/1-J...)
1. Paste the URL in a blog post or a page. Make sure the URL is on its own line and not hyperlinked.

= Method 2: Advanced install via FTP =

1. Upload the `distrify_embed_wp` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to [Distrify](http://distrify.com "Distrify") and to your film page and copy the URL (e.g. http://distrify.com/films/1-J...)
1. Paste the URL in a blog post or a page. Make sure the URL is on its own line and not hyperlinked.

== Frequently Asked Questions ==

= What is Distrify? =

[Distrify is the revolution in online film distribution and marketing](http://distrify.com/ "Distrify Website")

= Can I embed a Distrify player on a blog hosted on WordPress.COM? =

Currently the "hosted" version of WordPress does not support many external embeds and won't let you install themes or plugins. If you're using the WordPress.com service, why not move your blog to a different host? 
Or you can ask WordPress to support the Distrify player Embed. Contact WordPress here: http://en.support.wordpress.com/contact/

= Where can I find more films to embed? =

Have a look at the films on [muvies.com](http://muvies.com/ "Muvies")

== Screenshots ==

1. Paste the URL in a post or page
2. It will automatically be converted to an embedded Distrify player

== Changelog ==

= 0.3.1 = 
* Confirmed support for WordPress 3.9

= 0.3 = 
* Added support for muvies.com URLs and for URLs from Muvies collections.
* Save Featured Image to the post (affects all WordPress Embeds, not just Distrify).

= 0.2 = 
* Changed to add the provider on plugins_loaded.

= 0.1.1 =
* Updated compatibility.

= 0.1 =
* This is the first version!

== Upgrade Notice ==

= 0.2 = 
* Necessary for newer versions of WordPress (e.g. 3.2 or greater).

= 0.1.1 =
* This is the first version!