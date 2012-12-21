<?php


global $installed_dir;
global $MYUNPUBLISHEDSECRET;
global $hostdirstructure;
global $g_installed_servicename;
global $g_installed_db_host;
global $g_installed_db_user;
global $g_installed_db_pass;

global $SERVICE;
global $webhost;
global $serverdir;
global $dbhost;
global $dbuser;
global $dbpass;
global $dbspecific;
global $communitymanager;
global $comp;
global $secondaryDB;
global $db_prefix;


require_once("install/webservicedirectories.inc");

if ( $_SERVER['SCRIPT_FILENAME'] == "$installed_dir/hosted/servicename.php" ) {
	echo "FILE ACCESS FORBIDDEN";
	exit();
}
$SERVICE = $g_installed_servicename;		/// This may be derived from a mapping table.
$webhost = $webservicedirectories_server;   /// This service determined by a forumula set at install time.

$serverdir = '.';
$dbhost = $g_installed_db_host;
$dbuser = $g_installed_db_user;
$dbpass = $g_installed_db_pass;

if ( !isset($dbspecific) ) {
	$dbspecific = "copious";
}
$comp = $dbpass;  // may need to eradicate $comp....

?>
