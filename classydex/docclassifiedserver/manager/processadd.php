<?php
	
	// PROCESSADD .php
	//
	//	FOR A QUICK PROGRAM $controller_url is a variable operated on by side affects.
	//	This module needs to get no more complicated in this regard.
	//
	//	In fact a system of recipients with roles is needed. But, that's too much for now.
	////

	// This one is called from 

include '../servicename.php';
try {
	include '../../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
include 'mail_connect.php';

	$rightnow = datetime();
	$count_adds = 0;
	
	function input_lister_row() {
		$text = implode(file("lister_row.txt"));
		return($text);
	}


	function input_detail_display() {
		$text = implode(file("detail_display.txt"));
		return($text);
	}


	function input_email_format() {
		$text = implode(file("email_format.txt"));
		return($text);
	}


	function replace_in_txt_form($txt,$value,$key) {
		$copikey = "$" . $key . "$";
		return(str_replace($copikey,$value,$txt));
	}

	//===================================================
	//===================================================
	
	function update_process_time() {
		global $db_connection;
		global $rightnow;
		
		$section_q = "select LASTPROCESSED from classified_params where ( ID = 1 )";
		//
		$q_result = @mysqli_query($section_q) or die (mysqli_error($db_connection));  // 
		//
		$TT = 0;
		if ( $row = @mysqli_fetch_array($q_result) ) {
			//
			$TT = $row[0];
			//
		}

		$section_q = "update classified_params set LASTPROCESSED = '$rightnow' where ( ID = 1 )";
		$q_result = @mysqli_query($section_q) or die (mysqli_error($db_connection));  // 

		return($TT);
	}


	function store_current_content($storedcontent) {
		global $db_connection;
		global $rightnow;
		
		$storedcontent = urlencode($storedcontent);

		$section_q = "insert INTO classified_params (ID,LASTPROCESSED,PROCESSEDINFO) VALUES ( 0, '$rightnow', '$storedcontent' )";
		$q_result = @mysqli_query($section_q) or die (mysqli_error($db_connection));  // 
		
	}


	//
	function notify_user($ID,$addurl,$email_address,$contact_number,$ustatus,$nowtime) {
		if ( $ustatus == 1 ) { // update user
			$email_txt = input_email_format();		
		} else {
			$email_txt = "Copious Classifieds thanks you for placing an ad.\n\n";
			$email_txt .= "Contact e-mail: " . $email_address . "\n";
			$email_txt .= "Contact phone: " . $contact_number . "\n";
			$email_txt .= input_email_format();
		}
		$email_txt = replace_in_txt_form($email_txt,$ID,'ID');
		$email_txt = replace_in_txt_form($email_txt,$addurl,'addurl');
		$email_txt = replace_in_txt_form($email_txt,$email_address,'email_address');
		$email_txt = replace_in_txt_form($email_txt,$contact_number,'contact_number');
		$email_txt = replace_in_txt_form($email_txt,$nowtime,'nowtime');
		$subject = "Copious Classified ad placement notification.";

		$from = 'classifieds@copious-systems.com';
		$headers = array(
			'MIME-Version' => '1.0',
			'Content-Type' => 'text/plain; charset=UTF-8; format=flowed',
			'Content-Transfer-Encoding' => '8Bit',
			'X-Mailer' => 'Drupal'
		);
		if (isset($from)) {
			 $headers['Reply-To'] = $headers['Return-Path'] = $headers['Errors-To'] = $from;
		}
		$headers['Reply-To'] = 'classifiedhelp@copious-systems.com';

		classifieds_mail_wrapper("", $email_address, $subject, $email_txt, $from, $headers);
	}
	
	
	
	$contolleremail = "";
	$controller_url = "";
	$has_controller = false;
	$g_agent_email = "";
	
//
//	secondary_approval_type
///////
// DETERMINE IF THE PRODUCT TYPE IS SPECIAL ENOUGH TO GO STRAIGT TO DISPLAY...
//////

	function secondary_approval_type($product_type) {
		$tst = strncmp($product_type,"1.2",3);
		////
		if ( $tst == 0 ) {
			if ( strcmp($contolleremail,$g_agent_email) == 0 ) {
				return(false);
			}
			return(true);
		}
		
		return(false);
	}
	

	function controller_notifications($adurl_front,$adparms,$product_type) {
		global $contolleremail;
		global $controller_url;
		////
		$urlmiddle = "userapproval.php";			//  THIS IS A DEFAULT JUST IN CASE THE SECTION IS NOT RIGHT.
	
		$tst = strncmp($product_type,"1.2",3);
		if ( $tst == 0 ) {
		
			$controller_url = $adurl_front . "jobs/employerapproval.php" . $adparms;  	//  THIS GOES TO THE CONTROLLER :: GLOBAL $controller_url
			
			$urlmiddle = "jobs/agentediting.php";	//  THIS GOES TO THE AGENT.
		}
	
		return($urlmiddle);
	}

//
// RETURN PREASSEMBLED ROWS...
//

	// create_ad_description
	// returns $addurl
	//
	function create_ad_description($ID,$product_type,$add_title,$brief_description,$offered_price,$full_description,$shipping_origination,$entrydate) {
		global $webhost;
		global $classifiedserverdir;
		global $policy_day_length;
		global $has_controller;
		global $db_connection;
		//
		$process_imediacy = 0;				// DEFAULT IS THAT THE USER GETS APPROVAL BEFORE RELEASING AD
		if ( secondary_approval_type($product_type)  ) {
			$process_imediacy = 1;				/// THE ADD IS PUBLISHED BEFORE review...
			$has_controller = true;				//// NOTICE THIS CONDITION SET HERE....
		}
		
		//
		$lister_html_row = input_lister_row();
		$lister_html_row = replace_in_txt_form($lister_html_row,$ID,'ID');
		$lister_html_row = replace_in_txt_form($lister_html_row,$add_title,'add_title');
		$lister_html_row = replace_in_txt_form($lister_html_row,$brief_description,'brief_description');
		$lister_html_row = replace_in_txt_form($lister_html_row,$offered_price,'offered_price');
		$lister_html_row = replace_in_txt_form($lister_html_row,$shipping_origination,'shipping_origination');
		$lister_html_row = replace_in_txt_form($lister_html_row,$entrydate,'entrydate');
		$lister_html_row = urlencode($lister_html_row);
		//
		//
		$detailed_html = "";
		$detailed_html = input_detail_display();
		$detailed_html = replace_in_txt_form($detailed_html,$ID,'ID');
		$detailed_html = replace_in_txt_form($detailed_html,$product_type,'product_type');
		$detailed_html = replace_in_txt_form($detailed_html,$add_title,'add_title');
		$detailed_html = replace_in_txt_form($detailed_html,$offered_price,'offered_price');
		$detailed_html = replace_in_txt_form($detailed_html,$full_description,'full_description');
		$detailed_html = replace_in_txt_form($detailed_html,$shipping_origination,'shipping_origination');
		$detailed_html = replace_in_txt_form($detailed_html,$entrydate,'entrydate');		
		$detailed_html = urlencode($detailed_html);
		/*
		*/
		$deletion_date = days_from_now($entrydate,$policy_day_length);
		////
		$section_maker = "insert into classified_reports ";
		$section_maker .= "(ID,processed,priviledge_level,priority,refnumber,product_type,lister_html_row,detailed_html,deletion_date,entrydate)";
		$section_maker .= " VALUES (0,$process_imediacy,0,0,'";			// $process_imediacy default is 0, requiring user release. Payed is immediate,=1, with 
																		// control over delete or keep.
		$section_maker .= $ID . "','";
		$section_maker .= $product_type . "','";
		$section_maker .= $lister_html_row . "','";
		$section_maker .= $detailed_html . "','";
		$section_maker .= $deletion_date . "','";
		$section_maker .= $entrydate . "')";

		$q_result = @mysqli_query($section_maker) or die (mysqli_error($db_connection));  //

		if ( $process_imediacy = 0 ) {			/// DEFAULT DEFAULT
			//
			// THIS IS THE URL THAT ALLOWS EDITING AND PUBLICATION ACCEPTANCE
			// userapproval.php has a link to acceptadd.php
			//
			$adurl = "http://$webhost" . "/$classifiedserverdir/manager/userapproval.php?refnumber=$ID&section_number=$product_type";
			//
		} else {
			// 
			//  TWO URLS are required.  ONE IS VISIBLE HERE.
			//
			$adurl_front = "http://$webhost" . "/$classifiedserverdir/manager/";
			$adparms = "?refnumber=$ID&section_number=$product_type";
			$url_middle = controller_notifications($adurl_front,$adparms,$product_type);		// controller_notifications sets GLOBAL VARIABLES.
			////
			$adurl = $adurl_front . $url_middle . $adparms;				//  THIS GOES TO THE AGENT.  see controller_notifications for controller
		}
		
		return( $adurl );

	}
	
	
	// returns the status of the user as being new or not...	
	function update_user($email_address,$contact_number,$lasttime) {
		global $db_connection;
	
		$ustatus = 0;

		$section_q = "select count(*) from classified_user where ( email_address = '";
		$section_q .= $email_address;
		$section_q .= "' )";
		//
		$q_result = @mysqli_query($section_q) or die (mysqli_error($db_connection));  // 
		$row = @mysqli_fetch_row($q_result);
		$counter = $row[0];

		if ( $counter <= 0 ) {
			$user_maker = "";
			//
			$user_maker .= "insert into classified_user (ID,countuse,email_address,contact_number, lasttime)";
			//
			$user_maker .= " VALUES (0,1,'";
			$user_maker .= fixtext($email_address) . "','";
			$user_maker .= fixtext($contact_number) . "','";
			$user_maker .= $lasttime . "')";
			
			$q_result = @mysqli_query($user_maker) or die (mysqli_error($db_connection));  // 

		} else {
			$section_q = "select countuse from classified_user where ( email_address = '";
			$section_q .= $email_address;
			$section_q .= "' )";
			//
			$q_result = @mysqli_query($section_q) or die (mysqli_error($db_connection));  // 
			$row = @mysqli_fetch_row($q_result);
			$counter = $row[0];
			
			$counter++;
			$section_q = "update classified_user set countuse = '$counter', lasttime = '$lasttime' where ( email_address = '";
			$section_q .= $email_address;
			$section_q .= "' )";
			//
			$q_result = @mysqli_query($section_q) or die (mysqli_error($db_connection));  //
			$ustatus = 1;
		}
		
		return($ustatus);
		//
	}



	function fetch_section_after_time($last_processing_time) {
		global $count_adds;
		global $contolleremail;
		global $g_agent_email;
		global $controller_url;
		global $has_controller;
		global $db_connection;
		//
		//
		$content = $last_processing_time;

		$section_q = "select count(*) from classified_request where ( nowtime >= '";
		$section_q .= $last_processing_time;			// PARAMETER FROM UPDATE PROCESSING TIME.
		$section_q .= "' ) AND ( processed = '0' )";
		//
		$q_result = @mysqli_query($section_q) or die (mysqli_error($db_connection));  // 
		$row = @mysqli_fetch_row($q_result);
		$counter = $row[0];


		$count_adds = $counter;

		if ( $counter > 0 ) {
			//
			// GATHER UP REPORT INFORMATION THAT IS TO BE STORED IN THE DB.
			//
			$content = "<tr><td width='15%'></td><td width='18%'></td><td>" . datetime() . "</td></tr>\n";
			$colorchoice = "lightyellow";
				//
				
			//		GET THE ONES THAT HAVE NOT BEEN PROCESSED SINCE THE LAST TIME.
			//
			$section_q = "select * from classified_request where ( nowtime >= '";
			$section_q .= $last_processing_time;
			$section_q .= "' ) AND ( processed = '0' )";
			//
			$q_result = @mysqli_query($section_q) or die (mysqli_error($db_connection));  // 
			//
			//	PROCESS ALL THE RECORDS FETCHED
			////	
			while ( $row = @mysqli_fetch_array($q_result) ) {
				//
				$ID = $row['ID'];
				//
				$section_number = urldecode($row['section_number']);
				$add_title = urldecode($row['add_title']);
				$brief_description = urldecode($row['brief_description']);
				$offered_price = $row['offered_price'];
				$email_address = urldecode($row['email_address']);
				$agent_email_address = urldecode($row['agent_email_address']);
				$full_description = urldecode($row['full_description']);
				$shipping_origination = urldecode($row['shipping_origination']);
				$nowtime = $row['nowtime'];

				$contact_number = $row['contact_number'];
				
				///   ADD TO THE REPORT
				$content .= "<tr><td width='15%' style='background-color:$colorchoice'>$ID</td><td width='18%' style='background-color:$colorchoice'>$section_number</td><td width='33%' style='background-color:$colorchoice'> $email_address </td><td width='33%' style='background-color:$colorchoice'>$contact_number </td></tr>\n";

				////
				///// APPROVAL EMAIL....
				$contolleremail = $email_address;				// POSTER or the one with final decision making authority over delete or keep.
				$g_agent_email = $agent_email_address;			// The creator of ad content.
				//
				$has_controller = false;		// THIS MAY BE SET AS A SIDE EFFECT in 'create_ad_description'
				////
				//================================================================================
				//
				//  CREATE THE ADD DESCRIPTION
				
				// quite intentionally, the section number is checked in order to determine if the controller conditions and variables should be set.
				//
				$adurl = create_ad_description($ID,$section_number,$add_title,
													$brief_description,$offered_price,
														$full_description,$shipping_origination,$nowtime);
				////
				/// THE EDITOR IS CHECKED FOR STATS
				//
				$ustatus = update_user($agent_email_address,$contact_number,$nowtime);
				////
				////
				/// THE EDITOR IS ALWAYS NOTIFIED
				//
				notify_user($ID,$adurl,$agent_email_address,$contact_number,$ustatus,$nowtime);

				//================================================================================
				
				//   THERE IS A CONTROLLER SO MAKE SURE THAT THE CONTROLLING BUTTON IS MAILED BACK TO HIM.
				
				if ( $has_controller ) {
					//
					//		$controller_url    MADE IN		controller_notifications
					//
					notify_user($ID,$controller_url,$email_address,$contact_number,$ustatus,$nowtime);
					//
				}
/*
*/
				//================================================================================
	
				//
				if ( $colorchoice == "lightyellow" ) {
					$colorchoice = "#CCFFDD";
				} else {
					$colorchoice = "lightyellow";
				}
			}

			$section_q = "update classified_request set processed = '1' where ( nowtime >= '";
			$section_q .= $last_processing_time;
			$section_q .= "' ) AND ( processed = '0' )";
			//
			$q_result = @mysqli_query($section_q) or die (mysqli_error($db_connection));  // 
/*
*/
		}


		///  THERE ARE ADS SO STORE THE REPORT in the DB.
		if ( $count_adds > 0 ) {
			$storedcontent = '<table style="text-align: left; width: 100%; height: 100%;" border="0" cellpadding="1" cellspacing="3">';
			$storedcontent .= $content;
			$storedcontent .= '</table>';

			store_current_content($storedcontent);
		}

		return($counter);
	}



	////////////////////////////////////////////////////////////
	
	$last_processing_time = update_process_time();		// PROCESS TIME IS STORED IN THE DB.
		
	error_reporting(E_ALL);
	
	$time_less_delta = moments_before($last_processing_time,$delta_time_factor);

	$count_adds = fetch_section_after_time($time_less_delta);		// PROCESS ALL ADS THAT ARE READY AT THIS TIME.
																		// $last_processing_time is the last time processing occured.
	 
	$reportText = "CLASSIFIED: $count_adds processed at time $rightnow\n";
	echo $reportText;
?>
