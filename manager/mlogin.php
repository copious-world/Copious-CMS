<?php

	//////////
	//
	class phrases {
		var $index = 0;
		//
		function front() {
			$i = rand(0,3);
			$str = "";
			//
			switch ( $i ) {
				case 0: { $str = "aplsijktlelw"; break; }
				case 1: { $str = "dfpynetlnnjo"; break; }
				case 2: { $str = "uiaofkbsdfbc"; break; }
				default: { $str = "hfjdkfjhryqj"; break; }
			}
			//
			return($str);
		}
		function back() {
			$i = rand(0,3);
			$str = "";
			//
			switch ( $i ) {
				case 0: { $str = "oiupoiierqws"; break; }
				case 1: { $str = "cnagpqwilemx"; break; }
				case 2: { $str = "yruisbsndmbc"; break; }
				default: { $str = "psoskdfdhfnl"; break; }
			}
			//
			return($str);
		}
	}
	

	////  Just pick out one of several prime numbers used to transform 
	////  blocks of random numbers.
	function pick_prime() {
		$primes = array(13,17,23,29,43,57,71);
		$i = rand(0,6);
		$j = $primes[$i];
		return($j);
	}
	

	// Make a list of 64 indecies in a random permutation.
	
	function make_permutation() {
		//
		$permutation = array(-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,
							 -1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,
							 -1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,
							 -1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1);
		//
		for ( $i = 0; $i < 64; $i++ ) {
			$idx = 0;
			while ( $idx != -1 ) {
				$j = rand(0,64);
				if ( $j == 64 ) $j--;
				$idx = $permutation[$j];
				if ( $idx == -1 ) $permutation[$j] = $i;
			}
		}
		//
		//
		$permstr = "";
		for ( $i = 0; $i < 64; $i++ ) {
			 $j = $permutation[$i];
			 if ( $i > 0 ) {
				$permstr .= ',';
				if ( !($i % 16) ) {
					$permstr .= "\n\t\t\t\t";
				}
			 }
			 $permstr .= $j;
		}
		
		return($permstr);
	}


	//
	session_start();
	if ( session_is_registered('sess_mail_logged_in') ) {
		session_destroy();
	}
	
	if ( session_is_registered('sessPrime') ) {
		$permuter_str = $_SESSION['permuter_str'];
		$sessPrime = $_SESSION['sessPrime'];
		$sessRandom = $_SESSION['sessRandom'];
		//
		$sessPhrase_front = $_SESSION['sessPhrase_front'];
		$sessPhrase_back = $_SESSION['sessPhrase_back'];

	} else {
		session_register('permuter_str');
		session_register('sessPrime');
		session_register('sessRandom');
		session_register('sessPhrase_front');
		session_register('sessPhrase_back');
		
		
		$permuter_str = make_permutation();

		$phrase_parts = new phrases;
		$sessPhrase_front = $phrase_parts->front();
		$sessPhrase_back = $phrase_parts->back();
		//
		//
		$sessPrime = pick_prime();
		$sessRandom = rand(12345,55555);
	}

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>Copious Mail</title>
</head>

<LINK REL="stylesheet" TYPE="text/css" HREF="stylesheet.css" TITLE="Style">

<script language="JavaScript">


var supertext_front = "<?php echo $sessPhrase_front; ?> ";
var supertext_back  = "<?php echo $sessPhrase_back; ?>";
var localprime = <?php echo $sessPrime; ?>;   // generate prime number

//


var permutation = new Array(<?php echo $permuter_str; ?>);

var random_N;
var old_random_N;
//

function textOK(passw)
{
	var alnumReg = new RegExp("[\\w]{" + passw.length + "}");
	return(alnumReg.test(passw));
}


// Not yet an RSA signature...

function login_cipher(enctext,N)
{
	//
	var hidden = ((old_random_N & 0x00FFFFFF) + (random_N & 0x00FFFFFF)) & 0x00FFFFFF;	// variable line
	//	
	var i = 0;	
	var dest = "";
	
	var R = hidden;
	
	while ( i < N ) {
		var c = enctext.charAt(i);
		var cc = enctext.charCodeAt(i);
		var mc = (R & 0xFF);
	
		R = (R >> 8) & 0x00FFFFFF;
		if ( R == 0 ) {
			hidden *= localprime;
			hidden = ( hidden & 0x00FFFFFF );
			R = hidden;
		}
		//
		//
		cc = mc ^ cc;
		
		dest += cc.toString() + '_';
		//
		i++;
		//
	}
	
	
//debug
//loginform.mail_debug.value = report;

	
	return(dest);
}



function sec_permute(etxt,N)
{
	var parry = new Array;
	var ptxt = "";
	var i;
	
	for ( i = 0; i <= N; i++ ) {
		parry[i] = ' ';
	}
	
	for ( i = 0; i < N; i++ ) {
		var j = permutation[i];
		var cc = etxt.charAt(i);
		parry[j] = cc;
	}
	//
	for ( i = 0; i <= N; i++ ) {
		ptxt += parry[i];
	}
	//
	return(ptxt);
}

function secure_ascii_embed(passw)
{
    var enctext = "";

    enctext = supertext_front + passw + supertext_back;
    
    var n = enctext.length;
    var diff = 64 - n;
    for ( var i = 0; i < diff; i++ ) {		// padd the text with some character...
		enctext += '*';
    }
    //
    random_N = Math.floor(Math.random()*1000000000);
    loginform.mail_random.value = random_N;
    //
    enctext = sec_permute(enctext,64);
    enctext = login_cipher(enctext,64);

    return(enctext);
}


//





//
//


</script>
<body>
	<table border="0" cellspacing="0" cellpadding="0" width="100%" ID="Table6">
		<tbody>
			<tr>
				<td bgcolor="darkgreen" height="1" width="100%">
				</td>
			</tr>
		</tbody></table>
	<table border="0" cellspacing="0" cellpadding="0" width="100%" ID="Table7">
		<tbody>
			<tr>
				<td bgcolor="darkgreen" height="1" width="100%">
				</td>
			</tr>
		</tbody></table>
	<div style="background-color:#fcfcc5;">
		<table border="0" cellspacing="0" width="100%" ID="Table4">
			<tbody>
				<tr>
					<td align="left" height="24" nowrap="nowrap" valign="middle" width="30%">
						<img src="../../img/widelogo.jpg"><img src="../../img/intro.png" height="90">
					</td>
					<td align="right" height="24" nowrap="nowrap" valign="middle" width="30%">
						<font style="color: rgb(0, 0, 102); text-decoration: none; font-weight: bold;" face="Arial" size="-1">
							Please use your assigned user name and password to login Copious Mail. </font>
					</td>
					<td align="center" height="24" nowrap="nowrap" valign="middle" width="40%">
						&nbsp;
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- Biz Stuff  -->
	<div style="background-color:rgb(243,243,223)">
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr>
					<td bgcolor="darkgreen" height="1" width="100%">
					</td>
				</tr>
			</tbody></table>
		<table border="0" cellspacing="0" cellpadding="0" width="100%">
			<tbody>
				<tr>
					<td bgcolor="darkgreen" height="1" width="100%">
					</td>
				</tr>
			</tbody></table>
		<br>
		<form name="loginform" action="mcommandcenter.php">

<input type="hidden" name="mail_random" value="<?php echo $sessRandom; ?>">
<input type="hidden" name="mail_debug" value="*">

			<table border="0" cellspacing="0" width="100%">
				<tbody>
					<tr>
						<td align="right" height="24" nowrap="nowrap" valign="middle" width="33%">
							<span style="color: rgb(0, 0, 102); text-decoration: none;font-family:Arial;font-size:16;font-weight:bold">
	User Name:&nbsp&nbsp;
	</span>
						</td>
						<td align="center" style="background-color:rgb(236,236,223)" height="24" nowrap="nowrap" valign="middle" width="33%">
							<input name="mail_uname" size="45">
						</td>
						<td align="right" height="24" nowrap="nowrap" valign="middle" width="33%">
							<span style="color: rgb(0, 0, 102); text-decoration: none;font-family:Arial;font-size:16;font-weight:bold">
	&nbsp;
	</span>
						</td>
					</tr>
					<tr>
						<td align="right" height="24" nowrap="nowrap" valign="middle" width="33%">
							<span style="color: rgb(0, 0, 102); text-decoration: none;font-family:Arial;font-size:16;font-weight:bold">
	Password:&nbsp&nbsp;
	</span>
						</td>
						<td align="center" style="background-color:rgb(225,225,213)" height="24" nowrap="nowrap" valign="middle" width="33%">
							<input type="hidden" name="mail_password"> <input type="password" name="mail_password_input" size="45"> <!-- Field # 6 phone -->
						</td>
						<td align="right" height="24" nowrap="nowrap" valign="middle" width="33%">
							<font style="color: rgb(0, 0, 102); text-decoration: none;" face="Arial" size="-1">&nbsp;
							</font>
						</td>
					</tr>
					<tr>
						<td align="center" style="background-color:#fcfcA5;" height="24" nowrap="nowrap" valign="middle" width="33%">
							<input name="mail_reset" size="30" value="Reset" type="reset">
						</td>
						<td align="left" height="24" nowrap="nowrap" valign="middle" width="33%">
							&nbsp;
						</td>
						<td align="left" style="background-color:#fAfAC5;" height="24" nowrap="nowrap" valign="middle" width="33%">
							&nbsp;&nbsp;&nbsp;&nbsp;<input name="mail_SUBMIT" value="login" type="submit" width="30" onClick="return hidepassword();">
						</td>
					</tr>
				</tbody>
			</table>
			<!-- Biz Stuff  -->
			<table border="0" cellspacing="0" width="100%">
				<tbody>
					<tr>
						<td bgcolor="darkgreen" height="1" width="100%">
						</td>
					</tr>
				</tbody></table>
			<table border="0" cellspacing="0" width="100%">
				<tbody>
					<tr>
						<td bgcolor="#fcf8d5" height="1" width="100%">
						</td>
					</tr>
				</tbody></table>
	</div>
	<font size="1">Copious Systems © 2005</font><br>


<script language="JavaScript">
//
function hidepassword()
{
    var passw = document.loginform.mail_password_input.value;
    var result = true;
    //
    //
    if ( ( passw.length > 16 ) || ( passw.length < 6 ) ) {
		alert("The password should be from 6 to 16 characters in length.");
		result = false;
		document.loginform.mail_password_input.value = "";
    } else {
		if ( textOK(passw) ) {
			document.loginform.mail_password.value = secure_ascii_embed(passw);
		} else {
			alert("The password characters must be letters or numbers.");
			document.loginform.mail_password_input.value = "";
			result = false;
		}
    }
    
    return(result);
}
//
old_random_N = loginform.mail_random.value;  // Make sure to save what was sent.
//
//
</script>
</body>
</html>