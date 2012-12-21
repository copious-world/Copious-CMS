<?php

///accesslimits.php

	include "../admin_header.php";


	$serviceid = $_GET['serviceid'];
	$vid = $_GET['vid'];
	$RW = $_GET['RW'];
	$container = $_GET['container'];
	$accounttype = $_GET['accounttype'];

	$QQ = "SELECT terms FROM accessrules WHERE (serviceid = $serviceid) AND (vid = $vid) AND (RW = '$RW') AND ( accounttype = '$accounttype' ) ";
	$acclist = db_query_value($QQ);
	
	if ( ( $acclist != -1 ) && ( strlen($acclist) > 0 ) ) {
?>
alert("<?php echo $QQ; ?>");
access_limit_tree_selections("<?php echo $container; ?>","<?php echo $acclist; ?>","<?php echo $RW; ?>");

<?php
	} else {
?>

access_limit_tree_selections("<?php echo $container; ?>",null,"<?php echo $RW; ?>");

<?php
	}
?>
