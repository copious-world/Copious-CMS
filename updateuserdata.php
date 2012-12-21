<?php
	global $db_connection;
	$db_connection = 0;
	$db_select = 0;
	
	require_once "admin_header_lite.php";

	function send_user_private($uname,$e_mail) {
	    //
	    $mailmsg = "Thank you for using Copious Mail\n";
	    $mailmsg .= "Your account information has been updated.\n";
	    //
	    $mailmsg .= "\tUsername: " . $uname . "\n";
	    //
	    mail($e_mail,$uname . "Registration information from Copious Mail.", $mailmsg);
	}


	function get_user_feature($ID) {
		global $db_connection;
		$user_features = array();
		$featureQ = "select ID,features from user_features where UID = $ID";
		$q_result = mysqli_query($db_connection,$featureQ) or die (mysqli_error($db_connection));
		while ( $row = @mysqli_fetch_row($q_result) ) {
			$id = $row[0];
			$ff = $row[1];
			$ff = urldecode($ff);
			$user_features[$id] = $ff;
		}
		//
		return($user_features);
	}


	$ID = $_POST['nu_ID'];
	$username = $_POST['nu_username'];

	$nu_firstname = $_POST['nu_firstname'];
	$nu_lastname = $_POST['nu_lastname'];
	$nu_postal = $_POST['nu_postal'];
	//
	$nu_city = $_POST['nu_city'];
	$nu_state = $_POST['nu_state'];
	$nu_country = $_POST['nu_country'];
	$nu_zcode = $_POST['nu_zcode'];


	$nu_phone_country_code = $_POST['nu_phone_country_code'];
	$nu_phone_area_code = $_POST['nu_phone_area_code'];
	$nu_phone_primary = $_POST['nu_phone_primary'];
	$nu_phone_secondary = $_POST['nu_phone_secondary'];

	$nu_email = $_POST['nu_email'];

	$nu_email_notify = "off";
	if ( isset($_POST['nu_email_notify']) ) {
		$nu_email_notify = $_POST['nu_email_notify'];
	}
	
	$phonekey = trim($nu_phone_country_code) . trim($nu_phone_area_code) . trim($nu_phone_primary) . trim($nu_phone_secondary);

	$nu_emailserver = $_POST['nu_emailserver'];
	$nu_emailuser = $_POST['nu_emailuser'];
	$nu_emailpass = $_POST['nu_emailpass'];
	
	
	
	$taken_name = false;


	$wants_notify = "0";
	if ( $nu_email_notify == "on" ) $wants_notify = "1";

	$insertstmnt = "update users set username = '$username',";
	$insertstmnt .= " firstname = '$nu_firstname',";
	$insertstmnt .= " lastname = '$nu_lastname',";
	$insertstmnt .= " postal = '$nu_postal',";
	$insertstmnt .= " city = '$nu_city',";
	$insertstmnt .= " state = '$nu_state',";
	$insertstmnt .= " country = '$nu_country',";
	$insertstmnt .= " zcode = '$nu_zcode',";
	$insertstmnt .= " phone_country = '$nu_phone_country_code',";
	$insertstmnt .= " phone_area = '$nu_phone_area_code',";
	$insertstmnt .= " phone_primary = '$nu_phone_primary',";
	$insertstmnt .= " phone_secondary = '$nu_phone_secondary',";
	$insertstmnt .= " email = '$nu_email',";
	$insertstmnt .= " wants_notify = '$wants_notify',";		
	$insertstmnt .= " phonekey = '$phonekey' where ID = '$ID'";

	////////////////////////////////////
	$q_result = mysqli_query($db_connection,$insertstmnt) or die (mysqli_error($db_connection));
	////////////////////////////////////

	$uq = "select ID from user_pop3_account where UID = '$ID'";
	$q_result = mysqli_query($db_connection,$insertstmnt) or die (mysqli_error($db_connection));
	if ( $row = @mysqli_fetch_row($q_result) ) {
		$popid = $row[0];
		$insertstmnt = "update user_pop3_account set emailserver = '$nu_emailserver', pop3user = '$nu_emailuser', emailpass = '$nu_emailpass' where ID = '$popid'";
	} else {
		//
		$pop_emailserver = urlencode($nu_emailserver);
		$pop_emailuser = urlencode($nu_emailuser);
		$pop_emailpass = urlencode($nu_emailpass);
		//
		$insertstmnt = "insert into user_pop3_account (ID,UID,emailserver,pop3user,emailpass) VALUES (0, $ID, '$pop_emailserver', '$pop_emailuser', '$pop_emailpass' )";
	}
	
	////////////////////////////////////
	$q_result = mysqli_query($db_connection,$insertstmnt) or die (mysqli_error($db_connection));
	////////////////////////////////////
	
	$user_features = get_user_feature($ID);
	$n = count($user_features);	
	
	//
	foreach ( $user_features as $i => $feature  ) {
		//
		$vname = "use_" . $feature;
		$vname = strtolower($vname);
		$vname = str_replace(' ','_',$vname);
		//
		$vvalue = "off";
		if ( isset($_POST[$vname]) ) {
			$vvalue = $_POST[$vname];
		}
		
		if ( strcmp($vvalue,"on") == 0 ) {
			$insertstmnt = "update user_features set state = 1 where ( ID = '$i' )";
		} else {
			$insertstmnt = "update user_features set state = 0 where ( ID = '$i' )";
		}
		//
		////////////////////////////////////
		$q_result = mysqli_query($db_connection,$insertstmnt) or die (mysqli_error($db_connection));
		////////////////////////////////////
	}

///////
//	send_user_private($username,$nu_email);
///////
	/*
	*/
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Copious Mail new password</title>
</head>
<body>
<!-- Biz Stuff  -->
<table border="0" cellspacing="0" width="100%" ID="Table1">
<tbody><tr>
<td bgcolor="darkgreen" height="1" width="100%">
</td>
</tr></tbody></table>
<table border="0" cellspacing="0" width="100%" ID="Table2">
<tbody><tr>
<td bgcolor="#fcf8d5"" height="1" width="100%">
</td>
</tr></tbody></table>
<br>

<?php 
if ( $taken_name )   {
?>



<!-- Biz Stuff  -->
<table border="0" cellspacing="0" width="100%" ID="Table5">
<tbody><tr>
<td bgcolor="darkgreen" height="1" width="100%">
</td>
</tr></tbody></table>
<table border="0" cellspacing="0" width="100%" ID="Table6">
<tbody><tr>
<td bgcolor="#fcf8d5"" height="1" width="100%">
</td>
</tr></tbody></table>
<br>
<br>


<?php 

} else {

?>

<blockquote style="background-color: rgb(254,244,254) ">
<font style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
Your account information has been updated.
</font>

</blockquote>
<!-- Biz Stuff  -->
<br>

<?php 
}
?>


<!-- Biz Stuff  -->
<table border="0" cellspacing="0" width="100%" ID="Table3">
<tbody><tr>
<td bgcolor="darkgreen" height="1" width="100%">
</td>
</tr></tbody></table>
<table border="0" cellspacing="0" width="100%" ID="Table4">
<tbody><tr>
<td bgcolor="#fcf8d5"" height="1" width="100%">
</td>
</tr></tbody>
</table>
<!-- Biz Stuff  -->
<table border="0" cellspacing="0" width="100%" ID="Table8">
<tbody><tr>
<td bgcolor="darkgreen" height="1" width="100%">
</td>
</tr></tbody></table>
<table border="0" cellspacing="0" width="100%" ID="Table9">
<tbody><tr>
<td bgcolor="#fcf8d5"" height="1" width="100%">
</td>
</tr></tbody></table>

<font size="1">Copious Systems  2005</font><br>

</body>
</html>
<?php 
if ( $taken_name )   {
?>

<script language="JavaScript">
	////
	function check_required_fields() {
		var p1 = document.passwordentry.nu_pass1.value;
		var p2 = document.passwordentry.nu_pass1.value;

		if ( p1.length == 0 ) {
			alert("Both password fields require the same password.")
			return false
		}
		if ( p2.length == 0 ) {
			alert("Both password fields require the same password.")
			return false
		}

		if ( p1.length < 8 || p1.length > 16 ) {
			alert("Please enter a password that has between 8 and 16 characters.")
			return false
		}
		

		if ( p2.length < 8 || p2.length > 16 ) {
			alert("Please enter a password that has between 8 and 16 characters.")
			return false
		}

		return true;
	}

	function check_same_passwords() {
		var p1 = document.passwordentry.nu_pass1.value;
		var p2 = document.passwordentry.nu_pass2.value;
		if ( p1 == p2 ) {
			return(true);
		} else {
			document.passwordentry.nu_pass1.value = "";
			document.passwordentry.nu_pass2.value = "";
			alert("Please be sure that the passwords fields are the same.");
			return false;
		}	
	}

	function submitScript()
	{
		var first_test = check_required_fields();
		
		if ( first_test ) {
			first_test = check_same_passwords();
		}
		
		return first_test
	}
	///
</script>


<?php
}
?>
