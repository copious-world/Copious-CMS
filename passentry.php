<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!-- Sign Up  -->
<?php

	$db_connection = 0;
	$db_select = 0;
	
	require_once "admin_header_lite.php";
	require_once('identity.php');
	require_once('userfeatures.php');
	require_once('communitylink.php');

	global $db_connection;

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
	///
	$db_charset = mysqli_query($db_connection, "SHOW VARIABLES LIKE 'character_set_database'" );
	$charset_row = mysqli_fetch_assoc( $db_charset );
	mysqli_query($db_connection, "SET NAMES '" . $charset_row['Value'] . "'" );
	unset( $db_charset, $charset_row );
	///
	$username = $_POST['nu_username'];
	$nu_pass1 = $_POST['nu_pass1'];
	$nu_pass2 = $_POST['nu_pass2'];
	$nu_email = $_POST['nu_emailer'];
///
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

	
	$phonekey = $_POST['phonekey'];
///
$SERVICE = $_POST['SERVICE'];
$servicedir = $_POST['servicedir'];
$serviceid = $_POST['serviceid'];
$hasQuestionaire = $_POST['hasQuestionaire'];

	//$taken_name = find_user_name($username);
	
	if ( !($taken_name) ) {   /// Make a basic account.


		$insertstmnt = "insert into users (ID,username,firstname,lastname,postal,city,state,country,zcode,phone_country,phone_area,phone_primary,phone_secondary,email,phonekey) ";
		
		$insertstmnt .= "values (0,'";
		$insertstmnt .= $username . "','";
		$insertstmnt .= $nu_firstname . "','";
		$insertstmnt .= $nu_lastname . "','";
		$insertstmnt .= $nu_postal . "','";
		$insertstmnt .= $nu_city . "','";
		$insertstmnt .= $nu_state . "','";
		$insertstmnt .= $nu_country . "','";
		$insertstmnt .= $nu_zcode . "','";
		$insertstmnt .= $nu_phone_country_code . "','";
		$insertstmnt .= $nu_phone_area_code . "','";
		$insertstmnt .= $nu_phone_primary . "','";
		$insertstmnt .= $nu_phone_secondary . "','";
		$insertstmnt .= $nu_email . "','";
		$insertstmnt .= $phonekey . "')";
		
		////////////////////////////////////

		db_query_exe($insertstmnt);
		
		$qq = "select id from users where ( firstname = '$nu_firstname' ) AND ( lastname = '$nu_lastname' ) AND ( email = '$nu_email' ) ";
		$uid =  db_query_value($qq);

		$pass = crypt(trim($nu_pass1),getsalt());
		
		$insertstmnt = "insert into authpass (ID,UID,password) values (0,'$uid','$pass')";
		db_query_exe($insertstmnt);

		make_initial_group($uid);

		if ( isset($_POST['group_user_origin']) ) {
			include "group_operations.php";
			$group_origin = $_POST['group_origin'];
			$group_user_origin = $_POST['group_user_origin'];
			copy_group_members($group_user_origin,$uid,$group_origin);
			set_account_type("GROUP",$uid,$serviceid);
		}

///////		send_user_private($username,$nu_pass1,$nu_email);
///////
		send_new_user_company($username,$nu_pass1,$nu_email);
//////
		set_user_features($uid);
		
		insert_secondary_login_sync($uid,$servicedir);
	}
	/*
	*/
?>

<title><?php echo $SERVICE . " " .  $nu_email; ?> new password</title>
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
		/// TAKEN NAME ===================================================
		/// ========= TRY AGAIN ========================

if ( $taken_name )   {
?>
	
	<blockquote style="background-color: rgb(254,244,254) ">
		<span style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
		This user name is already taken. Please try another...
		</span>
		</blockquote>
		<br>
		<blockquote style="background-color: rgb(254,244,254) ">
		<span style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
		Step 2. For 
		</span>
		&nbsp;&nbsp;&nbsp;
		<span style="color: rgb(20, 50, 100); text-decoration: none; font-weight: bold; font-size : 24" >
		Peace Names
		</span>
		&nbsp;&nbsp;&nbsp;
		<span style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
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
	
		echo "<b>$nu_firstname $nu_lastname</b>, ";
	?>
	
	Peace Names has determined that you are a new user.
	<br>
	<br>You may now select a user name and password.
	<br>
	<br>When this information is registered, you will be sent a confirmation e-mail. 
	<br> A link in the confirmation e-mail will take you back to the Peace Names login page.
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
	<input type="hidden" NAME="nu_emailer" value="<?php echo $nu_email; ?>" >
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
	
	
	<table align="left" ID="Table7"  width="100%">
	<tr>
		<td  width="30%" align="right">User Name:</td> <td  width="70%"  align="left"><input type="text" id="Text1" size="60" NAME="nu_username"></td>
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


	if ( $uses_account_types == 0 ) {

?>
	<blockquote style="background-color: rgb(254,244,254) ">
		<span style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
		Done!<br><br>
		You are now a member of
		</span>
		&nbsp;&nbsp;&nbsp;
		<span style="color: rgb(20, 50, 100); text-decoration: none; font-weight: bold; font-size : 24" >
<?php echo $SERVICE; ?>
		</span>
		&nbsp;&nbsp;&nbsp;
		<span style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
		<br><br>Look for your confirmation e-mail.<br>   Thank you.
		</span>
	</blockquote>
	<!-- Biz Stuff  -->
	<br>

<?php 
	} else {    /// THERE IS IN FACT A QUESTIONAIRE....
?>
<?php

	if ( $uses_account_types > 0  ) {

		require_once('process_account_type.php');
		$formobj = fetch_service_form($serviceid);  // The form data needed to select an account type for this service
		echo "<div class='requirementsForm'>";   // Show a form for selecting an account type or for other information...

?>
<table width="80%" border="0" cellspacing="0" cellpadding="0" >
<tr>
<td widht ="30%" valign="top" >
	<blockquote style="background-color: rgb(254,244,254) ">
		<span style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
		Done!<br><br>
		You are now a member of
		</span>
		&nbsp;&nbsp;&nbsp;
		<span style="color: rgb(20, 50, 100); text-decoration: none; font-weight: bold; font-size : 24" >
<?php echo $SERVICE; ?>
		</span>
		&nbsp;&nbsp;&nbsp;
		<span style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
		<br><br>Look for your confirmation e-mail.<br>   Thank you.
		</span>
	</blockquote>
</td>
<td widht ="70%" valign="top">
<?php
		if ( $uses_account_types == 2 ) {
			$soloacc = $formobj->solo_account_type;

?>
<div style="border:2px red solid;padding:8px;font-weight:bold;color:darkred;margin-bottom:8px;">
	But there is one more step required for your <?php echo $soloacc; ?> account to be activated. Please enter the requested information below.
</div> 
<?php

			if ( $formobj->needs_approval ) {
				echo '<form method="POST" action="accounttype/store_accounttype_form.php" >';
				echo '<input type="hidden"  NAME="workflowstep" value="approve"  >';
				$users_next_action = "SUBMIT FOR $soloacc ACCOUNT APPROVAL";
			} else if ( $formobj->needs_pay ) {
				echo '<form method="POST" action="accounttype/store_accounttype_form.php"  >';
				echo '<input type="hidden"  NAME="workflowstep" value="pay"  >';
				$users_next_action = "CONTINUE TO PAYMENT";
			} else {
				echo '<form method="POST" action="accounttype/store_accounttype_form.php" >';
				echo '<input type="hidden"  NAME="workflowstep" value="registered"  >';
				$users_next_action = "STORE NEW $soloacc ACCOUNT INFORMATION";
			}

		} else {
?>
<div style="border:2px red solid;padding:8px;font-weight:bold;color:darkred;margin-bottom:8px;">
	But there is one more step required for your account to be activated. Please select an account type from the list below.
</div> 
<?php
			echo '<form method="POST" action="accounttype/getaccounttypeinfo.php">';
		}

		$form = urldecode($formobj->published_accounts);
		$form = str_replace("@username",$username,$form);
		echo $form; /// The account type offering form..

?>
		<input type="hidden"  NAME="accounttypes" value="<?php echo $soloacc; ?>"  > 
		<input type="hidden"  NAME="SERVICE" value="<?php echo $SERVICE; ?>"  > 
		<input type="hidden"  NAME="servicedir" value="<?php echo $servicedir; ?>"  > 
		<input type="hidden"  NAME="serviceid" value="<?php echo $serviceid; ?>"  > 
		<input type="hidden"  NAME="hasQuestionaire" value="<?php echo $hasQuestionaire; ?>"  > 
		<input type="hidden"  NAME="fiz" value="<?php echo $uid; ?>"  >
		<br>
<?php
		if ( $uses_account_types == 2 ) {
?>
		<input type="submit"  NAME="subr" value="<?php echo $users_next_action; ?>"  >
<?php
		}
		echo "</form></div>";
	}
?>
<?php 

		if ( $uses_account_types > 0  ) {
?>
	</td></tr></table>
<?php
		}
	}
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
<?php 
if ( ( ( !$taken_name ) && ( $hasQuestionaire == 0) ) && ($uses_account_types <= 0) ) {
?>
	<br>
	<p align="center">
	<a href="javascript:self.close();">Close this Window</a>
	</p>
	<br>
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

<span style="font-size:0.75em">Copious Systems &copy; 2008</span><br>

</body>
</html>



<?php 
		/// TAKEN NAME ===================================================
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

		function submitScript() {
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
