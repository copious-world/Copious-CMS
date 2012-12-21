<?php

// maptaxonomy.php

$dbspecific = "taxonomy";
include "../admin_header_lite.php";
global $db_connection;


if ( isset($_POST) ) {
	$vname = $_POST['vocabname'];
	$appname = $_POST['appname'];
	$html_element_id = $_POST['markup_id'];
	$label_form = $_POST['label_form'];
	$use_label_id_array = $_POST['use_label_id'];
} else if ( isset($_GET) ) {
	$vname = $_GET['vocabname'];
	$appname = $_GET['appname'];
	$html_element_id = $_GET['markup_id'];
	$label_form = $_GET['label_form'];
	$use_label_id_array = $_GET['use_label_id'];
}

$QQ = "select id from vocabulary where name = '$vname'";
$vid = db_query_value($QQ);


if ( $vid > 0 ) {
	$QQ = "insert into taxo_map (id, vid, HTML, label_form, markup_id, use_label_id_array)";
	$QQ .= " VALUES (0,'$vid','process', '$label_form','$html_element_id',$use_label_id_array)";	
	db_query_exe($QQ);

	$now = datetime();
	$cdata = "finder_key=process&table=taxo_map&field=HTML";  // Get an indicator as to where data is located and what marks it as needing to be processed.

	if ( strlen($appname) == 0 ) {
		$appname = 'publish_taxo_html';
	}

	$QQ = "insert into taxo_change_queue (id, vid, state, when, process, custom_data)"
	$QQ .= " VALUES (0,'$vid','0', '$now','$appname','$cdata')";	
	db_query_exe($QQ);

	echo "Map Inserted";
} else {
	echo "Vocabulary named $vname does not exist.";
}


?>
