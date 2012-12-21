<?php


include "../admin_header.php";


	$classifier = $_GET['classifiers'];
	$name = $_GET['content_type_name'];
	$id = $_GET['content_type_id'];
	$TABLE = $_GET['form_table'];


	$QQ = "SELECT form FROM $TABLE WHERE ( content_type_id = $id ) AND ( content_type_name = '$name' ) AND ( LOCATE('$classifier,',classifiers) > 0 )";
	$from = db_query_value($QQ);

	echo $form;

?>
