<?php

	////
	//
	require_once("login.php");
	//
	////
	
	$username = $_GET['username'];
	$br = $_GET['browser'];
	
	if ( !strcmp($br,"IE") ) {
		$username = urldecode($username);
	}

	$encodeduname = urlencode($username);

//
//
?>



g_supertext_front = "<?php echo $sessPhrase_front; ?> ";
g_supertext_back  = "<?php echo $sessPhrase_back; ?>";
//
g_permutation = new Array(<?php echo $permuter_str; ?>);

g_old_random_N = "<?php echo $sessRandom; ?>";
g_localprime = <?php echo $sessPrime; ?>;   // generate prime number
//

var g_localperm = "<?php echo $permuter_str ?>";
var g_localuser = "<?php echo $encodeduname; ?>";

function doPassLoginAuth() {
	//
	//
	passw = $("PN_password").value;
	//
	if ( textOK(passw) ) {
		//
		//
		spanID = "signedInDone";
		//
		g_passCovered = secure_ascii_embed(passw);
		//
		var urlNparameters = "copiousauth/verify.php";
		urlNparameters += "?mail_password=" + g_passCovered;
		//
		urlNparameters += "&username=" + g_localuser;;
		urlNparameters += "&permuter_str=" + g_localperm;
		urlNparameters += "&spf=" + g_supertext_front.length;
		urlNparameters += "&arandom=" + g_random_N;
		urlNparameters += "&grandom=" + g_old_random_N;
		urlNparameters += "&prime=" + g_localprime;
		urlNparameters += "&spb=" + g_supertext_back.length;

		makeDocEvalRequest(urlNparameters);
	}
	//
}

passwordAuth = doPassLoginAuth;
