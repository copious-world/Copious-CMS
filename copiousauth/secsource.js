//
///
//
///

var g_random_N;
var g_passCovered = "";

var g_supertext_front = "";
var g_supertext_back  = "";
//
var g_permutation = null;

var g_old_random_N = "";
var g_localprime = 0;   // generate prime number


////
// Not yet an RSA signature...

function login_cipher(enctext,N)
{
	//
	var hidden = ((g_old_random_N & 0x00FFFFFF) + (g_random_N & 0x00FFFFFF)) & 0x00FFFFFF;	// variable line
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
			hidden *= g_localprime;
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
		var j = g_permutation[i];
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

    enctext = g_supertext_front + passw + g_supertext_back;
    
    var n = enctext.length;
    var diff = 64 - n;
    for ( var i = 0; i < diff; i++ ) {		// padd the text with some character...
		enctext += '*';
    }
    //
    g_random_N = Math.floor(Math.random()*1000000000);
    //
    
    enctext = sec_permute(enctext,64);
    enctext = login_cipher(enctext,64);

    return(enctext);
}


var g_sec_lang = 1;

function textOK(passw)
{
	var rslt = false;
	if (  g_sec_lang == 1 ) {
		var alnumReg = new RegExp("[\\w|\\d]{" + passw.length + "}");
		rslt = alnumReg.test(passw);
	} else {
		var n = passw.length;
		var asciipart = "";
		for ( var i = 0; i < n; i++ ) {
			var c = passw.charCodeAt(i);
			if ( ( c & 0x00FF ) == c ) {
				asciipart += passw.charAt(i);
			}
		}
		if ( asciipart.length > 0 ) {
			var alnumReg = new RegExp("[\\w|\\d]{" + asciipart.length + "}");
			rslt = alnumReg.test(asciipart);
		} else rslt = true;
	}
	
	return( rslt );
}


var g_sec_userid = 0;
var g_sec_sessionid = 0;

function set_user_id(uid) {
	g_sec_userid = uid;
}

function set_session_id(sid) {
	g_sec_sessionid = sid;
}

