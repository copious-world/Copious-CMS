<?php

	// This one is called from 

include '../servicename.php';
try {
	include '../../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}


//
// RETURN PREASSEMBLED ROWS...
//

	// create_ad_description
	// returns $addurl
	//
	function delete_ad_description_ref($ID) {
		global $db_connection;
		//
		
		////
		$section_maker = "delete from classified_reports ";
		$section_maker .= "where refnumber = '$ID' ";
		
		$q_result = @mysqli_query($section_maker) or die (mysqli_error($db_connection));  //
	}
	
	////////////////////////////////////////////////////////////
	
	$refnumber = $_GET['refnum'];

	error_reporting(E_ALL);
	delete_ad_description_ref($refnumber);
	
	$reportText = "Ad deleted.";
	
	echo "$reportText";

?>
