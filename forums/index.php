<?php

/// User's Own

$leftLogo = "/hosted/img/logo.jpg";
$rightLogo = "/hosted/img/logo.jpg";


echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

include "../admin_header.php";

switch_db_connection("taxonomy");

$QQ = "SELECT id FROM vocabulary WHERE ( serviceid = $serviceid ) AND ( name = 'forums' )";
$forum_taxo_id = db_query_value($QQ);

switch_db_connection("copious");

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
	<script language="javascript" type="text/javascript" src="/hosted/js/browserid.js"></script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/serverdata.js"></script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/jsresources.js"> </script>

	<script type="text/javascript" >
		var featureList=["tab","panelbar","dimmer","dialog"];
	</script>

	<link REL="stylesheet" TYPE="text/css" HREF="/hosted/css/stylesheet.css" TITLE="Style">
	<link REL="stylesheet" TYPE="text/css" HREF="/hosted/css/classydex.css" TITLE="Style">
	<link REL="stylesheet" TYPE="text/css" HREF="/hosted/css/copious_menus.css" TITLE="Style">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<META NAME="Description" content="classified advertising with sections germain to green technology">
	<META NAME="keywords" content="classified ads buy and sell person to person advertising">
	<META NAME="robots" content="All">
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<title><?php echo $bus_appdir; ?> Forums</title>

</head>
<script type="text/javascript" language="javascript">

var g_forum_taxo_id = <?php echo $forum_taxo_id; ?>;
var g_classydex_session_id = <?php echo $sessionid; ?>;
var g_s_i = <?php echo $serviceid; ?>;
var g_account_type = "<?php echo $g_account_type; ?>";

//////////////////////////////////////////////////////
var admin_locus = "";
var server_locus = "";
var focus_locus = "";
var server_details_locus = "";
var spanID = "docpages";
var save_responder_element = "docpages";
var tree_locus = "";

var olData = null;

//////////////////////////////////////////////////////
</script>
	<script language="javascript" type="text/javascript" src="/hosted/js/oat/loader.js"></script>
	<script language="javascript" type="text/javascript" src="/hosted/js/infowindow.js"></script>
	<script language="javascript" type="text/javascript" src="/hosted/js/classydex/classydex.js"></script>
	<script language="javascript" type="text/javascript" src="/hosted/js/content_type.js"></script>
	<script language="javascript" type="text/javascript" src="app.js"></script>
<!--  -->
<script type="text/javascript" language="javascript">

var gHostbase = homevars.basic.toString();
gHostbase = gHostbase.substring(gHostbase.indexOf('//') + 2);
gHostbase = gHostbase.substring(0,gHostbase.lastIndexOf('/',gHostbase.lastIndexOf('/')-1)+1);

var gServiceBase = homevars.basic.toString();
gServiceBase =  gServiceBase.substring(gServiceBase.indexOf('//') + 2,gServiceBase.lastIndexOf('/'));
gServiceBase =  gServiceBase.substring(gServiceBase.lastIndexOf('/')+1);

var securityWindow = null;

var WELCOME_MESSAGE = "classydex: The Green E-commerce Market Place.";
var SERVICE  = "classydex";
var INFORMATION_MSGS  = "Your membership will help bring together forces that oppose global warming.";
var SITE_LOGIN_HANDLER = "communityconnect";
var SITE_WINDOW_VIEW = "div";
var SITE_USE_BACKNAV = true;
var SITE_LOGIN_RESULT = encodeURIComponent("classydex/inuse.php");
var SITE_USE_CUSTOM_LOGO = false;


var loginScrn = "https://" + gHostbase + "index.php";

var countyLat =  "19.27376";
var countyLong = "-149.03476";
var countyStartZoom = 1;


</script>

<script language="JavaScript" type="text/javascript" src="/hosted/js/dimensions.js"> </script>
<script language="JavaScript" type="text/javascript" src="/hosted/js/docjax.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/windowshades.js"></script>


<body>

	<div style="border-top:darkgreen solid 2px;border-bottom:darkgreen solid 2px"> 
		<table style="text-align: left; width: 100%; height: 49px;" border="0" cellpadding="0" cellspacing="0">
			<tbody>
				<tr>
					<td width="15%" height="49px" valign="middle" nowrap align="right" style="background-color:#fcfcc5;margin:0;">
						<img src="/hosted/img/intro.png" height="100%" width="200" align="right">
					</td>
					<td  width="15%" align="left" style="vertical-align: middle;background-color:#fcfcc5;margin:0;">
						<span style="font-family:Times;font-weight: bold;font-size:0.95em;color:black">
							<span id="datestr">02/20/06</span>
						</span>
					</td>
					<td  width="40%" align="center" style="vertical-align: middle;">
							<div style="color:gold;font-size:0.5em;font-family:'arial';letter-spacing:3.5px;background-color:navy">
							<?php echo $bus_appdir; ?> Forums
							</div>
						<div id="titleSpot" style="font-family:'Helvetica';font-weight:700;font-size:1.9em;letter-spacing:3.5px;color: #000066;">
							Forums
						</div>
						<a href="http://www.copious-systems.com/" style="text-decoration:none;" target="_blank">
							<div style="color:orange;font-size:0.5em;font-family:'arial';letter-spacing:3.5px;background-color:darkgreen">
							Green E-Commerce Market Place
							</div>
						</a>
					</td>
					<td width="15%" align="right" style="vertical-align: middle;background-color:#fcfcc5;margin:0;" >
						<span style="font-family:Times;font-weight: bold;font-size:0.95em;color:black">
							Time: <span id="timestr">00:00:00</span>
						</span>
					</td>
					<td width="15%" height="49px" valign="middle" nowrap align="left" style="background-color:#fcfcc5;margin:0;">
						<img src="/hosted/img/intro_right.png" height="100%" width="200" align="left">
					</td>
				</tr>
			</tbody>
		</table>
	</div>


<div id="tree" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
<td width="20%" valign="top" style="border:1px solid gold;" >
		<div style="text-align:center;background-color:darkgreen;color:gold;border:1px solid gold;font-weight:bold;font-size:1.2em" >Topics</div>
		<div style="max-height:600px;overflow:auto;" onmouseout="node_remember(null);correctCatNames()">
<div id="content_type_area" >

</div>
		</div>
	</td>
	<td width="80%" valign="top" style="border:1px solid gold;" >
		<div class="controlbar" >
			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
			<tr>
			<td  style="text-align:center;width:20%">
				<span class="buttonLike" id="helpBtn" onmouseover="titleStatus('helpBtn')" onmouseout="resetTitleStatus()">Help</span>
			</td>
			<td style="text-align:center;width:20%">
				<span class="buttonLike" id="adBtn" onmouseover="titleStatus('adBtn')" onmouseout="resetTitleStatus()">Post a Topic</span>
			</td>
			<td style="text-align:center;width:20%">
				<span class="buttonLike" id="searchBtn" onmouseover="titleStatus('searchBtn')" onmouseout="resetTitleStatus()">Search</span>
			</td>
			<td style="text-align:left;width:40%;backgroundColor:#FAFADD" >
Current Forum: <span id="forumTitle" class="forumTitle" ></span>
			</td>
			</tr>
			</table>
		</div>
		<div id="urlselections" class="navbar" >
			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
			<tr>
			<td style="text-align:right;width:50;padding-right:20px;padding-top:2px;">
				<img src="/sharedimages/goleft.jpg" style="cursor:pointer" onclick="goprev();">
			</td>
			<td style="text-align:left;width:50%;padding-left:20px;padding-top:2px;">
				<img src="/sharedimages/goright.jpg" style="cursor:pointer" onclick="gonexts();" >
			</td>
			</table>
		</div>
		<div style="max-height:600px;overflow:auto;">

<div id="searchResults" style="width: 100%; height: 400px;border:solid 1px lightgray;" >
</div>



		</div>
	</td>
</tr>
</table>
</div>


<div id="topic1_1" class="topicclass" >
<div style="overflow:auto" >

	<div style="background-color:white;border: solid 2px navy;" >
	<div class="howto_message">
		In order to post a topic, first click on an Topic category under the word 'Topics'.
		Then enter your information below.
		Then click on the button just below this text to submit it.
	</div>
	<div style="margin-left:20px;padding-top:10px;padding-bottom:10px;" >
	<span id="posterHitBtn" class="buttonLike">Post a Topic for the following category: <span id="posterForum" class="forumTitle" ></span></span>
	</div>
	<div class="forumFormContainer" >
	<form id="topic_submit_form"  method="POST" action="../forums/posttopic.php" target="postResponseLayer" >

<div class="forumPostEl" >
<span class="forumTitle forumTitleEl" >Title:</span><input id="topic_submit_title"  type="text" name="title" style="width:80%">
</div>
<br>
<div class="forumPostEl" >
<span class="forumTitle" >Topic Entry:</span><br>
<textarea id="topic_submit_entry"  name="entry" style="width:80%">
</textarea>
</div>

			<input id="topic_submit_term" type="hidden"  NAME="term" value=" "  > 
			<input id="topic_submit_taxo_id" type="hidden"  NAME="taxo" value="0"  > 


			<input type="hidden"  NAME="sess" value="<?php echo $sessionid; ?>"  > 
			<input type="hidden"  NAME="SERVICE" value="<?php echo $SERVICE; ?>"  > 
			<input type="hidden"  NAME="servicedir" value="<?php echo $servicedir; ?>"  > 
			<input type="hidden"  NAME="serviceid" value="<?php echo $serviceid; ?>"  > 
	</form>

	</div>
<br>


</div>
</div>



<!-- My Places - business -->
<div id="topic1_2" class="topicclass"  >
<div style="overflow:auto" >
	<div style="background-color:white;border: solid 2px navy;" >
	<div class="howto_message">
		Click on a category under the word "Topics". Then click on the button below this text in order for the program to find entries for you.
	</div>

<div style="margin-left:20px;padding-top:10px;padding-bottom:10px;" >
<span id="form_instruct" class="sys_describe" > Click this button to <span id="search_button" class="buttonLike" >SEARCH <span id="search_forum" class="forumTitle" >no forum selected </span></span> for the keyed fields below.</span> 
</div>

<div class="forumFormContainer" >

		<div style="max-height:600px;overflow:auto;">
<div class="form_header" >

<span id="form_instruct" class="forumTitle" >Search by Title:<span id="title_search" style="visibility:inherit" >
<input type="checkbox" id="include-search_form-title"></span><input id="search_form-title" style="width:20%" > </span>
</div>
<div id="date_search" class="form_header" style="visibility:inherit;" >
&nbsp;<span class="search_date">From Date</span>&nbsp;<image src="/hosted/img/favicon.ico" id="search_lb_date" style="width:20px;height:20px;" title="pickdate">
<input  id="search_lb_value" type="text" value="">
<span class="search_date">To Date</span>&nbsp;<image src="/hosted/img/favicon.ico" id="search_ub_date" style="width:20px;height:20px;" title="pickdate">
&nbsp;<input  id="search_ub_value" type="text" value="">
</div>
<div style="margin:12px;padding:12px;text-align:center;width:98%">
<div id="urlselections" style="overflow:hidden" >
<!-- -->
<div id="formDepositorDiv" style="text-align:left;">

<span id="form_instruct" class="forumTitle" >Use Key words:<span id="title_search" style="visibility:inherit" >
<input type="checkbox" id="include-search_form-keys"></span><input id="search_form-keys" style="width:20%" > </span>

</div>


		</div>
</div>

</div>
</div>

<!-- My Places - car -->
<div id="topic1_3" class="topicclass"  >
<div   style="overflow:auto;background-color:white" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
<td width="65%" valign="top" style="border:1px solid gold;" >
<div class="helpText" >
	On this site you may place and view classified ads.
	<br>
	<p>
	In order to place an Ad, click on the button 'Post a Topic'.<br>
	Clicking the button will cause small window to open that will help you tie the selection of a category to a request for the form for the category.
	After selecting the category and clicking the button on the window screen a form will appear in the same window for enterying an ad.<br>
	Ads will appear on the level at which they are placed. So, if you want to be less specific about your placement or you cannot find a particular class 
	for your ad, then go ahead and put it on a higher level.
	</p>
	<p>
	In order to see Ads, click on the button 'Search'.<br>
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

<!-- My Places - business -->
<div id="topic1_4" class="topicclass"  >
<div style="overflow:auto" >
	<div id="docpages" style="background-color:#FAFAFD;border: dotted 2px orange;" >

<iframe name="postResponseLayer" id="postResponseLayer" >
</iframe>

	</div>
</div>
</div>

<!-- My Places - business -->
<div id="topic1_5" class="topicclass"  >
<div style="overflow:auto" >
	<div id="searchResults" style="background-color:#FCFCFA;border: solid 2px orange;" >

	Waiting for entries from the database

	</div>
</div>
</div>

<div id="singleItemEntry" class="topicclass" style="visibility:visible;">
<div style="overflow:auto" >
	<div id="singleItemEntrySpan">&nbsp;</div>
<div>
<span id="contacterBtn" class="buttonLike" >contact poster</span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="commentBtn" class="buttonLike" >comments</span>
</div>

</div>
</div>



<div id="contactDiv" class="topicclass" style="visibility:inherited;">
<div style="left:0%;top:0%;" >
	<form name="contactForm" action="javascript:" method="post" ID="Form1">
		<!--     =============================================================           -->
		<br>
		<div style="width:99%;text-decoration:none;font-weight:bold;font-size:12;color:004411;font-family:arial;padding:2; background-color:#EFFFE2;border: 1px orange solid">
			<div style="width:99%;color:004411;font-family:arial;padding:3; background-color:#FFFFE9;
		border-top: 1px black solid;border-left: 1px navy solid;border-right: 1px orange solid;;border-bottom: 1px #EBEBE2 solid;">
				Send E-Mail to Poster about Advertisement:
			</div>
			&nbsp;&nbsp;<span id="contactDivTitle">&nbsp;</span>
		</div>
		<div style="width:99%;text-decoration:none;font-weight:bold;font-size:12;color:004411;font-family:arial;padding:2; background-color:#EDFFDA;border: 1px red solid">
			<table border="0" cellspacing="0" cellpadding="2" ID="Table4">
				<!--     =============================================================           -->
				<tr>
					<td width="60%" align="left" style="text-decoration:none;font-weight:bold;font-size:12;color:004411;">
						<div style="width:98%;color:004411;font-family:arial;padding:3; background-color:#FFFFE9;
		border-top: 1px black solid;border-left: 1px navy solid;border-right: 1px orange solid;;border-bottom: 1px #EBEBE2 solid;">
							Your Email Address:
						</div>
						&nbsp;&nbsp;<input type="text" id="contact_email_address" size="60" NAME="contact_email_address">
					</td>
					<td width="40%" align="left" style="text-decoration:none;font-weight:bold;font-size:12;color:004411;">
						<div style="width:98%;color:004411;font-family:arial;padding:3; background-color:#FFFFE9;
		border-top: 1px black solid;border-left: 1px navy solid;border-right: 1px orange solid;;border-bottom: 1px #EBEBE2 solid;">
							Your Phone:<br>
						</div>
						&nbsp;&nbsp;<input type="text" id="contact_number2" size="20" NAME="contact_number2">
				</tr>
				</tr>
			</table>
		</div>
		<div style="width:99%;text-decoration:none;font-weight:bold;font-size:12;color:004411;font-family:arial;padding:2; background-color:#EFF0c2;border: 1px purple solid">
			<div style="width:99%;color:004411;font-family:arial;padding:3; background-color:#FFFFE9;
		border-top: 1px black solid;border-left: 1px navy solid;border-right: 1px orange solid;;border-bottom: 1px #EBEBE2 solid;">
				Your Comments:
			</div>
			&nbsp;&nbsp;<TEXTAREA name="contact_comments" rows="3" cols="80" ID="contact_comments"></TEXTAREA>
		</div>
		<!--                -->
	<table border="0" cellspacing="0" width="100%" ID="Table5">
		<tbody>
			<tr>
				<td height="20px" width="33%" style="margin-top:4;margin-bottom:5px;" align="center">
					<a href="javascript:closeContact();" style="text-decoration:none;font-weight:bold;font-size:12;color:004411;font-family:arial;">
						<span style="padding-left:4; padding-right:4; background-color:#FFEFE2;border: 2px orange solid" onmouseover="rollover(this);" onmouseout="rollout(this);">
	cancel
				</span>
					</a>
				</td>
				<td height="20px" width="33%" style="margin-top:4;margin-bottom:5px;font-weight:bold;font-size:12;color:004411;font-family:arial;" align="center">
					<span style="padding-left:4; padding-right:4; background-color:#EFFFE2;border: 2px orange solid" onmouseover="rollover(this);" onmouseout="rollout(this);" onclick="sendClassiContact();">
	Make Contact
				</span>
				</td>
				<td height="20px" width="33%" style="margin-top:4;margin-bottom:5px;" align="center">
			</tr>
		</tbody>
	</table>
	</form>
</div>
</div>



</body>

<script language="javascript">

	g_monthoffset = 0;
	refreshEvents();

/**/

</script>

</html>
