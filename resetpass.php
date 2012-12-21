<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!-- Sign Up  -->
<?php
	require_once "admin_header_lite.php";
	require_once('identity.php');
?>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	global $db_connection;

	///
	$db_charset = mysqli_query($db_connection, "SHOW VARIABLES LIKE 'character_set_database'" );
	$charset_row = mysqli_fetch_assoc( $db_charset );
	mysqli_query($db_connection, "SET NAMES '" . $charset_row['Value'] . "'" );
	unset( $db_charset, $charset_row );
	///
	////

	class toc_line {
		var $tagline = "";
		var $tagset = false;
		var $description = "";
		var $descset = false;
		function complete() {
			$result = ($tagset && $descset);
			return($result);
		}
	}
	

	//
	//
	$logged_in = false;
	
	$sessid = $_GET['sess'];
	$browser = $_GET['browser'];
	
	if ( active_session($sessid) ) {
		$logged_in = true;
		$username = active_session_uname($sessid);
	}
	//
	
	if ( $logged_in ) {
		$uid = $user_id_number;
		$postaction = "passentryreset.php";
/*		DB SWITCH
*/
//
//

	}

	$pnumber = -1;
	$report = "";
	//
	//
	//
	//		CHECK PASSWORD
	//


///////////////////////////////////////////////////

$processible = $logged_in;
	//////////
?>

<title><?php echo $SERVICE; ?> password reset</title>
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
</tr>
</tbody>
</table>
<br>
<?php

	if ( !$processible ) {
?>

<blockquote style="background-color: rgb(254,244,254) ">
&nbsp;&nbsp;&nbsp;
<font style="color: rgb(20, 50, 100); text-decoration: none; font-weight: bold; font-size : 24" >
<?php echo $SERVICE; ?>
</font>
<font style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
&nbsp;requires you to be logged in to use this page.
</font>
</blockquote>	

<?php
	} else {
?>

<blockquote style="background-color: rgb(254,244,254) ">
&nbsp;&nbsp;&nbsp;
<font style="color: rgb(20, 50, 100); text-decoration: none; font-weight: bold; font-size : 24" >
				<?php echo $SERVICE?>.
</font>
&nbsp;&nbsp;&nbsp;					
&nbsp;&nbsp;&nbsp;
<font style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
Password Reset
</font>

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

<blockquote style="background-color: rgb(249,249,220) ">
<p align="justify" >
<br> <?php echo $username . ",  "; ?> please enter your new password.
<br>
<br>When this information is registered, you will see a result on this web page.. 
</p>
</blockquote>
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
<form name="passwordentry" action="<?php echo $postaction; ?>" method="post" ID="Form1" onsubmit="return submitScript()" >
<input type="hidden" NAME="uid" value="<?php echo $uid; ?>">
<input type="hidden" NAME="sess" value="<?php echo $sessid; ?>">
<input type="hidden" NAME="browser" value="<?php echo $browser; ?>">
<input type="hidden" NAME="servicedir" value="<?php echo $servicedir; ?>">

<table align="left" ID="Table7"  width="100%">
<tr>
<td  width="30%" align="right">&nbsp;</td> <td  width="70%" align="left">&nbsp;</td>
</tr>
<tr>
<td  width="30%" align="right">Password:</td> <td  width="70%"  align="left"><input type="password" id="Text7" size="60" NAME="re_pass1"></td>
</tr>
<tr>
<td  width="30%" align="right">Verify Password:</td> <td  width="70%"  align="left"><input type="password" id="Text9" size="60" NAME="re_pass2"></td>
</tr>

<tr>
<td  width="30%" align="right">&nbsp;</td> <td  width="70%" align="left">&nbsp;</td>
</tr>
<tr>
<td  width="30%" align="right">&nbsp;</td>
<td  width="70%"  align="left"><input type="submit" value="reset password" ID="Submit1" NAME="Submit1"></td>
</tr>


</table>
</form>

<?php
	}
?>

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

<font size="1">Copious Systems  2005</font><br>

</body>
</html>
<script language="JavaScript">
	////
	function check_required_fields() {
		var p1 = document.passwordentry.re_pass1.value;
		var p2 = document.passwordentry.re_pass1.value;

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
		var p1 = document.passwordentry.re_pass1.value;
		var p2 = document.passwordentry.re_pass2.value;
		if ( p1 == p2 ) {
			return(true);
		} else {
			document.passwordentry.re_pass1.value = "";
			document.passwordentry.re_pass2.value = "";
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
