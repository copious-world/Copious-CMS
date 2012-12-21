<?php

$dbspecific = "taxonomy";
include "../admin_header_lite.php";
global $db_connection;


$id = $_GET["taxo"];
if ( isset($_GET["nametaxo"]) ) {
	$name = $_GET["nametaxo"];
}


/*
*/

	if ( isset($name) ) {
		$QQ = "select HTML from vocabulary where name = '$name'";
	} else {
		$QQ = "select HTML from vocabulary where id = '$id'";
	}
	$text = db_query_value($QQ);

	if ( ( strlen($text) == 0 ) || ( $text == -1 ) ) {
$output =<<<LNAME
			<li>/<ul>
			</ul></li>
LNAME;
		echo $output;
	} else {
		$text = urldecode($text);
		echo $text;
	}

?>


