<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!-- Sign Up  -->
<?php

	global $db_connection;
	require_once('admin_header_lite.php');
	require_once('identity.php');


?>
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $SERVICE; ?> New User</title>
</head>
<style type="text/css" media="screen"><!--

		#SymbolNameEntry {
			visibility: visible;
		}

		#IdNameEntry {
			visibility: hidden;
			position: absolute;
			top: 0px;
			left: 0px;
		}
		
		#AddressEntry {
			visibility: hidden;
			position: absolute;
			top: 0px;
			left: 0px;
		}

		#PhoneEntry {
			visibility: hidden;
			position: absolute;
			top: 0px;
			left: 0px;
		}
		
		
		#EmailEntry {
			visibility: hidden;
			position: absolute;
			top: 0px;
			left: 0px;
		}
		
		#Completion {
			visibility: hidden;
			position: absolute;
			top: 0px;
			left: 0px;
		}
		
		#tester {
			visibility: hidden;
		}


		.formEntry {
			border: 1px gray solid;
			width:500px;
			text-align:justify;
			padding:10px;
			background-color:#FEFEF5;
		}
		

 --></style>

<script language="javascript" type="text/javascript" src="/hosted/js/browserid.js"></script>
<script language="JavaScript" type="text/javascript" src="/hosted/js/dimensions.js"> </script>
<script language="JavaScript" type="text/javascript" src="/hosted/js/docjaxresponse.js"> </script>
<script language="JavaScript" type="text/javascript" src="/hosted/js/docjax.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/jsresources.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/copiousauth/secsource.js"></script>
<!--  ========================================== --->
<!-- Multilingual Keyboard -->
<script language="javascript" type="text/javascript" src="/hosted/js/cvt/util.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/cvt/kbvariants.js"></script>
<!-- Multilingual Keyboard -->
<script language="javascript" type="text/javascript" src="/hosted/js/cvt/cvt.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/cvt/cvtnonus.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/cvt/cvtnon_e.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/cvt/cvtinterface.js"></script>
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


var basiclocus = self.location;

basiclocus = new String(basiclocus.toString());

if ( basiclocus.substring(0,5) == "https" ) {
	securelocus = basiclocus;
	basiclocus = "http" + basiclocus.slice(5);
} else {
	securelocus = "https" + basiclocus.slice(4);
}

var homevars = { secure: securelocus, basic: basiclocus };
		
		
if ( g_squeeze == 0 ) {
	document.writeln('<LINK REL="stylesheet" TYPE="text/css" HREF="../stylesheet.css" TITLE="Style">');
} else if ( g_squeeze == 1 ) {
	document.writeln('<LINK REL="stylesheet" TYPE="text/css" HREF="../stylesheet700.css" TITLE="Style">');
} else {
	document.writeln('<LINK REL="stylesheet" TYPE="text/css" HREF="../stylesheet600.css" TITLE="Style">');
}
</script>
<!--  ========================================== --->

<script language="javascript" type="text/javascript" >

	
	///////////////////////////////////////////////////////////////////////
	
	var form_val_nu_symbolname = "";
	var form_val_nu_firstname = "";
	var form_val_nu_lastname = "";
	var form_val_nu_postal = "";
	var form_val_nu_city = "";
	var form_val_nu_state = "";
	var form_val_nu_country = "";
	var form_val_nu_zcode = "";
	var form_val_nu_phone_country_code = "";
	var form_val_nu_phone_area_code = "";
	var form_val_nu_phone_primary = "";
	var form_val_nu_phone_secondary = "";
	var form_val_nu_email = "";
	
	///////////////////////////////////////////////////////////////////////
	
	function checkform(sname) {
		return(true);
	}

	function hidepanels() {
		$hide("SymbolNameEntry");
		$hide("IdNameEntry");
		$hide("AddressEntry");
		$hide("PhoneEntry");
		$hide("EmailEntry");
		$hide("Completion");
	}
	
	function initialPanel() {
		hidepanels();
		$show("SymbolNameEntry");
		$("nu_symbolname").focus();
	}
	
	function savesymbolcheck(fieldname) {
		var sname = $(fieldname).value;
		if ( sname.length == 0 ) {
			alert("Please type a symbol name into this field");
			return(false);
		}
		if ( checkform(sname) ) {
			return(true);
		}
	}
	
	function savesymbol() {
		if ( savesymbolcheck("nu_symbolname") ) {
			//
			form_val_nu_symbolname = $("nu_symbolname").value;
			$hide("SymbolNameEntry");
			$show("IdNameEntry");
			//
			$("IdNameEntry").style.top = $("SymbolNameEntry").offsetTop + "px";
			$("IdNameEntry").style.left = $("SymbolNameEntry").offsetLeft + "px";
			$("nu_firstname").focus();
			upindex();
		} else resetindex();
	}
	

	function savenames() {
		if ( savesymbolcheck("nu_firstname") && savesymbolcheck("nu_lastname") ) {
			//
			form_val_nu_firstname = $("nu_firstname").value;
			form_val_nu_lastname = $("nu_lastname").value;
			$hide("IdNameEntry");
			$show("AddressEntry");
			//
			$("AddressEntry").style.top = $("SymbolNameEntry").offsetTop + "px";
			$("AddressEntry").style.left = $("SymbolNameEntry").offsetLeft + "px";
			$("nu_postal").focus();
			upindex();
		} else resetindex();
	}
	
	function saveaddress() {
		if ( savesymbolcheck("nu_country") ) {
			//
			form_val_nu_postal = $("nu_postal").value;
			form_val_nu_city = $("nu_city").value;
			form_val_nu_state = $("nu_state").value;
			form_val_nu_country = $("nu_country").value;
			form_val_nu_zcode = $("nu_zcode").value;

			$hide("AddressEntry");
			$show("PhoneEntry");
			//
			$("PhoneEntry").style.top = $("SymbolNameEntry").offsetTop + "px";
			$("PhoneEntry").style.left = $("SymbolNameEntry").offsetLeft + "px";
			$("nu_phone_country_code").focus();
			upindex();
		} else resetindex();
	}

	function savephone() {
		//
		form_val_nu_phone_country_code = $("nu_phone_country_code").value;
		form_val_nu_phone_area_code = $("nu_phone_area_code").value;
		form_val_nu_phone_primary = $("nu_phone_primary").value;
		form_val_nu_phone_secondary = $("nu_phone_secondary").value;

		$hide("PhoneEntry");
		$show("EmailEntry");
		//
		$("EmailEntry").style.top = $("SymbolNameEntry").offsetTop + "px";
		$("EmailEntry").style.left = $("SymbolNameEntry").offsetLeft + "px";
		$("nu_email").focus();
		upindex();
	}

	function saveemail() {
		if ( savesymbolcheck("nu_email") ) {
			//
			form_val_nu_email = $("nu_email").value;

			$hide("EmailEntry");
			//
			$("Completion").style.top = $("SymbolNameEntry").offsetTop + "px";
			$("Completion").style.left = $("SymbolNameEntry").offsetLeft + "px";
			
			
			document.userdata.nu_symbolname.value = form_val_nu_symbolname;
			document.userdata.nu_firstname.value = form_val_nu_firstname;
			document.userdata.nu_lastname.value = form_val_nu_lastname;
			document.userdata.nu_postal.value = form_val_nu_postal;
			document.userdata.nu_city.value = form_val_nu_city;
			document.userdata.nu_state.value = form_val_nu_state;
			document.userdata.nu_country.value = form_val_nu_country;
			document.userdata.nu_zcode.value = form_val_nu_zcode;
			document.userdata.nu_phone_country_code.value = form_val_nu_phone_country_code;
			document.userdata.nu_phone_area_code.value = form_val_nu_phone_area_code;
			document.userdata.nu_phone_primary.value = form_val_nu_phone_primary;
			document.userdata.nu_phone_secondary.value = form_val_nu_phone_secondary;
			document.userdata.nu_email.value = form_val_nu_email;
/*			
*/
			$show("Completion");

			upindex();
		} else resetindex();
	}





var panellist = ["savesymbol", "savenames", "saveaddress", "savephone", "saveemail", "userdata"];
var panelindex = 0;
var panelcount = 5;
var panelcurrent = 0;
var fromarrow = false;

function nextpanel() {
	fromarrow = true;
	if( panelindex < panelcount ) {
		$(panellist[panelindex]).submit();
		panelcurrent = panelindex;
		panelindex++;
	}
}
 
function prevpanel() {
	fromarrow = true;
	panelcurrent = panelindex;
	panelindex -= 2;
	if( ( panelindex > 0 ) || (panelcurrent == 2) ) {
		hidepanels();
		nextpanel();
	} else {
		panelindex = 0;
		initialPanel();
	}
}

function resetindex() {
	panelindex = panelcurrent;
	fromarrow = false;
}


function upindex() {
	if ( !(fromarrow) ) panelindex++;
	fromarrow = false;
}


</script>
<body>
		<!-- Biz Stuff  -->
		<table border="0" cellspacing="0" width="100%" ID="Table1">
			<tbody>
				<tr>
					<td bgcolor="darkgreen" height="1" width="100%">
					</td>
				</tr>
			</tbody></table>
		<table border="0" cellspacing="0" width="100%" ID="Table2">
			<tbody>
				<tr>
					<td bgcolor="#fcf8d5" height="1" width="100%">
					</td>
				</tr>
			</tbody></table>
		<br>
		<blockquote style="background-color: rgb(254,244,254) ">
		 <span style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18px">
				Please, sign up as a new member of </span>&nbsp;&nbsp;&nbsp; 
				<span style="font-family:Tahoma;color: rgb(20, 50, 100); text-decoration: none; text-transform: capitalize;font-weight: bold; font-size : 24px">
				<?php echo $SERVICE?>.
				 </span>
				</blockquote>
		<!-- Biz Stuff  -->
		<br>
		<!-- Biz Stuff  -->
		<table border="0" cellspacing="0" width="100%" ID="Table3">
			<tbody>
				<tr>
					<td bgcolor="darkgreen" height="1" width="100%">
					</td>
				</tr>
			</tbody></table>
		<table border="0" cellspacing="0" width="100%" ID="Table4">
			<tbody>
				<tr>
					<td bgcolor="#fcf8d5" height="1" width="100%">
					</td>
				</tr>
			</tbody>
		</table>
		<blockquote style="background-color: rgb(249,249,220);padding:3px;border:solid 1px orange; ">
				Please enter the information in the fields below so that the service, <?php echo $SERVICE?>, can create a 
				user account for you.&nbsp;&nbsp;&nbsp; (Note that some fields are *required.)
				<br>
				Signing up will give you access to certain features, which may be what brought you to this page
				or may be extra bennefits.
		</blockquote>
		<!-- Biz Stuff  -->
		<table border="0" cellspacing="0" width="100%" ID="Table5">
			<tbody>
				<tr>
					<td bgcolor="darkgreen" height="1" width="100%">
					</td>
				</tr>
			</tbody></table>
		<table border="0" cellspacing="0" width="100%" ID="Table6">
			<tbody>
				<tr>
					<td bgcolor="#fcf8d5" height="1" width="100%">
					</td>
				</tr>
			</tbody></table>
		<br>
<div id ="navigators" align="center">
		<table  border="0" cellspacing="0" width="100%" height="30px" ID="Table5"  style="text-align:center;width:40%;nowrap:true;font-size:1.1em;font-family:arial black;text-weight:bolder;color:darkgreen;border:solid 1px darkgreen;background-color:rgb(249,249,220);">
				<tr>
					<td style="font-weight: bold;text-align:center;" width="50%" onclick="prevpanel()">
						<span style="color:#5555AA;cursor:pointer;" >&lt;&lt;prev</span>
					</td>
					<td style="font-weight: bold;text-align:center;" width="50%" onclick="nextpanel()">
						<span style="color:#5555AA;cursor:pointer;" >next&gt;&gt;</span>
					</td>
				</tr>
		</table>
</div>
		<br>
		<br>
		<div align="center" >
			<div id="SymbolNameEntry"  class="formEntry" >
				<form id="savesymbol" name="usersymbolname" action="javascript:savesymbol();">
					<table align="left" ID="Table10" width="100%">
						<tr>
							<td width="30%" align="right" style="font-weight: bold;">Symbol Name:</td>
							<td width="70%" align="left">
							<input type="text" style="width:60%" size="60" id="nu_symbolname" NAME="nu_symbolname"  onselect="saveCaret(this)" 
										onclick="saveCaret(this)" onkeyup="saveCaret(this)" 
											onkeypress="return changeKey(this, event, fName);" >
							</td>
						</tr>
					</table>
					<br><br>
					In this field, please enter a symbolic name, which may be your name. This will be used to identify you to others.
					In the next step, we will ask you for your identity, which describes you as a unique user in the system.
					<br><br>
					Also, it may be typed in the keyboard that best fits your language.
							<div style="nowrap:true;padding:8px;padding-bottom:6px;font-size:10px;font-family:arial black;cursor:pointer;text-weight:bolder;color:darkgreen;border:solid 2px darkgreen;background-color:#FAFAAA;" onchange="languageChange($('langchoice').value);" >
									<select id="langchoice" name="langchoice">
												<option value="English">English</o3ption>
												<option value="Russian">Russian</option>
											</select>
							</div>

					<br>
				</form>
			</div>

		<!-- Names  -->

			<div id="IdNameEntry"  class="formEntry" >
				<form id="savenames"  name="userdatanames" action="javascript:savenames();" >
					In the next two fields, please use phonetic spelling from the USA keyboard.
					This is the first part of your identity
					<br><br>
					<table align="left" ID="Table11" width="100%">
						<tr>
							<td width="30%" align="right" style="font-weight: bold;">*First Name:</td>
							<td width="70%" align="left"><input style="width:60%" type="text" id="nu_firstname" size="60" NAME="nu_firstname"></td>
						</tr>
						<tr>
							<td width="30%" align="right" style="font-weight: bold;">*Last Name:</td>
							<td width="70%" align="left"><input style="width:60%" type="text" id="nu_lastname" size="60" NAME="nu_lastname"></td>
						</tr>
						<tr>
							<td width="30%" align="right" style="font-weight: bold;">&nbsp;</td>
							<td width="70%" align="left"><input style="width:60%" type="submit" id="Text1" size="60" value="submit names"></td>
						</tr>
					</table>
				</form>
					<br><br>
			</div>
			
		<!-- Address  -->

			<div id="AddressEntry"  class="formEntry" >
				<form id="saveaddress"  name="userdataaddress" action="javascript:saveaddress();" >
					Continuting with your identity, please entery current postal information:
					<br><br>
					<table align="left" ID="Table12" width="100%">
						<tr>
							<td width="30%" align="right">Postal Address:</td>
							<td width="70%" align="left"><input style="width:60%" type="text" id="nu_postal" size="60" NAME="nu_postal"></td>
						</tr>
						<tr>
							<td width="30%" align="right">City:</td>
							<td width="70%" align="left"><input style="width:60%" type="text" id="nu_city" size="60" NAME="nu_city"></td>
						</tr>
						<tr>
							<td width="30%" align="right">State/Provence:</td>
							<td width="70%" align="left"><input style="width:60%" type="text" id="nu_state" size="60" NAME="nu_state"></td>
						</tr>
						<tr>
							<td width="30%" align="right">*Country:</td>
							<td width="70%" align="left"><input style="width:60%" type="text" id="nu_country" size="60" NAME="nu_country"></td>
						</tr>
						<tr>
							<td width="30%" align="right">Zip code/Postal code:</td>
							<td width="70%" align="left"><input style="width:60%" type="text" id="nu_zcode" size="60" NAME="nu_zcode"></td>
						</tr>
						<tr>
							<td width="30%" align="right" style="font-weight: bold;">&nbsp;</td>
							<td width="70%" align="left"><input type="submit" id="Submit2" size="60" value="submit address" NAME="Submit2"></td>
						</tr>
					</table>
				</form>
					<br><br>
			</div>

		<!-- Phone  -->

			<div id="PhoneEntry"  class="formEntry" >
				<form id="savephone"  name="userdataphone" action="javascript:savephone();" ID="Form1">
					While your phone information is not required for your idenity, enterying it may be helpful in future transactions.
					<br><br>
					<table align="left" ID="Table13" width="100%">
							<tr>
							<td width="30%" align="right">Phone:</td>
							<td width="70%" align="left">
								<input type="text" id="nu_phone_country_code" size="2" NAME="nu_phone_country_code"> - 
								<input type="text" id="nu_phone_area_code" size="3" NAME="nu_phone_area_code"> - 
								<input type="text" id="nu_phone_primary" size="6" NAME="nu_phone_primary"> - 
								<input type="text" id="nu_phone_secondary" size="8" NAME="nu_phone_secondary">
							</td>
						</tr>						
						<tr>
							<td width="30%" align="right" style="font-weight: bold;">&nbsp;</td>
							<td width="70%" align="left"><input type="submit" id="Submit3" size="60" value="submit phone" NAME="Submit2"></td>
						</tr>
					</table>
				</form>
					<br><br>
			</div>

		<!-- Email  -->

			<div id="EmailEntry"  class="formEntry" >
				<form id="saveemail"  name="userdataphone" action="javascript:saveemail();" ID="Form2">
					Your e-mail address is a key part of your identity. This e-mail address should be one at which you receive transaction information
					for bills, payment services such as paypal, etc. We will send information about your account to this address.
					<br><br>
					<table align="left" ID="Table14" width="100%">
						<tr>
							<td width="30%" align="right">*e-mail address:</td>
							<td width="70%" align="left"><input style="width:60%" type="text" id="nu_email" size="60" NAME="nu_email"></td>
						</tr>
						<tr>
							<td width="30%" align="right" style="font-weight: bold;">&nbsp;</td>
							<td width="70%" align="left"><input type="submit" id="Submit4" size="60" value="submit email" NAME="Submit2"></td>
						</tr>
					</table>
				</form>
					<br><br>
			</div>


		<!-- Completion  -->

			<div id="Completion" class="formEntry" >
					<form id="userdata"  name="userdata" ID="userdata" action="<?php echo $questionaire_url; ?>" method="POST" >	
					That's all you need to enter to become a user. Thank you for your information.
					If you are satisfied with what you see, go ahead and submit it. But, you may make changes
					in the form below first. <input type="submit" id="Submit1" size="60" value="submit information" NAME="Submit2">
					<br>
					<br>
						<input style="width:60%" type="text" NAME="nu_symbolname" value="none" ID="Hidden1"  size="60" > 
						<br>
						<input style="width:60%" type="text" NAME="nu_firstname" value="none" ID="Hidden2"  size="60" > 
						<br>
						<input style="width:60%" type="text" NAME="nu_lastname" value="none" ID="Hidden3"  size="60" > 
						<br>
						<input style="width:60%" type="text" NAME="nu_postal" value="none" ID="Hidden4"  size="60" > 
						<br>
						<input type="text" style="width:60%"  NAME="nu_city" value="none" ID="Hidden5"  size="60" > 
						<br>
						<input type="text" style="width:60%"  NAME="nu_state" value="none" ID="Hidden6"  size="60" > 
						<br>
						<input type="text" style="width:60%"  NAME="nu_country" value="none" ID="Hidden7"  size="60" > 
						<br>
						<input type="text" style="width:60%"  NAME="nu_zcode" value="none" ID="Hidden8"  size="60" > 
						<br>
						<input type="text" style="width:60%"  NAME="nu_phone_country_code" value="none" ID="Hidden9"  size="60" > 
						<br>
						<input type="text" style="width:60%"  NAME="nu_phone_area_code" value="none" ID="Hidden10"  size="60" > 
						<br>
						<input type="text" style="width:60%"  NAME="nu_phone_primary" value="none" ID="Hidden11"  size="60" > 
						<br>
						<input type="text" style="width:60%"  NAME="nu_phone_secondary" value="none" ID="Hidden12"  size="60" > 
						<br>
						<input type="text" style="width:60%"  NAME="nu_email" value="none" ID="Hidden13"  size="60" > 
						<br>
						<input type="hidden"  NAME="SERVICE" value="<?php echo $SERVICE; ?>"  > 
						<input type="hidden"  NAME="servicedir" value="<?php echo $servicedir; ?>"  > 
						<input type="hidden"  NAME="serviceid" value="<?php echo $serviceid; ?>"  > 
						<input type="hidden"  NAME="hasQuestionaire" value="<?php echo $hasQuestionaire; ?>"  > 

					</form>
			</div>

		</div>
		<br><br><br>
<?php
	if ( $hasQuestionaire != 0 ) {
?>
		<blockquote style="background-color: rgb(253,253,200) ">
			<p align="justify">
				<u>For this service, <span style="font-weight:bold;"><?php echo $SERVICE; ?></span> there will be an opportunity to upgrade your basic count to another account type.</u>
				<div style="border:1px dotted darkgreen;padding:4px;" >
				After signing up for a basic account, you will presented with a list of account types you may access. Some of
				these account types require approval, and others may require a fee, and then some may require a fee after an approval.
				These requirements depend on the account type selected and the policy set by the service <?php echo $SERVICE; ?>.
				Copious Systems the software to manage the account selection process. In the event that you are required to pay or receive
				approval for an account type, you first be prompted to allow the system to continue. The pages will end their session with you.
				Later, when you log back into the service, you will be notified about the stage of processing of your account. 
				When the transaction for attaining the account type is complete, you will be able to access the information and tools for
				that type of account upon logging in.
				</div>
			</p>
		</blockquote>
<?php
	}
?>
<br><br><br><br><br><br><br><br>
		<br>
		<!-- Biz Stuff  -->
		<table border="0" cellspacing="0" width="100%" ID="Table8">
			<tbody>
				<tr>

					<td bgcolor="darkgreen" height="1" width="100%">
					</td>
				</tr>
			</tbody></table>
		<table border="0" cellspacing="0" width="100%" ID="Table9">
			<tbody>
				<tr>
					<td bgcolor="#fcf8d5" height="1" width="100%">
					</td>
				</tr>
			</tbody></table>
		<span style="font-size:10px">Copious Systems &copy; 2006-2008</span>

		

	</body>
</html>
<script language="javascript" type="text/javascript" src="/hosted/js/cvt/cvtinterfaceinit.js"></script>
<script language="JavaScript">
	////
	function check_required_fields() {
		//////
	//
		if ( document.userdata.nu_firstname.value == "" ) {
			alert("Please enter a value for field, First Name.")
			return false
		}
		if ( document.userdata.nu_lastname.value == "" ) {
			alert("Please enter a value for field, Last Name.")
			return false
		}
		if ( document.userdata.nu_country.value == "" ) {
			alert("Please enter a value for field, Country Name.")
			return false
		}
		if ( document.userdata.nu_email.value == "" ) {
			alert("Please enter a value for field, E-mail.")
			return false
		}


		return true;
	}

	function submitScript()
	{
		var first_test = check_required_fields();
		
		first_test = first_test
		
		return first_test
	}
	///
</script>

