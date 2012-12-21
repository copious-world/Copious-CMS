<?php


$dbspecific = "taxonomy";
include "../admin_header_lite.php";
global $db_connection;

$entity = $_POST['business'];
$taxonomies = $_POST['taxoselect'];

if ( !is_array($taxonomies) ) {
	$taxonomies = explode(",",$taxonomies);
}

$deletecond = "";
if ( isset( $_POST['deletecond']) ) {
	$cond = str_replace("\\","",$_POST['deletecond']);
	$deletecond = "   AND " . $cond;
}

/*
*/
	if ( count($taxonomies) ) {
		$DD = "DELETE FROM content_type where entity_symbol = '$entity'" . $deletecond;
		db_query_exe($DD);
	
		$II = "INSERT into content_type (id,name,entity_symbol,vid) VALUES ";
		$sep = "";
		$vlist = "";
		foreach ( $taxonomies as $taxoid ) {
			$QQ = "SELECT name FROM vocabulary WHERE id = $taxoid";
			$name = db_query_value($QQ);
			$vlist .= $sep . "(0,'$name','$entity',$taxoid)";
			$sep = ",";
		}
		$II .= $vlist;
		db_query_exe($II);

		echo "content types stored";

	} else {
		echo "No Taxonomies Selected";
	}

?>
