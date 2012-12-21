<?php


// inclulded file

/// Fetch the result of classifications made each session.

	$QQ = "SELECT * FROM rolled_oat_classifier ORDER by date DESC";
	$infolist = db_query_object_list($QQ);
	$objlist = array();

/// When the list is loaded (recalled), the sessions are restored in an order of oldest to newest; so that,
/// newer classifcations mask older classification in case of a change. (which should be rare)

	foreach ( $infolist as $classer ) {
		$classifier = urldecode($classer->classifier);
		$classifier = (array)json_decode($classifier);
		$objlist = array_merge($objlist,$classifier);

	}

	$component_obj = (object)($objlist);
	$component_obj = json_encode($component_obj);

?>
set_classified_oat_components(<?php echo $component_obj; ?>);
