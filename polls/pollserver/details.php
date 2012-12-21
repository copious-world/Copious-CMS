<?php


include "../../admin_header.php";


//
// RETURN PREASSEMBLED ROWS...
//

	function fetch_single_topic($topicID) {
		//
		$content = "empty";
		////
		// select short rows from the table...
		//
		$classy_q = "select HTML from all_content where ( id = '$topicID' )";
		$content = db_query_value($classy_q);
		if ( $content != -1 ) {
			$content = urldecode($content);
		} else {
			$content = "NO DETAILS FOR THIS TOPIC";
		}

		return $content;
	}


	////////////////////////////////////////////////////////////
	
	$detailID = $_GET['topicid'];
		
	error_reporting(E_ALL);

	$sectionText = fetch_single_topic($detailID);
	echo $sectionText;

?>
