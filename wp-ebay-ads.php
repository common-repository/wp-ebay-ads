<?php
/*
Plugin Name: WP eBay Ads
Plugin URI: http://www.freelogohub.com/wp-ebay-ads/
Description: Integrate eBay ads on to your posts pages and make money with ebay partner network.
Version: 1.7
Author: jw
Author URI: http://www.ljapps.com
License: GPL
*/

//-------add shortcode---------------------------

add_shortcode('wpebayads', 'wp_ebay_ads_short');

function wp_ebay_ads_short()
{
if(is_single()){
//ini_set('display_errors',1);
//error_reporting(E_ALL|E_STRICT);

//get post_id and pass to main function
$postid = get_the_ID();

//find query from custom field-------------
$query = get_post_meta($postid, 'ebay_search', true);

if($query!=""){
include('shortfunctions.php');

$display = wp_ebay_ads_short_dis($postid,$query);

return $display;
}

}
}


//--------------------------install, uninstall---------------
/* Runs when plugin is activated */
register_activation_hook(__FILE__,'wp_ebay_ads_install'); 

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'wp_ebay_ads_remove' );

function wp_ebay_ads_install() {
/* Creates new database field */
add_option("wp_ebay_ads_campid", '5336611530', '', 'yes');
add_option("wp_ebay_ads_campid_multi", 'no', '', 'yes');
add_option("wp_ebay_ads_author_share", '0', '', 'yes');
add_option("wp_ebay_ads_dis_icon", 'yes', '', 'yes');
add_option("wp_ebay_ads_dis_search_bar", 'yes', '', 'yes');
add_option("wp_ebay_ads_cl_top_bar", 'E4E4E4', '', 'yes');
add_option("wp_ebay_ads_cl_top_txt", '000000', '', 'yes');
add_option("wp_ebay_ads_row_color", 'FFFFFF', '', 'yes');
add_option("wp_ebay_ads_alt_row_color", 'E7E7E7', '', 'yes');
add_option("wp_ebay_ads_cl_title_txt", '000000', '', 'yes');
add_option("wp_ebay_ads_cl_details_txt", '000000', '', 'yes');
add_option("wp_ebay_ads_cl_bot_bar", 'E4E4E4', '', 'yes');
add_option("wp_ebay_ads_cl_bot_txt", '000000', '', 'yes');
add_option("wp_ebay_ads_num_rows", '6', '', 'yes');
add_option("wp_ebay_ads_contribute", '5', '', 'yes');
add_option("wp_ebay_ads_linkback", 'yes', '', 'yes');
add_option("wp_ebay_ads_row_highlight", 'F9F9F9', '', 'yes');
//filter and sort
add_option("wp_ebay_ads_globalid", 'EBAY-US', '', 'yes');
add_option("wp_ebay_ads_search_desc", 'False', '', 'yes');
add_option("wp_ebay_ads_category", '', '', 'yes');
add_option("wp_ebay_ads_auct_type", 'All', '', 'yes');
add_option("wp_ebay_ads_min_price", '', '', 'yes');
add_option("wp_ebay_ads_max_price", '', '', 'yes');
add_option("wp_ebay_ads_min_bids", '', '', 'yes');
add_option("wp_ebay_ads_max_bids", '', '', 'yes');
add_option("wp_ebay_ads_condition", '', '', 'yes');
add_option("wp_ebay_ads_sort_by", 'BestMatch', '', 'yes');
add_option("wp_ebay_ads_zip", '', '', 'yes');
}

function wp_ebay_ads_remove() {
/* Deletes the database field */
delete_option('wp_ebay_ads_campid');
delete_option('wp_ebay_ads_campid_multi');
delete_option('wp_ebay_ads_author_share');
delete_option('wp_ebay_ads_dis_icon');
delete_option('wp_ebay_ads_dis_search_bar');
delete_option('wp_ebay_ads_cl_top_bar');
delete_option('wp_ebay_ads_cl_top_txt');
delete_option('wp_ebay_ads_row_color');
delete_option('wp_ebay_ads_alt_row_color');
delete_option('wp_ebay_ads_cl_title_txt');
delete_option('wp_ebay_ads_cl_details_txt');
delete_option('wp_ebay_ads_cl_bot_bar');
delete_option('wp_ebay_ads_cl_bot_txt');
delete_option('wp_ebay_ads_num_rows');
delete_option('wp_ebay_ads_contribute');
delete_option('wp_ebay_ads_linkback');
delete_option('wp_ebay_ads_row_highlight');
//filter and sort
delete_option('wp_ebay_ads_globalid');
delete_option('wp_ebay_ads_search_desc');
delete_option('wp_ebay_ads_category');
delete_option('wp_ebay_ads_auct_type');
delete_option('wp_ebay_ads_min_price');
delete_option('wp_ebay_ads_max_price');
delete_option('wp_ebay_ads_min_bids');
delete_option('wp_ebay_ads_max_bids');
delete_option('wp_ebay_ads_condition');
delete_option('wp_ebay_ads_sort_by');
delete_option('wp_ebay_ads_zip');
}


//---------------------admin settings page-------------
if ( is_admin() ){
/* Call the html code */
add_action('admin_menu', 'wp_ebay_ads_admin_menu');

function wp_ebay_ads_admin_menu() {
add_options_page('WP eBay Ads', 'WP eBay Ads', 'administrator','wp-ebay-ads', 'wp_ebay_ads_html_page');
}
}

function wp_ebay_ads_html_page() {
?>
<script type="text/javascript" src="<? echo get_bloginfo('wpurl'); ?>/wp-content/plugins/wp-ebay-ads/jscolor.js"></script>

<div>
<h2>WP eBay Ads Options</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table width="800">
<tr valign="top">
 <td><b>Enter Admin Campaign ID:</b>
 <input name="wp_ebay_ads_campid" type="text" id="wp_ebay_ads_campid"
 value="<?php echo get_option('wp_ebay_ads_campid'); ?>" />
<br>(You need this to make money from eBay partner network.)<br><br></td>
</tr>
<?
if(function_exists('get_the_author_meta')) {
?>
<tr valign="top">
 <td scope="row"><b>Share revenue with your authors (optional):</b>
  <select name="wp_ebay_ads_campid_multi">
  <option value="<?php echo get_option('wp_ebay_ads_campid_multi'); ?>"><?php echo get_option('wp_ebay_ads_campid_multi'); ?></option>
  <option value="yes">yes</option>
  <option value="no">no</option>
  </select>
</td>
</tr>
<tr valign="top">
 <td>
(This will replace the admin campaign ID on the single post page with the one for the author who created the post.
A field will be displayed on the author profile page where they can enter their campaign ID.)<br><br>
</td>
</tr>

<?
if(get_option('wp_ebay_ads_campid_multi')=="yes"){
?>
<tr valign="top">
 <td><b>Enter the percentage you would like to deduct from your authors:</b>
 <input size="3" name="wp_ebay_ads_author_share" type="text" id="wp_ebay_ads_author_share"
 value="<?php echo get_option('wp_ebay_ads_author_share'); ?>" />%
 <br>(This allows you to deduct a percentage from your authors posts. If you set this at 5% then 5% of the time your campaing ID
 will be used instead of the author's. Set this to zero to give the author complete credit.)<br><br>
</td>
</tr>
<?
}
}
?>

</table>

<table width="800">
<tr valign="top">
 <th colspan="2" scope="row"><br><br><big><u>Display Options</u></big><br><br></th>
</tr>
<tr valign="top">
 <th scope="row">Display eBay icon:</th>
 <td>
  <select name="wp_ebay_ads_dis_icon">
  <option value="<?php echo get_option('wp_ebay_ads_dis_icon'); ?>"><?php echo get_option('wp_ebay_ads_dis_icon'); ?></option>
  <option value="yes">yes</option>
  <option value="no">no</option>
  </select>
 </td>
</tr>
<tr valign="top">
 <th scope="row">Display Search Field:</th>
 <td>
  <select name="wp_ebay_ads_dis_search_bar">
  <option value="<?php echo get_option('wp_ebay_ads_dis_search_bar'); ?>"><?php echo get_option('wp_ebay_ads_dis_search_bar'); ?></option>
  <option value="yes">yes</option>
  <option value="no">no</option>
  </select>
 </td>
</tr>
<tr valign="top">
 <th scope="row">Background color for header bar:</th>
 <td>
 <input class="color" name="wp_ebay_ads_cl_top_bar" type="text" id="wp_ebay_ads_cl_top_bar"
 value="<?php echo get_option('wp_ebay_ads_cl_top_bar'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Text color for header bar:</th>
 <td>
 <input class="color" name="wp_ebay_ads_cl_top_txt" type="text" id="wp_ebay_ads_cl_top_txt"
 value="<?php echo get_option('wp_ebay_ads_cl_top_txt'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Row background color:</th>
 <td>
 <input class="color" name="wp_ebay_ads_row_color" type="text" id="wp_ebay_ads_row_color"
 value="<?php echo get_option('wp_ebay_ads_row_color'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Alternate Row background color:</th>
 <td>
 <input class="color" name="wp_ebay_ads_alt_row_color" type="text" id="wp_ebay_ads_alt_row_color"
 value="<?php echo get_option('wp_ebay_ads_alt_row_color'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Row background mouse-over highlight color:</th>
 <td>
 <input class="color" name="wp_ebay_ads_row_highlight" type="text" id="wp_ebay_ads_row_highlight"
 value="<?php echo get_option('wp_ebay_ads_row_highlight'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Auction title text color:</th>
 <td>
 <input class="color" name="wp_ebay_ads_cl_title_txt" type="text" id="wp_ebay_ads_cl_title_txt"
 value="<?php echo get_option('wp_ebay_ads_cl_title_txt'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Auction details text color:</th>
 <td>
 <input class="color" name="wp_ebay_ads_cl_details_txt" type="text" id="wp_ebay_ads_cl_details_txt"
 value="<?php echo get_option('wp_ebay_ads_cl_details_txt'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Background color for footer bar:</th>
 <td>
 <input class="color" name="wp_ebay_ads_cl_bot_bar" type="text" id="wp_ebay_ads_cl_bot_bar"
 value="<?php echo get_option('wp_ebay_ads_cl_bot_bar'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Text color for footer bar:</th>
 <td>
 <input class="color" name="wp_ebay_ads_cl_bot_txt" type="text" id="wp_ebay_ads_cl_bot_txt"
 value="<?php echo get_option('wp_ebay_ads_cl_bot_txt'); ?>" /></td>
</tr>
<tr valign="top">
 <th scope="row">Number of auctions to list:</th>
 <td>
 <input name="wp_ebay_ads_num_rows" type="text" id="wp_ebay_ads_num_rows"
 value="<?php echo get_option('wp_ebay_ads_num_rows'); ?>" /></td>
</tr>
</table>


<table width="800">
<tr valign="top">
 <th colspan="2" scope="row"><br><br><big><u>Search Results Filter</u></big><br><br></th>
</tr>
<tr valign="top">
 <th scope="row">eBay Global ID (ex: EBAY-US):</th>
 <td>
 <input name="wp_ebay_ads_globalid" type="text" id="wp_ebay_ads_globalid"
 value="<?php echo get_option('wp_ebay_ads_globalid'); ?>" /> - click <a href="http://developer.ebay.com/devzone/finding/CallRef/Enums/GlobalIdList.html" target="_blank">here</a> for list.
</td>
</tr>
<tr valign="top">
 <th scope="row">Search Title and Description (slows down results):</th>
 <td>
  <select name="wp_ebay_ads_search_desc">
  <option value="<?php echo get_option('wp_ebay_ads_search_desc'); ?>"><?php echo get_option('wp_ebay_ads_search_desc'); ?></option>
  <option value="false">False</option>
  <option value="true">True</option>
  </select>
 </td>
</tr>

<tr valign="top">
 <th scope="row">Search in a Specific Category (optional):</th>
 <td>
 <input name="wp_ebay_ads_category" type="text" id="wp_ebay_ads_category"
 value="<?php echo get_option('wp_ebay_ads_category'); ?>" /> - click <a href="http://pages.ebay.com/sellerinformation/growing/categorychanges.html" target="_blank">here</a> for list.
</td>
</tr>
<tr valign="top">
 <th scope="row">Auction Type:</th>
 <td>
  <select name="wp_ebay_ads_auct_type">
  <option value="<?php echo get_option('wp_ebay_ads_auct_type'); ?>"><?php echo get_option('wp_ebay_ads_auct_type'); ?></option>
  <option value="All">All</option>
  <option value="AdFormat">AdFormat</option>
  <option value="Auction">Auction</option>
  <option value="AuctionWithBIN">AuctionWithBIN</option>
  <option value="Classified">Classified</option>
  <option value="FixedPrice">FixedPrice</option>
  <option value="StoreInventory">StoreInventory</option>
  </select>
 </td>
</tr>
<tr valign="top">
 <th scope="row">Minimum Price (optional):</th>
 <td>
 <input name="wp_ebay_ads_min_price" type="text" id="wp_ebay_ads_min_price"
 value="<?php echo get_option('wp_ebay_ads_min_price'); ?>" />
</td>
</tr>
<tr valign="top">
 <th scope="row">Maximum Price (optional):</th>
 <td>
 <input name="wp_ebay_ads_max_price" type="text" id="wp_ebay_ads_max_price"
 value="<?php echo get_option('wp_ebay_ads_max_price'); ?>" />
</td>
</tr>
<tr valign="top">
 <th scope="row">Minimum Bids (optional):</th>
 <td>
 <input name="wp_ebay_ads_min_bids" type="text" id="wp_ebay_ads_min_bids"
 value="<?php echo get_option('wp_ebay_ads_min_bids'); ?>" />
</td>
</tr>
<tr valign="top">
 <th scope="row">Maximum Bids (optional):</th>
 <td>
 <input name="wp_ebay_ads_max_bids" type="text" id="wp_ebay_ads_max_bids"
 value="<?php echo get_option('wp_ebay_ads_max_bids'); ?>" />
</td>
</tr>
<tr valign="top">
 <th scope="row">Condition:</th>
 <td>
  <select name="wp_ebay_ads_condition">
  <option value="<?php echo get_option('wp_ebay_ads_condition'); ?>"><?php echo get_option('wp_ebay_ads_condition'); ?></option>
  <option value="">All Conditions</option>
  <option value="New ">New </option>
  <option value="Used">Used</option>
  <option value="Unspecified ">Unspecified</option>
  </select>
 </td>
</tr>
</table>


<table width="800">
<tr valign="top">
 <th colspan="2" scope="row"><br><br><big><u>Search Results Sort Options</u></big><br><br></th>
</tr>
<tr valign="top">
 <th scope="row">Sort by:</th>
 <td>
  <select name="wp_ebay_ads_sort_by">
  <option value="<?php echo get_option('wp_ebay_ads_sort_by'); ?>"><?php echo get_option('wp_ebay_ads_sort_by'); ?></option>
  <option value="BestMatch">Best Match</option>
  <option value="CurrentPriceHighest">Price High to Low</option>
  <option value="DistanceNearest">Distance (must enter postal code below)</option>
  <option value="EndTimeSoonest">Ending Soonest</option>
  <option value="PricePlusShippingHighest">Price+Shipping High to Low</option>
  <option value="PricePlusShippingLowest">Price+Shipping Low to High</option>
  <option value="StartTimeNewest">Newest Listed</option>
  </select>
 </td>
</tr>
<tr valign="top">
 <th scope="row">5-digit Zip Code (only required if using the distance sort option):</th>
 <td>
 <input name="wp_ebay_ads_zip" type="text" id="wp_ebay_ads_zip"
 value="<?php echo get_option('wp_ebay_ads_zip'); ?>" /></td>
</tr>
</table>


<table width="800">
<tr valign="top">
 <td><br><br><b><big><u>Please Help Support This Plugin:</u></big></b><br></td>
</tr>
<tr valign="top">
 <td><b>Enter the percentage you would like to donate to this plugin:</b>
 <input size="3" name="wp_ebay_ads_contribute" type="text" id="wp_ebay_contribute"
 value="<?php echo get_option('wp_ebay_ads_contribute'); ?>" />%
 <br>(This will replace your campaign ID with a donation one. If you leave at 5% then only 5 out of 100 times my campaing ID will be used.
 Setting it to anything lower than 5% will make me sad.)<br><br>
</td>
</tr>
<tr valign="top">
 <td scope="row"><b>Keep "Powered By" link active:</b>
  <select name="wp_ebay_ads_linkback">
  <option value="<?php echo get_option('wp_ebay_ads_linkback'); ?>"><?php echo get_option('wp_ebay_ads_linkback'); ?></option>
  <option value="yes">yes</option>
  <option value="no">no</option>
  </select>
 <br>(Please consider leaving this set to yes and show some love for this plug-in. Especially if you enjoy using it.)<br><br>
</td>
</tr>
</table>








<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="
wp_ebay_ads_campid,
wp_ebay_ads_campid_multi,
wp_ebay_ads_author_share,
wp_ebay_ads_dis_icon,
wp_ebay_ads_dis_search_bar,
wp_ebay_ads_cl_top_bar,
wp_ebay_ads_cl_top_txt,
wp_ebay_ads_row_color,
wp_ebay_ads_alt_row_color,
wp_ebay_ads_row_highlight,
wp_ebay_ads_cl_title_txt,
wp_ebay_ads_cl_details_txt,
wp_ebay_ads_cl_bot_bar,
wp_ebay_ads_cl_bot_txt,
wp_ebay_ads_num_rows,
wp_ebay_ads_contribute,
wp_ebay_ads_linkback,
wp_ebay_ads_query,
wp_ebay_ads_globalid,
wp_ebay_ads_search_desc,
wp_ebay_ads_category,
wp_ebay_ads_auct_type,
wp_ebay_ads_min_price,
wp_ebay_ads_max_price,
wp_ebay_ads_min_bids,
wp_ebay_ads_max_bids,
wp_ebay_ads_condition,
wp_ebay_ads_sort_by,
wp_ebay_ads_zip" />

<p>
<input type="submit" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>







<?php
}
//-----------------------end admin page---------------------------------

//----------------------custom user fields-----------------------------
if(function_exists('get_the_author_meta')) {
add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { 
?>

	<h3>Extra profile information</h3>

	<table class="form-table">

		<tr>
			<th><label for="twitter">eBay Campaign ID:</label></th>

			<td>
				<input type="text" name="wp_ebay_ads_ebcampid" id="wp_ebay_ads_ebcampid" value="<?php echo esc_attr( get_the_author_meta( 'wp_ebay_ads_ebcampid', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Enter your eBay Campaign ID to make money from the auctions listed on your post by WP eBay Ads plugin.</span>
			</td>
		</tr>

	</table>
<?php 
}

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, 'wp_ebay_ads_ebcampid', $_POST['wp_ebay_ads_ebcampid'] );
}
}
//----------------to display on site......the_author_meta( $meta_key, $user_id );

//-------------------------------------------------------------------------
    function getPrettyTimeFromEbayTime($eBayTimeString){
        // Input is of form 'PT12M25S'
        $matchAry = array(); // initialize array which will be filled in preg_match
        $pattern = "#P([0-9]{0,3}D)?T([0-9]?[0-9]H)?([0-9]?[0-9]M)?([0-9]?[0-9]S)#msiU";
        preg_match($pattern, $eBayTimeString, $matchAry);
        
        $days  = (int) $matchAry[1];
        $hours = (int) $matchAry[2];
        $min   = (int) $matchAry[3];    // $matchAry[3] is of form 55M - cast to int 
        //$sec   = (int) $matchAry[4];
        
        $retnStr = '';
        if ($days)  { $retnStr .= "$days day"    . pluralS($days);  }
        if ($hours) { $retnStr .= " $hours hr" . pluralS($hours); }
        if ($min)   { $retnStr .= " $min min" . pluralS($min);   }
        //if ($sec)   { $retnStr .= " $sec sec" . pluralS($sec);   }
        
        return $retnStr;
    } // function

    function pluralS($intIn) {
        // if $intIn > 1 return an 's', else return null string
        if ($intIn > 1) {
            return 's';
        } else {
            return '';
        }
    }

?>
