=== Term Featured Image Fallback ===
Contributors: Eduardo Lazaro
Tags: term, taxonomy, featured image, featured, thumbnail, custom post type, post, page, custom post type, category, tag
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=PKKYCEKCNCCCU
Requires at least: 4.4
Tested up to: 4.7.3
Stable tag: trunk
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html

Enables featured images for terms of any category, tag or custom taxonomy and set them as fallback for posts of any post type.

== Description ==

Features:

1. Add featured images to all terms of any taxonomy, including, categories, tags or terms of any custom taxonomy.
2. Set a fallback option for posts of any post type so they use term featured images as fallback for post featured images.
3. Set a priority in terms so the each post uses the higher priority featured image as fallback in case the post has many terms associated.
4. Set also a priority in taxonomies in case a post has one or more terms of different taxonomies associated.
5. Enable and disable the fallback option by post type.
6. Clean uninstall option to delete all data related to this plugin so you can keep your database clean.
7. If you are a developer, you can use the cs__the_term_thumbnail() and the cs__get_term_thumbnail_id() functions to get the featured image or the featured image id for any term.

== Installation ==

1. Unzip and upload the "taxonomy-featured-images" directory to the plugin directory (`/wp-content/plugins/`)

2. Activate the plugin through the 'Plugins' menu in WordPress

== Tutorial ==
1. Go to Appearance -> Taxonomy images

2. In "Taxonomy configuration" you have a list of taxonomies.
2.1. In the first select box you can select here whether its terms should have a featured image.
2.2. In the second select box you can select if posts should use this taxonomy as a fallback for the featured image in case they have a term associated.
     You can also select the priority in case they have terms of more than one taxonomy.
2.3. In the "Post type configuration" area there's a list of post types. You can select if the taxonomy featured image fallback should be enabled or disabled for each post type.

3. If you go to the page of a taxonomy in which the featured image is enabled, you should be able to upload a featured image and also to set the priority, in case a post has more than one term of this taxonomy.
4. Functions for developers:

4.1. cs__the_term_thumbnail($termid[OPTIONAL])
	 You can use this function to print the term featured image in case there's one selected.
	 You can pass the termid parameter to print the image for a term.
	 If you don't pass the termid parameter, it will print the current taxonomy image in case tou are in a term archive page or if there is a term in the current query.
4.2. cs__get_term_thumbnail_id($termid[OPTIONAL])
	 You can use this function to get the the term featured image id in case there's one selected.
	 You can pass the termid parameter to get the featured image id of that term.
	 If you don't pass the termid parameter, it will get the current taxonomy image id in case tou are in a term archive page or if there is a term in the current query.	

== Changelog ==

= 1.0 =
* Initial release