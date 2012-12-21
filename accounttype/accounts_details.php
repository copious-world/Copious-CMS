<?php

	$acctype_id = $_GET['id'];
	$qq = "select count(*) from accounttypes where ( id = '$acctype_id' )";
	$n = db_query_value($qq);

	if ( $n <= 0 ) exit();

	$qq = "SELECT * FROM accounttypes ac INNER JOIN authspecials aut ON (ac.id = aut.account_type_id) where ( id = '$acctype_id' )";
	$acc = db_query_object($qq);

	$acc->needs_form = $acc->needs_form ? "true" : "false";
	$acc->needs_approval = $acc->needs_approval ? "true" : "false";
	$acc->needs_pay = $acc->needs_pay ? "true" : "false";

	$acc->description = str_replace("+"," ",$acc->description);
	$acc->form = str_replace("+"," ",$acc->form);
	$acc->help = str_replace("+"," ",$acc->help);


?>

$('add_accounttype-name').value = "<?php echo $acc->type_name; ?>";
$('add_accounttype-description').value = decodeURIComponent("<?php echo $acc->description; ?>");
$('add_accounttype-roles').value = "<?php echo $acc->roles; ?>";
$('add_accounttype-form').value = decodeURIComponent("<?php echo $acc->form; ?>");
$('add_accounttype-help').value = decodeURIComponent("<?php echo $acc->help; ?>");
$('add_accounttype-needs_form').checked = (<?php echo $acc->needs_form; ?>);
$('add_accounttype-needs_approval').checked = (<?php echo $acc->needs_approval; ?>);
$('add_accounttype-needs_pay').checked = (<?php echo $acc->needs_pay; ?>);
$('add_accounttype-price').value = "<?php echo $price; ?>";
