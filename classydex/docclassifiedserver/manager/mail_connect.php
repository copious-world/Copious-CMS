<?php

//// Classified ads mail wrapper...

function post_back_to_mailservers($req) {
	////
	$fp = fsockopen ('www.copious-systems.com', 80, $errno, $errstr, 30);

	if ( !$fp ) {	
			//// drupal_set_message($errno . "  " . $errstr);
		// write to error log...
		return(null);
	}
	$header = "";
	//
	// post back to PayPal system to validate
	$header .= "POST /php/mailhandler.php HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

	fputs($fp, $header . $req);
	return($fp);
}



function classifieds_mail_wrapper($mailkey, $to, $subject, $body, $from, $headers) {

	/////
	$req = "";

	$to = urlencode(stripslashes($to));
	$req .= "&to=$to";

	
	$subject = urlencode(stripslashes($subject));
	$req .= "&subject=$subject";
	
	$body = urlencode(stripslashes( str_replace("\r", '', $body) ));
	$req .= "&body=$body";

	$from = urlencode(stripslashes($from));
	$req .= "&from=$from";

    $mimeheaders = array();
    foreach ($headers as $name => $value) {
      $mimeheaders[] = $name .': '. $value;
    }
	$hrdr = join("\n", $mimeheaders);

	$headers = urlencode(stripslashes($hrdr));
	$req .= "&headers=$headers";

	/////

	if ( ($fp = post_back_to_mailservers($req)) != null ) {
		while ( !feof($fp) ) {
			$res = fgets ($fp, 1024);
			////drupal_set_message($res);
		}
		fclose ($fp);
	}

	/////

}




?>




