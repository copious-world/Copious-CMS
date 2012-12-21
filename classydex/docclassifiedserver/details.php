
<?php

include 'servicename.php';
try {
	include '../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}


//
// RETURN PREASSEMBLED ROWS...
//

	function fetch_single_add($addID) {
		//
		$content = "empty";
		////
		// select short rows from the table...
		//
		$classy_q = "select detailed_html from classified_reports where ( refnumber = '";
		$classy_q .= $addID;
		$classy_q .= "' )";
		////
		$q_result = @mysqli_query($db_connection,$classy_q) or die (mysqli_error($db_connection));  // 
		////	
		if ( $row = @mysqli_fetch_array($q_result) ) {
			$tr_text = $row['detailed_html'];
			$content = urldecode($tr_text);
		}
		
		return $content;
	}


	////////////////////////////////////////////////////////////
	
	$detailID = $_GET['entrynumber'];
		
	error_reporting(E_ALL);

	$sectionText = fetch_single_add($detailID);
	echo $sectionText;

?>
