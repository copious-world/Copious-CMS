<?php

/// User's Own

$leftLogo = "/hosted/img/logo.jpg";
$rightLogo = "/hosted/img/logo.jpg";


echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";


$nosuperrequirred = false;

global $g_sname_depth;
$g_sname_depth = '..';
include "../admin_header.php";


$groups_array = array(
	"&lt;Everyone&gt;", "&curren;", 
	"&curren;", "&curren;", "&curren;", "&curren;",
	"&curren;", "&curren;", "&curren;", "&curren;",
	"&curren;", "&curren;", "&curren;", "&curren;",
	"&curren;", "&curren;", "&curren;", "&curren;"
);



function add_group_record($uid) {
	global $groups_array;
					
	$mailIG_q = "insert into mail_groups ( ID, UID ) values (0,$uid)";
	db_query_exe($mailIG_q);
}

function load_user_mail_groups($uid) {		
	global $groups_array;
	global $db_connection;
	////
	
	$mailG_q = "select count(*) from mail_groups where ( UID = '";
	$mailG_q .= $uid;
	$mailG_q .= "')";
	//
	$counter = db_query_value($mailG_q);
	
	if ( $counter == 0 ) {
		add_group_record($uid);
	}
	
	$mailG_q = "select * from mail_groups where ( UID = '$uid' )";
	/////
	$q_result = @mysqli_query($db_connection,$mailG_q) or die (mysqli_error($db_connection));  //
	//
	$row = @mysqli_fetch_row($q_result);
	
	$row_id = $row[0];

	for ( $i = 1; $i < 16; $i++ ) {
		$ostr = urldecode($row[$i + 2]);
		if ( strlen($ostr) > 0 ) {
			$groups_array[$i] = $ostr;
		}
	}

	//
	return($row_id);
}

//
$group_rec_id = load_user_mail_groups($userid);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<!--

	Copious Systems created for Classydex
	The classy classified index.
	Copyright (C) 2007 Copious Systems

	This file is enabled by the OpenLink Ajax Toolkit (OAT) project
	Copyright (C) 2005-2007 OpenLink Software

	This project is free software; you can redistribute it and/or modify it
	under the terms of the GNU General Public License as published by the
	Free Software Foundation; only version 2 of the License, dated June 1991

	This project is distributed in the hope that it will be useful, but
	WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	General Public License for more details.

	The GNU General Public License is available from the Free Software Foundation,
	Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA

-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php


if ( $userid <= 0 ) {
?>

</head>
<body>
		<table border="0px" cellspacing="0px" cellpadding="0px" width="100%" ID="Table6">
			<tbody>
				<tr>
					<td bgcolor="darkgreen" height="1px" width="100%"></td>
				</tr>
			</tbody></table>
		<table border="0px" cellspacing="0px" cellpadding="0px" width="100%" ID="Table6">
			<tbody>
				<tr>
					<td bgcolor="darkgreen" height="1px" width="100%"></td>
				</tr>
			</tbody></table>
		<!-- =======================================  -->
		<div style="background-color:#fcfcc5;">
			<table border="0px" cellspacing="0px" cellpadding="0px" width="100%">
				<tbody>
					<tr>
						<td align="left" height="24px" nowrap valign="middle" width="30%">
<img src="<?php echo $leftLogo; ?>"><img src="/hosted/img/faderight.jpg" height="90px">
						</td>
						<td align="center" height="24px" nowrap valign="middle" width="40%">
							<span  style="font-face:Arial;font-size:18px;color: rgb(0, 0, 102); text-decoration: none; font-weight: bold;">
									<span style="font-weight:bold;font-size:1.1em" >The mail page is only accessible after signing in.
							</span>
						<br>
						</td>
						<td align="right" height="24px" nowrap valign="middle" width="30%">
<img src="/hosted/img/fadeleft.jpg" height="90px"><img src="<?php echo $rightLogo; ?>">
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<table border="0px" cellspacing="0px" cellpadding="0px" width="100%" ID="Table6">
			<tbody>
				<tr>
					<td bgcolor="darkgreen" height="1px" width="100%"></td>
				</tr>
			</tbody></table>
		<table border="0px" cellspacing="0px" cellpadding="0px" width="100%" ID="Table6">
			<tbody>
				<tr>
					<td bgcolor="darkgreen" height="1px" width="100%"></td>
				</tr>
			</tbody></table>
		<!-- =======================================  -->

<br>
<body>
</html>

<?php
	exit();
}
?>

<script type="text/javascript" language="javascript">
//////////////////////////////////////////////////////
var admin_locus = "";
var server_locus = "";
var focus_locus = "";
var server_details_locus = "";
var spanID = "docpages";
var save_responder_element = "docpages";
var tree_locus = "";

var olData = null;

var g_group_rec_id = <?php echo $group_rec_id; ?>;
var g_s_i = <?php echo $serviceid; ?>;
var g_account_type = "<?php echo $g_account_type; ?>";

//////////////////////////////////////////////////////
</script>

	<script language="JavaScript" type="text/javascript" src="/hosted/js/jsresources.js"> </script>
	<script type="text/javascript" >
<?php 
	if ( isset($sess) ) {
?>
		var g_classydex_session_id = <?php echo $sess; ?>;
<?php 
	}
?>
		var featureList=["tab","panelbar","dimmer","dialog","window","mswin","rectwin","roundwin","tab","panelbar","ghostdrag","tree"];
	</script>
	<script language="javascript" type="text/javascript" src="/hosted/js/browserid.js"></script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/serverdata.js"></script>

	<script language="JavaScript" type="text/javascript" src="/hosted/js/oat/loader.js"></script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/infowindow.js"></script>
	<script type="text/javascript" language="JavaScript" src="/hosted/js/drupal_oat.js"></script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/classydex/classydex.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="/hosted/js/dimensions.js"> </script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/docjax.js"></script>
	<script language="javascript" type="text/javascript" src="/hosted/js/windowshades.js"></script>
	<script language="javascript" type="text/javascript" src="/hosted/js/content_type.js"></script>

	<script type="text/javascript" src="app2.js"></script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/rolled_oats_admin.js"></script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/trans_drupal/blockbar.js"></script>

	<script language="JavaScript" type="text/javascript" >
		g_application_group_menu_count = 8;
	</script>

	<link REL="stylesheet" TYPE="text/css" HREF="style2.css" TITLE="Style">
	<META NAME="Description" content="classified advertising with sections germain to green technology">
	<META NAME="keywords" content="classified ads buy and sell person to person advertising">
	<META NAME="robots" content="All">
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<title>User Editing Tools</title>

</head>



<!--  -->
<script type="text/javascript" language="javascript">



var g_date_holder = new Date();

var gHostbase = homevars.basic.toString();
gHostbase = gHostbase.substring(gHostbase.indexOf('//') + 2);
gHostbase = gHostbase.substring(0,gHostbase.lastIndexOf('/',gHostbase.lastIndexOf('/')-1)+1);

var gServiceBase = homevars.basic.toString();
gServiceBase =  gServiceBase.substring(gServiceBase.indexOf('//') + 2,gServiceBase.lastIndexOf('/'));
gServiceBase =  gServiceBase.substring(gServiceBase.lastIndexOf('/')+1);

var securityWindow = null;

var WELCOME_MESSAGE = "Welcome to Your<br>Copious Mail Center";
var SERVICE  = "Copious Mail";
var INFORMATION_MSGS  = "This is server bound mail";
var SITE_LOGIN_HANDLER = "communityconnect";
var SITE_WINDOW_VIEW = "div";
var SITE_USE_BACKNAV = false;
var SITE_LOGIN_RESULT = encodeURIComponents("mail/index.php");
var SITE_USE_CUSTOM_LOGO = false;



var loginScrn = "https://" + gHostbase + "index.php";
var countyLat =  "19.27376";
var countyLong = "-149.03476";
var countyStartZoom = 1;




/// Removed Login Opener



</script>

<!--
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAlh2xI8YCDMn3x7RGvkr_-hQAU1maTd0nj_B7oHhb_x6jUexdvhRr493pZ8Ms3tn5VV4YiBJapu9bDg"
      type="text/javascript"></script>
-->
<script language="JavaScript" type="text/javascript" src="/hosted/js/map_functions.js"> </script>




<body >
		<!-- ============================================================================================  -->
		<table width="100%" border="0" cellpadding="1px" cellspacing="0" ID="Table1">
			<tr>
				<td height="1px" style="background-color: darkgreen;" width="100%">
				</td>
			</tr>
		</table>
		<div style="height:75%;background-color: rgb(252, 252, 224);align:center;">
			<!-- ============================================================================================  -->
			<div align="center">
	<div style="border-top:darkgreen solid 2px;border-bottom:darkgreen solid 2px"> 
<table border="0" cellspacing="0" cellpadding="0"  width="100%" style="margin-top:2px;" >
<tr>
<td width="15%" style="clear:both;text-align:center;background-color:white;padding-top:2px">
<div  style="clear:both;" >
 &nbsp;  <a style="padding:0px;margin:0px;" href="http://<? echo $webhost; ?>/" title="Home"><img src="../img/smalllogo.jpg" alt="Home" /></a>
</div>
</td>
<td width="3%">&nbsp;</td>
<td width="35%">

<h1><a class="site-name title" style='padding-left:8px;' href="http://www.opensource-copious.org/">Tools for User <span class="theme_user_name"><?php echo $username; ?></span></a></h1>
</td>
<td width="2%">&nbsp;</td>
<td width="45%">
<div class="site-slogan" align='center' style='padding-right:8px;background-color:darkgreen'>
<a class="site-name title" style="color:gold" href="http://www.copious-systems.com/">Editing Tools</a><span style="margin-left:8px">[ Build it Here ]</span></div>
</td>
</tr>

</table>
</div>
			<!-- ============================================================================================  -->
			<table width="100%" border="0" cellpadding="1px" cellspacing="0" ID="Table5">
				<tr>
					<td height="1px" style="background-color: darkgreen;" width="100%">
					</td>
				</tr>
			</table>


<div id="tree" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
<td width="20%" valign="top" style="border:1px solid gold;" >
<div style="text-align:center;background-color:navy;color:gold;border:1px solid gold;font-weight:bold;font-size:1.2em" >Lists for Group <span id="spCurrentGroup">&lt;Everyone&gt;</span></div>


<!-- USER's OWNN -->
 <div class="content"><span id="block_bar_num" class="5"><div class="blockbar-title blockbar-2-title" onclick="blockbar_toggle('_block2_sub1','2')">      <div align="center" class="blockbar-head-img collapse" id="blockbarhead__block2_sub1">      </div>    <div class="blockbar-head blockbar-2-head" nowrap>Windows</div></div><div class="blockbar-content blockbar-2-content" id="_block2_sub1" style="display:none;">
<div class="menucontainer" style="width:95%" >

		<span class="menuItemTxt" id="mail_menu1" onclick="doMailMenu(1);" >
				&nbsp;Publications From Group:<span class="menuItemTitleTxt" id="mail_menu_span_1">bbb</span>
		</span><br>
		<hr color="navy">
		<span class="menuItemTxt" id="mail_menu2" onclick="doMailMenu(2);" >
				&nbsp;My Publications <span class="menuItemTitleTxt" id="mail_menu_span_2">bbb</span>
		</span><br>
		<hr color="navy">
		<span class="menuItemTxt" id="mail_menu3" onclick="doMailMenu(3);" >
				&nbsp;Members of Group <span class="menuItemTitleTxt" id="mail_menu_span_3">bbb</span>
		</span><br>
</div>
</div><div class="blockbar-title blockbar-2-title" onclick="blockbar_toggle('_block2_sub2','2')">      <div align="center" class="blockbar-head-img collapse" id="blockbarhead__block2_sub2">      </div>    <div class="blockbar-head blockbar-2-head" nowrap>Group Editing</div></div><div class="blockbar-content blockbar-2-content" id="_block2_sub2" style="display:none;">
<div class="menucontainer" style="width:95%" >

		<span class="menuItemTxt" id="mail_menu4" onclick="doMailMenu(4);" >
				&nbsp;Change Name of Group <span class="menuItemTitleTxt" id="mail_menu_span_4">bbb</span>
		</span><br>
		<hr color="navy">
		<span class="menuItemTxt" id="mail_menu5" >
				&nbsp;Group Member Editor
		</span>
		<hr color="navy">
		<span class="menuItemTxt" id="mail_menu6" onclick="save_groups();" >
				&nbsp;Save Groups
		</span>
</div>
</div><div class="blockbar-title blockbar-2-title" onclick="blockbar_toggle('_block2_sub3','2')">      <div align="center" class="blockbar-head-img collapse" id="blockbarhead__block2_sub3">      </div>    <div class="blockbar-head blockbar-2-head" nowrap>Editing Commands</div></div><div class="blockbar-content blockbar-2-content" id="_block2_sub3" style="display:none;">
<div class="menucontainer" style="width:95%" >
		<span class="menuItemTxt" id="mail_menu7" onmouseover="rollover(this);" onmouseout="rollout(this);">
				&nbsp;Create Content
		</span>
		<hr color="navy">
		<span class="menuItemTxt" id="mail_menu9" >
				&nbsp;Search for Content
		</span>
		<hr color="navy">
		<span class="menuItemTxt" id="mail_menu10" >
				&nbsp;Edit Content</span>
		</span>
		<hr color="navy">
		<span class="menuItemTxt" id="mail_menu11" >
				&nbsp;View Publications Marked for Deletion
		</span><br>
		<hr color="navy">
		<span class="menuItemTxt" id="mail_menu12" onclick="message_eraser();" >
				&nbsp;Erase Marked Publications Permenantly
		</span>
</div>
</div></span><span id=block_bar_panel2 class=3></span><span id=block_bar_sticky2 class=block_sticky></span><span id=block_bar_unique2 class=block_unique></span></div>
</div>


	</td>
	<td width="80%" valign="top" style="border:1px solid gold;margin-left:20px;" >
<style type="text/css" media="screen"><!--
		
-->
</style>

<div style="background-color:lightgray;border:solid 1px maroon">
<div id="helpBtn" class="buttonLike" style="float:left;text-align:center;vertical-align:middle;width:8%;margin-right:2px;margin-left:4px" >
	HELP
</div>
 <div id="groupDiv" align="center" >
	<table width="90%" border="1"  cellspacing="0"  cellpadding="0">
<tr>
<td id="groupTD1" class="groupstyles" width="12%" onclick="group_action(this,1);" ><?php echo $groups_array[0]; ?></td>
<td id="groupTD2" class="groupstyles" width="12%" onclick="group_action(this,2);" >&lt;<?php echo $groups_array[1]; ?>&gt;</td>
<td id="groupTD3" class="groupstyles" width="12%" onclick="group_action(this,3);" >&lt;<?php echo $groups_array[2]; ?>&gt;</td>
<td id="groupTD4" class="groupstyles" width="12%" onclick="group_action(this,4);" >&lt;<?php echo $groups_array[3]; ?>&gt;</td>
<td id="groupTD5" class="groupstyles" width="12%" onclick="group_action(this,5);" >&lt;<?php echo $groups_array[4]; ?>&gt;</td>
<td id="groupTD6" class="groupstyles" width="12%" onclick="group_action(this,6);" >&lt;<?php echo $groups_array[5]; ?>&gt;</td>
<td id="groupTD7" class="groupstyles" width="12%" onclick="group_action(this,7);" >&lt;<?php echo $groups_array[6]; ?>&gt;</td>
<td id="groupTD8" class="groupstyles" width="12%" onclick="group_action(this,8);" >&lt;<?php echo $groups_array[7]; ?>&gt;</td>
</tr>
<tr>
<td id="groupTD9" class="groupstyles" width="12%" onclick="group_action(this,9);" >&lt;<?php echo $groups_array[8]; ?>&gt;</td>
<td id="groupTD10" class="groupstyles" width="12%" onclick="group_action(this,10);" >&lt;<?php echo $groups_array[9]; ?>&gt;</td>
<td id="groupTD11" class="groupstyles" width="12%" onclick="group_action(this,11);" >&lt;<?php echo $groups_array[10]; ?>&gt;</td>
<td id="groupTD12" class="groupstyles" width="12%" onclick="group_action(this,12);" >&lt;<?php echo $groups_array[11]; ?>&gt;</td>
<td id="groupTD13" class="groupstyles" width="12%" onclick="group_action(this,13);" >&lt;<?php echo $groups_array[12]; ?>&gt;</td>
<td id="groupTD14" class="groupstyles" width="12%" onclick="group_action(this,14);" >&lt;<?php echo $groups_array[13]; ?>&gt;</td>
<td id="groupTD15" class="groupstyles" width="12%" onclick="group_action(this,15);" >&lt;<?php echo $groups_array[14]; ?>&gt;</td>
<td id="groupTD16" class="groupstyles" width="12%" onclick="group_action(this,16);" >&lt;<?php echo $groups_array[15]; ?>&gt;</td>
</tr>
	</table>
 </div>
</div>
<div class="statusReportStyle" id="statusMsg">
status: ready.
</div>
		<div style="max-height:600px;overflow:auto;">
<div class="form_header" >
<span id="form_instruct" class="sys_describe" >All Content Types Need a Title:<span id="title_search" style="visibility:hidden" ><input type="checkbox" id="search_title"></span><input id="sys_required-title" style="width:20%" > Please, enter Data Below.  </span><span id="form_instruct" class="sys_describe" > Then <span id="form_command" class="buttonLike" >save</span> it.</span> 
</div>
<div id="date_search" class="form_header" style="visibility:hidden;" >
&nbsp;<span class="search_date">From Date</span>&nbsp;<image src="/hosted/img/favicon.ico" id="search_lb_date" style="width:20px;height:20px;" title="pickdate">
<input  id="search_lb_value" type="text" value="">
<span class="search_date">To Date</span>&nbsp;<image src="/hosted/img/favicon.ico" id="search_ub_date" style="width:20px;height:20px;" title="pickdate">
&nbsp;<input  id="search_ub_value" type="text" value="">
</div>
<div style="margin:12px;padding:12px;text-align:center;width:98%">
<div id="urlselections" style="overflow:hidden" >
<!-- -->
<div id="formDepositorDiv" style="text-align:left;">
<div class="sys_describe" >
You may enter just some content in this field below. This data will not be classified as any type, and will be placed in a quickly expiring feed.
<br>In order to create special content elements, select from the editing commands, select a content type, and then a term classifying the content.
</div>
<textarea id="sys_required-default" style="width:90%" >

</textarea>


</div>

		</div>
	</td>
</tr>
</table>
</div>


<!-- My Places - car -->
<div id="helpDIV" class="topicclass"  >
<div   style="overflow:auto;background-color:white" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
<td width="65%" valign="top" style="border:1px solid gold;" >
<div class="helpText" >
	On this site you may place and view classified ads.
	<br>
	<p>
	In order to place an Ad, click on the button 'Post an Advertisement'.<br>
	Clicking the button will cause small window to open that will help you tie the selection of a category to a request for the form for the category.
	After selecting the category and clicking the button on the window screen a form will appear in the same window for enterying an ad.<br>
	Ads will appear on the level at which they are placed. So, if you want to be less specific about your placement or you cannot find a particular class 
	for your ad, then go ahead and put it on a higher level.
	</p>
	<p>
	In order to place see Ads, click on the button 'Search'.<br>
	Clicking the button will cause small window to open that will help you tie the selection of a categories to a request for the form for the ad entries.
	When ad entries come up, you may click on the entries to get further details about the ad.
	</p>
</div>
</td>
<td width="35%" valign="top" style="border:1px solid gold;" >
<div style="padding:12px" >
<img src="/hosted/img/logo.jpg" style="float:left">
This site is made possible by
<div><a href="http://www.copious-systems.com/" target="_blank">Copious Systems</a></div>
</div>
</td>
</tr>
</table>
</div>
</div>





<div id="topic1_1" class="topicclass" >
<div style="overflow:auto" >
	<table width="90%" cellspacing="10" cellpadding="4" border="0" >
		<tr>
			<td width="35%" height="400" class="messageBox"  style="overflow:scroll;height:60%" valign="top" >
				<div id="readerOuterWrapper" style="position:relative; overflow:auto;width:100%" >
					<span id="mailGroupReaderMsgsSpan" >
						<table  width="100%" cellspacing="1" cellpadding="0" border="0" >
							<tr>
							<td style="padding-left:16;border:2px solid lightblue;" onClick="selectMessages(this);">message 1</td></tr>
							<td style="padding-left:16;border:2px solid lightblue;" onClick="selectMessages(this);">message 2</td></tr>
							<td style="padding-left:16;border:2px solid lightblue;" onClick="selectMessages(this);">message 3</td></tr>
							<td style="padding-left:16;border:2px solid lightblue;" onClick="selectMessages(this);">message 4</td></tr>
						</table>
					</span>
				</div>
			</td>
			<td width="65%" align="left" valign="top" >

				<div style="height:30px;background-color:#EEFFF1;padding-bottom:10px;border:solid 1px darkgreen;">
					<table width="90%" cellspacing="10" cellpadding="1" border="0" >
						<tr>
							<td width="45%"  class="messageBoxControl" valign="middle" align="center" style="padding-top:2px;">
							 For COPY: Drag Icon to other Group <img id="messageCopyToken" src="bigM.jpg" width="24px" height="24px">
							</td>
							<td width="25%"  class="messageBoxControl" valign="middle" align="center" onClick="killMessage();" >
							Delete
							</td>			
							<td width="30%"  class="messageBoxControl" valign="middle" align="center" onClick="blockMember();" >
							BLOCK Sender
							</td>

						</tr>
					</table>
				</div>
				<br>
				<table width="100%">
					<tr>
					<td width="100%" align="left">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" >
						<tr>
							<td width="20%" valign="middle" align="left" style="padding-left:18;border:solid 1px blue;font-size:12;">
							<b>Sender</b>
							</td>
							<td width="20%" valign="middle" align="left" style="padding-left:18;border-top:solid 1px blue;border-bottom:solid 1px blue;font-size:12;">
							<b>Date</b>
							</td>
							<td width="60%" valign="middle" align="left" style="padding-left:18;border:solid 1px blue;font-size:12;">
							<b>Subject</b>
							</td>
						</tr>
						<tr>
							<td width="20%" valign="middle">
							<span id="mailGroupReaderSenderSpan" style="padding-left:8;padding-top:10;font-weight:bold;font-size:18;color:navy;" >&nbsp;</span>
							</td>
							<td width="20%" valign="middle">
							<span id="mailGroupReaderDateSpan" style="padding-left:8;padding-top:10;font-weight:bolder;font-size:12" >&nbsp;</span>
							</td>
							<td width="60%" valign="middle">
							<span id="mailGroupReaderSubjectSpan" style="padding-left:8;padding-top:10;font-weight:bolder;font-size:14;color:green;"  >&nbsp;</span>
							</td>
						</tr>
					</table>
					</td>
					</tr>
					<tr>
					<td width="100%" align="center">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" >
						<tr>
							<td width="50%" valign="middle">
							<span id="mailGroupReaderSenderSpan" style="padding-left:8;padding-top:10;font-weight:bold;font-size:18;color:navy;" >&nbsp;</span>
							</td>
							<td width="50%" valign="middle">
								<span id="mailGroupReaderAttachmentSpan" style="padding-left:8;padding-top:10;font-weight:bolder;font-size:12;color:navy;"  >
									&nbsp;
								</span>
							</td>
						</tr>
					</table>
					</td>
					</tr>
					<tr>
					<td width="100%" align="center">
<div style="text-align:justify;width:99%;text-decoration:none;font-weight:bold;font-size:12;color:004411;font-family:arial;padding:2; background-color:#FFF5E2;border: 1px navy solid" >
<span id="mailGroupReaderMessageSpan" >
The message text goes here
</span>
</div>
					</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>


</div>
</div>



<!-- My Places - business -->
<div id="topic1_2" class="topicclass"  >
<div style="overflow:auto" >


	<table width="99%" cellspacing="10" cellpadding="4" border="0" >
		<tr>
			<td width="35%" height="400" class="messageBox"  style="overflow:scroll;height:60%" valign="top" >
				<div id="sent_readerOuterWrapper" style="position:relative; overflow:auto;width:100%" >
					<span id="mailGroupReaderSentMsgsSpan" >
						<table  width="100%" cellspacing="1" cellpadding="0" border="0" >
							<tr>
							<td style="padding-left:16;border:2px solid lightblue;" onClick="selectSentMessages(this);">my message 1</td></tr>
							<td style="padding-left:16;border:2px solid lightblue;" onClick="selectSentMessages(this);">my message 2</td></tr>
							<td style="padding-left:16;border:2px solid lightblue;" onClick="selectSentMessages(this);">my message 3</td></tr>
							<td style="padding-left:16;border:2px solid lightblue;" onClick="selectSentMessages(this);">my message 4</td></tr>
						</table>
					</span>
				</div>
				<div width="25%"  class="messageBoxControl" valign="middle" align="center" onClick="killSentMessage();" >
				Delete Selected Message
				</div>			
				<div width="25%"  class="messageBoxControl" valign="middle" align="center"  >
					For COPY: Drag Icon to other Group <img id="sent_messageCopyToken" src="bigM.jpg" width="24px" height="24px">
				</div>			
			</td>
			<td width="65%" align="left" valign="top" >
				<table width="100%">
					<tr>
					<td width="100%" align="left">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" >
						<tr>
							<td width="20%" valign="middle" align="left" style="padding-left:18;border:solid 1px blue;font-size:12;">
							<b>Recipients</b>
							</td>
							<td width="20%" valign="middle" align="left" style="padding-left:18;border-top:solid 1px blue;border-bottom:solid 1px blue;font-size:12;">
							<b>Date</b>
							</td>
							<td width="60%" valign="middle" align="left" style="padding-left:18;border:solid 1px blue;font-size:12;">
							<b>Subject</b>
							</td>
						</tr>
						<tr>
							<td width="20%" valign="middle">
							<span id="sent_mailGroupReaderDateSpan" style="padding-left:8;padding-top:10;font-weight:bolder;font-size:12" >&nbsp;</span>
							</td>
							<td width="20%" valign="middle">
							<span id="sent_mailGroupReaderReceiversSpan" style="padding-left:8;padding-top:10;font-weight:bold;font-size:18;color:navy;" >&nbsp;</span>
							</td>
							<td width="60%" valign="middle">
							<span id="sent_mailGroupReaderSubjectSpan" style="padding-left:8;padding-top:10;font-weight:bolder;font-size:14;color:green;"  >&nbsp;</span>
							</td>
						</tr>
					</table>
					</td>
					</tr>
					<tr>
					<td width="100%" align="center">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" >
						<tr>
							<td width="50%" valign="middle">
							<span id="sent_mailGroupReaderSenderSpan" style="padding-left:8;padding-top:10;font-weight:bold;font-size:18;color:navy;" >&nbsp;</span>
							</td>
							<td width="50%" valign="middle">
								<span id="sent_mailGroupReaderAttachmentSpan" style="padding-left:8;padding-top:10;font-weight:bolder;font-size:12;color:navy;"  >
									&nbsp;
								</span>
							</td>
						</tr>
					</table>
					</td>
					</tr>
					<tr>
					<td width="100%" align="center">
<div style="text-align:justify;width:99%;text-decoration:none;font-weight:bold;font-size:12;color:004411;font-family:arial;padding:2; background-color:#FFF5E2;border: 1px navy solid" >
<span id="sent_mailGroupReaderMessageSpan" >
The message text goes here
</span>
</div>
					</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>

</div>
</div>

<!-- My Places - business -->
<div id="topic1_3" class="topicclass"  >
<div style="overflow:auto" >

<div id="mailGroupListSpan">
	<table  width="100%" cellspacing="1" cellpadding="0" border="0" >
		<tr>
		<tr><td style="padding-left:16;border:2px solid lightblue;" onClick="selectFriend(this);">my friend 1</td></tr>
		<tr><td style="padding-left:16;border:2px solid lightblue;" onClick="selectFriend(this);">my friend 2</td></tr>
		<tr><td style="padding-left:16;border:2px solid lightblue;" onClick="selectFriend(this);">my friend 3</td></tr>
		<tr><td style="padding-left:16;border:2px solid lightblue;" onClick="selectFriend(this);">my friend 4</td></tr>
		
	</table>
</div>
<div>
<table>
<tr>
	<td width="30%"  class="messageBoxControl" valign="middle" align="center" onClick="selectAllFriends();" >
	Select All
	</td>
	<td width="30%"  class="messageBoxControl" valign="middle" align="center" onClick="selectNoneFriends();" >
	Select None
	</td>
</tr>
</table>
</div>



</div>
</div>



<!-- My Places - business -->
<div id="topic1_4" class="topicclass"  >
<div style="overflow:auto" >

<div style="padding:12px;">
<br>
Change the name of this group: <span class="menuItemTitleTxt" style="color:darkred;" id="mail_menu_span_6">bbb </span> Please note: Only the name of group 'Everyone' cannot be changed.
<br><br>
To the name you type here: <input id="New-Group-Name" >
<br><br>
<span class="messageBoxControl" onclick="obj_change_group_name($('mail_menu_span_6'),$('New-Group-Name'))">Click here to change this group name</span>
<br><br>
</div>

</div>
</div>

<!-- My Places - business -->
<div id="topic1_5" class="topicclass"  >
<div style="overflow:auto" >
	<table width="90%" cellspacing="10" cellpadding="4" border="0" >
		<tr>
			<td  id="mailGroupEditorDivTable"  width="30%"  class="messageBox" valign="top">
				<div id="mailGroupEditorListSpan">
					<table  width="90%" cellspacing="1" cellpadding="0" border="0" >
						<tr>
						<td style="padding-left:16;border:2px solid lightblue;" onClick="selectEditFriend(this,1);">my friend 1</td></tr>
						<td style="padding-left:16;border:2px solid lightblue;" onClick="selectEditFriend(this,2);">my friend 2</td></tr>
						<td style="padding-left:16;border:2px solid lightblue;" onClick="selectEditFriend(this,3);">my friend 3</td></tr>
						<td style="padding-left:16;border:2px solid lightblue;" onClick="selectEditFriend(this,4);">my friend 4</td></tr>
					</table>
				</div>
			</td>
			<td  id="mailGroupEditorDivTable2"  width="70%" align="left" valign="top" >
				<table width="100%">
					<tr>
						<td width="25%" valign="top">
							&nbsp;
						</td>
						<td width="50%"  class="messageBoxControl" valign="middle" align="center" onClick="copyMember(event);" >
						Drag Icon to COPY this group member to another group  <img id="memberCopyToken" src="bigM.jpg" width="24px" height="24px"> 
						</td>
						<td width="25%" valign="top">
							<span id="mail_button6" class="messageBoxControl"  target="USERLIST" >List of Users</span>
						</td>
					</tr>
					<tr>
						<td width="25%" valign="top">
							&nbsp;
						</td>
						<td width="50%" id="group_promoter" class="messageBoxControl" valign="middle" align="center" >
						Promote this Group, <span id="mail_menu_span_5">gname</span>, to Public Status
						</td>
						<td width="25%" valign="top">
							&nbsp;
						</td>
					</tr>
				</table>


				<br><br><br>
				<form name="messageEntry" action="javascript:;" ID="messageEntry">
					<table width="100%">
						<tr><td width="100%" valign="top">
						<b><u>Enter Member Name</u>:</b>&nbsp;&nbsp;<input type="text" id="member_name" size="80" NAME="member_name">

						</td></tr>
					</table>
					<table width="60%">
						<tr>
						<td width="20%" valign="top">
							&nbsp;
						</td>
						<td width="20%" valign="top">
							<input type="reset" value="Clear" ID="Submit1" NAME="Submit1">
						</td>
						<td width="20%" valign="top">
							<input type="submit" value="Add Member" ID="Submit1" NAME="Submit1" onclick="javascript:AddMember();">
						</td>
						<td width="20%" valign="top">
							<input type="submit" value="Delete Member" ID="Submit1" NAME="Submit1" onclick="javascript:DeleteMember();">
						</td>
						<td width="20%" valign="top">
						</td>
						</tr>
					</table>
				</form>

			</td>
		</tr>

		<tr>
		<td>
			<table width="100%">
				<tr>
					<td width="60%" valign="top">
						&nbsp;
					</td>
					<td width="40%"  class="messageBoxControl" valign="middle" align="center" onClick="storeGroupEdit();" >
					store member data
					</td>
				</tr>
			</table>
		</td>
		
		<td  style="border-top: 1px dotted brown" >
			&lt;--- Please Note: Changes will not be stored until you click on "Store member data".
		</td>

		</tr>
	</table>
 

</div>
</div>



<!-- My Places - business -->
<div id="topic1_6" class="topicclass"  >
<div style="overflow:auto" >

<div id="usersobject" >
&nbsp;&nbsp;&nbsp;&nbsp;&lt;&lt;-----------------------------------------------------------------
</div>


</div>
</div>



<!-- My Places - business -->
<div id="topic1_7" class="topicclass"  >
<div style="overflow:auto" >

<table class="sys_table">
<tr>

<td class="sys_td" width="20%" >
<table class="sys_table" >
<?php

	global $content_type_display_kind;
	global $cts_call_count;
	global $vocabrenderop;
	global $RW;

	$RW = "W";
	$vocabrenderop = "filtered_taxo_pick";
	$cts_call_count = 0;
	$content_type_display_kind = "pushbutton";
	include "../taxonomy/content_type_selection.php";

?>
</table>
</td>

<td class="sys_td" width="70%" >
Select from the content type tree below in order to get an editing form:
<div id="content_type_area1" >

</div>
</td>

</tr>
</table>

</div>
</div>


<!-- My Places - business -->
<div id="topic1_8" class="topicclass"  >
<div style="overflow:auto" >
<div class="sys_describer" >
	Your user information will be the groups user information.
The group will be a user, and you will be able to log into the group. 
You may share your group password with other group members, your personal information will not be accessible through the group.
</div>

<div id="Completion" class="formEntry" >
		<form id="userdata"  name="userdata" ID="userdata" action="../makeaccount_groupdata.php" method="POST" >	
		<input type="submit" id="Submit1" size="60" value="submit information" NAME="Submit2">
		<br>
		<br>
			Members being copied from user's subgroup:  <span class="userinfo" ID="mail_menu_span_7" >a</span>
			<input type="hidden" NAME="group_origin" value="1" ID="mail_menu_span_8"  size="60" > 
			<input type="hidden" NAME="userid_origin" value="<?php echo $userid; ?>" size="60" > 
			<br>
			Enter a symbol for this group: <input style="width:60%" type="text" NAME="nu_symbolname" value="none" ID="nu_symbolname"  size="60" > 
			<br>
			First Name: <span class="userinfo" ID="nu_firstname_display" >a</span><input type="hidden" NAME="nu_firstname" value="none" ID="nu_firstname"  size="60" > 
			<br>
			Last Name :<span class="userinfo" ID="nu_lastname_display" >b</span><input type="hidden" NAME="nu_lastname" value="none" ID="nu_lastname"  size="60" > 
			<br>
			Postal: <span class="userinfo" ID="nu_postal_display" >c</span><input type="hidden" NAME="nu_postal" value="none" ID="nu_postal"  size="60" > 
			<br>
			City: <span class="userinfo" ID="nu_city_display" >d</span><input type="hidden" NAME="nu_city" value="none" ID="nu_city"  size="60" > 
			<br>
			State: <span class="userinfo" ID="nu_state_display" >e</span><input type="hidden" NAME="nu_state" value="none" ID="nu_state"  size="60" > 
			<br>
			Country: <span class="userinfo" ID="nu_country_display" >f</span><input type="hidden" NAME="nu_country" value="none" ID="nu_country"  size="60" > 
			<br>
			Postal Code: <span class="userinfo" ID="nu_zcode_display" >g</span><input type="hidden" NAME="nu_zcode" value="none" ID="nu_zcode"  size="60" > 
			<br>
			<span class="userinfo" ID="nu_phone_country_code_display" >h</span> <span class="userinfo" ID="nu_phone_area_code_display" >i</span><span class="userinfo" ID="nu_phone_primary_display" >j</span><span class="userinfo" ID="nu_phone_secondary_display" >k</span>

			<input type="hidden" NAME="nu_phone_country_code" value="none" ID="nu_phone_country_code"  size="60" > 
			<input type="hidden" NAME="nu_phone_area_code" value="none" ID="nu_phone_area_code"  size="60" > 
			<input type="hidden" NAME="nu_phone_primary" value="none" ID="nu_phone_primary"  size="60" > 
			<input type="hidden" NAME="nu_phone_secondary" value="none" ID="nu_phone_secondary"  size="60" > 
			<span class="userinfo" ID="nu_email_display" >l</span><input type="hidden" NAME="nu_email" value="none" ID="nu_email"  size="60" > 
			<!-- plus the following -->
			<input type="hidden"  NAME="SERVICE" value="<?php echo $SERVICE; ?>"  > 
			<input type="hidden"  NAME="servicedir" value="<?php echo $servicedir; ?>"  > 
			<input type="hidden"  NAME="serviceid" value="<?php echo $serviceid; ?>"  > 
			<input type="hidden"  NAME="hasQuestionaire" value="0"  > 

		</form>
</div>


</div>
</div>



<!-- My Places - business -->
<div id="topic1_9" class="topicclass"  >
<div style="overflow:auto" >


<table class="sys_table">
<tr>

<td class="sys_td" width="20%" >
<table class="sys_table" >
<?php

	global $content_type_display_kind;
	global $vocabrenderop;
	global $RW;

	$RW = "R";
	$vocabrenderop = "filtered_taxo_pick";
	$content_type_display_kind = "pushbutton";
	include "../taxonomy/content_type_selection.php";

?>
</table>
</td>

<td class="sys_td" width="70%" >
Select from the content type tree below in order to get a search form:
<div id="content_type_area2" >

</div>
</td>

</tr>
</table>


</div>
</div>





<!-- My Places - business -->
<div id="topic1_10" class="topicclass"  >
<div style="overflow:auto" >


<table class="sys_table">
<tr>

<td class="sys_td" width="20%" >
<table class="sys_table" >
<?php

	global $content_type_display_kind;
	global $vocabrenderop;
	global $RW;

	$RW = "W";
	$vocabrenderop = "filtered_taxo_pick";
	$content_type_display_kind = "pushbutton";
	include "../taxonomy/content_type_selection.php";

?>
</table>
</td>

<td class="sys_td" width="35%" >
Select from the content type tree below in order to get an editing form:
<div id="content_type_area3" >

</div>
</td>

<td class="sys_td" width="35%" >
List of items in this category which you may edit:
<div id="Publication_SelectionList" style="visibility:inherit;text-align:left;max-height:350px;overflow:auto;" >

</div>
</td>
</tr>
</table>

</div>
</div>



<!-- My Places - business -->
<div id="topic1_11" class="topicclass"  >
<div style="overflow:auto" >



	<table width="99%" cellspacing="10" cellpadding="4" border="0" >
		<tr>
			<td width="35%" height="400" class="messageBox"  style="overflow:scroll;height:60%" valign="top" >
				<div id="deleted_readerOuterWrapper" style="position:relative; overflow:auto;width:100%" >
					<span id="mailGroupReaderDeletedMsgsSpan" >
						<table  width="100%" cellspacing="1" cellpadding="0" border="0" >
							<tr>
							<td style="padding-left:16;border:2px solid lightblue;" onClick="selectDeletedMessages(this);">my message 1</td></tr>
							<td style="padding-left:16;border:2px solid lightblue;" onClick="selectDeletedMessages(this);">my message 2</td></tr>
							<td style="padding-left:16;border:2px solid lightblue;" onClick="selectDeletedMessages(this);">my message 3</td></tr>
							<td style="padding-left:16;border:2px solid lightblue;" onClick="selectDeletedMessages(this);">my message 4</td></tr>
						</table>
					</span>
				</div>
				<div width="25%"  class="messageBoxControl" valign="middle" align="center"  >
					For COPY: Drag Icon to other Group <img id="deleted_messageCopyToken" src="bigM.jpg" width="24px" height="24px">
				</div>			
			</td>
			<td width="65%" align="left" valign="top" >
				<table width="100%">
					<tr>
					<td width="100%" align="left">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" >
						<tr>
							<td width="20%" valign="middle" align="left" style="padding-left:18;border:solid 1px blue;font-size:12;">
							<b>Recipients</b>
							</td>
							<td width="20%" valign="middle" align="left" style="padding-left:18;border-top:solid 1px blue;border-bottom:solid 1px blue;font-size:12;">
							<b>Date</b>
							</td>
							<td width="60%" valign="middle" align="left" style="padding-left:18;border:solid 1px blue;font-size:12;">
							<b>Subject</b>
							</td>
						</tr>
						<tr>
							<td width="20%" valign="middle">
							<span id="Deleted_mailGroupReaderDateSpan" style="padding-left:8;padding-top:10;font-weight:bolder;font-size:12" >&nbsp;</span>
							</td>
							<td width="20%" valign="middle">
							<span id="Deleted_mailGroupReaderReceiversSpan" style="padding-left:8;padding-top:10;font-weight:bold;font-size:18;color:navy;" >&nbsp;</span>
							</td>
							<td width="60%" valign="middle">
							<span id="Deleted_mailGroupReaderSubjectSpan" style="padding-left:8;padding-top:10;font-weight:bolder;font-size:14;color:green;"  >&nbsp;</span>
							</td>
						</tr>
					</table>
					</td>
					</tr>
					<tr>
					<td width="100%" align="center">
					<table width="100%" border="0" cellspacing="0" cellpadding="0" >
						<tr>
							<td width="50%" valign="middle">
							<span id="Deleted_mailGroupReaderSenderSpan" style="padding-left:8;padding-top:10;font-weight:bold;font-size:18;color:navy;" >&nbsp;</span>
							</td>
							<td width="50%" valign="middle">
								<span id="Deleted_mailGroupReaderAttachmentSpan" style="padding-left:8;padding-top:10;font-weight:bolder;font-size:12;color:navy;"  >
									&nbsp;
								</span>
							</td>
						</tr>
					</table>
					</td>
					</tr>
					<tr>
					<td width="100%" align="center">
<div style="text-align:justify;width:99%;text-decoration:none;font-weight:bold;font-size:12;color:004411;font-family:arial;padding:2; background-color:#FFF5E2;border: 1px navy solid" >
<span id="Deleted_mailGroupReaderMessageSpan" >
The message text goes here
</span>
</div>
					</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>



</div>
</div>




<!-- My Places - business -->
<div id="topic1_12" class="topicclass"  >
<div style="overflow:auto" >



</div>
</div>



</body>
<script language="javascript" >
	add_group_to_array("Everyone",1);

<?php
	for ( $i = 1; $i < 16; $i++ ) {
		$ostr = $groups_array[$i];
		if ( $ostr != "&curren;" ) {
			echo "\tadd_group_to_array('$ostr',$i+1);\n";
		}
	}
?>
	set_current_group("Everyone");
// 
	$("member_name").value = "";
	clear_message_selection(0);
	clear_message_selection(1);
	clear_message_selection(2);
</script>
<script language="javascript" type="text/javascript" src="app3.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/cvt/cvtinterfaceinit.js"></script>

</html>
