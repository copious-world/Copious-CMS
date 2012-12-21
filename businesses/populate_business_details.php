<?php

	$qq = "SELECT count(*) FROM serivcesource WHERE ( servicename = '$bus_appdir' )";
	$n = db_query_value($qq);

	if ( $n <= 0 ) exit();

	$qq = "SELECT * FROM serivcesource WHERE ( servicename = '$bus_appdir' )";
	$bus = db_query_object($qq);

	$bus->hasQuestionaire = $bus->hasQuestionaire ? "true" : "false";
	$bus->needs_form = $bus->needs_form ? "true" : "false";
	$bus->needs_approval = $bus->needs_approval ? "true" : "false";
	$bus->needs_pay = $bus->needs_pay ? "true" : "false";

	$bus->url = str_replace("+"," ",$bus->url);
	$bus->questionaire_url = str_replace("+"," ",$bus->questionaire_url);

?>
<script language="javascript" >
$('edit_business-url').value = "<?php echo $bus->serviceurl; ?>";
$('edit_business-questionaire_url').value = "<?php echo $bus->questionaire_url; ?>";
$('edit_business-hasQuestionaire').checked = (<?php echo $bus->hasQuestionaire; ?>);
$('edit_business-needs_form').checked = (<?php echo $bus->needs_form; ?>);
$('edit_business-needs_approval').checked = (<?php echo $bus->needs_approval; ?>);
$('edit_business-needs_pay').checked = (<?php echo $bus->needs_pay; ?>);
// $('edit_business-price').value = "<?php echo $bus->price; ?>";
</script>
