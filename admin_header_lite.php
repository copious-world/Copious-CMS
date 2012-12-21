<?php

$browser = 1;
if ( isset($_GET['browser']) ) {
	$browser = $_GET['browser'];
}

$servicedir = "copious";
if ( isset($_POST['servicedir']) ) {
	$servicedir = $_POST['servicedir'];
} else if ( isset($_GET['servicedir']) ) {
	$servicedir = $_GET['servicedir'];
}


require_once "servicename.php";
if ( !isset($no_database) ) {
	try {
		include 'database.php';
	} catch (Exception $e) {
		echo 'Caught exception: ' .  $e->getMessage();
	}
}

?>
