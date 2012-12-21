<?php

	include "../admin_header.php";

	$content_type = $_GET['content_type'];
	$details = $_GET['details'];
	$details = urldecode($details);

	function array_from($objstr) {
		$arrayset = explode(",",$objstr); // term tp field list.
		$n = count($arrayset);
		$arrayout = array();
		for ( $i = 0; $i < $n; $i++ ) {
			list($key,$fields) = explode(":",$arrayset[$i]);
			$arrayout[$key] = str_replace("!",":",str_replace("@",",",$fields));
		}
		return($arrayout);
	}

	$details = array_from($details);

	$QQ = "INSERT INTO rolled_oat_field_lists (id,content_type,term,field_list) VALUES ";
	$sep = "";
	$termlist = array();
	foreach ( $details as $term => $fieldlist ) {
		if ( strlen($term) ) {
			$termlist[] = $term;
			$QQ .= $sep . "(0,'$content_type','$term','$fieldlist')";
			$sep = ",";
		}
	}

	$termlist = implode("','",$termlist);

	$DD = "DELETE FROM rolled_oat_field_lists WHERE (content_type = '$content_type') AND term in ('$termlist')";
	db_query_exe($DD);  /// Clear out the old...
	db_query_exe($QQ);	/// Bring in the new...

?>
alert("INSERTIONS MADE");
