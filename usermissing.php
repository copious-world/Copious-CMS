<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Sign Up  -->
<?php

	//
	//
	$logged_in = false;
	
	require_once "admin_header_lite.php";

	$uid = $_POST['nu_ID'];
	$nu_firstname = $_POST['nu_firstname'];
	$nu_lastname = $_POST['nu_lastname'];
	$nu_email = $_POST['nu_email'];

	$nu_email = $nu_email;

	$qq = "update users set firstname = '$nu_firstname', lastname = '$nu_lastname', email='$nu_email' where id = $uid";

	db_query_exe($qq);

?>
<title>restore account info</title>
</head>
<body>
</body>

</html>