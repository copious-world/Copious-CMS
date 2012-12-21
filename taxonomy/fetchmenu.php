<?php



$dbspecific = "taxonomy";
include "../admin_header_lite.php";

$which_menu = $_GET["menunum"];


if ( $which_menu == 1 ) {

/*
*/
global $db_connection;


	$QQ = "select id, name, description from vocabulary";

if ( isset($_GET['taxosubset']) ) {
	$taxos = $_GET['taxosubset'];
	$clause = " where ( LOCATE('$taxos',name) > 0 )";
	$QQ .= $clause;
}

	$bus_id = $_GET['bus_id'];
	if ( !isset($clause) ) {
		$QQ .= " where ";
	}
	$QQ .= "( serviceid = $bus_id ) OR ( serviceid = 0 )"; // if serviceid = 0 look for subscription unless $bus_id == 1

	$vlist = db_query_object_list($QQ);
	$n = 0;
	$n = count($vlist);

	if ( $n > 0 ) {
		$output = "";
		for ( $i = 0; $i < $n; $i++ ) {
			$vocab = $vlist[$i];
			$id = $vocab->id;

$output .=<<<LNAME
<li class="leaf"><span class="vocab_pick" onclick="pick_vocabulary('$vocab->name','$id')">$vocab->name</span></li>
LNAME;

		}
		echo $output;
	} else {


?>

<li class="leaf">No Vocabularies Specified Yet</li>


<?php
	}

} else {

?>


<?php

}

?>
