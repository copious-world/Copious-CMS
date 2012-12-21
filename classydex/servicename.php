<?php

	global $installed_dir;

	require_once("../../install/webservicedirectories.inc");

	if ( $_SERVER['SCRIPT_FILENAME'] == "$installed_dir/hosted/classydex/servicename.php" ) {
		echo "FILE ACCESS FORBIDDEN";
		exit();
	}

	$SERVICE = "classydex";
	$hostaddr = "localhost";

	$webhost = 'localhost';
	$serverdir = '.';
	$dbhost = "localhost";
	$dbuser = "leddy";
	$dbpass = 'test2test';
	$dbspecific = "copious";

	$communitymanager = 'allsites';
	$comp = 'simple';
	$secondaryDB = "drupalcommunities";
	$db_prefix = "cmn_";

?>
