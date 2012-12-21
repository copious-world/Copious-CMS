<?php

include "../admin_header.php";

/// Called by theme_admin_store..

///-- parameters
///--------------------------------------
$content_type = $_GET['content_type'];
$term = $_GET['term'];
///--------------------------------------


/// Producing ... --------------------------------
/// entry_form, search_form, entry_js, search_js
///-----------------------------------------------


/// Form element calls also create the javascript in these arrays.
///--------------------------------------
global $entry_js;
global $search_js;

$entry_js = array();
$search_js = array();
///--------------------------------------

include "theme_javascript.php";


///--------------------------------------


$QQ = "SELECT * FROM theme_editing_data WHERE ( content_type = '$content_type' ) AND ( term = '$term' ) AND ( serviceid = '$serviceid' )";
$theme_editing = db_query_object($QQ);
///----->
$formatted_text = urldecode($theme_editing->formatted_text);
$formatted_text = majic_quotes($formatted_text);
///----->
/// Text contains the drop container, which has variable data in it...
$marker =<<<OESPANMARK
<span class="buttonLike" id="oat_drop_container
OESPANMARK;
$marker = trim($marker);


///----------------------------------------------------------------------------------------
/// This loop makes a form for gathering data from the user when the user makes a content type.
///----------------------------------------------------------------------------------------
///
$output = $formatted_text;
while ( ($offset = strpos($output,$marker))!== false ) {   /// Parse the text by the marker...
///--------------------------
	$prefx = substr($output,0,$offset); /// Prefix
	$rest = substr($output,$offset);	/// After marker
	$postfx = substr(strstr($output,"</span></span>"),strlen("</span></span>"));  /// After container...
	$ee = strpos($rest,"</span></span>");
///--------------------------
/// Finally, extraxt the variable data...
	$var_data = substr($rest,0,$ee);
	list($id,$name) = extract_id_name($var_data);

	$rolledoat = load_oat_components($name);
///
	$specials = load_specialization($term,$content_type,$id,$rolledoat,$name);
						/// This is the substitution...
	$form_elements = data_gathering_elements($id,$name,$rolledoat,$var_data,$specials);			/// DATA FORM ELEMENTS
	$output = $prefx . $form_elements . $postfx;

}
$entry_form = $output;			/// ENTRY FORM
$entry_form = urlencode($entry_form);


echo $formatted_text . "\n";
var_dump($entry_js);


$entry_form_obj = urlencode($entry_form_obj);
$search_form_obj = "null";

/// Text contains the drop container, (See above...this is the same operation, but a different substitution. )
///----------------------------------------------------------------------------------------
/// This loop makes a form for gathering search keys from the user when the user searches for elements of a content type.
///----------------------------------------------------------------------------------------
///
$output = $formatted_text;
while ( ($offset = strpos($output,$marker))!== false ) {   /// Parse the text by the marker...
///--------------------------
	$prefx = substr($output,0,$offset); /// Prefix
	$rest = substr($output,$offset);	/// After marker
	$postfx = substr(strstr($output,"</span></span>"),strlen("</span></span>"));  /// After container...
	$ee = strpos($rest,"</span></span>");
///--------------------------
/// Finally, extraxt the variable data...
	$var_data = substr($rest,0,$ee);
	list($id,$name) = extract_id_name($var_data);
	$rolledoat = load_oat_components($name);
///
	$specials = load_specialization($term,$content_type,$id,$rolledoat,$name);
						/// This is the substitution...
	$form_elements = data_searching_elements($id,$name,$rolledoat,$var_data,$specials);			/// SEARCH FORM ELEMENTS
	$output = $prefx . $form_elements . $postfx;
}
$search_form = $output;			/// SEARCH FORM
$search_form = urlencode($search_form);


/// DELETE PREVIOUS VERSIONS FROM content_forms.... ( A change of the forms not of content.. )
$DD = "DELETE FROM content_forms WHERE (content_type = '$content_type' ) AND ( classifier = '$term' ) AND ( serviceid = '$serviceid' )";  /// By business...
db_query_exe($DD);

/// prepare for DB Storage
$entry_js = json_encode($entry_js);
$entry_js = urlencode($entry_js);

$search_js = json_encode($search_js);
$search_js = urlencode($search_js);

/// Add the new forms to the data base.
$now = datetime();
$II = "INSERT INTO content_forms (id,serviceid,date,content_type,classifier,entry_form,search_form,entry_js,search_js) VALUES (0,$serviceid,'$now','$content_type','$term','$entry_form','$search_form','$entry_js','$search_js')";
db_query_exe($II);

?>
DONE!
