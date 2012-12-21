<?php


/// TAXONOMY MODULE APC BOOT...

include '../servicename.php';
$dbspecific = "taxonomy";

try {
	include '../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}


global $db_connection;


	echo "\nSTORING ALL ROLLED OATS (APC)\n";

	$QQ = "SELECT * FROM rolled_oats";
	$oatlist = db_query_object_list($QQ);

	$all_rolled_oats = array();
	foreach ( $oatlist as $oat ) {
		$name = $oat->name;
		$all_rolled_oats[$name] = $oat;
	}


	apc_store("all_rolled_oats",(object)$all_rolled_oats);



?>