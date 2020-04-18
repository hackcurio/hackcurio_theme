# HackCurio Theme

View the live site to see the theme in action: https://hackcur.io.

- [Main Features](#main-features)
  * [Media Metadata](#media-metadata)
  * [Other Highlights in `functions.php`](#other-highlights-in-functionsphp)
  * [Styling](#styling)
  * [OEmbed Plugin](#oembed-plugin)
- [Usage](#usage)
  * [Initial Setup](#initial-setup)
  * [Vimeo](#vimeo)
  * [Note on Image Assets](#note-on-image-assets)

## Main Features

### Media Metadata
One core problem we had to solve was developing a method for storing custom metadata on externally hosted videos. First, we use a customized plugin to create a media library object from an external URL (see the [OEmbed Plugin](#oembed-plugin) section below and find the plugin itself [here](https://github.com/hackcurio/oembed_in_library)). Then, at the beginning of `functions.php`, we define the specific metadata fields that we want (and a function to save their inputs).

Also in `functions.php`, you will find metadata definitions for entry and category pages. 

### Other Highlights in `functions.php`
A. Some helper functions: 

1. `get_thumbnail($post)`: Retrieves the thumbnail image for a post, by querying its attached media items. Returns HackCurio icon if nothing found. 

2. `get_attachment_url_by_title($title)`: Used for querying assets stored in the media library that aren’t video embeds. For example, get_attachment_url_by_title(“Twitter Logo”) is used to retrieve the Twitter logo in the footer. 

3. `get_featured_post($category)`: Each category gets a “featured post” (defined in the category_metadata functions) which is used to source a thumbnail to represent that category on the homepage. This function retrieves that associated post (not yet the thumbnail itself) when given a category. 

4. `parse_author`: Formatting help for author names in different contexts (e.g., The List, etc.). Includes support for “Last, First”, “First Last”, and multiple authors. 

B. Further oembed options: We wrap video embeds in a `div` with class `video-container`. (For now-deprecated YouTube embeds, we also remove related videos.)

C. The `session_cat($cat, $post_id, $reset)` function sets the built-in WP `$_SESSION` object to hold a value for the currently “active” category (i.e., which category to highlight in bold on the sidebar). The active category is given the built-in WP class “.current-cat”. We use this as a state variable to track the most recently visited category as users navigate through the site — admittedly of only minor use in the current version of the site, but support is already built out for posts having multiple categories. Pass a category in the first argument position to set the active category directly; pass `null, $post_id` to determine the correct category to apply for a given post (if multiple, uses currently set category if available, or else the first category of that post listed in the database); pass `null, null, true` to clear the `$_SESSION[‘active_category’]` variable. 

**NB:** There are likely other tweaks that would need to be made throughout the site to be to handle entries with multiple categories, and while this particular piece of logic is equipped to handle it, other places may assume one category per entry. 

D. Within the `load_scripts` section, we use `wp_localize_script` to pass PHP data to Javascript to handle display options for The List page. The data chunks are defined that `load_scripts` section of `functions.php`, and then passed to `the-list-toggle.js` script. This script assembles the data chunks in the correct format to view The List by author or by date, and attaches them to `.the-list-toggle` class element in `page-the-list.php`. 

You may notice some commented-out code throughout for a “homepage slideshow”. This is a deprecated feature that could optionally be turned back on, though it may need some further styling to match the latest design features. 

### Styling
Most style rules should be self-explanatory from the CSS. Classes are reused across page types as much as possible. One handy convention worth mentioning is the `.slash` class: text with this class appears with a H_C-red slash before it. 

### OEmbed Plugin
This theme is designed to work with the [OEmbed in Library plugin](https://github.com/hackcurio/oembed_in_library), which is a custom modification of a now-deprecated external [plugin](https://wordpress.org/plugins/oembed-in-library/).

## Usage
### Initial Setup
After a standard Wordpress install, download the repository into `wp-content/themes`. Then download the [OEmbed in Library plugin](https://github.com/hackcurio/oembed_in_library) into `wp-content/plugins`.

### Vimeo
We use Vimeo for our external video hosting. The [Vimeo PHP library](https://github.com/vimeo/vimeo.php) is included, and should be kept updated with future Wordpress upgrades. You will need to set values for `VIMEO_CLIENT_ID`, `VIMEO_CLIENT_SECRET`, and `VIMEO_ACCESS_TOKEN` in `wp-config.php`. Other hosts can be configured; there is partial (vestigial) support for YouTube links.

### Note on Image Assets
You will need to upload your own logo/image assets if you are making use of those features. These assets are typically called by their name in the media library (e.g., “Twitter Logo” is called in `footer.php`). If you are using Twitter, most pages are configured to generate [Twitter Cards](https://developer.twitter.com/en/docs/tweets/optimize-with-cards/guides/getting-started) automatically; however, you may want to add a screenshot of your homepage to use when tweeting out links to the homepage (by default, `index.php` looks for a media item named “Homepage Screenshot”).
