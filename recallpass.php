<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!-- Sign Up  -->
<?php

	$db_connection = 0;
	$db_select = 0;
	
	require_once "admin_header_lite.php";
	require_once('identity.php');
	require_once('communitylink.php');
?>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $SERVICE; ?> New User</title>
</head>
<?php
	global $db_connection;

	$recall_name = $_POST['recall_name'];
	$recall_email = $_POST['recall_email'];

	function send_user_private($uname,$pass,$e_mail) {
		global $SERVICE;
		//
		$mailmsg = "Thank you for using $SERVICE;\n";
		$mailmsg .= "Your account information (temporary new password) is: " . $pass . "\n";
		//
		mail($e_mail,$uname . " - your requested $SERVICE information.", $mailmsg);
	}


	function update_password($uid, $found_pass) {
		global $servicedir;
		global $db_connection;

		$u_pass_q = "update authpass set password = '$found_pass' where UID = '$uid'";
		
		$q_result = @mysqli_query($db_connection,$u_pass_q);  //  or die (mysqli_error($db_connection))
		//
		reset_secondary_password($uid,$servicedir);
	}

	
	function find_user_unameemail($username, $email) {
		global $db_connection;

		$result = true;
		
		$u_name_q = "select count(*) from users where ( username = '";
		$u_name_q .= $username;
		$u_name_q .= "') AND ( email = '";
		$u_name_q .= $email;
		$u_name_q .= "')";
		
		//
		$q_result = @mysqli_query($db_connection,$u_name_q);  //  or die (mysqli_error($db_connection))
		//$q_result = @mysqli_query($db_connection,$u_name_q) or die (mysqli_error($db_connection));  // 
		//
		$row = @mysqli_fetch_row($q_result);
		//
		$counter = $row[0];

		if ( $counter <= 0 ) $result = false;
		
		return $result;
	}

		
	function randomPass() {
		$passsource = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$n = strlen($passsource) - 1;
		$rpass = "";
		for ( $i = 0; $i < 10; $i++ ) {
			$rpass .= $passsource[rand(0,$n)];
		}
		
		return $rpass;
	}


//
	$userin_db = find_user_unameemail($recall_name, $recall_email);
	
	if ( $userin_db ) {
		global $db_connection;

		$u_id_q = "select ID from users where ( username = '";
		$u_id_q .= $recall_name;
		$u_id_q .= "') AND ( email = '";
		$u_id_q .= $recall_email;
		$u_id_q .= "')";
		
		//
		$q_result = @mysqli_query($db_connection,$u_id_q);  //  or die (mysqli_error($db_connection))
		//
		$row = @mysqli_fetch_row($q_result);
		//
		$id = $row[0];

		$found_pass  = randomPass();
		
		$salt = getsalt();
		$cpass = crypt($found_pass,$salt);

		update_password($id,$cpass);


		send_user_private($recall_name,$found_pass,$recall_email);

	}
	

?>

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
	if ( $userin_db ) {
?>


<blockquote style="background-color: rgb(254,244,254) ">
<font style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
Thank you.<br><br>
&nbsp;&nbsp;&nbsp;
<font style="color: rgb(20, 50, 100); text-decoration: none; font-weight: bold; font-size : 24" >
<?php echo $SERVICE; ?>
</font>
&nbsp;
<font style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
will now send account information to the provided e-mail address:
<?php
echo "$recall_email";
?>
</font>

</blockquote>

<?php
} else {
?>

<br>
<p  align="center" style="color: rgb(20, 50, 100); text-decoration: none; font-weight: bold; font-size : 24" >
<?php echo $SERVICE; ?>
</p>
<!-- Biz Stuff  -->
<br>
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
<blockquote style="background-color: rgb(245,235,253);text-color: rgb(235,0,0);">
<p align="justify" >
<font style="color: rgb(150, 50, 20); text-decoration: none; font-weight: bold; font-size : 14" >
This user and e-mail are not on file together.
</font>
</p>
</blockquote>
<blockquote style="background-color: rgb(235,235,253) ">
<p align="justify" >
In order for <?php echo $SERVICE; ?> to retrieve your password, you will have to enter your <?php echo $SERVICE; ?> user name and your verifying e-mail address.
<br>You will receive an e-mail containing information to help you retrieve your password.
<br>The e-mail will be sent to the e-mail address that <?php echo $SERVICE; ?> has on file.
</p>
</blockquote>
<!-- Biz Stuff  -->
<table border="0" cellspacing="0" width="100%">
<tbody><tr>
<td bgcolor="darkgreen" height="1" width="100%">
</td>
</tr></tbody></table>
<table border="0" cellspacing="0" width="100%">
<tbody><tr>
<td bgcolor="#fcf8d5"" height="1" width="100%">
</td>
</tr></tbody></table>
<br>
<br>
<form name="passlink" action="recallpass.php" method="POST" ID="Form1" onsubmit="return submitScript()">
<table align="center">
<tr>
<td>
Please enter your user name: &nbsp; &nbsp; &nbsp; &nbsp;  <input type="text" id="user_name" size="60" name="recall_name">
</td>
</tr>
<tr>
<td>
Please enter your e-mail address: &nbsp; <input type="text" id="user_address" size="60" name="recall_email">
</td>
</tr>
<tr>
<td>
<br>
<input type="submit" value="get email">
</td>
</tr>
</table>
</form>

<?php
}
?>

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