<?php

$dbspecific = "taxonomy";
include "../admin_header_lite.php";

$entity = $_POST['business'];
$taxonomies = $_POST['taxoselect'];
/*
*/
global $db_connection;

	if ( count($taxonomies) ) {
		$DD = "DELETE FROM subscription where entity_symbol = '$entity'";
		db_query_exe($DD);
	
		$II = "INSERT into subscription (id,entity_symbol,vid) VALUES ";
		$sep = "";
		$vlist = "";
		foreach ( $taxonomies as $taxoid ) {
			$vlist .= $sep . "(0,'$entity',$taxoid)";
			$sep = ",";
		}
		$II .= $vlist;
		db_query_exe($II);
	} else {
		echo "No Taxonomies Selected";
	}

?>
