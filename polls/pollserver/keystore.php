<?php


include 'servicename.php';
try {
	include '../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}


	$key = $_GET["appkey"];
	$salt = $_GET["salt"];
	$storesamples = $_GET["samples"];
	$name = $_GET["name"];
	$email = $_GET"[email"];
	$zip = $_GET["zip"];
	$phone = $_GET["phone"];
	$instime = $_GET["instime"];
	
	$QQ = "insert into PURCHASEDKEYS (id,appkey,salt,samples,name,email,zip,phone,instime) VALUES (0,'$key','$salt','$storesamples','$name','$email','$zip','$phone',$nowtime)";
	db_query_exe($QQ);
	
?>
<div style="border: 1px solid orange;">
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="rleddy@svn.net">
<input type="hidden" name="item_name" value="SodokuDots">
<input type="hidden" name="item_number" value="game-2">
<input type="hidden" name="amount" value="8.00">
<input type="hidden" name="shipping" value="0.00">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="http://www.sudokudots.com/keyDataFulfill.php?email=<?php echo $email; ?>&salt=<?php echo $salt; ?>">
<input type="hidden" name="cancel_return" value="http://www.sudokudots.com/">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="bn" value="PP-BuyNowBF">
<input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-but23.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
</div>
