<?php

include '../servicename.php';
try {
	include '../../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
	
	$ad_title = "";
	$ad_short_description = "";
	$ad_long_description = "";
	$ad_price = "";

	//
	///
	////
	function input_lister_row() {
		$text = implode(file("lister_row.txt"));
		return($text);
	}


	function input_detail_display() {
		$text = implode(file("detail_display.txt"));
		return($text);
	}

	function replace_in_txt_form($txt,$value,$key) {
		$copikey = "$" . $key . "$";
		return(str_replace($copikey,$value,$txt));
	}



	function update_ad_status($ID) {
		global $db_connection;
		global $policy_day_length;
		//
		$nowtime = datetime();
		$deletion_date = days_from_now($nowtime,$policy_day_length);
		////
		$section_maker = "update classified_reports ";
		$section_maker .= "set processed = '1', deletion_date = '$deletion_date' where refnumber = '$ID'";
		
		$q_result = @mysqli_query($section_maker) or die (mysqli_error($db_connection));  //
	}
	

	function fetch_single_tagline($addID) {
		global $db_connection;
		//
		$content = "empty";
		////
		// select short rows from the table...
		//
		$classy_q = "select lister_html_row from classified_reports where ( refnumber = '";
		$classy_q .= $addID;
		$classy_q .= "' )";
		////
		$q_result = @mysqli_query($classy_q) or die (mysqli_error($db_connection));  // 
		////	
		if ( $row = @mysqli_fetch_array($q_result) ) {
			$tr_text = $row['lister_html_row'];
			$content = urldecode($tr_text);
		}
		
		return $content;
	}


	function fetch_single_add($addID) {
		global $db_connection;
		//
		$content = "empty";
		////
		// select short rows from the table...
		//
		$classy_q = "select detailed_html from classified_reports where ( refnumber = '";
		$classy_q .= $addID;
		$classy_q .= "' )";
		////
		$q_result = @mysqli_query($classy_q) or die (mysqli_error($db_connection));  // 
		////	
		if ( $row = @mysqli_fetch_array($q_result) ) {
			$tr_text = $row['detailed_html'];
			$content = urldecode($tr_text);
		}
		
		return $content;
	}



	////////////////////////////////////////////////////////////
	
	$refnumber = $_GET['refnum'];
	
	update_ad_status($refnumber);
	$shortText = fetch_single_tagline($refnumber);
	$longText = fetch_single_add($refnumber);

		
	error_reporting(E_ALL);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
		<meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
		<style type="text/css">
		#column1, #column2 {
			margin-right: 5px;
			float: left;
			border: solid 2px lightgray;
		}
		.editButton {
			font-weight:bold;
			text-align:center;
			background-color:#EEFFBB;
			border:1px solid darkred;
		}
		
		#change_title {
			position: absolute;
			visibility: hidden;
			background-color: lightgray;
			width:70%;
			padding:10;
		}
		#change_shortdescr {
			position: absolute;
			visibility: hidden;
			background-color: lightgray;
			width:70%;
			padding:10;
		}
		#change_longdescr {
			position: absolute;
			visibility: hidden;
			background-color: lightgray;
			width:70%;
			padding:10;
		}
		#change_price {
			position: absolute;
			visibility: hidden;
			background-color: lightgray;
			width:70%;
			padding:10;
		}

		</style>
	</head>
	<script language="javascript">
		function rollover(obj) {
			savecolor = obj.style.borderColor;
			obj.style.borderColor = "darkgreen";
		}

		function rollout(obj) {
			obj.style.borderColor = savecolor;
		}
		
	</script>
	
	<body>
	
		<div id="column1" style="padding:10;width:55%" >
			<div id="shortSection">
				<div id="display" style="background-color:#EEFFBB;border-bottom:1px solid #AAEE88">
				<span style="color:#004422;font-weight:bold;font-size:16;">The lines appearing in the list are as follows:</span>
				</div>
				<br>
				<div style="background-color:#FFFBCC">
				<table border="0" cellspacing="0" cellpadding="0" width="100%" ID="Table1">
				<tbody>
				<?php echo $shortText; ?>
				</tbody>
				</table>
				</div>
			</div>
				<br>
				<br>
			<div id="longSection">
				<div id="display" style="background-color:#EEFFBB;border-bottom:1px solid #AAEE88">
				<span style="color:#004422;font-weight:bold;font-size:16;">The lines appearing in the detail box are as follows:</span>
				</div>
				<br>
				<div style="background-color:#FFFBCC">
				<?php echo $longText; ?>
				</div>
			</div>
		</div>

		<div id="column2" style="padding:10;width:35%;" >
			<span style="color:#004422;font-weight:bold;font-size:14;background-color:#EEFFBB;border-bottom:1px solid #AAEE88">Go to Classifieds:</span>
			<table border="0" cellspacing="8" cellpadding="1" width="100%" ID="Table1">
			<tbody>
				<tr>
					<td width="10%">&nbsp;</td>
					<td width="50%" class="editButton" onmouseover="rollover(this);" onmouseout="rollout(this);">
					
					<a href="http://<?php echo $webhost; ?>/hosted/classydex/index.html" style="text-decoration:none;color:green">
					&nbsp;Go There&nbsp;
					</a></td>
				</tr>
			</tbody>
			</table>
		</div>

	</body>
</html>
