<?php

include '../servicename.php';

try {
	include '../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
	exit();
}
/*
*/
global $db_connection;


add_db_connection($dbhost,$dbuser,$dbpass,$secondaryDB);
switch_db_connection($secondaryDB);


switch_db_connection($dbspecific);


$tablenames = file("/srv/www/lighttpd/hosted/boot_db/crittables.txt"); 
////echo str_replace("\n","",implode(",",$tablenames)) . "\n";
$test = db_tables_exist($tablenames);

if ( is_string($test) ) {
	echo "MISSING TABLE $test";
	exit(1);
}


?>
KEEP GOING