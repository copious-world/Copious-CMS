<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!-- Sign Up  -->
<?php
	
	require_once "admin_header.php";
?>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	global $db_connection;


	///////////////////////////////////////////////////
	/////////////////////////////////////////////////

	function find_user_name_id($username) {
		global $db_connection;

		$result = true;
		
		$u_id_q = "select ID from users where ( username = '";
		$u_id_q .= $username;
		$u_id_q .= "')";
		
		//
		$q_result = @mysqli_query($db_connection,$u_id_q);  //  or die (mysqli_error($db_connection))
		//
		$row = @mysqli_fetch_row($q_result);
		//
		$id = $row[0];
		
		return $id;
	}


	function update_password($uid, $found_pass) {
		$u_pass_q = "update authpass set password = '$found_pass' where UID = '$uid'";
		db_query_exe($u_pass_q);
	}


	function send_user_private($uname,$pass,$e_mail) {
		global $SERVICE;
	    //
	    $mailmsg = "Thank you for using $SERVICE.\n";
	    $mailmsg .= "Your account information is as follows:\n";
	    //
	    $mailmsg .= "\tUsername: " . $uname . "\n";
	    $mailmsg .= "\tPassword: " . $pass . "\n";
	    //
//	    mail($e_mail,$uname . "Registration information from $SERVICE.", $mailmsg);
	}


	$uid = $_POST['uid'];
	$sessid = $_POST['sess'];
	$browser = $_POST['browser'];

	$re_pass1 = $_POST['re_pass1'];
	$re_pass2 = $_POST['re_pass2'];
	//	
	////

	$pass = crypt(trim($re_pass1),getsalt());
	
	$updatestmnt = "update authpass set password = '";
	$updatestmnt .= $pass . "' where UID = '";
	$updatestmnt .= $uid . "'";

	db_query_exe($updatestmnt);

	//reset_secondary_password($uid,$servicedir);
?>
<title><?php echo $SERVICE; ?> new password</title>
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


<blockquote style="background-color: rgb(254,244,254) ">
<span style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18px" >
Done!<br><br>
Your password has been reset.
</span>
&nbsp;&nbsp;&nbsp;
<span style="color: rgb(20, 50, 100); text-decoration: none; font-weight: bold; font-size : 24px" >
<?php echo $SERVICE; ?>
</span>
&nbsp;&nbsp;&nbsp;
<span style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18px" >
<br><br>Recall for your records: <span style="color: orange; text-decoration: none; font-weight: bold; font-size : 24px" >
<?php echo $re_pass1; ?></span>.<br>   Thank you.
</span>
<br>
</blockquote>
<!-- Biz Stuff  -->
<br>


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
<br>
This window will close in 20 seconds.
<br>
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

<font size="1">Copious Systems  2006</font><br>
<script language="javascript" type="text/javascript">
	setTimeout("close()",2000);
</script>
</body>
</html>
