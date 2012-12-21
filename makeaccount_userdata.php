<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<?php

	$db_connect = 0;
	$db_connection = 0;
	$db_select = 0;
	
	require_once "admin_header_lite.php";
	include 'database.php';
	include_once 'userfeatures.php';
	
	global $db_connection;


$nu_symbolname = $_POST['nu_symbolname'];
//
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

$servicedir = $_POST['servicedir'];
$serviceid = $_POST['serviceid'];
$hasQuestionaire = $_POST['hasQuestionaire'];


	$empty_search = false;
//
	$phonekey = trim($nu_phone_country_code) . trim($nu_phone_area_code) . trim($nu_phone_primary) . trim($nu_phone_secondary);
	$user_is_new = true;
	$user_is_new = !(find_users($nu_firstname,$nu_lastname,$nu_email));
	$numsame = samesymbolcount($nu_symbolname);
	
	if ( $numsame == 0 ) {
		$numsame = "";
	}

?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $SERVICE; ?> new user step 2</title>
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
<font style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
Step 2. For 
</font>
&nbsp;&nbsp;&nbsp;
<span style="background-color:#fcfcc5;color: rgb(20, 50, 100); text-transform:capitalize;text-decoration: none; font-weight: bold; font-size : 24" >
<?php echo $SERVICE; ?>.
</span>
&nbsp;&nbsp;&nbsp;
<span style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18px" >
Please select a new user name and password.
</span>

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
<?php 

if ( $user_is_new ) {
	echo "<b>$nu_firstname $nu_lastname</b>, ";
?>

<?php echo $SERVICE; ?> has determined that you are a new user.
<br>
<br>You may now select a user name and password.
<br>
<br>When this information is registered, you will be sent a confirmation e-mail. 
<br> A link in the confirmation e-mail will take you back to the <?php echo $SERVICE; ?> login page.
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
<form name="passwordentry" action="passentry.php" method="post" ID="Form1" onsubmit="return submitScript()" >
<table align="left" ID="Table7"  width="100%">
<tr>
<td  width="30%" align="right">User Name:</td> <td  width="70%"  align="left">
<input type="text" id="Text1" size="60" NAME="nu_username" value="<?php echo $nu_symbolname . $numsame; ?>" >
<input type="hidden" NAME="nu_symbolname" value="<?php echo $nu_symbolname; ?>" >
<input type="hidden" NAME="nu_emailer" value="<?php echo $nu_email; ?>" >
<input type="hidden" NAME="phonekey" value="<?php echo $phonekey; ?>" >

<input type="hidden" NAME="nu_firstname" value="<?php echo $nu_firstname; ?>" >
<input type="hidden" NAME="nu_lastname" value="<?php echo $nu_lastname; ?>" >
<input type="hidden" NAME="nu_postal" value="<?php echo $nu_postal; ?>" >

<input type="hidden" NAME="nu_city" value="<?php echo $nu_city; ?>" >
<input type="hidden" NAME="nu_state" value="<?php echo $nu_state; ?>" >
<input type="hidden" NAME="nu_country" value="<?php echo $nu_country; ?>" >
<input type="hidden" NAME="nu_zcode" value="<?php echo $nu_zcode; ?>" >

<input type="hidden" NAME="nu_phone_country_code" value="<?php echo $nu_phone_country_code; ?>" >
<input type="hidden" NAME="nu_phone_area_code" value="<?php echo $nu_phone_area_code; ?>" >
<input type="hidden" NAME="nu_phone_primary" value="<?php echo $nu_phone_primary; ?>" >
<input type="hidden" NAME="nu_phone_secondary" value="<?php echo $nu_phone_secondary; ?>" >

<input type="hidden"  NAME="SERVICE" value="<?php echo $SERVICE; ?>"  > 
<input type="hidden"  NAME="servicedir" value="<?php echo $servicedir; ?>"  > 
<input type="hidden"  NAME="serviceid" value="<?php echo $serviceid; ?>"  > 
<input type="hidden"  NAME="hasQuestionaire" value="<?php echo $hasQuestionaire; ?>"  > 
</td>
</tr>
<tr>
<td  width="30%" align="right">&nbsp;</td> <td  width="70%" align="left">
<br>
Please be sure that to enter a password between 8 and 16 characters in length.</td>
</tr>
<tr>
<td  width="30%" align="right">&nbsp;</td> <td  width="70%" align="left">&nbsp;</td>
</tr>
<tr>
<td  width="30%" align="right">Password:</td> <td  width="70%"  align="left"><input type="password" id="Text7" size="60" NAME="nu_pass1"></td>
</tr>
<tr>
<td  width="30%" align="right">Verify Password:</td> <td  width="70%"  align="left"><input type="password" id="Text9" size="60" NAME="nu_pass2"></td>
</tr>

<tr>
<td  width="30%" align="right">&nbsp;</td> <td  width="70%" align="left">&nbsp;</td>
</tr>
<tr>
<td  width="30%" align="right">&nbsp;</td>
<td  width="70%"  align="left"><input type="submit" value="sign up" ID="Submit1" NAME="Submit1"></td>
</tr>

</table>
</form>

<?php
	} else {
?>

The user is already registered.

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
		if ( document.passwordentry.nu_username.value == "" ) {
			alert("Please enter a value for field, User Name.")
			return false
		}
		if ( document.passwordentry.nu_pass1.value == "" ) {
			alert("Both password fields require the same password.")
			return false
		}
		if ( document.passwordentry.nu_pass2.value == "" ) {
			alert("Both password fields require the same password.")
			return false
		}

		return true;
	}
	
	function check_same_passwords() {
		var p1 = document.passwordentry.nu_pass1.value;
		var p2 = document.passwordentry.nu_pass2.value;
		if ( p1 == p2 ) {
			if ( ( p1.length > 16 ) || ( p1.length < 6 ) ) {
				alert("The password should be from 6 to 16 characters in length.");
				document.passwordentry.nu_pass1.value = "";
				document.passwordentry.nu_pass2.value = "";
				return false;
			} else {
    			return(true);
    		}
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
