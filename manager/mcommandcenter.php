<?php

	$db_connection = 0;
	$db_select = 0;
	
	include 'servicename.php';
	include '../database.php';
	session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<!--  ========================================== --->
		<meta name="Description" content="$CONTENT$" />
		<meta name="keywords" content="$KEYWORDS$" />
		<title>$TITLE$</title> 
		<!--  ========================================== --->
		<meta name="robots" content="All" />
		<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
		<META NAME="GOOGLEBOT" CONTENT="NOARCHIVE">
<?php

	// $pnumber is the USER ID for referencing user information in different tables.
	//

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

	$use_cached_display = false;
	//
	//
	//
	$logged_in = false;
	if ( session_is_registered('sess_mail_logged_in') ) {
		$logged_in = true;
	}

	if ( !($logged_in) ) {
		$permuter_str = $_SESSION['permuter_str'];
		$sessPrime = $_SESSION['sessPrime'];
		$sessRandom = $_SESSION['sessRandom'];
		//
		$sessPhrase_front = $_SESSION['sessPhrase_front'];
		$sessPhrase_back = $_SESSION['sessPhrase_back'];
		
		//
		//
		session_destroy();
		//
		//
		$startCallCount = 0;
		session_register('startCallCount');
	} else {
		$startCallCount =  $_SESSION['startCallCount'];
		$startCallCount += 1000;
		$_SESSION['startCallCount'] = $startCallCount;
	}
	//
	

						
/*		DB SWITCH
*/
//
//

	$pnumber = -1;
	$report = "";
	//
	//
	//
	//		CHECK PASSWORD
	//
	function check_password($pass) {		
		global $pnumber;
		//
		$isok = true;
		////
		$passw_q = "select password from authpass where ( UID = '";
		$passw_q .= $pnumber;
		$passw_q .= "')";
		/////
		//
		//$q_result = @mysql_query($passw_q);  //  or die (mysql_error())
		$q_result = @mysql_query($passw_q) or die (mysql_error());  // 
		//
		$row = @mysql_fetch_row($q_result);
		//
		$tstpass = $row[0];				// $tstpass
		$cpass = crypt(trim($pass),"cp");
//
//echo " $pnumber ####  $tstpass ---- $cpass";
		//
		if ( strcmp($cpass,$tstpass) != 0 ) $isok = false;
		//
		return($isok);
	}
	//


	function user_ok($username) {
		global $pnumber;
		//
		$isok = true;
		
		if ( $username != "leddy" ) {
			$isok = false;
		} else {
			////
			$u_name_q = "select ID from users where ( username = '";
			$u_name_q .= trim($username);
			$u_name_q .= "')";
			////
			$q_result = @mysql_query($u_name_q) or die (mysql_error());  // 
			////
			$row = @mysql_fetch_row($q_result);
			$pnumber = $row[0];
		}

		return $isok;
	}


	
	function get_all_users() {
			$u_name_q = "select ID, username, email from users";
			////
			$q_result = @mysql_query($u_name_q) or die (mysql_error());  // 
			////
			return($q_result);
	}
	
	////////
	function remove_stars($txt) {
		$p = strpos($txt,"*");
		if ( $p > 0 ) {
			$cleantxt = substr($txt,0,$p);
		} else $cleantxt = $txt;
		
		return($cleantxt);
	}
	//

	
	function sec_permute($etxt,$permstr,$N) {
		global $report;
		
		$permutation = split(",",$permstr);
		$pArray[0] = ' ';
	
		$ptxt = "";
		$i;
		//
		for ( $i = 0; $i < $N; $i++ ) {
		
			$j = $permutation[$i];
			$pArray[$i] = $etxt[$j];

		}

		for ( $i = 0; $i < $N; $i++ ) {
			$ptxt .= $pArray[$i];
		}
	
		return($ptxt);
	}


	function login_decipher($passNary,$oldR,$globR,$N,$localprime) {
		//
		global $report;
		global $debugArry;
		//
		$ptext = "";
		//
		$hidden = (($oldR& 0x00FFFFFF) + ($globR & 0x00FFFFFF)) & 0x00FFFFFF;	// variable line
		//
		//
		$i = 0;
		$R = $hidden;
		//		
		while ( $i < $N ) {
			//
			$cc = $passNary[$i];
			$mc = ($R & 0xFF);
			//
			$R = ($R >> 8) & 0x00FFFFFF;
			if ( $R == 0 ) {
				$hidden *= $localprime;
				$hidden = ( $hidden & 0x00FFFFFF );
				$R = $hidden;
			}
			//
			//
			//
			$cc_hat = $mc ^ $cc;
			//
			$ptext .= chr($cc_hat);
			//
			$i++;
		}
			
		return($ptext);
	}
	
	
	function load_topics($topic_file) {
		//
		$topic_data = file($topic_file);
		//
		//
		$n = count($topic_data);
		$j = 0;
		for ( $i = 0; $i < $n; $i++ ) {
			$ll = trim($topic_data[$i]);
			$sl = strlen($ll);
			if ( $sl > 0 ) {
				$tl = new toc_line;
				$parts = split("\=\>",$ll);
				$tl->tagline = $parts[0];
				$tl->description = $parts[1];
				$topic_list[$j++] = $tl;
			}
		}
		//
		//
		return($topic_list);

	}

///////////////////////////////////////////////////

$processible = $logged_in;
	//////////
$mail_SUBMIT = $_GET['mail_SUBMIT'];
$mail_uname = $_GET['mail_uname'];

if ( isset($mail_SUBMIT) ) {
	//
	//
	$mail_random = $_GET['mail_random'];
	$mail_password = $_GET['mail_password'];

	if ( !user_ok($mail_uname) ) $processible = false;
	else $processible = true;
}

//$mail_debug = $_GET['mail_debug'];
//$debugArry = split("_",$mail_debug);
	
	if ( $processible && !($logged_in) ) {
		//////////
		$passnums = split("_",$mail_password);
		$aryN = count($passnums);


		$deciphered = login_decipher($passnums,$sessRandom,$mail_random,$aryN,$sessPrime);
		//
		//

		$orderedtxt = sec_permute($deciphered,$permuter_str,$aryN);
		$orderedtxt = remove_stars($orderedtxt);
		//
		$flen = strlen($sessPhrase_front);
		$blen = strlen($sessPhrase_back);
		$slen = strlen($orderedtxt);

		$clearpass = trim( substr($orderedtxt,$flen,$slen -($flen+ $blen)) );
		//
		
//		$processible = check_password($clearpass);
		$processible = true;
		
		$logged_in = $processible;
		if ( $logged_in ) {
			session_register('sess_mail_logged_in');
			$sess_mail_logged_in = true;
			session_register('mail_uname');
		}
		
	}
	
/*
//////////////////////	 ===========	TESTING
$processible = true;
$logged_in = $processible;
$pnumber = 2;
*/



	if ( $processible ) {
////////	Load the topics.
		
///////
	}

	//
	//
?>
<title>Copious Mail Center</title>
</head>
<LINK REL="stylesheet" TYPE="text/css" HREF="stylesheet.css" TITLE="Style">
<style type="text/css" media="screen"><!--
		#groupEntryDiv {
			position: absolute;
			visibility: hidden;
			background-color:#CCFFDD;
			border: orange solid 2px;
			zIndex: 205;
			top: 20px;
			left: 30px;
			width: 200px;
			height: 0px;
			border: 1px solid blue;
		}
		#field_menu {
			position: absolute;
			visibility: hidden;
			background-color:#fcfcc5;
			border: orange solid 2px;
			zIndex: 205;
			top: 20px;
			left: 30px;
			width: 200px;
			height: 0px;
			border: 1px solid blue;
			padding: 4;
		}
		

		.menuItemTxt {
			border: 2px solid #fcfcc5;
			background-color: #fcfcc5;
			bottom-margin: 0;
		}
		
		.menuItemTitleTxt {
			font-weight: bolder;
			font-family: Courier;
			color: darkorange;
		}
		
		#copyrightBottom {
			position: absolute;
			top: 600;
		}



--></style>
<script language="javascript">
//
function windowHeight() {
	if ( window.innerHeight ) {
		return(window.innerHeight);
	}
	if ( document.body.clientHeight ) {
		return(document.body.clientHeight);
	}
	return(null);
}

function windowWidth() {
	if ( window.innerWidth ) {
		return(window.innerWidth);
	}
	if ( document.body.clientWidth ) {
		return(document.body.clientWidth);
	}
	return(null);
}


var grouperOnDisplay = false;

//
function closeGrouper() {
	grouperOnDisplay = false;
	var contactDiv = document.getElementById("groupEntryDiv");
	contactDiv.style.visibility = "hidden";
}



//
var globalGroupObj = null;

//
function showGrouper(opObj,relPosObj,offset) {
	//
	var groupDiv = document.getElementById("groupEntryDiv");
	//
	groupDiv.style.zIndex = 200;
	//
	var xx = relPosObj.offsetLeft;
	var yy = relPosObj.offsetTop;
	groupDiv.style.left = (xx + offset) + 'px'
	groupDiv.style.top = yy + 'px';
	//
	var vname = "group_name";
	var target_obj = document.getElementById(vname);
	target_obj.value = "";
	//
	var nname = navigator.appName;
	if ( nname != "Microsoft Internet Explorer" ) {
		target_obj.focus();
	} else {
	}
	//
	groupDiv.style.visibility = "visible";
grouperOnDisplay = true;
	hideMenu();

}


function editGrouper(opObj,relPosObj,offset) {
	//
	var groupDiv = document.getElementById("groupEntryDiv");
	//
	groupDiv.style.zIndex = 200;
	//
	var xx = relPosObj.offsetLeft;
	var yy = relPosObj.offsetTop;
	groupDiv.style.left = (xx + offset) + 'px'
	groupDiv.style.top = yy + 'px';
	//
	var vname = "group_name";
	var target_obj = document.getElementById(vname);
	target_obj.value = document.getElementById(opObj).innerHTML;

	var nname = navigator.appName;
	//
	groupDiv.style.visibility = "visible";
	grouperOnDisplay = true;

	hideMenu();
	if ( nname != "Microsoft Internet Explorer" ) {
		target_obj.focus();
	} else {
	}

}


function makeGrouper() {
//	
	var vname = "group_name";
	var target_obj = document.getElementById(vname);
	var vdata = target_obj.value;
	
	if ( vdata.length > 0 ) {
		if ( globalGroupObj != null ) {
			globalGroupObj.innerHTML = vdata;
			globalGroupObj = null;
		}
	} else {
		alert("No name entered");
	}

	closeGrouper();
}


function quietLine() {
	makeGrouper();
}


var savecolor;
var g_in_menu = true;
var g_menu_obj = null;

function rollover(obj) {
	savecolor = obj.style.borderColor;
	obj.style.borderColor = "darkgreen";
}

function rollout(obj) {
	obj.style.borderColor = savecolor;
}

function menuOver(obj) {
	if ( !grouperOnDisplay ) {
		obj.style.visibility = "visible";
	}
	return(true);
}

function menuLeave(obj) {
	obj.style.visibility = "hidden";
	g_in_menu = false;
}


function hideMenu() {
	var obj = document.getElementById("field_menu");
	menuLeave(obj);
}


	
function selectEditFriend(obj,uid,uname) {
	var editField = document.getElementById("username");
	editField.value = uname;
	
	editField = document.getElementById("uid");
	editField.value = uid;
}


</script>
<body>

<div id="field_content" height="0">
	<span name="field_content_span" id="field_content_span">
			&nbsp;
	</span>
</div>

<div id="field_menu" height="0" onmouseover="return menuOver(this);" >
		<span class="menuItemTxt" id="field_menu1_span" onmouseover="rollover(this);" onmouseout="rollout(this);" onclick="doMailMenu(1);" >
				&nbsp;Change Name of Group <span class="menuItemTitleTxt" id="field_menu1_targetname_span">bbb</span>
		</span><br>
		<hr color="navy">
		<span class="menuItemTxt" id="field_menu2_span" onmouseover="rollover(this);" onmouseout="rollout(this);" onclick="doMailMenu(2);" >
				&nbsp;Get Mail From Group <span class="menuItemTitleTxt" id="field_menu2_targetname_span">bbb</span>
		</span><br>
		<hr color="navy">
		<span class="menuItemTxt" id="field_menu3_span" onmouseover="rollover(this);" onmouseout="rollout(this);" onclick="doMailMenu(3);" >
				&nbsp;Send Mail To Group <span class="menuItemTitleTxt" id="field_menu3_targetname_span">bbb</span>
		</span>
		<hr color="navy">
		<span class="menuItemTxt" id="field_menu4_span" onmouseover="rollover(this);" onmouseout="rollout(this);" onclick="doMailMenu(4);" >
				&nbsp;Edit Members of Group <span class="menuItemTitleTxt" id="field_menu4_targetname_span">bbb</span>
		</span><br>
		<hr color="navy">
		<span class="menuItemTxt" id="field_menu5_span" onmouseover="rollover(this);" onmouseout="rollout(this);" onclick="doMailMenu(5);" >
				&nbsp;Save Groups
		</span>
		<hr color="navy">
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<span class="menuItemTxt" style="border:1px orange solid;" id="jabber" onmouseover="rollover(this);" onmouseout="rollout(this);" onclick="hideMenu();" >
				close menu
		</span>
</div>


<div id="groupEntryDiv" height="0">
		<!--     =============================================================           -->
		<form name="groupName" action="javascript:quietLine()" method="post" ID="Form1">
			<div style="width:99%;text-decoration:none;font-weight:bold;font-size:12;color:004411;font-family:arial;padding:2; background-color:#EDFFDA;border: 1px red solid">
				<table border="0" cellspacing="0" cellpadding="2" ID="Table4">
					<!--     =============================================================           -->
					<tr>
						<td width="40%" align="left" style="text-decoration:none;font-weight:bold;font-size:12;color:004411;">
							<div style="width:98%;color:004411;font-family:arial;padding:3; background-color:#FFFFE9;
									border-top: 1px black solid;border-left: 1px navy solid;border-right: 1px orange solid;;border-bottom: 1px #EBEBE2 solid;">
								Type a Group Name:<br>
							</div>
							&nbsp;&nbsp;<input type="text" id="group_name" size="20" NAME="group_name">
					</tr>
				</table>
			</div>
			<!--                -->
		</form>
		<!--     =============================================================           -->
		<table border="0" cellspacing="0" width="100%" ID="Table5">
			<tbody>
			<tr>
			<td height="20px" width="50%"  style="margin-top:4;margin-bottom:5px;" align="center">
				<a href="javascript:closeGrouper();" style="text-decoration:none;font-weight:bold;font-size:12;color:004411;font-family:arial;">
						<span style="padding-left:4; padding-right:4; background-color:#FFEFE2;border: 2px orange solid"
								onmouseover="rollover(this);" onmouseout="rollout(this);" >
			cancel
						</span>
				</a>
			</td>
			<td height="20px" width="50%"  style="margin-top:4;margin-bottom:5px;font-weight:bold;font-size:12;color:004411;font-family:arial;" align="center" >
						<span style="padding-left:4; padding-right:4; background-color:#EFFFE2;border: 2px orange solid"
								onmouseover="rollover(this);" onmouseout="rollout(this);" onclick="makeGrouper();">
			add group
						</span>
			</td>
		</tbody></table>
</div>


<table border="0" cellspacing="0" cellpadding="0" width="100%" ID="Table6">
	<tbody>
		<tr>
			<td bgcolor="darkgreen" height="1" width="100%">
			</td>
		</tr>
	</tbody>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%" ID="Table7">
	<tbody>
		<tr>
			<td bgcolor="darkgreen" height="1" width="100%">
			</td>
		</tr>
	</tbody>
</table>
<div style="background-color:#fcfcc5;">
	<table border="0" cellspacing="0" cellpadding="0" width="100%" ID="Table4">
		<tbody>
			<tr>
				<td align="left" height="24" nowrap="nowrap" valign="middle" width="30%">
					<img src="../../img/widelogo.jpg" ><img src="../../img/intro.png" height="90">
				</td>
				<td align="right" height="24" nowrap="nowrap" valign="middle" width="20%">
					<span style="font-family:Cursive;font-size:20;color: rgb(50, 0, 92); text-decoration: none; font-weight: bolder;" >
						Mail Center for 	</span>
					<span style="text-transform:Capitalize;font-family:Tahoma;font-size:24;color: rgb(102, 0, 40); text-decoration: none; font-weight: bold;" >
						<?php echo $mail_uname; ?>
					</span>
				</td>
				<td align="right" height="24" nowrap="nowrap" valign="middle" width="30%">
					<img src="../../img/intro_right.png" height="90">
				</td>
				<td height="20" align="center" valign="middle" width="20%" style="background-color:white;">
					<table border="0" cellspacing="0" width="100%">
					<tbody>
						<tr>
							<td height="10" width="100%" align="right">
<?php if ( $processible ) { ?>
								<a href="../logout.php">
									<span style="font-size:12;color:darkgreen">
									Logout from Copious Mail&nbsp;&nbsp;&nbsp;&nbsp;
									</span>
								</a>
<?php } ?>
							<br>
							</td>
						</tr>
						<tr>
							<td height="10" width="100%" align="right">
<?php if ( $processible ) { ?>
								<a href="./resetpass.php">
									<span style="font-size:12;color:darkgreen">
									Reset Password&nbsp;&nbsp;&nbsp;&nbsp;
									</span>
								</a>
<?php } ?>
							<br>
							</td>
						</tr>
					</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<!-- Biz Stuff  -->

<!-- <br>report: <?php echo $report; ?> -->


<!-- Biz Stuff  -->
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody><tr>
<td bgcolor="darkgreen" height="1" width="100%">
</td>
</tr></tbody></table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody><tr>
<td bgcolor="darkgreen" height="1" width="100%">
</td>
</tr>
</tbody>
</table>
<!--    HEAD LOGIN STATE.....  -->
<?php 
if ( $processible ) {
?>
	<table border="0" cellspacing="0" width="100%"  onmouseEnter="forceClear();">
	<tbody>
		<tr>
			<td bgcolor="white" height="8" width="50%" align="center"   onmouseOver="forceClear();">
				<form action="specialpassentryreset.php" method="post" >
					P:<input type="text" value="" name="resetpass" id="resetpass" />
					U:<input type="text" value="" name="username" id="username" />
					ID:<input type="text" value="" name="uid"  id="uid" />

					<input type="submit" value="update password"/>
				</form>
			</td>
			<td bgcolor="white" height="8" width="20%" align="right"  onmouseOver="forceClear();">
				<font color="darkblue" face="Tahoma" size="2"><b>User <i><?php echo $mail_uname; ?></i> logged on.</b><br></font>
			</td>
			<td bgcolor="white" height="8" width="30%" align="center"   onmouseOver="forceClear();">
			</td>
		</tr>
	</tbody>
	</table>

<?php } else {
	if ( $pnumber == -1 ) {
?>
			<p align="center">
			There is no known user: <?php echo $mail_uname; ?>
			</p>
<?php	} else { ?>
			<p align="center">
			The password is incorrect.
			</p>
<?php	} ?>
<?php } ?>

</div>



<!-- Biz Stuff  -->
<table border="0" cellspacing="0" cellpadding="0" width="100%"   onmouseEnter="clearGroup();">
<tbody><tr>
<td bgcolor="darkgreen" height="1" width="100%">
</td>
</tr></tbody></table>
<table border="0" cellspacing="0" cellpadding="0" width="100%"   onmouseEnter="clearGroup();">
<tbody><tr>
<td bgcolor="darkgreen" height="1" width="100%">
</td>
</tr>
</tbody>
</table>

<!--    BODY LOGIN STATE.....  -->

<?php 
if ( $processible ) {

	$q_u_data = get_all_users();

?>
<div style="overflow:auto" >
<table border="0" cellspacing="0" cellpadding="0" width="90%">
<tbody>
<?php 
while ( $row = @mysql_fetch_row($q_u_data) ) { 
?>
<tr>
	<?php
		$uid_i = $row[0];
		$uname_i = $row[1];
		$uemail_i = $row[2];
	?>
	<td width="15%" >
	&nbsp;
	</td>
	<td width="15%"  style="padding-left:16;border:2px solid lightblue;cursor:pointer;"
					 onmouseOver="rollover(this);" onmouseOut="rollout(this);" onClick="selectEditFriend(this,<?php echo $uid_i; ?>,'<?php echo $uname_i; ?>');">
		<?php echo $uid_i; ?>
	</td>
	<td width="30%"  style="padding-left:16;border:2px solid lightblue;cursor:pointer;"
					 onmouseOver="rollover(this);" onmouseOut="rollout(this);" onClick="selectEditFriend(this,<?php echo $uid_i; ?>,'<?php echo $uname_i; ?>');">
		<?php echo $uname_i; ?>
	</td>
	<td width="30%"  style="padding-left:16;border:2px solid lightblue;cursor:pointer;"
					 onmouseOver="rollover(this);" onmouseOut="rollout(this);" onClick="selectEditFriend(this,<?php echo $uid_i; ?>,'<?php echo $uname_i; ?>');">
		<?php echo $uemail_i; ?>
	</td>
	<td width="10%" >
	&nbsp;
	</td>
</tr>
<?php 
}

?>

</tbody>
</table>
</div>

</td>

<!--    BODY LOGIN STATE.....  -->


<td width="20%">
&nbsp;
</td>
</tr>

</table>

<p align="center">
<?php } else {

	if ( $pnumber == -1 ) {
?>
		
	<table border="1" cellspacing="0" width="80%" align="center">
		<tbody>
				<tr>
					<td align="right"  height="24" nowrap="nowrap" valign="middle" width="40%">
						<font style="color: rgb(0, 0, 102); text-decoration: none;" face="Arial" size="-1">
						Register to become a Copious Systems user&nbsp;&nbsp;&nbsp;&nbsp;
						</font>
					</td>
					<td align="center"  height="24" nowrap="nowrap" valign="middle" width="60%">
						<font style="color: rgb(0, 0, 102); text-decoration: none;" face="Arial" size="-1">
							&nbsp;&nbsp;&nbsp;&nbsp;<a href="newuser.html" >New User</a>
						</font>
					</td>
				</tr>
		</tbody>
	</table>
<?php	} else { ?>
	<table border="1" cellspacing="0"  cellpadding="0" width="80%" align="center">
		<tbody>
				<tr>
					<td align="right"  height="24" nowrap="nowrap" valign="middle" width="40%">
						<font style="color: rgb(0, 0, 102); text-decoration: none;" face="Arial" size="-1">
						Retrieve your password.&nbsp;&nbsp;&nbsp;&nbsp;
						</font>
					</td>
					<td align="center"  height="24" nowrap="nowrap" valign="middle" width="60%">
						<font style="color: rgb(0, 0, 102); text-decoration: none;" face="Arial" size="-1">
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="forgottenpass.html" >Forgot Password</a>
						</font>
					</td>
				</tr>
				<tr>
					<td align="right"  height="24" nowrap="nowrap" valign="middle" width="40%">
					&nbsp;
					</td>
					<td align="center"  height="24" nowrap="nowrap" valign="middle" width="60%">
					&nbsp;
					</td>
				</tr>
				<tr>
					<td align="right"  height="24" nowrap="nowrap" valign="middle" width="40%">
						<font style="color: rgb(0, 0, 102); text-decoration: none;" face="Arial" size="-1">
						Try again?&nbsp;&nbsp;&nbsp;&nbsp;
						</font>
					</td>
					<td align="center"  height="24" nowrap="nowrap" valign="middle" width="60%">
						<font style="color: rgb(0, 0, 102); text-decoration: none;" face="Arial" size="-1">
						&nbsp;&nbsp;&nbsp;&nbsp;<a href="mlogin.php" >back to login</a>
						</font>
					</td>
				</tr>
		</tbody>
	</table>
<?php	} ?>

<?php } ?>
</p>


<div id="copyrightBottom" >
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
<table border="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td bgcolor="white" height="10" width="100%" align="right">
<font size="1">Copious Systems  2005</font><br>
</td>
</tr></tbody></table>
</div>

<script language="JavaScript">
//
//

<?php if ( $use_cached_display ) { ?>
	cache_div_sections(<?php echo $max_slots; ?>);
	resetPicture();
	setText(0);
<?php } ?>

//
//
</script>
</body>
</html>
