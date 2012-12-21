<?php
	include "../admin_header.php";


	$term = $_GET['term'];
	$content_type = $_GET['content_type'];
	$droptarget = $_GET['droptarget'];
	$roatname = $_GET['roatname'];
	$fieldname = $_GET['fieldname'];

$QQ = "SELECT substitutions, parameters FROM rolled_oats_content_fields WHERE ( content_type = '$content_type' ) AND ( classifier = '$term' ) AND  ( fieldname = '$fieldname' ) AND ( rolled_oat_name = '$roatname' ) AND ( droptarget = '$droptarget' )";
$datum = db_query_object($QQ);

if ( $datum == null ) {
	$QQ = "SELECT data_source_parameters, substitution_vars FROM rolled_oats WHERE name = '$roatname'";
	$roat = db_query_object($QQ);

	if ( $roat == null ) {
		if ( !isset($_GET['nojs']) ) {
?>
		alert("No details templates for <?php echo $roatname; ?>");
<?php
		} else {
			echo $roat->substitution_vars . " !!! " .  $roat->data_source_parameters;
		}
		exit;
	}

	if ( ( strlen(trim($roat->substitution_vars)) == 0 ) && (  strlen(trim($roat->substitution_vars)) == 0 ) ) {
		if ( !isset($_GET['nojs']) ) {
?>
		alert("No details templates for <?php echo $roatname; ?>");
<?php
		} else {
			echo $roat->substitution_vars . " !!! " .  $roat->data_source_parameters;
		}
		exit;
	}

	$datum = array ( "substitutions" => $roat->substitution_vars, "parameters" => $roat->data_source_parameters );
	$datum = (object)($datum);
}

if ( !isset($_GET['nojs']) ) {
$js_datum = json_encode($datum);
?>
detail_editor_callback("<?php echo $droptarget; ?>",<?php echo $js_datum; ?>);

<?php

} else {
	echo $datum->substitutions . " !!! " . $datum->parameters;
}

?>