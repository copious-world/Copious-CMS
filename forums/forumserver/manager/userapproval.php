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

	function get_last_seqname($refnumber) {
		global $db_connection;
		//
		$section_retriever = "select filename from classifieds_images where ( refnum = '$refnumber' )";
		$q_result = @mysqli_query($db_connection,$section_retriever) or die (mysqli_error($db_connection));  // 
		////	
		$fname = "";
		if ( $row = @mysqli_fetch_array($q_result) ) {
			$fname = $row[0];
		}
		
		return($fname);
	}


	function update_ad_description($ID) {
		global $db_connection;

		$section_q = "select * from classified_request where ( ID = '$ID' )";
		//
		$q_result = @mysqli_query($db_connection,$section_q) or die (mysqli_error($db_connection));  // 
		////	
		if ( $row = @mysqli_fetch_array($q_result) ) {
			//
			$product_type = urldecode($row['section_number']);
			$add_title = urldecode($row['add_title']);
			$brief_description = urldecode($row['brief_description']);
			$offered_price = $row['offered_price'];
			$email_address = urldecode($row['email_address']);
			$contact_number = urldecode($row['contact_number']);
			$full_description = urldecode($row['full_description']);
			$shipping_origination = urldecode($row['shipping_origination']);
			$entrydate = $row['nowtime'];
					
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
			////
			$section_maker = "update classified_reports ";
			$section_maker .= "set lister_html_row = '$lister_html_row', detailed_html = '$detailed_html' ";
			$section_maker .= "where refnumber = '$ID'";
			
			$q_result = @mysqli_query($db_connection,$section_maker) or die (mysqli_error($db_connection));  //
		}
	}

	function update_db_entries($refnumber,$section_number,$change_action,$change_value) {
			
			$change_key = "";
			$change_data = "";

			if ( $change_action == "title" ) {
				$change_key = "add_title";
				$change_data = fixtext($change_value);
			} else if ( $change_action == "short description" ) {
				$change_key = "brief_description";
				$change_data = fixtext($change_value);
			} else if ( $change_action == "long description" ) {
				$change_key = "full_description";
				$change_data = $change_value;
				$change_data = str_replace("\\'","'",$change_value);
			} else if ( $change_action == "price" ) {
				$change_key = "offered_price";
				$change_data = $change_value;
			} else if ( $change_action == "picture" ) {
				$change_key = "full_description";
				$change_data = str_replace("\\'","'",$change_value);
				
				$pic_data = '<img src="' . imagelocus();
				$pic_data .= get_last_seqname($refnumber);
				$pic_data .= '" heigth="150" width="150">';
				$change_data .= urlencode($pic_data);
			}
			//			
			$section_q = "update classified_request set $change_key = '$change_data' where ( ID = '$refnumber')";
			$q_result = @mysqli_query($db_connection,$section_q) or die (mysqli_error($db_connection));  // 
			//
			
			update_ad_description($refnumber);
			/*
			*/
	}
	
	function fetch_pariticular_parts($addID) {
		global $ad_title;
		global $ad_short_description;
		global $ad_long_description;
		global $ad_price;
		
		$classy_q = "select * from classified_request where ( ID = '$addID' )";
		////
		$q_result = @mysqli_query($db_connection,$classy_q) or die ( mysqli_error($db_connection) );  // 
		////	
		if ( $row = @mysqli_fetch_array($q_result) ) {
				$ad_title = urldecode($row['add_title']);
				$ad_short_description = urldecode($row['brief_description']);
				$ad_long_description = urldecode($row['full_description']);
				$ad_price = $row['offered_price'];
		}
		
	}

	function fetch_single_tagline($addID) {
		//
		$content = "empty";
		////
		// select short rows from the table...
		//
		$classy_q = "select lister_html_row from classified_reports where ( refnumber = '";
		$classy_q .= $addID;
		$classy_q .= "' )";
		////
		$q_result = @mysqli_query($db_connection,$classy_q) or die (mysqli_error($db_connection));  // 
		////	
		if ( $row = @mysqli_fetch_array($q_result) ) {
			$tr_text = $row['lister_html_row'];
			$content = urldecode($tr_text);
		}
		
		return $content;
	}


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
	
	$refnumber = $_GET['refnumber'];;
	$section_number = $_GET['section_number'];
	if ( isset($_GET['change_action']) ) {
		$change_action = $_GET['change_action'];
	}
	
	error_reporting(E_ALL);
	
	if ( isset($change_action) ) {
		$change_value = $_GET['change_value'];
		update_db_entries($refnumber,$section_number,$change_action,$change_value);
		//
		$shortText = fetch_single_tagline($refnumber);
		$longText = fetch_single_add($refnumber);
		fetch_pariticular_parts($refnumber)
		
?>		
		<div id="shortSection">
			<div id="display" style="background-color:#EEFFBB;border-bottom:1px solid #AAEE88">
			<span style="color:#004422;font-weight:bold;font-size:1em;">The lines appearing in the list are as follows:</span>
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
			<span style="color:#004422;font-weight:bold;font-size:1em;">The lines appearing in the detail box are as follows:</span>
			</div>
			<br>
			<div style="background-color:#FFFBCC">
			<?php echo $longText; ?>
			</div>
		</div>
		<div id="hiddenedittext" >
		<?php echo $ad_long_description; ?>
		</div>

<?php
	} else {


		$classy_q = "select count(*) from classified_reports where ( refnumber = '";
		$classy_q .= $refnumber;
		$classy_q .= "' )";

		////
		$q_result = @mysqli_query($db_connection,$classy_q) or die (mysqli_error($db_connection));  // 
		////	
		if ( $row = @mysqli_fetch_array($q_result) ) {
			////
			$counter = $row[0];
			if ( $counter > 0 ) {
				$shortText = fetch_single_tagline($refnumber);
				$longText = fetch_single_add($refnumber);
				fetch_pariticular_parts($refnumber)
	

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
			cursor:pointer;
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
		#add_picture {
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
		#hiddenedittext  {
			visibility: hidden;
			height: 0;
		}

		</style>
	</head>
	<script language="javascript">
		//
		var savecolor;
		var http_request = null;

		function docsAlertContents() {
			if ( http_request.readyState == 4 ) {
				if ( http_request.status == 200 ) {
					result = http_request.responseText;
					var divobj = document.getElementById("column1");
					divobj.innerHTML = result;
					
					var edittext = document.getElementById("hiddenedittext").innerHTML;
					var placetext = document.getElementById("ad_long_description");
					placetext.value = edittext;

				} else {
					clear_server_parameters();
					alert('There was a problem with the request.');
				}
			}
		}


		function makeDocRequest(urlNparameters) {
		
			http_request = null;

			if ( window.XMLHttpRequest ) { // Mozilla, Safari,...
				http_request = new XMLHttpRequest();
				if ( http_request.overrideMimeType ) {
					http_request.overrideMimeType('text/xml');
				}
			} else if ( window.ActiveXObject ) { // IE
				try {
					http_request = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
					try {
						http_request = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e) {}
				}
			}

			if ( http_request == null ) {
				alert('Cannot create XMLHTTP instance');
				return(false);
			} else {
				try {
					http_request.onreadystatechange = docsAlertContents;
					http_request.open('GET', urlNparameters, true);
					http_request.send(null);
				} catch (e) {
					clear_server_parameters();
					alert('There was trouble sending the request.');
				}
			}
			
		}


		function rollover(obj) {
			savecolor = obj.style.borderColor;
			obj.style.borderColor = "darkgreen";
		}

		function rollout(obj) {
			obj.style.borderColor = savecolor;
		}

		function editContent(editname) {
			var chObj = null;
			var zorder = 0;
			//
			chObj = document.getElementById("change_title");
			chObj.style.visibility = "hidden";
			chObj = document.getElementById("change_shortdescr");
			chObj.style.visibility = "hidden";
			chObj = document.getElementById("change_longdescr");
			chObj.style.visibility = "hidden";
			chObj = document.getElementById("change_price");
			chObj.style.visibility = "hidden";
			chObj = document.getElementById("add_picture");
			chObj.style.visibility = "hidden";
			//
			switch ( editname ) {
				case "title": {
					chObj = document.getElementById("change_title");
					zorder = 100;
					break;
				}
				case "short description": {
					chObj = document.getElementById("change_shortdescr");
					zorder = 101;
					break;
				}
				case "long description": {
					chObj = document.getElementById("change_longdescr");
					zorder = 102;
					break;
				}
				case "price": {
					chObj = document.getElementById("change_price");
					zorder = 103;
					break;
				}
				case "picture": {
					chObj = document.getElementById("add_picture");
					zorder = 104;
					break;
				}
			}
			
			var refobj = document.getElementById("column1");
			
			chObj.style.visibility = "visible";
			chObj.style.zIndex = zorder;
			chObj.style.left = "10%";
			var y = refobj.offsetTop + refobj.offsetHeight + 10;
			chObj.style.top = y + "px";
		}

		function hideDiv(divname) {
			chObj = document.getElementById(divname);
			chObj.style.visibility = "hidden";
		}
		
		function makeChange(whichchange) {
			var chObj = null;
			var zorder=0;
			var cvalue = "";
			switch ( whichchange ) {
				case "title": {
					chObj = document.getElementById("ad_title");
					hideDiv("change_title");
					break;
				}
				case "short description": {
					chObj = document.getElementById("ad_short_description");
					hideDiv("change_shortdescr");
					break;
				}
				case "long description": {
					chObj = document.getElementById("ad_long_description");
					hideDiv("change_longdescr");
					break;
				}
				case "price": {
					chObj = document.getElementById("ad_price");
					hideDiv("change_price");
					break;
				}
				case "picture": {
					chObj = document.getElementById("ad_picture");
					// POST PICTURE....

					// POST PICTURE....
					hideDiv("add_picture");
					chObj = document.getElementById("ad_long_description");
					
					break;
				}
			}
			//
			cvalue = chObj.value;

			var url = "userapproval.php?refnumber=<?php echo $refnumber; ?>&section_number=<?php echo $section_number; ?>&change_action=";
			url += whichchange + "&";
			url += "change_value=" + cvalue + "&";
			
			makeDocRequest(url);
		}
		
		
		function doImagePost() {
			document.pictureform.submit();
		}
		
	</script>
	<body>
	
	<div id="change_title">
	<form>
		<input type="text" id="ad_title" size="80" NAME="ad_title" value="<?php echo $ad_title; ?>">
		<table cellpadding="0" cellspacing="0" border="0" width="100%" ID="Table1">
			<tr>
			<td width="15%" style="text-align:center;background-color:#FEFEEE;border-top: solid 1px darkred">
			<a href="javascript:hideDiv('change_title');" style="background-color:#FFFFE0;padding:2;font-size:0.80em;text-align:center;text-decoration:none;border: solid 1px brown">
			&nbsp;close&nbsp;
			</a>
			</td>
			<td width="50%" style="text-align:center;background-color:#FEFEEE;border-top: solid 1px darkred">
				<a href="javascript:makeChange('title');" style="background-color:#FFFFE0;padding:2;font-size:0.80em;text-align:center;text-decoration:none;border: solid 1px green"> 
				&nbsp;make change&nbsp;
				</a>
			</td><td width="30%" style="background-color:#FEFEEE">&nbsp;</td>
			</tr>
		</table>
	</form>
	</div>
	
	<div id="change_shortdescr">
	<form>
		<input type="text" id="ad_short_description" size="80" NAME="ad_short_description" value="<?php echo $ad_short_description; ?>">
		<table cellpadding="0" cellspacing="0" border="0" width="100%" ID="Table1">
			<tr>
			<td width="15%" style="text-align:center;background-color:#FEFEEE;border-top: solid 1px darkred">
			<a href="javascript:hideDiv('change_shortdescr');" style="background-color:#FFFFE0;padding:2;font-size:0.80emtext-align:center;text-decoration:none;border: solid 1px brown">
			&nbsp;close&nbsp;
			</a>
			</td>
			<td width="50%" style="text-align:center;background-color:#FEFEEE;border-top: solid 1px darkred">
				<a href="javascript:makeChange('short description');" style="background-color:#FFFFE0;padding:2;font-size:0.80emtext-align:center;text-decoration:none;border: solid 1px green"> 
				&nbsp;make change&nbsp;
				</a>
			</td><td width="30%" style="background-color:#FEFEEE">&nbsp;</td>
			</tr>
		</table>
	</form>
	</div>

	<div id="change_longdescr">
	<form>
		<TEXTAREA name="ad_long_description" rows="10" cols="80" ID="ad_long_description"><?php echo $ad_long_description; ?></TEXTAREA> 
		<table cellpadding="0" cellspacing="0" border="0" width="100%" ID="Table1">
			<tr>
			<td width="15%" style="text-align:center;background-color:#FEFEEE;border-top: solid 1px darkred">
			<a href="javascript:hideDiv('change_longdescr');" style="background-color:#FFFFE0;padding:2;font-size:0.80emtext-align:center;text-decoration:none;border: solid 1px brown">
			&nbsp;close&nbsp;
			</a>
			</td>
			<td width="50%" style="text-align:center;background-color:#FEFEEE;border-top: solid 1px darkred">
				<a href="javascript:makeChange('long description');" style="background-color:#FFFFE0;padding:2;font-size:0.80emtext-align:center;text-decoration:none;border: solid 1px green"> 
				&nbsp;make change&nbsp;
				</a>
			</td><td width="30%" style="background-color:#FEFEEE">&nbsp;</td>
			</tr>
		</table>
	</form>
	</div>

	<div id="add_picture">
	<form name="pictureform" action="upload.php" method="post" enctype="multipart/form-data" target="testframe" >
	    <input type="hidden" name="refnumber" value="<?php echo $refnumber; ?>" />
	    <input type="hidden" name="section_number" value="<?php echo $section_number; ?>" />
	    <input type="hidden" name="MAX_FILE_SIZE" value="180000" />
		<input type="file" id="ad_picture" size="80" NAME="ad_picture" value=" " onchange="doImagePost();">
		
<!--  <input type="submit" name="imagePOST" value="upload" /> -->
		<table cellpadding="0" cellspacing="0" border="0" width="100%" ID="Table1" >
			<tr>
			<td width="15%" style="text-align:center;background-color:#FEFEEE;border-top: solid 1px darkred">
			<a href="javascript:hideDiv('add_picture');" style="background-color:#FFFFE0;padding:2;font-size:0.80emtext-align:center;text-decoration:none;border: solid 1px brown">
			&nbsp;close&nbsp;
			</a>
			</td>
			<td width="40%" style="text-align:center;background-color:#FEFEEE;border-top: solid 1px darkred">
				<a href="javascript:makeChange('picture');" style="background-color:#FFFFE0;padding:2;font-size:0.80emtext-align:center;text-decoration:none;border: solid 1px green"> 
				&nbsp;make change&nbsp;
				</a>
			</td>
			<td width="40%" style="background-color:#FEFEEE">
			</td>
			</tr>
		</table>
	</form>
		<div style="float:right">
			<iframe name="testframe" id="testframe" >
			</iframe>
		</div>
	</div>


	<div id="change_price">
	<form>
		<input type="text" id="ad_price" size="80" NAME="ad_price" value="<?php echo $ad_price; ?>">
		<table cellpadding="0" cellspacing="0" border="0" width="100%" ID="Table1">
			<tr>
			<td width="15%" style="text-align:center;background-color:#FEFEEE;border-top: solid 1px darkred">
			<a href="javascript:hideDiv('change_price');" style="background-color:#FFFFE0;padding:2;font-size:0.80emtext-align:center;text-decoration:none;border: solid 1px brown">
			&nbsp;close&nbsp;
			</a>
			</td>
			<td width="50%" style="text-align:center;background-color:#FEFEEE;border-top: solid 1px darkred">
				<a href="javascript:makeChange('price');" style="background-color:#FFFFE0;padding:2;font-size:0.80em;text-align:center;text-decoration:none;border: solid 1px green"> 
				&nbsp;make change&nbsp;
				</a>
			</td><td width="30%" style="background-color:#FEFEEE">&nbsp;</td>
			</tr>
		</table>
	</form>
	</div>


		<div id="column1" style="padding:10;width:55%" >
			<div id="shortSection">
				<div id="display" style="background-color:#EEFFBB;border-bottom:1px solid #AAEE88">
				<span style="color:#004422;font-weight:bold;font-size:1em;">The lines appearing in the list are as follows:</span>
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
				<span style="color:#004422;font-weight:bold;font-size:1em;">The lines appearing in the detail box are as follows:</span>
				</div>
				<br>
				<div style="background-color:#FFFBCC">
				<?php echo $longText; ?>
				</div>
			</div>
			<div id="hiddenedittext" >&nbsp;</div>
		</div>
		
		<div id="column2" style="padding:10;width:35%;" >
			<span style="color:#004422;font-weight:bold;font-size:0.95em;background-color:#EEFFBB;border-bottom:1px solid #AAEE88">Selections for change:</span>
			<table border="0" cellspacing="8" cellpadding="1" width="100%" ID="Table1">
			<tbody>
				<tr>
					<td width="10%">&nbsp;</td>
					<td width="50%" class="editButton" onclick="editContent('title');" onmouseover="rollover(this);" onmouseout="rollout(this);">&nbsp;title&nbsp;</td>
				</tr>
				<tr>
					<td width="10%">&nbsp;</td>
					<td width="50%" class="editButton" onclick="editContent('short description');"  onmouseover="rollover(this);" onmouseout="rollout(this);">&nbsp;short description&nbsp;</td><td width="40%">&nbsp;</td>
				</tr>
				<tr>
					<td width="10%">&nbsp;</td>
					<td width="50%"  class="editButton" onclick="editContent('long description');"  onmouseover="rollover(this);" onmouseout="rollout(this);">&nbsp;long description&nbsp;</td><td width="40%">&nbsp;</td>
				</tr>
				<tr>
					<td width="10%">&nbsp;</td>
					<td width="50%"  class="editButton" onclick="editContent('price');"  onmouseover="rollover(this);" onmouseout="rollout(this);">&nbsp;price&nbsp;</td><td width="40%">&nbsp;</td>
				</tr>
				<tr>
					<td width="10%">&nbsp;</td>
					<td width="50%"  class="editButton" onclick="editContent('picture');"  onmouseover="rollover(this);" onmouseout="rollout(this);">&nbsp;upload picture&nbsp;</td><td width="40%">&nbsp;</td>
				</tr>
			</tbody>
			</table>
			<br>
			<span style="color:#440022;font-weight:bold;font-size:0.95em;background-color:#EEFFBB;border-bottom:1px solid #AAEE88">Delete Ad From System</span>
			<table border="0" cellspacing="8" cellpadding="1" width="100%" ID="Table1">
			<tbody>
				<tr>
					<td width="10%">&nbsp;</td>
					<td width="50%" class="editButton" onmouseover="rollover(this);" onmouseout="rollout(this);">
					<a href="deletead.php?refnum=<?php echo $refnumber; ?>&" style="color:#006622;;text-decoration:none;">&nbsp;YES&nbsp;<a>
					</td>
					<td width="40%">&nbsp;</td>
				</tr>
			</tbody>
			</table>
			<span style="color:#004422;font-weight:bold;font-size:1.05em;background-color:#FFFFBB;border:2px solid #FF2288;padding:3px;">Accept Ad Content and Publish</span>
			<table border="0" cellspacing="8" cellpadding="1" width="100%" ID="Table1">
			<tbody>
				<tr>
					<td width="10%">&nbsp;</td>
					<td width="50%" class="editButton" onmouseover="rollover(this);" onmouseout="rollout(this);">
					<a href="acceptadd.php?refnum=<?php echo $refnumber; ?>&" style="color:#006622;;text-decoration:none;">&nbsp;YES&nbsp;<a>
					</td>
				</tr>
				<tr>
					<td width="10%">&nbsp;</td>
					<td width="50%" class="editButton" onmouseover="rollover(this);" onmouseout="rollout(this);">
					<a href="http://www.copious-systems.com" style="color:black;text-decoration:none;">&nbsp;CANCEL&nbsp;<a>
					</td><td width="40%">&nbsp;</td>
				</tr>
			</tbody>
			</table>
			<br>
		</div>
	</body>
</html>

<?php 
			} else {
				echo "This add has been deleted.";
			}
		} else {
				echo "This add cannot be found.";
		}
	}
?>
