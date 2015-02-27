=== Disqus Popular Posts ===
Contributors: godthor
Tags: disqus, comments, widget, posts
Requires at least: 3.0.1
Tested up to: 4.1.1
Stable tag: 1.2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Creates a widget to show the most popular posts and pages on your site based on Disqus comments.

== Description ==

This will create a new widget to use which will display your most popular posts and pages based on comment count with Disqus.

It's very simple to use. Just drag the widget into a sidebar and configure it.

**Options Include:**

* Show featured image.
* Choose featured image size.
* Choose featured image alignment.
* Show the post date.
* Select how many days to check, IE: past 90 days.
* Set how many posts to show.
* Save the results for faster loading.

**Note:** This plugin requires you have an application registered with Disqus: https://disqus.com/api/applications/
It's free and simple to setup, just follow that link.

== Installation ==

1. Upload `dpp.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place the Disqus Popular Posts widget into a sidebar.
4. Configure the widget. This requires you have an application registered with Disqus: https://disqus.com/api/applications/

== Screenshots ==

1. An example of the widget being shown on the site.
2. A screenshot of the options screen.

== Changelog ==

= 1.2.4 =
* Verified compatability with WordPress 4.1.1

= 1.2.3 =
* Added PHP documentation.
* Rate and review link shows on the widget configuration for ease of access :)
* Moved the screenshots to the assets folder instead of the plugin folder.

= 1.2.2 =
* Unchecking **Save the Results** will now clear out any previously saved results when you reload your site. You can then check it off again, reload the site and in turn force the widget to query Disqus for updated results to save.
* Added a fail-safe if you are set to save the results and the results are empty then it will query Disqus to get results and save them.

= 1.2.1 =
* Bug fix with the **Save the Results** option where it would save them even if not selected.
* Added a database version variable to allow saved results to be reloaded as needed with plugin version changes, like this version.
* Results from Disqus will now sort on most comments *overall* in the day range, not just most comments in the given period. If you had comments on an article prior to the period you gave, IE: 30 days, and comments within the day range then those articles could sort oddly in the results. Thanks to jrrera for pointing this out.

= 1.2.0 =
* Added an option to save the Disqus results. This will reduce API calls to Disqus for your application and load faster. You can configure how frequently these results refresh.
* Cleaned up the widget and added some more informative text for the features.

= 1.1.1 =
* Updated the readme.txt

= 1.1.0 =
* Added an option to show the post date.
* Added an option for featured image alignment.

= 1.0.11 =
* Removed the previous disqus.php and replaced it with dpp.php. Sorry about this. First time with SVN.

= 1.0.1 =
* Renamed the plugin file to avoid it showing a link to settings for the Disqus plugin.
* Reformatted this readme file.

= 1.0.0 =
* Initial release.