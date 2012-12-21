<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Sign Up  -->
<?php

	//
	//
	$logged_in = false;
	$sessid = $_GET['sess'];

	require_once "admin_header_lite.php";

	global $db_connection;
try {
	require_once('identity.php');
	require_once('userfeatures.php');
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}

$sess = $sessid;
require_once('user_from_session.php');



?>
<?php
include "userinfo.php";

$processible = false;


	if ( active_session($sessid) ) {
		$logged_in = true;
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
	$uid = $user_id_number;
	//

	if ( !find_user_data($uid) ) {
		$processible = false;
	}
/**/
	//
?>
<title><?php echo $SERVICE; ?> account info</title>
</head>
		<!--  ========================================== --->
<script language="JavaScript" type="text/javascript" src="/hosted/js/jsresources.js"> </script>
<script language="JavaScript" type="text/javascript" src="/hosted/js/dimensions.js"> </script>
<script language="JavaScript" type="text/javascript" src="/hosted/js/docjax.js"></script>
		<!--  ========================================== --->
<script language="javascript">
	var g_squeeze = 0;
	if ( g_screenHeight >= 900 ) {
		document.writeln('<LINK REL="stylesheet" TYPE="text/css" HREF="../stylesheet.css" TITLE="Style">');
	} else if ( g_screenHeight > 600 ) {
		g_squeeze = 1;
		document.writeln('<LINK REL="stylesheet" TYPE="text/css" HREF="../stylesheet700.css" TITLE="Style">');
	} else {
		g_squeeze = 2;
		document.writeln('<LINK REL="stylesheet" TYPE="text/css" HREF="../stylesheet600.css" TITLE="Style">');
	}
</script>
<script language="JavaScript" type="text/javascript" >
	var onDisplay = null;
	var refsection = null;
	
	function showPartDiv(divname) {
		////
		var divobj = $(divname);

		if ( ( refsection != null ) && ( divobj != null ) ) {


			if ( onDisplay != null ) {
				hidePart(onDisplay);
			}

			onDisplay = divobj;
			if ( onDisplay != refsection ) {
				onDisplay.style.top = refsection.offsetTop;
				onDisplay.style.left = refsection.offsetLeft;
			}
			$show(divname);
		}

	}

	var bbb = "<?php echo $browser?>";
	function resetPassAction() {
		//
		if ( bbb != "IE" ) {
			var urlNparams = "./resetpass.php?sess=<?php echo $sessid; ?>&browser=<?php echo $browser; ?>&busappdir=<?php echo $servicedir; ?>";
			var win = window.open(urlNparams, "passreset", "width=800,height=600,scrollbars");
		}
	}

	function setHREF(lnker) {
		if ( bbb == "IE" ) {
			lnker.href = "./resetpass.php?sess=<?php echo $sessid; ?>&browser=<?php echo $browser; ?>&servicedir=<?php echo $servicedir; ?>";
		}
	}

</script>
<style type="text/css" media="screen"><!--

	#basic_info {
		position: relative;
		left: 0px;
		right: 0px;
		
	}
	#pop3_info {
		position: absolute;
		left: 0px;
		right: 0px;
		visibility: hidden;
		zIndex: 100;
	}
	
	#signup_info {
		position: absolute;
		left: 0px;
		right: 0px;
		visibility: hidden;
		zIndex: 101;
	}
	
--></style>
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

&nbsp;&nbsp;&nbsp;
<span style="color: rgb(20, 50, 100); text-decoration: none; font-weight: bold; font-size : 24" >
<?php echo $SERVICE; ?>
</span>
<br><br>
<span style="background-color: #F4F4FA; border: 1px solid gold;padding:10px;" >
<span style="border: 1px solid gold;padding-left:4px;padding-right:4px;background-color: #8888CC;color: gold; text-decoration: none; font-weight: bold; font-size : 16px"><?php echo $username; ?></span>
Originally signed up through:
<span style="color: navy; text-decoration: none; font-weight: bold; font-size : 14px"><?php echo $signerpage; ?></span>

</span>
<br><br>
&nbsp;&nbsp;&nbsp;<?php echo $username . ",  "; ?> please make your necessary changes.
<br>	



<table width="100%"><tbody><tr><td bgcolor="darkgreen" height="1" width="100%"></td></tr></tbody></table>

		<br>
		<form name="userdata" action="updateuserdata.php" method="POST" ID="Form1" onsubmit="return submitScript()">
			<input type="hidden" NAME="nu_ID" value="<?php echo $nu_ID;?>" />
			<input type="hidden" NAME="nu_firstname" value="<?php echo $nu_firstname;?>" />
			<input type="hidden" NAME="nu_lastname" value="<?php echo $nu_lastname;?>" />
			<input type="hidden" NAME="nu_email" value="<?php echo $nu_email;?>" />			
			<input type="hidden" NAME="nu_username" value="<?php echo $username;?>" />		
			<input type="hidden" NAME="nu_Nuses" value="<?php echo $n_uses;?>" />
			<input type="hidden" NAME="servicedir" value="<?php echo $servicedir;?>" />
		
<span onclick="javascript:showPartDiv('basic_info');" style="cursor:pointer;font-family:helvetica;font-weight:bold;border:1px solid purple;font-family:helvetica;font-size:14px;padding:2px;background-color:transparent;color:maroon" onmouseover=" this.style.backgroundColor = 'gold'; " onmouseout=" this.style.backgroundColor = 'transparent'; ">
Basic Information
</span>
<span onclick="javascript:showPartDiv('pop3_info');" style="cursor:pointer;font-family:helvetica;font-weight:bold;border:1px solid purple;font-family:helvetica;font-size:14px;padding:2px;background-color:transparent;color:maroon" onmouseover=" this.style.backgroundColor = 'gold'; " onmouseout=" this.style.backgroundColor = 'transparent'; ">
E-mail Account
</span>
<span onclick="javascript:showPartDiv('signup_info');" style="cursor:pointer;font-family:helvetica;font-weight:bold;border:1px solid purple;font-family:helvetica;font-size:14px;padding:2px;background-color:transparent;color:maroon" onmouseover=" this.style.backgroundColor = 'gold'; " onmouseout=" this.style.backgroundColor = 'transparent'; ">
Usage Features
</span>
<script language="javascript" type="text/javascript" >
	if ( bbb == "IE" ) {
document.writeln("<a id=\"rsetpassID\" href=\"\" target=\"_blank\" onmouseover=\"setHREF(this)\" >");
	}
</script>
<span onclick="javascript:resetPassAction();" style="cursor:pointer;font-family:helvetica;font-weight:bold;border:1px solid purple;font-family:helvetica;font-size:14px;padding:2px;background-color:transparent;color:maroon" onmouseover=" this.style.backgroundColor = 'gold';setHREF($('rsetpassID'));" onmouseout=" this.style.backgroundColor = 'transparent'; ">
Reset Password
</span>
<script language="javascript" type="text/javascript" >
	if ( bbb == "IE" ) {
document.writeln("</a>");
	}
</script>


		<br><br>

	<div id="basic_info">
			<table align="left" ID="Table7" width="100%">
				<tr>
					<td width="30%" align="right">First Name:</td>
					<td width="70%" align="left"><?php echo $nu_firstname;?></td>
				</tr>
				<tr>
					<td width="30%" align="right">Last Name:</td>
					<td width="70%" align="left"><?php echo $nu_lastname;?></td>
				</tr>
				<tr>
					<td width="30%" align="right">&nbsp;</td>
					<td width="70%" align="left">&nbsp;</td>
				</tr>


				<tr>
					<td width="30%" align="right">Postal Address:</td>
					<td width="70%" align="left"><input type="text" id="Text3" size="60" NAME="nu_postal" value="<?php echo $nu_postal;?>" /></td>
				</tr>
				<tr>
					<td width="30%" align="right">City:</td>
					<td width="70%" align="left"><input type="text" id="Text4" size="60" NAME="nu_city" value="<?php echo $nu_city;?>" /></td>
				</tr>
				<tr>
					<td width="30%" align="right">State/Provence:</td>
					<td width="70%" align="left"><input type="text" id="Text5" size="60" NAME="nu_state" value="<?php echo $nu_state;?>" /></td>
				</tr>
				<tr>
					<td width="30%" align="right">Country:</td>
					<td width="70%" align="left"><input type="text" id="Text6" size="60" NAME="nu_country" value="<?php echo $nu_country;?>" /></td>
				</tr>
				<tr>
					<td width="30%" align="right">Zip code/Postal code:</td>
					<td width="70%" align="left"><input type="text" id="Text8" size="60" NAME="nu_zcode" value="<?php echo $nu_zcode;?>" /></td>
				</tr>
				<tr>
					<td width="30%" align="right">&nbsp;</td>
					<td width="70%" align="left">&nbsp;</td>
				</tr>
				<tr>
					<td width="30%" align="right">Phone:</td>
					<td width="70%" align="left">
						<input type="text" id="Text7" size="2" NAME="nu_phone_country_code" value="<?php echo $nu_phone_country_code;?>" /> - 
						<input type="text" id="Text10" size="3" NAME="nu_phone_area_code" value="<?php echo $nu_phone_area_code;?>" />
						- <input type="text" id="Text11" size="6" NAME="nu_phone_primary" value="<?php echo $nu_phone_primary;?>" /> - 
						<input type="text" id="Text12" size="8" NAME="nu_phone_secondary" value="<?php echo $nu_phone_secondary;?>" />
					</td>
				</tr>
				<tr>
					<td width="30%" align="right">e-mail address:</td>
					<td width="70%" align="left"><?php echo $nu_email;?></td>
				</tr>
				<tr>
					<td width="30%" align="right"><input type="checkbox" id="checks10" NAME="nu_email_notify" "<?php echo $wants_notify;?>"></td>
					<td width="70%" align="left">receive email notifications</td>
				</tr>
			</table>

	</div>
	<div id="pop3_info">

			<table align="left" ID="Table7" width="100%" >
				<tr>
					<td width="30%" align="right">First Name:</td>
					<td width="70%" align="left"><?php echo $nu_firstname;?></td>
				</tr>
				<tr>
					<td width="30%" align="right">Last Name:</td>
					<td width="70%" align="left"><?php echo $nu_lastname;?></td>
				</tr>
				<tr>
					<td width="30%" align="right">&nbsp;</td>
					<td width="70%" align="left">&nbsp;</td>
				</tr>

				<tr>
					<td width="30%" align="right">E-mail server:</td>
					<td width="70%" align="left"><input type="text" id="Text3" size="60" NAME="nu_emailserver" value="<?php echo $nu_emailserver;?>" /></td>
				</tr>
				<tr>
					<td width="30%" align="right">E-mail User ID:</td>
					<td width="70%" align="left"><input type="text" id="Text4" size="60" NAME="nu_emailuser" value="<?php echo $nu_emailuser;?>" /></td>
				</tr>
				<tr>
					<td width="30%" align="right">E-Mail Password:</td>
					<td width="70%" align="left"><input type="text" id="Text5" size="60" NAME="nu_emailpass" value="<?php echo $nu_emailpass;?>" /></td>
				</tr>			
			</table>

	</div>
	
	<div id="signup_info">

			<table align="left" ID="Table7" width="100%" >
				<tr>
					<td width="30%" align="right">First Name:</td>
					<td width="70%" align="left"><?php echo $nu_firstname;?></td>
				</tr>
				<tr>
					<td width="30%" align="right">Last Name:</td>
					<td width="70%" align="left"><?php echo $nu_lastname;?></td>
				</tr>
				<tr>
					<td width="30%" align="right">&nbsp;</td>
					<td width="70%" align="left">&nbsp;</td>
				</tr>
<?php 
	for ( $i = 0; $i < $n_uses; $i++ ) {
		$fieldname = strtolower(str_replace(' ','_',$nu_usefeature[$i]));
?>
				<tr>
					<td width="30%" align="right"><?php echo $nu_usefeature[$i];?>:</td>
					<td width="70%" align="left"><input type="checkbox" id="nu_use_<?php echo $i;?>" NAME="use_<?php echo $fieldname;?>" <?php echo $nu_use[$i];?> /></td>
				</tr>
<?php 
	}
?>

			</table>

	</div>

			<table align="left" ID="Table7" width="100%" >
				<tr>
					<td width="30%" align="right">
<table width="100%"><tbody><tr><td bgcolor="darkgreen" height="1" width="100%"></td></tr></tbody></table>
					</td>
					<td width="70%" align="left">
<table width="100%"><tbody><tr><td bgcolor="darkgreen" height="1" width="100%"></td></tr></tbody></table>
					</td>
				</tr>
				<tr>
					<td width="30%" align="right">&nbsp;</td>
					<td width="70%" align="left"><input type="submit" value="update" ID="Submit1" NAME="Submit1"></td>
				</tr>
			</table>

		</form>

		<br>
		<!-- Biz Stuff  -->

<?php
	}
?>

<br>
<!-- Biz Stuff  -->


<span style="font-size:9px">Copious Systems  2005</span>
<table width="100%"><tbody><tr><td bgcolor="darkgreen" height="1" width="100%"></td></tr></tbody></table>

<?php
	if ( ( strlen($nu_firstname) == 0 ) || ( strlen($nu_lastname) == 0 ) || ( strlen($nu_email) == 0 ) ) {
?>
<script language="javascript" type="text/javascript" >

	function postthis(frmObj) {
		frmObj.submit();
		self.close();
	}

</script>
<style type="text/css" >

	#GetMissingData {
		background-color: lightyellow;
		border: 3px solid red;
		position: absolute;
		z-index: 500;
		top: 100px;
		left: 100px;
		padding:8px;
	}

	.missingDataSender {
		border: 2px solid orange;
		padding:2px;
		cursor: pointer;
	}

</style>
<div id="GetMissingData" >
	<u>Some of your user information is missing. Please enter this before doing more account maintenance.</u>
<br>
	<form id="missingDataForm" method="POST" action="usermissing.php" >
			<input type="hidden" NAME="nu_ID" value="<?php echo $nu_ID;?>" />
			<input type="hidden" NAME="servicedir" value="<?php echo $servicedir;?>" />
			<b>First Name:</b> <input type="text" NAME="nu_firstname"  size="60" value="<?php echo $nu_firstname;?>" /><br>
			<b>Last Name:</b> <input type="text" NAME="nu_lastname"  size="60" value="<?php echo $nu_lastname;?>" /><br>
			<b>Account E-mail:</b> <input type="text" NAME="nu_email"  size="60" value="<?php echo $nu_email;?>" /><br>			
	</form>
	<br>
	<span class="missingDataSender" onclick="postthis($('missingDataForm'))">click here to submit data</span>
</div>

<?php
	}
?>

</body>
</html>
<script language="JavaScript">
//
onDisplay = $("basic_info");
refsection = onDisplay;
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
