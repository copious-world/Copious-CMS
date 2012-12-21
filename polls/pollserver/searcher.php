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

	function fetch_section($section,$startnumber) {
		global $db_connection;
		//
		$content = true;
		$sectkey = fixtext($section);
		//
		
		$todaytext = datetime();
		
		///
		// Search key starts the string identifying the category...
		///
		
		$section_q = "select count(*) from classified_reports where ( LOCATE('$sectkey',product_type) = 1 ) ";
		$section_q .= " AND ( processed = '1' ) ";
		$section_q .= " AND ( deletion_date >= '$todaytext' )";
		//
		$q_result = @mysqli_query($db_connection,$section_q) or die (mysqli_error($db_connection));  // 
		////
		$row = @mysqli_fetch_row($q_result);
		//
		$counter = $row[0];
		
		////		////		////		////
		
		if ( $counter <= 0 ) {
			$content = '<span style="background-color:#FFEEBB;color:darkred;font-family:arial;font-weight:bold;font-size:18;">';
			$content .= "There are no ads in the section,";
			$content .= '<span style="color:navy;font-family:arial;font-weight:bolder;font-size:20;">';
			$content .= " $sectkey</span>";
			$content .= ", at this time: $todaytext.<br>";
			$content .= "However, if you would like to place one, then click the button, <b><u>'post to this category'.</u></b>";
			$content .= "</span>";
		} else {
			$start = $startnumber;
			if ( $start > $counter ) {
				$content = "You have reached the end of the listings..<br>Please continue with the previous button or a class selection.<br><br>Thank you.";
			} else {
				if ( ( $start + 100 ) > $counter ) {
					$display_number = $counter - $start;
				} else {
					$display_number = 100;
				}
				//
				////
				// select short rows from the table...
				//
				$classy_q = "select lister_html_row from classified_reports where ( LOCATE('$sectkey',product_type) = 1 )";
				$classy_q .= " AND ( processed = '1' )";
				$classy_q .= " AND ( priviledge_level >= '0' )";
				$classy_q .= " AND ( deletion_date >= '$todaytext' )";				
				$classy_q .= " ORDER BY priority, entrydate";
				//
				$classy_q .= " LIMIT $start, $display_number";
				//
				////
				$q_result = @mysqli_query($db_connection,$classy_q) or die (mysqli_error($db_connection));  // 
				////	
				$htmlrow = "";		
				while ( $row = @mysqli_fetch_array($q_result) ) {
													// Each row has an href to javascript:display_details(<myid#>);
					$tr_text = $row['lister_html_row'];
					$tr_text = urldecode($tr_text);
					//
					$htmlrow .= $tr_text . "\n";
					//
				}
			}
			$content = $htmlrow;
		}
		
		return $content;
	}


	////////////////////////////////////////////////////////////
	
	$sectionID = $_GET['sectionNum'];
	$startNum = $_GET['startNumber'];
		
	error_reporting(E_ALL);
	//	$sectionText = $sectionID;

	if ( strchr($sectionID,",") ) {
		$sectionlist = explode(",",$sectionID);
		$sectionText = "";
		$n = count($sectionlist);
		for ( $i = 0; $i < $n; $i++ ) {
			$sectionID  = $sectionlist[$i];
			$sectionText .= fetch_section($sectionID,$startNum);
		}
	} else {
		$sectionText = fetch_section($sectionID,$startNum);
	}

?>

<table border="0" cellspacing="0" cellpadding="0" width="100%" ID="Table1">
<tbody>
<?php echo $sectionText; ?>
</tbody>
</table>
