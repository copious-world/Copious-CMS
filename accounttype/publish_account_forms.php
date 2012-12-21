<?php

include "../admin_header.php";


$QQ = "SELECT ac.id, cf.entry_form FROM content_forms cf INNER JOIN accounttypes ac ON ( cf.classifier = ac.type_name )  WHERE ( cf.content_type = 'roles' ) AND  ( ac.serviceid = '$serviceid' )";
$form_list = db_query_object_list($QQ);


foreach ( $form_list as $fromdat ) {
	$form = $fromdat->entry_form;
	$id = $fromdat->id;
	$UU = "UPDATE authspecials SET form = '$form', needs_form = 1 WHERE ( account_type_id = $id ) AND ( serviceid = '$serviceid' ) AND (UID = 0)";
	db_query_exe($UU);
}

// The end result of this is that the signup forms appear at the time a user signs up...

?>
