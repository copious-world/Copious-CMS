<?php
	include "../admin_header.php";


	$term = $_GET['term'];
	$content_type = $_GET['content_type'];
	$droptarget = $_GET['droptarget'];
	$roatname = $_GET['roatname'];
	$fieldname = $_GET['fieldname'];
	$substitutions = $_GET['substitutions'];
	$parameters = $_GET['parameters'];

	$substitutions = urlencode($substitutions);
	$parameters = urlencode($parameters);

$QQ = "SELECT count(*) FROM rolled_oats_content_fields WHERE ( content_type = '$content_type' ) AND ( classifier = '$term' ) AND  ( fieldname = '$fieldname' ) AND ( rolled_oat_name = '$roatname' ) AND ( droptarget = '$droptarget' )";

$n = db_query_value($QQ);

if ( $n > 0 ) {
	$EE = "UPDATE rolled_oats_content_fields SET substitutions = '$substitutions', parameters = '$parameters' WHERE ( content_type = '$content_type' ) AND ( classifier = '$term' ) AND  ( fieldname = '$fieldname' ) AND ( rolled_oat_name = '$roatname' ) AND ( droptarget = '$droptarget' )";
} else {
	$EE = "INSERT INTO rolled_oats_content_fields (id,content_type,classifier,fieldname,rolled_oat_name,droptarget,substitutions,parameters) VALUE (0,'$content_type','$term','$fieldname','$roatname','$droptarget','$substitutions','$parameters')";
}

db_query_exe($EE);

?>
