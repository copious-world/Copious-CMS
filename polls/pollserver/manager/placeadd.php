<?php

include '../servicename.php';
try {
	include '../../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}

	$add_title = "";
	$brief_description = "";
	$offered_price = "";
	$email_address = "";
	$contact_number = "";
	$full_description = "";
	$shipping_origination = "";

	function add_advert_request($section_number) {
		global $db_connection;
		//	
		global $add_title;
		global $brief_description;
		global $offered_price;
		global $email_address;
		global $contact_number;
		global $full_description;
		global $shipping_origination;

		$add_title = fixtext($add_title);
		$brief_description = fixtext($brief_description);
		$offered_price = fixtext($offered_price);
		$email_address = $email_address;
		$contact_number = fixtext($contact_number);
		$full_description = urlencode($full_description);
		$shipping_origination = fixtext($shipping_origination);
		$nowtime = datetime();

		//
		$section_maker = "insert into classified_request ";
		$section_maker .= "(ID,processed,section_number,add_title,brief_description,offered_price,email_address,agent_email_address,contact_number,full_description,shipping_origination,nowtime)";
		$section_maker .= " VALUES (0,0,'";
		$section_maker .= $section_number . "','";
		$section_maker .= $add_title . "','";
		$section_maker .= $brief_description . "','";
		$section_maker .= $offered_price . "','";
		$section_maker .= $email_address . "','";
		$section_maker .= $email_address . "','";	// NOTE: In regular ad placement the agent email and the controller email are the same.
		$section_maker .= $contact_number . "','";
		$section_maker .= $full_description . "','";
		$section_maker .= $shipping_origination . "','";
		$section_maker .= $nowtime . "')";

		$q_result = @mysqli_query($section_maker) or die (mysqli_error($db_connection));  // 
	}


	////////////////////////////////////////////////////////////
	
	$section_number = $_GET['section'];
	$add_title = $_GET['add_title'];
	$brief_description = $_GET['brief_description']; // Second line.
	$offered_price = $_GET['offered_price']; // End first line
	$email_address = $_GET['email_address']; // User Identification
	$contact_number = $_GET['contact_number'];
	$full_description = $_GET['full_description'];
	$shipping_origination = $_GET['shipping_origination'];
	
	error_reporting(E_ALL);

	add_advert_request($section_number);
	
	
	$sectionText = "Thank you for submitting your ad.";
	echo $sectionText;

?>
