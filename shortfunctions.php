<?php
//ini_set('display_errors',1);  
//error_reporting(E_ALL);

function wp_ebay_ads_short_dis($postid,$query)
{



if($query!=""){

//$query = str_replace(' ', '+', $query);

//---------get saved options
$admin_campid=get_option('wp_ebay_ads_campid');

if(function_exists('get_the_author_meta')) {
$author_campid = get_the_author_meta( 'wp_ebay_ads_ebcampid');
}

$use_multi_campid=get_option('wp_ebay_ads_campid_multi');
$multi_share_amount=get_option('wp_ebay_ads_author_share');
$dis_icon=get_option('wp_ebay_ads_dis_icon');
$dis_search_bar=get_option('wp_ebay_ads_dis_search_bar');
$cl_top_bar="#".get_option('wp_ebay_ads_cl_top_bar');
$cl_top_txt="#".get_option('wp_ebay_ads_cl_top_txt');
$row_color="#".get_option('wp_ebay_ads_row_color');
$alt_row_color="#".get_option('wp_ebay_ads_alt_row_color');
$cl_title_txt="#".get_option('wp_ebay_ads_cl_title_txt');
$cl_details_txt="#".get_option('wp_ebay_ads_cl_details_txt');
$cl_bot_bar="#".get_option('wp_ebay_ads_cl_bot_bar');
$cl_bot_txt="#".get_option('wp_ebay_ads_cl_bot_txt');
$row_highlight="#".get_option('wp_ebay_ads_row_highlight');
$num_rows=get_option('wp_ebay_ads_num_rows');
$contribute=get_option('wp_ebay_ads_contribute');
$linkback=get_option('wp_ebay_ads_linkback');

//set campaign id
if($use_multi_campid=="yes"){
	$temp_per = rand(1,100);
	if($multi_share_amount<=$temp_per){
		$campid = $author_campid;
	} else {
		$campid = $admin_campid;
	} 
} else {
	$campid = $admin_campid;
}

//set donation amount
if($contribute>0){
	$temp_per2 = rand(1,100);
	if($contribute>$temp_per2){
		$campid = "5336611530";
	}
}

if($campid==""){
$campid = "5336611530";
}



//get sort and filter options
	$globalid=get_option('wp_ebay_ads_globalid');	// Global ID of the eBay site you want to search (e.g., EBAY-US)
	$search_desc=get_option('wp_ebay_ads_search_desc');
	$category=get_option('wp_ebay_ads_category');
	$auct_type=get_option('wp_ebay_ads_auct_type');
	$min_price=get_option('wp_ebay_ads_min_price');
$min_price = preg_replace ('/[^\d\s]/', '', $min_price);
	$max_price=get_option('wp_ebay_ads_max_price');
$max_price = preg_replace ('/[^\d\s]/', '', $max_price);
	$min_bids=get_option('wp_ebay_ads_min_bids');
	$max_bids=get_option('wp_ebay_ads_max_bids');
	$condition=get_option('wp_ebay_ads_condition');
	$sort_by=get_option('wp_ebay_ads_sort_by');
	$zip=get_option('wp_ebay_ads_zip');

//error_reporting(E_ALL);  // Turn on all errors, warnings and notices for easier debugging

// API request variables
$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
$version = '1.0.0';  // API version supported by your application
$appid = 'JWWhite81-afcb-41c1-9945-b21d6866e6a';  // Replace with your own AppID

$filterArray =
	array(
	  array(
		'name' => 'MaxPrice',
		'value' => $max_price,
		'paramName' => 'Currency',
		'paramValue'  => 'USD'),
	  array(
		'name' => 'MinPrice',
		'value' => $min_price,
		'paramName' => 'Currency',
		'paramValue'  => 'USD'),

	  array(
		'name' => 'MaxBids',
		'value' => $max_bids,
		'paramName' => '',
		'paramValue'  => ''),

	  array(
		'name' => 'MinBids',
		'value' => $min_bids,
		'paramName' => '',
		'paramValue'  => ''),

	  array(
		'name' => 'Condition',
		'value' => $condition,
		'paramName' => '',
		'paramValue'  => ''),

	  array(
		'name' => 'ListingType',
		'value' => $auct_type,
		'paramName' => '',
		'paramValue'  => ''),
	); 

for ($counter = 0; $counter <= 4; $counter += 1) {
	if($filterArray[$counter]['value']==""){
	unset($filterArray[$counter]);
	}
}


  // Build item filters URL array
  function buildURLArray2 ($filterArray) {
    global $filter1;
    //global $i;
	$i = '0';  // Initialize the item filter index array to 0
    // Iterate through each filter in the array

    foreach($filterArray as $itemFilter) {
      // Iterate through each key in the filter

      foreach ($itemFilter as $key =>$value) {
        $r = '0'; //A number that increments each time the above "for" loops;

        if(is_array($value)) { //if the 'value' var content is an array
          if($value != "") { //check to make sure the content isn't empty
            foreach($value as $j => $content) {
              $filter1 .= "&itemFilter($i).$key($j)=$content";
            }
          }
        }
        else { //this isnt an array so just print the single contents of the 'value' container, no indexing of keys needed
          if($value != "") {
            $filter1 .= "&itemFilter($i).$key=$value";
          }
        }
        $r++;
      }
      $i++;
    }
    return $filter1;
  } // End of buildURLArray function


$urlfilter=buildURLArray2($filterArray);

// Load the call and capture the document returned by eBay API

$search = $query;
$SafeQuery = urlencode($query);  // Make the query URL-friendly
// Construct the findItemsAdvanced call 
$apicall = "$endpoint?";
$apicall .= "OPERATION-NAME=findItemsAdvanced";
$apicall .= "&SERVICE-VERSION=$version";
$apicall .= "&SECURITY-APPNAME=$appid";
$apicall .= "&GLOBAL-ID=$globalid";
$apicall .= "&keywords=$SafeQuery";
if($category!=""){
$apicall .= "&categoryId=$category";
}
if($zip!=""){
$apicall .= "&buyerPostalCode=$zip";
}
$apicall .= "&affiliate.networkId=9";
$apicall .= "&affiliate.trackingId=$campid";
if($sort_by!=""){
$apicall .= "&sortOrder=$sort_by";
}
$apicall .= "&descriptionSearch=$search_desc";
$apicall .= "&paginationInput.entriesPerPage=$num_rows";
$apicall .= $urlfilter;
$resp = simplexml_load_file($apicall);


// Check to see if the response was loaded, else print an error
 if ($resp->searchResult->item) {
	$results = '';

$result = "

<SCRIPT LANGUAGE='JavaScript'><!--
function myFunction() {
    window.open('http://rover.ebay.com/rover/1/711-53200-19255-0/1?type=3&campid=".$campid."&toolid=10001&customid=&ext=' + document.myForm.Query.value + '&satitle=' + document.myForm.Query.value,'ebay');
    return false;
}
//--></SCRIPT>

			
<FORM NAME='myForm' onSubmit='return myFunction()'>

<table border='0' bordercolor='#C0C0C0' width='100%'>";
if($dis_icon=="yes" || $dis_search_bar=="yes"){$result .="<TR><td colspan='3'>";if($dis_icon=="yes"){	$result .=" <div style=' display: inline; float: left; '><img src='http://pics.ebay.com/aw/pics/api/ebay_market_108x44.gif' width='108' height='44' alt='eBay' border='0'/></div>";}if($dis_search_bar=="yes"){	$result .=" <div style=' display: inline; float: left; '><INPUT style=' max-width: 100%; margin: 3px; ' type='text' name='Query' size='20' value='".$search."'></div><div style=' display: inline; float: left; '><INPUT TYPE='BUTTON' VALUE='Go' onClick='myFunction()'></div>";}$result .="	</td></TR>";}					
$result .="			
		<TR bgcolor='".$cl_top_bar."' style='background-color: ".$cl_top_bar.";'>
			<TD bgcolor='".$cl_top_bar."' style='background-color: ".$cl_top_bar.";'><B>&nbsp;<span style='color: ".$cl_top_txt."'>Pic</B></span></TD>
			<TD bgcolor='".$cl_top_bar."' style='background-color: ".$cl_top_bar.";'><B>&nbsp;<span style='color: ".$cl_top_txt.";'>Title</B></span></TD>
			<TD bgcolor='".$cl_top_bar."' style='background-color: ".$cl_top_bar.";'><B>&nbsp;<span style='color: ".$cl_top_txt.";'>Details</B></span></TD>
		</TR>";


$results = '';
$bgColor = $row_color;

    // If the response was loaded, parse it and build links  
    foreach($resp->searchResult->item as $item) {
        $pic   = $item->galleryURL;
        $linka  = $item->viewItemURL;

        $title = $item->title;
	$price = $item->sellingStatus->currentPrice;
	$currencyid = $item->sellingStatus->currentPrice['currencyId'];
if($currencyid == "GBP"){
$currencysign = "&pound;";
} else if($currencyid == "USD") {
$currencysign = "$";
} else {
$currencysign = "";
$cidtext = $currencyid;
}
	$bidcount = $item->sellingStatus->bidCount;
	if($bidcount==""){$bidcount=0;}
	$time = $item->sellingStatus->timeLeft;
	$time = getPrettyTimeFromEbayTime2($time);



//reduce fp for seo--------------------------------------------------------------------------------
$rover = "buystuff"; // This is the word 'rover' will be replaced with in the link, 
$ebay = "buycheap"; // Ditto but for the word 'ebay' i.e. with this example you 

                                $newterms = array($rover,$ebay);
                                $oldterms = array("rover","ebay");

$linka = str_replace ( $oldterms, $newterms, $linka );
$linka = base64_encode ( $linka );
$storeurl = get_bloginfo ( 'wpurl' ) . "/wp-content/plugins/wp-ebay-ads/store.php?";

$linka = $storeurl."&buy=".$rover."&cheap=".$ebay."&buyurl=".$linka;

	//display the result in a table row   
  

$result .="

					<TR bgcolor='".$bgColor."' style='background-color: ".$bgColor.";' onmouseover=\"style.backgroundColor='".$row_highlight."';\" onmouseout=\"style.backgroundColor='".$bgColor."'\">	
						<TD width='82' style='vertical-align: middle;'><A href='".$linka."' target='_blank' rel='nofollow' alt='".$title."'>
						<img style='border: 1px solid white;' src='".$pic."'></A></TD>

						<TD style='vertical-align: middle;padding: 10px;'><A href='".$linka."' target='_blank' rel='nofollow'>
						<span style='color: ".$cl_title_txt.";'>".$title."</span></A></TD>

						<TD width='190' style='vertical-align: middle;'>    
						<b><span style='color: #".$cl_details_txt.";'>Current Price: ".$currencysign.$price." ".$cidtext."</span></b><br>
    						<span style='color: ".$cl_details_txt.";'># of Bids: ".$bidcount."</span><br>
    						<span style='color: ".$cl_details_txt.";'>Ending: ".$time."</span></TD>
						</TR>
";


		//alternate the background colours
		if($bgColor==$row_color){
		$bgColor=$alt_row_color;
		} else {
		$bgColor=$row_color;
		}
	}



$storeurl = get_bloginfo ( 'wpurl' ) . "/wp-content/plugins/wp-ebay-ads/store.php?";
$follow = "http://rover.ebay.com/rover/1/711-53200-19255-0/1?type=3&campid=".$campid."&toolid=10001&customid=&ext=".$search."&satitle=" . $SafeQuery;
$follow = str_replace ( $oldterms, $newterms, $follow );

$follow = base64_encode ( $follow );

$follow = $storeurl."&buy=".$rover."&cheap=".$ebay."&buyurl=".$follow;

$result .="
		</TABLE>
	</FORM>";

	} else {
	// If there was no response, print an error
	echo "Oops! No results, try changing your search!";

	}

$result .="

<TABLE cellspacing='0' border='0' width= '100%'>
<TR>
<TD bgcolor='".$cl_bot_bar."' style='background-color: ".$cl_bot_bar.";'>&nbsp;<A href='".$follow."' target='_blank' rel='nofollow'><span style='color: ".$cl_bot_txt.";'>View all items...</span></A></TD>
<TD bgcolor='".$cl_bot_bar."' style='font-size: 0.72em; text-align: right;background-color: ".$cl_bot_bar.";'>
";

	if ($linkback =="yes"){
	$result .="
	<A href='http://ljapps.com/wp-ebay-ads-wordpress-plugin/' target='_blank'><span style='color: <? echo $cl_bot_txt; ?>;'>(Powered by: WPeBayAds)</span></A>
	&nbsp;";

	} else {
	$result .="
	<span style='color: ".$cl_bot_txt.";'>(Powered by: WP eBay Ads)</span>
	&nbsp;";

	}

$result .="

</TD>
</TR>
</TABLE>";

	}
   return $result;
}


//-------------------------------------------------------------------------
    function getPrettyTimeFromEbayTime2($eBayTimeString){
        // Input is of form 'PT12M25S'
        $matchAry = array(); // initialize array which will be filled in preg_match
        $pattern = "#P([0-9]{0,3}D)?T([0-9]?[0-9]H)?([0-9]?[0-9]M)?([0-9]?[0-9]S)#msiU";
        preg_match($pattern, $eBayTimeString, $matchAry);
        
        $days  = (int) $matchAry[1];
        $hours = (int) $matchAry[2];
        $min   = (int) $matchAry[3];    // $matchAry[3] is of form 55M - cast to int 
        //$sec   = (int) $matchAry[4];
        
        $retnStr = '';
        if ($days)  { $retnStr .= "$days day"    . plurals1($days);  }
        if ($hours) { $retnStr .= " $hours hr" . plurals1($hours); }
        if ($min)   { $retnStr .= " $min min" . plurals1($min);   }
        //if ($sec)   { $retnStr .= " $sec sec" . plurals1($sec);   }
        
        return $retnStr;
    } // function

    function plurals1($intIn) {
        // if $intIn > 1 return an 's', else return null string
        if ($intIn > 1) {
            return 's';
        } else {
            return '';
        }
    }

?>