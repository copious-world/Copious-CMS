<?php

// DocEvalRequest..

include "../admin_header.php";

$content_type = $_GET['content_type'];
$term = $_GET['term'];

$QQ = "SELECT * FROM theme_editing_data WHERE ( content_type = '$content_type' ) AND ( term = '$term' )";
$theme_editing = db_query_object($QQ);

$drop_spot_array = "";
if ( $theme_editing != null ) {
	$editing_text = str_replace("+"," ",$theme_editing->editing_text);
	$formatted_text = str_replace("+"," ",$theme_editing->formatted_text);
	
	$editing_text = urldecode($editing_text);
	$formatted_text = urldecode($formatted_text);
	$drop_spot_array = $theme_editing->drop_spots;

?>
$('thm_topic1_1_preview').innerHTML = decodeURIComponent("<?php echo $formatted_text ?>");
$('thm_topic1_1').value = decodeURIComponent("<?php echo $editing_text ?>");
<?php
}

if ( strlen($drop_spot_array) ) {
?>
unserialize_drop_spots(<?php echo $drop_spot_array ?>);
<?php
} else {
?>
unserialize_drop_spots({ used_drops: [] });
<?php
}
?>
get_content_type_fields_callback("<?php echo $term; ?>","<?php echo $content_type; ?>");
