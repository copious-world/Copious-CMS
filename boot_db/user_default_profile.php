<?php


include "../admin_header.php";

if ( isset($_GET['uid']) ) {

	$uid = $_GET['uid'];
	$chkarray = $uid;

} else {

	$QQ = "SELECT ID FROM users";
	$chkarray = db_query_list($QQ);
	
	$QQ = "SELECT uid FROM userprofiles";
	$chkarray2 = db_query_list($QQ);
	
	$chkarray =  array_diff($chkarray, $chkarray2);
	$chkarray = implode(",",$chkarray);

}


$QQ = "SELECT u.id, u.username, u.original_source, srv.id AS serviceid FROM users u INNER JOIN serivcesource srv ON ( u.original_source = srv.servicename ) AND ( u.id IN ($chkarray) )";
$uobjs = db_query_object_list($QQ);

$themedir = "../usersown";
$fileform = file_get_contents("$themedir/form.txt");
$templatetxt = file_get_contents("$themedir/profile_template.html");
$formform = file_get_contents("$themedir/pre_form.txt");


$II = "INSERT INTO userprofiles (id,uid,serviceid,pre_html,user_form,pre_form) VALUES ";

foreach ( $uobjs as $uobj ) {

	$id = $uobj->id;
	$srvid = $uobj->serviceid;

	$fileform = str_replace("@theme_var_USERNAME",$uobj->username,$fileform);
	$fileform = str_replace("@busnessname",$uobj->original_source,$fileform);

	$templatetxt = str_replace("@theme_var_USERNAME",$uobj->username,$templatetxt);
	$templatetxt = str_replace("@busnessname",$uobj->original_source,$templatetxt);

	$formform = str_replace("@theme_var_USERNAME",$uobj->username,$formform);
	$formform = str_replace("@busnessname",$uobj->original_source,$formform);
	///
	$fileform = urlencode($fileform);
	$templatetxt = urlencode($templatetxt);
	$formform = urlencode($formform);

	$sep = "";
	$II .= $sep . "(0,$uid,$srvid,'$templatetxt','$fileform','$formform')";
	$sep = ",";

}

db_query_exe($II);


?>
