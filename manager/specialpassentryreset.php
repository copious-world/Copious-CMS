<?php

	include '../database.php';


	function find_user_name_id($username) {
		$result = true;
		
		$u_id_q = "select ID from users where ( username = '";
		$u_id_q .= $username;
		$u_id_q .= "')";
		
		//
		$q_result = @mysql_query($u_id_q);  //  or die (mysql_error())
		//
		$row = @mysql_fetch_row($q_result);
		//
		$id = $row[0];
		
		return $id;
	}

	function find_user_email($id) {
		$result = true;
		
		$u_id_q = "select email from users where ( ID  = '$id')";
		//
		$q_result = @mysql_query($u_id_q);  //  or die (mysql_error())
		//
		$row = @mysql_fetch_row($q_result);
		//
		$id = $row[0];
		
		return $id;
	}


	function send_user_private($uname,$pass,$e_mail) {
	    //
	    $mailmsg = "Thank you for using Copious Mail\n";
	    $mailmsg .= "Your account information is as follows:\n";
	    //
	    $mailmsg .= "\tUsername: " . $uname . "\n";
	    $mailmsg .= "\tPassword: " . $pass . "\n";
	    //
		$headers = 'From: mailmanager@copious-systems.com' . "\r\n" . 'Reply-To: mailmanager@copious-systems.com' . "\r\n";
	    //
	    mail($e_mail,$uname . "- Registration information from Copious Mail.", $mailmsg,$headers);
	}


	$re_pass1 = $_POST['resetpass'];
	$username = $_POST['username'];
	$test_uid = $_POST['uid'];
//
	$db_connection = 0;
	$db_select = 0;

	////

	$id = find_user_name_id($username);

	if ( $test_uid == $id ) {

		$re_pass1 = trim($re_pass1);
		$pass = crypt($re_pass1,"cp");
		
		
		
		$updatestmnt = "update authpass set password = '$pass' where UID = '$id'";
		$q_result = mysql_query($updatestmnt) or die (mysql_error());
		
		$nu_email = find_user_email($id);

		send_user_private($username,$re_pass1,$nu_email);

	}
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

<blockquote style="background-color: rgb(254,244,254) ">
<?php echo "password for $username has been reset."; ?>
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

<font size="1">Copious Systems © 2006</font><br>

</body>
</html>
