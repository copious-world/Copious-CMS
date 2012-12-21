<?php


include "../admin_header.php";

$account_type = "SUPER";
if ( isset($_GET['acctype']) ) {
	$account_type = $_GET['acctype'];
}

$serviceid = $_GET['serviceid'];


$QQ = "SELECT * FROM accounttypeknown WHERE name = '$account_type'";
$acctypeK = db_query_object($QQ);

$name = $acctypeK->name;
$description = urldecode($acctypeK->description);
$help = urldecode($acctypeK->help);

$QQ = "SELECT au.needs_form, au.needs_approval, au.needs_pay, au.price  FROM authspecials au INNER JOIN accounttypes at ON ( au.account_type_id = at.id )";
$QQ .= " WHERE ( au.serviceid = '$serviceid' ) AND ( au.UID = '0' ) AND ( at.type_name = '$account_type' )";
$accdetails = db_query_object($QQ);

/*
*/

?>


$('add_accounttype-name').value = "<?php echo $name; ?>";
$('add_accounttype-description').value = "<?php echo $description; ?>";
$('add_accounttype-help').value = "<?php echo $help; ?>";

<?php 
if ( $accdetails != null ) {
	$needs_form = ($accdetails->needs_form == 1) ? "true" : "false";
	$needs_approval = ($accdetails->needs_approval == 1) ? "true" : "false";
	$needs_pay = ($accdetails->needs_pay == 1) ? "true" : "false";
?>
$('add_accounttype-price').value = "<?php echo $accdetails->price; ?>";
$('add_accounttype-needs_form').checked = "<?php echo $accdetails->needs_form ; ?>";
$('add_accounttype-needs_approval').checked = "<?php echo $accdetails->needs_approval; ?>";
$('add_accounttype-needs_pay').checked = "<?php echo $accdetails->needs_pay == 1; ?>";

<?php 
}
?>

