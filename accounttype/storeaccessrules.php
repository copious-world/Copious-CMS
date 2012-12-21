<?php

	include "../admin_header.php";

	$taxoid = $_POST["taxoid"];
	$serviceid = $_POST["serviceid"];
	$terms = $_POST["terms"];
	$accounttype = $_POST["accounttype"];
	$RW = $_POST["RW"];

	$DD = "DELETE FROM accessrules WHERE (serviceid = $serviceid) AND (vid = $taxoid) AND ( accounttype = '$accounttype' ) AND ( RW = '$RW' )";
	db_query_exe($DD);

	$II = "INSERT INTO accessrules (id,serviceid,vid,RW,accounttype,terms) VALUES (0,$serviceid,$taxoid,'$RW','$accounttype','$terms')";

	db_query_exe($II);
	echo "Account Access rules written";

?>
