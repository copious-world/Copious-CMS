<?php

$leftLogo = "./img/logo.jpg";
$rightLogo = "./img/logo.jpg";

if ( isset($_POST['WELCOME_MESSAGE']) || isset($_GET['WELCOME_MESSAGE']) ) {
	if ( isset($_POST['WELCOME_MESSAGE']) ) {
		$WELCOME_MESSAGE = $_POST['WELCOME_MESSAGE'];
		$SERVICE =  $_POST['SERVICE'];
		$INFORMATION_MSGS = $_POST['INFORMATION_MSGS'];
////
		$server =  $_SERVER['SERVER_NAME'];
		///
		$actionurl =  "http://" . $server . "/";
		$secactionurl =  "https://" . $server . "/";

		$phpfile = "commandcenter";
		if ( isset( $_POST['phpfile'] ) ) {
			$phpfile = $_POST['phpfile'];
		}

		$phpservicedir =  $_POST['RELSERVICELOCUS'];

		$windowView = "pop";
		if ( isset( $_POST['windowView'] ) ) {
			$windowView = $_POST['windowView'];
		}
		$backnav = "";
		if ( isset( $_POST['backnav'] ) ) {
			$backnav = $_POST['backnav'];
			$backnav = urldecode($backnav);
		}

		$servicelist = null;
		$clickhandler = "";
		if ( isset( $_POST['clickhandler'] ) ) {
			$clickhandler = $_POST['clickhandler'];
			$clickhandler = urldecode($clickhandler);
		}

		if ( isset($_POST['suppress_signup']) ) {
			$suppress_signup_button = TRUE;
		}

	} else {
		$WELCOME_MESSAGE = $_GET['WELCOME_MESSAGE'];
		$SERVICE =  $_GET['SERVICE'];
		$INFORMATION_MSGS = $_GET['INFORMATION_MSGS'];
////
		$server =  $_SERVER['SERVER_NAME'];
		///
		$actionurl =  "http://" . $server . "/";
		$secactionurl =  "https://" . $server . "/";


		$phpfile = "commandcenter";
		if ( isset( $_GET['phpfile'] ) ) {
			$phpfile = $_GET['phpfile'];
		}

		$phpservicedir =  $_GET['RELSERVICELOCUS'];

		$windowView = "pop";
		if ( isset( $_GET['windowView'] ) ) {
			$windowView = $_GET['windowView'];
		}

		$servicelist = null;
		
		if ( isset( $_GET['leftlogo'] ) ) {
			$leftLogo = urldecode($_GET['leftlogo']);
		}

		if ( isset( $_GET['rightlogo'] ) ) {
			$rightLogo = urldecode($_GET['rightlogo']);
		}

		$backnav = "";
		if ( isset( $_GET['backnav'] ) ) {
			$backnav = $_GET['backnav'];
			$backnav = urldecode($backnav);
		}

		$clickhandler = "";
		if ( isset( $_GET['clickhandler'] ) ) {
			$clickhandler = $_GET['clickhandler'];
			$clickhandler = urldecode($clickhandler);
		}

		if ( isset($_GET['suppress_signup']) ) {
			$suppress_signup_button = TRUE;
		}

	} 

} else {
	$windowView = "pop";
	$phpfile = "commandcenter";

	class service {
		public $label;
		public $href;
		public $description;
	};

	$WELCOME_MESSAGE = "Welcome to Copious Systems Services";
	$SERVICE =  "Collection";
	$INFORMATION_MSGS = "<span style='font-weight:bold;color:drakgreen;'>Please select from one of the following services:</span>";
	$actionurl =  "null";
	////
	$server =  $_SERVER['SERVER_NAME'];
	///
	$actionurl =  "http://" . $server . "/hosted/mail/";
	$secactionurl =  "https://" . $server . "/hosted/mail/";

	$phpservicedir = ".";
	$phpfile = "commandcenter";
	//
	$saddr = "http://$server/hosted/";
	////
	include "../install/servicelist.inc";

} 

$userportal = "hosted/accounttype/";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!--  ========================================== --->
	<meta name="Description" content="$CONTENT$" />
	<meta name="keywords" content="$KEYWORDS$" />
	<title>Hosted Service Entry</title> 
	<!--  ========================================== --->
	<meta name="robots" content="All" />
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<META NAME="GOOGLEBOT" CONTENT="NOARCHIVE">
<style type="text/css"> <!--
	
	#midsectionAnchor {
		position: relative;
		left: 0px;
		top: 0px;
		visibility: visible;
	}

	#accessAnchor {
		position: relative;
		left: 0px;
		top: 0px;
		visibility: visible;
		background-color: white;
		border: solid 1px navy;
		padding: 2px;
		margin: 2px;
	}
	.midBanner {
		position: absolute;
		left: 0px;
		top: 0px;
		visibility: hidden;
	}


--></style>

<!--  ========================================== --->
<LINK REL="stylesheet" TYPE="text/css" HREF="stylesheet.css" TITLE="Style">
<script language="javascript" type="text/javascript" src="js/browserid.js"></script>
<script language="javascript" type="text/javascript" src="js/infowindow.js"></script>
<script  language="javascript" type="text/javascript" >

showWindowOperationLoc = false;

var actionurl = "<?php echo $actionurl; ?>";
var secactionurl = "<?php echo $secactionurl; ?>";

var phpfile = "<?php echo $phpfile; ?>";
var phpservicedir = "<?php echo $phpservicedir; ?>";

var g_click_handler = "<?php echo $clickhandler; ?>";

var reactionbase = secactionurl +  "<?php echo $userportal; ?>";

var basiclocus = self.location;

basiclocus = new String(basiclocus.toString());


if ( basiclocus.indexOf(".php") > 0 ) {
	basiclocus = basiclocus.substring(0,basiclocus.lastIndexOf(".php"));
	basiclocus = basiclocus.substring(0,basiclocus.lastIndexOf("/")+1);
}


if ( basiclocus.substring(0,5) == "https" ) {
	securelocus = basiclocus;
	basiclocus = "http" + basiclocus.slice(5);
} else {
	securelocus = "https" + basiclocus.slice(4);
}




var homevars = { secure: securelocus, basic: basiclocus };
////////
//////
////

/*
var special_ops = {};
var special_ops_key = "";
*/
function hosted_index_focuser(result) {
	if ( result == "OK" ) {
var q = window.opener;
window.blur();
q.focus();
q.location = "http://localhost/hosted/" + '<?php echo $backnav;?>' + "?sess=" + g_sec_sessionid;
	}
}



function window_refocus_operation(vardata) {
	if ( g_click_handler.length > 0 ) {
		spanID = "";
		special_ops_key = "stateful";
		special_ops[special_ops_key] = hosted_index_focuser;
		var url = g_click_handler + "?sid=" + g_sec_sessionid  + "&data=" + vardata;
		makeDocRequest(url);
	}
}




</script>
<script language="JavaScript" type="text/javascript" src="js/dimensions.js"> </script>
<script  language="javascript" type="text/javascript" >
////
var featureWin = [null,null,null,null,null,null,null,null,null,null];
var featureWinCurrentURL = "";

function wopener(urlNpar,ff) {
	if ( (featureWin[ff] != null ) && featureWin[ff].closed ) featureWin[ff] = null;
	////
	if ( featureWin[ff] == null ) {
		var w = self.open(urlNpar,("FEATUREWIN" + ff),"width=" + g_screenWidth + ",height=" + g_screenHeight + ",resizeble=yes,status=yes,scrollbars=yes,toolbar");
		featureWin[ff] = w;
		w.moveTo(20,20);
		w.focus();
	} else {
		featureWin[ff].focus();
	} 
}


function closeFeatures() {
	var n = featureWin.length;
	for ( var i = 0; i < n; i++ ) {
		if ( featureWin[i] != null ) featureWin[i].close();
	}
}

</script>
<script language="JavaScript" type="text/javascript" src="js/docjaxresponse.js"> </script>
<script language="JavaScript" type="text/javascript" src="js/docjax.js"></script>
<script language="javascript" type="text/javascript" src="js/jsresources.js"></script>
<script language="javascript" type="text/javascript" src="copiousauth/secsource.js"></script>
<!--  ========================================== --->
<!-- Multilingual Keyboard -->
<script language="javascript" type="text/javascript" src="js/cvt/util.js"></script>
<script language="javascript" type="text/javascript" src="js/cvt/kbvariants.js"></script>
<!-- Multilingual Keyboard -->
<script language="javascript" type="text/javascript" src="js/cvt/cvt.js"></script>
<script language="javascript" type="text/javascript" src="js/cvt/cvtnonus.js"></script>
<script language="javascript" type="text/javascript" src="js/cvt/cvtnon_e.js"></script>
<script language="javascript" type="text/javascript" src="js/cvt/cvtinterface.js"></script>
<!--  ========================================== --->
<script language="javascript" type="text/javascript" >
var g_squeeze = 0;
if ( g_screenHeight >= 900 ) {
	g_squeeze = 0;
} else if ( g_screenHeight > 600 ) {
	g_squeeze = 1;
} else {
	g_squeeze = 2;
}


		
if ( g_squeeze == 0 ) {
	document.writeln('<LINK REL="stylesheet" TYPE="text/css" HREF="../stylesheet.css" TITLE="Style">');
} else if ( g_squeeze == 1 ) {
	document.writeln('<LINK REL="stylesheet" TYPE="text/css" HREF="../stylesheet700.css" TITLE="Style">');
} else {
	document.writeln('<LINK REL="stylesheet" TYPE="text/css" HREF="../stylesheet600.css" TITLE="Style">');
}
</script>
<!--  ========================================== --->

</head>

<!--  ========================================== --->
<body onunload="javascript:reloadLogout();" >
		<table border="0px" cellspacing="0px" cellpadding="0px" width="100%" ID="Table6">
			<tbody>
				<tr>
					<td bgcolor="darkgreen" height="1px" width="100%"></td>
				</tr>
			</tbody></table>
		<table border="0px" cellspacing="0px" cellpadding="0px" width="100%" ID="Table6">
			<tbody>
				<tr>
					<td bgcolor="darkgreen" height="1px" width="100%"></td>
				</tr>
			</tbody></table>
		<!-- =======================================  -->
		<div style="background-color:#fcfcc5;">
			<table border="0px" cellspacing="0px" cellpadding="0px" width="100%">
				<tbody>
					<tr>
						<td align="left" height="24px" nowrap valign="middle" width="30%">
<script language="javascript">
	if ( g_squeeze < 2 ) {
		document.writeln('<img src="<?php echo $leftLogo; ?>"><img src="./img/faderight.jpg" height="90px">');
	} else {
		document.writeln('<img src="<?php echo $leftLogo; ?>" height="45px"><img src="./img/faderight.jpg" height="45px">');
	}
</script>
						</td>
						<td align="center" height="24px" nowrap valign="middle" width="40%">
							<span  style="font-face:Arial;font-size:18px;color: rgb(0, 0, 102); text-decoration: none; font-weight: bold;">
									<?php echo $WELCOME_MESSAGE; ?>
							</span>
						<br>
						<span style="font-face:Arial;font-size:18px;color: rgb(0, 0, 102); text-decoration: none; font-weight: bold;">
							<?php echo $SERVICE; ?>
						</span>
						</td>
						<td align="right" height="24px" nowrap valign="middle" width="30%">
<script language="javascript">
	if ( g_squeeze < 2 ) {
		document.writeln('<img src="./img/fadeleft.jpg" height="90px"><img src="<?php echo $rightLogo; ?>">');
	} else {
		document.writeln('<img src="./img/fadeleft.jpg" height="45px"><img src="<?php echo $rightLogo; ?>" height="45px">');
	}
</script>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="background-color:rgb(243,243,223)">
			<!-- ===========================================  -->
			<table border="0px" cellspacing="0px" cellpadding="0px" width="100%">
				<tbody>
					<tr>
						<td bgcolor="darkgreen" height="1px" width="100%"></td>
					</tr>
				</tbody></table>
			<table border="0px" cellspacing="0px" cellpadding="0px" width="100%">
				<tbody>
					<tr>
						<td bgcolor="darkgreen" height="1px" width="100%"></td>
					</tr>
				</tbody></table>
			<br>
			<div id="midsectionAnchor" align="center" style="padding:2px;">
				<div id="midsectionWhiteDiv" style="width: 60%;max-height:300px;background-color:white;border: solid 1px navy;padding: 8px;overflow:auto;">
				<?php echo $INFORMATION_MSGS . "\n";
		if ( ( $servicelist != "null" ) && (count($servicelist) > 0) && (isset($_SERVER['HTTPS'])) ) {
	?>

		<br>	<br>
		<table border="0px" cellspacing="0px" cellpadding="0px" width="75%">
		<tbody>
<?php
		$n = count($servicelist);
		for ( $i = 0; $i < $n; $i++ ) {
			$service = $servicelist[$i];
			$href = $service->href;
			$label = $service->label;
			$description = $service->description;
$servicerow =<<<EOROW
		<tr>
		<td width="30%">
		<a href="$href" target="_blank" >$label</a>
		</td>
		<td width="70%" >
		$description
		</td>
		</tr>
EOROW;
		$rr = $servicerow;
		echo $rr . "\n";
		}
?>
		</tbody>
		</table>
		<br>
		<br>
<?php
}
?>

				</div>
				<br>
				<!--  ========================================== --->
				<div style=" border: 2px solid yellow;padding:2px;">
					<div id="accessAnchor" style="width: 60%;">
<!--  ========================================== --->
<!--  ========================================== --->
<?php 
	if ( !isset($_SERVER['HTTPS']) ) {
?>
<div style="text-align:center" >
		This page cannot deliver a service HTTPS, http over ssl must be use.
</div>
<?php
	} else {
?>
<script language="javascript" type="text/javascript" src="/hosted/copiousauth/authengine.js"></script>


<style type="text/css"> <!--
	.controlpanel = {
		background-color: #FFFFAA;
		border: solid 1px red;
	}
--></style>


<style type="text/css"> <!--
		
	.signupAnchor {
		background-color: rgb(230,240,220);
		text-decoration: none;
		border: gold 1px solid;
		color: darkgreen;
		padding: 2px;
		font-family: tahoma;
		font-weight: bold;
		font-size: 12px;
	}

	.attention_sign_up {
		color: #551100;
		font-family: tahoma;
		font-weight: bold;
		font-size: 12px;
		padding: 2px;
		padding-right:6px;
		padding-left:6px;
		background-color: rgb(245,245,180);
		border: solid gold 1px;
		border-right: none;
		text-decoration: underline;
	}

	.attention_sign_up_point {
		color: darkred;
		font-family: tahoma;
		font-weight: bold;
		font-size: 12px;
		padding: 0px;
		background-color: rgb(245,245,180);
		border-right: none;
	}

	#multiLangInput {
		position: absolute;
		visibility: hidden;
		left: 0px;
		top: 0px;
		z-index: 104;
		background-color: #FEFEEE;
		border: solid 1px darkgreen;
		padding: 4px;
	}
	
	#multiLangPass {
		position: absolute;
		visibility: hidden;
		left: 0px;
		top: 0px;
		width: 0px;
		z-index: 104;
		background-color: #FEFEEE;
		border: solid 1px darkgreen;
		padding: 4px;
	}

	#authUserName {
		position: relative;
		visibility: hidden;
		left: 0px;
		top: 0px;
		height: 0px;
		width: 0px;
		z-index: 104;
	}
	
	#succesfulLogin {
		position: absolute;
		visibility: hidden;
		left: 0px;
		top: 0px;
		height: 0px;
		width: 0px;
		z-index: 104;
	}
	
	#signedInDone {
	}

	.logoutSpan {
		cursor:pointer;
		font-size:12;
		color:darkgreen;
		border: solid green 1px;
		padding: 2px;
	}
	
	.langchoicStyle {
		padding:8px;
		padding-bottom:6px;
		font-size:10px;
		font-family:arial black;
		cursor:pointer;
		text-weight:bolder;
		color:darkgreen;
		border:solid 2px darkgreen;
		background-color:#FAFAAA;
	}
	
	.exitRefProc {
		border:1px solid black;
		width:200px;
		font-family: arial;
		font-size:12px;
		color: rgb(0, 0, 102);
		text-decoration: none;
		padding-left: 2px;
		padding-right: 2px;
	}
--></style>
						<div align="left" style="background-color:rgb(253,243,223);padding-left: 8px;padding-top: 4px;">
							<table style="text-align: left; height: 35px; width: 100%; font-weight:bold;" border="0" cellpadding="0" cellspacing="0">
								<tbody>
									<tr>
										<form id="loginform" method="post" action="javascript:loginAuth();" target="_self">
											<td id="imgholder" align="left" valign="middle" width="75%" style="background-color: rgb(252, 252, 224);padding-left:12px;">
												<div id="SIGNINDIV" style="width:100%;">
													<span class="signupAnchor" style="cursor:pointer" onclick="javascript:showform('buttonImgSignUp');">Sign In</span>
													<a href="javascript:showform('buttonImgSignUp');" style="padding-top:4px;vertical-align:middle;">
														<img id="buttonImgSignUp" src="./img/buttonUp.jpg" border="0" height="20px"> </a>
													<div id="multiLangInput">
														<span class="langchoicStyle" onchange="languageChange($('langchoice').value);">
															<select id="langchoice" name="langchoice" onchange="languageChange($('langchoice').value);" >
																<option value="English">English</option>
																<option value="Russian">Russian</option>
															</select>
														</span>
														&nbsp; <input maxlength="16" value="" name="username" id="username" size="20" onselect="saveCaret(this)" onclick="saveCaret(this)" onkeyup="saveCaret(this)" onkeypress="return changeKey(this, event, fName);">
														<input type="submit" value="sign in" ID="Submit2" NAME="Submit1">
													</div>
		
													<div id="multiLangPass">
														<span id="authUserName" style="padding-right:2px;padding-left:2px;color:darkgreen;border: 1px green solid;text-decoration:none;">
														&nbsp;
													</span>
														Enter Password:&nbsp; <input type="password" value="" maxlength="16" name="PN_password" id="PN_password" size="20">
														<input type="submit" value="sign in" ID="Submit3" NAME="Submit1">
														
<script language="javascript" type="text/javascript"><!--
	if ( ( g_squeeze >= 1 ) || ( live_page_width() < 900 ) )  {
		document.writeln('<br>');
	} else {
		document.writeln('&nbsp;&nbsp;');
	}
// --></script>											<a href="forgottenpass.php?servicedir=<?php echo $phpservicedir; ?>" class="exitRefProc" >
														Forgot Password
														</a>
													</div>
												</div>
												<div id="succesfulLogin">
													<span id="signedInDone">
													</span>
													<span  class="logoutSpan" onclick="javascript:logoutAction();" >
														Logout
													</span>
													&nbsp;
<script language="javascript" type="text/javascript">
if ( Br == "IE" ) {
function setHref(linker) {
	setServiceDir(phpservicedir);
	var gothere = accountFeatureParams();
	linker.href = gothere;
}
document.writeln("<a onmouseover=\"setHref(this)\" class=\"logoutSpan\" style=\"cursor:pointer;background-color:#FFFFEF;border: 1px solid darkgreen;text-align:center;\" target=\"ACCOUNTINFO\" >Account Information</a>");
} else {
setServiceDir(phpservicedir);
document.writeln("<span id=\"accountInfoSpan\" class=\"logoutSpan\" onclick=\"accountFeaturesAction();\" >");
document.writeln("Account Information</span>");
}
</script>
												</div>
												<br><br>
											</td>
										</form>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div align="center" style="width: 40%;background-color:rgb(243,243,243);padding-top: 6px;">
			  <!-- ===========================================  -->
			  <div align="right" style="background-color:rgb(243,253,223);padding-right: 8px;padding-bottom: 4px;">
<?php
	if ( !(isset($suppress_signup_button)) ) {
?>
			  <span class="attention_sign_up">Get an account here
					<span class="attention_sign_up_point" style="padding-left:4px;">&gt;</span><span class="attention_sign_up_point" style="color:orange;">&gt;</span><span class="attention_sign_up_point" style="color:green;">&gt;</span></span>
<a class="signupAnchor" href="newuser.php?servicedir=<?php echo $phpservicedir; ?>" target="_blank">Sign Up</a>
<?php
	}
?>
			  <span style="color: rgb(0, 0, 102); text-decoration: none;font-family:Arial;font-size:16;font-weight:bold">
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <script language="javascript" type="text/javascript" >
			  document.writeln('<a href="' + homevars.basic + 'help.html" target="_blank" style="border:1px solid purple;font-family:helvetica;font-size:10px;padding:2px;background-color:#EEFFEF;color:maroon">');
	  </script>
			  help</a>
			  </span>
			  </div>
						
					</div>
				</div>
			</div>
<?php 
	}
?>
			<br>
			<!-- ===========================================  -->
			<table border="0px" cellspacing="0px" cellpadding="0px" width="100%">
				<tbody>
					<tr>
						<td bgcolor="darkgreen" height="1px" width="100%"></td>
					</tr>
				</tbody></table>
			<table border="0px" cellspacing="0px" cellpadding="0px" width="100%">
				<tbody>
					<tr>
						<td bgcolor="darkgreen" height="1px" width="100%"></td>
					</tr>
				</tbody></table>
		</div>
<font size="1px">Copious Systems © 2006</font><br>
<script language="javascript" type="text/javascript" src="js/cvt/cvtinterfaceinit.js"></script>
<?php 
			  switch ( $windowView ) {
					case "pop": {
?>
<script >
	var actionWindow = null;
	user_login_state_action = (function(state) {
		if ( state ) {
			/// g_sec_userid = 0;
			/// g_sec_sessionid = 0;
			if ( actionurl != null ) {
				actionWindow = self.open(actionurl + phpfile + ".php?diddle=" + g_sec_userid + "&sid=" + g_sec_sessionid +  "&browser=dopey");
			}
			//
		} else {
			if ( actionWindow != null ) {
				actionWindow.close();
			}
			self.close();
		} 
	});


</script>
<?php 
					break;
				}
				case "div": {
?>
<script >
	var actionWindow = null;
	var main_control_window = null;
	user_login_state_action = (function(state) {
		if ( state ) {
			if ( actionurl != null ) {

				spanID = "midsectionWhiteDiv";
				var getter = (reactionbase + phpfile + ".php?diddle=" + g_sec_userid + "&sid=" + g_sec_sessionid +  "&browser=" + Br + "&appdir=" + phpservicedir);
				makeDocEvalRequest(getter);
				////
				var backnavrul = ('<?php echo $backnav;?>');
				if ( backnavrul.length ) {
				//
					var q = window.opener;
					main_control_window = q;
					q.focus();
					q.location = basiclocus + '<?php echo $backnav;?>' + "?sess=" + g_sec_sessionid + "&appdir=" + phpservicedir;
				//
				}
			}
			//
		} else {
			closeFeatures();
			if ( main_control_window == null ) {
				var q = window.opener;
				main_control_window = q;
			}
			main_control_window.focus();
			main_control_window.history.back();
			// main_control_window.location = basiclocus + phpservicedir;
			self.close();
		} 
	});


</script>
<?php 
					break;
				}
				case "win": {
					break;
				}
			}


	?>

		
	</body>
</html>
