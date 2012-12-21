<?php
	//
	$application = "Copious Mail";

if ( isset($_GET["sess"]) ) {
	$sess = $_GET["sess"];
	$when = $_GET["when"];
}

global $db_connection;
global $g_sname_depth;
$g_sname_depth = '..';
include "../admin_header.php";
include 'emailutils.php';
include("POP3PopulateMessages.php");

	$report = uploadPOP3( $userid, $username );

	echo  $report;

?>
