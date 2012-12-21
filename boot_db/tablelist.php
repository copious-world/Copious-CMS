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


$secondaryDB_connections = array('copious','drupalcommunities','taxonomy');

foreach( $secondaryDB_connections as $secondaryDB ) {
	if ( $secondaryDB != "copious" ) {
		add_db_connection($dbhost,$dbuser,$dbpass,$secondaryDB);
	}
}

$secondaryDB_connections = array('copious','drupalcommunities','taxonomy');

foreach( $secondaryDB_connections as $secondaryDB ) {
	switch_db_connection($secondaryDB);
	$QQ = "show tables";
echo "DATABASE >> $secondaryDB\n";
echo "=====================================================================DATABASE >> $secondaryDB\n";
	$tables = db_query_list($QQ);
	$tabletxt = implode(",",$tables);
echo $tabletxt;
	foreach ( $tables as $table ) {
		$QQ = "show columns from $table";
		$table_obj_list = db_query_object_list($QQ);

echo "  >>  " . $table . " =========================>  \n";
		foreach( $table_obj_list as $value ) {
var_dump($value);
		}
echo "\n\n";
	}

}


?>

