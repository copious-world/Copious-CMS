




<!--  ========================================== --->
<script language="JavaScript" type="text/javascript" src="dimensions.js"> </script>
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
	var alnumReg = new RegExp("[\\w]{" + passw.length + "}");
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
