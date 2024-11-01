=== Plugin Name ===Contributors: jgwhite33Donate link: http://www.wiredmamas.com/wp-ebay-ads/Tags: ebay, auction, affiliate, listing, product, multi-author, revenue share, ads, monetizeRequires at least: 2.5Tested up to: 4.4.2Stable tag: trunk
WP eBay Ads - allows you to easily insert eBay product listings into your WP posts, and earn commission from sales.
== Description ==
Allows you to insert a listing of related eBay products, on the single post page by using a custom field called ebay_search and either the shortcode
[wpebayads] directly in your post or by inserting simple code in your template file.
The listings are completely customizable according to parameters defined in the admin panel. 
If you include an eBay Partner Network campaign ID, you can earn money from traffic you drive to ebay!
Also allows you to share revenue with your authors on a multi-author blog. Creates a custom field on the author profile pages so they can input their campaign ID. Whoever wrote the post gets credit in the listing.
A few of the features:
*   Specify the search with a custom field in the post called ebay_search
*   Use a shortcode to insert or code in your template file
*   Allows you to use the eBay Partner Network
*   Allows multi-author blogs to share revenue, you can even specify the percentage to share
*   Can share revenue with the author of the post if you desire
*   Uses advanced search parameters
*   Display is easily customizable
*   Hides the affiliate link to ebay== Installation ==
WP eBay Ads is installed like any other Wordpress plugin.
1) Download the latest package from the downloads page (http://wordpress.org/extend/plugins/wp-ebay-ads/).
2) Upload the whole directory into your wordpress plugins directory (usually, yoursite/wp-content/plugins). The plugin must reside in a sub-folder called "wp-ebay-ads" (lower-case!) as supplied in the zip file, else it WON’T WORK
3) Go into the Wordpress admin panel, find Plugins and WP eBay Ads should be listed. Click Activate to activate!
Using WP eBay Ads
There are two ways to use WP eBay Ads. Pick either 1) or 2) then move to step 3).
1) Place the following shortcode directly in your post.
`[wpebayads]`
2) You can also get the listings by placing the following code in your template file for your single post. Usually called single.php. Place it inside the loop. I like to place it right after the_content tag.
`<?php if(function_exists('wp_ebay_ads')) {wp_ebay_ads($post->ID);}?>`
* After you either use the shortcode in your post or edit your template file then all you have to do is add a custom field to the post called ebay_search. Set the value for what you are searching for.
ex:
Name: ebay_search
Value: ipod3) View the post and you should see the listing show up.
4) Go to the "WP eBay Ads" admin panel under the Settings dropdown, and modify what you would like.
5) For multi-author blogs, each author needs to enter their campaign ID on their profile page in the input field added at the bottom.
Notes: * If the ebay_search custom field is not used or blank then the ads will not be displayed.* You can use the [wpebayads] shortcode method and the template code method at the same time.
More about search terms:
It can be difficult to target searches, so here are some more tips :
*  green lamp - this is logical, a space between the words means all products with "green" and "lamp" in the title.
*  "green lamp" - exact phrase match means the exact phrase "green lamp" must be found in the product title
*  lamp -green - AND NOT - searches for all occurrences of "lamp", but minus sign excludes any titles with "green". No green lamps here!
*  (lamp,"bedside table") - OR - brackets apply logical OR (also AND/OR I think) to all items in the brackets, whether single keywords or phrases, i.e. this will find all items with either "lamp" OR "bedside table".
*  ("old lamp","old telephone") -green - find all items with either "old lamp" or "old telephone" in the title, but excluding "green".
*  lamp -(book,CD) - this will search on "lamp" BUT will exclude "book" and/or "CD". This type of search is especially useful as it allows you to eliminate most of the junk/irrelevant items like "My Old Lamp CD" and narrow the search down to just actual lamps! Though some of these searches can get quite long, and there is a limit to the number of terms. Just experiment.
By the way,  you are not suppose to put spaces after commas or minus signs.
There is more help on the relevant eBay page (http://pages.ebay.com/help/search/advanced-search.html?fromFeature=Advanced%20Search).
== Frequently Asked Questions ==
= I don't see the mulit-author settings. =You must be using Wordpress V2.8 or higher.= Why should I contribute or leave the powered by link? =Because you're a cool person and like to show your appreciation.== Screenshots ==
1. View of post page2. Admin options3. Admin options== Changelog ==
= 1.7 =* fixed issue with currency not displaying correctly= 1.6 =* minor bug fixes= 1.5 =* minor bug fixes
= 1.4 =* minor bug fixes= 1.3 =* Fixed error with hidden ebay link redirect.= 1.2 =* Added the ability to use shortcode. [wpebayads] now inserts auction listings in your posts. Still need to set the ebay_search custom field.= 1.1 =* Updated search term code to include more results from ebay.= 1.0 =* No changes, first released version.== Upgrade Notice ==
= 1.5 = Upgrade to fix minor bugs with styles.= 1.4 = Upgrade to fix minor bugs.= 1.3 = Upgrade to fix error with hidden ebay link redirect.




