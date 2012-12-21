 <?php

	//
	include "../admin_header.php";

	require_once('../userinfo.php');

	$processible = true;
	if ( !find_user_data($userid) ) {
		$processible = false;
	}

	if ( $processible ) {  // DOC EVAL REQUEST
?>

$("nu_firstname_display").innerHTML = "<?php echo $nu_firstname; ?>";
$("nu_firstname").value = "<?php echo $nu_firstname; ?>";
///
$("nu_lastname_display").innerHTML = "<?php echo $nu_lastname; ?>";
$("nu_lastname").value = "<?php echo $nu_lastname; ?>";
///
$("nu_postal_display").innerHTML = "<?php echo $nu_postal; ?>";
$("nu_postal").value = "<?php echo $nu_postal; ?>";
///
$("nu_city_display").innerHTML = "<?php echo $nu_city; ?>";
$("nu_city").value = "<?php echo $nu_city; ?>";
///
$("nu_country_display").innerHTML = "<?php echo $nu_country; ?>";
$("nu_country").value = "<?php echo $nu_country; ?>";
///
$("nu_zcode_display").innerHTML = "<?php echo $nu_zcode; ?>";
$("nu_zcode").value = "<?php echo $nu_zcode; ?>";
///
$("nu_phone_country_code_display").innerHTML = "<?php echo $nu_phone_country_code; ?>";
$("nu_phone_country_code").value = "<?php echo $nu_phone_country_code; ?>";
///
$("nu_phone_area_code_display").innerHTML = "<?php echo $nu_phone_area_code; ?>";
$("nu_phone_area_code").value = "<?php echo $nu_phone_area_code; ?>";
///
$("nu_phone_primary_display").innerHTML = "<?php echo $nu_phone_primary; ?>";
$("nu_phone_primary").value = "<?php echo $nu_phone_primary; ?>";
///
$("nu_phone_secondary_display").innerHTML = "<?php echo $nu_phone_secondary; ?>";
$("nu_phone_secondary").value = "<?php echo $nu_phone_secondary; ?>";
///
$("nu_email_display").innerHTML = "<?php echo $nu_email; ?>";
$("nu_email").value = "<?php echo $nu_email; ?>";


<?php

	}
?>
