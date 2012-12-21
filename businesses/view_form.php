<?php


include '../servicename.php';

try {
	include '../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
/*
*/
global $db_connection;



	$QQ = "SELECT published_accounts FROM serivcesource";

	if ( isset($_GET['servicename']) ) {
		$sname = $_GET['servicename'];
		$QQ .= " WHERE servicename = '$sname'";

		$form = db_query_value($QQ);
		$form = urldecode($form);
		echo "FORM:<br>";
		echo $form;
	} else {
		$formlist = db_query_list($QQ);

		foreach ( $formlist as $form ) {
			$form = urldecode($form);
			echo $form;
			echo "<br>";
		}
	}


?>