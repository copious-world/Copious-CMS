<?php

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

$sessionid = $_GET["sess"];

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
	<script type="text/javascript" src="/hosted/js/oat/loader.js"></script>
	<script type="text/javascript" src="/hosted/js/infowindow.js"></script>
	<script type="text/javascript" src="app.js"></script>
	<script type="text/javascript" src="classydex.js"></script>

	<link REL="stylesheet" TYPE="text/css" HREF="stylesheet.css" TITLE="Style">
	<link REL="stylesheet" TYPE="text/css" HREF="classydex.css" TITLE="Style">
	<link REL="stylesheet" TYPE="text/css" HREF="/hosted/copious_menus.css" TITLE="Style">
	<link rel="stylesheet" type="text/css" href="style.css" />
	<META NAME="Description" content="classified advertising with sections germain to green technology">
	<META NAME="keywords" content="classified ads buy and sell person to person advertising">
	<META NAME="robots" content="All">
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<title>CLASSYDEX: Copious Classifieds</title>

</head>
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

//////////////////////////////////////////////////////
</script>

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

var g_classydex_session_id = null;
<?php 
	if ( isset($sessionid) ) {
?>
var g_classydex_session_id = <?php echo $sessionid; ?>;
<?php 
	}
?>

var loginScrn = "https://" + gHostbase + "index.php";

var countyLat =  "19.27376";
var countyLong = "-149.03476";
var countyStartZoom = 1;


</script>

<script language="JavaScript" type="text/javascript" src="/hosted/js/dimensions.js"> </script>
<script language="JavaScript" type="text/javascript" src="/hosted/js/docjax.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/windowshades.js"></script>


<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAlh2xI8YCDMn3x7RGvkr_-hQAU1maTd0nj_B7oHhb_x6jUexdvhRr493pZ8Ms3tn5VV4YiBJapu9bDg"
      type="text/javascript"></script>
<script language="JavaScript" type="text/javascript" src="/hosted/js/map_functions.js"> </script>


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
							Copious Classifieds
							</div>
						<div id="titleSpot" style="font-family:'Helvetica';font-weight:700;font-size:1.9em;letter-spacing:3.5px;color: #000066;">
							CLASSYDEX
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
		<div style="text-align:center;background-color:darkgreen;color:gold;border:1px solid gold;font-weight:bold;font-size:1.2em" >Classifications</div>
		<div style="max-height:600px;overflow:auto;" onmouseout="node_remember(null);correctCatNames()">
		<ul id="tree_content">
<li>
<div style="margin-bottom:8px;font-weight:bold;width:80%;">
Click on one of the buttons below in order to get the classified index menu. If you are a member, you will get your custom index.
</div>
</li>
<li>
<div style="margin-bottom:8px;font-weight:bold">General Access: </div>
<span class="buttonLike" onclick="fetch_index(0)">All Public Listings</span>
</li>
<li>


<div style="margin-bottom:8px;font-weight:bold">Are you a member?</div>

<script language="javascript" >
	if ( Br == "IE" ) {
		document.writeln("<form id=\"linkLogin\" method=\"POST\" action=\"" + loginScrn + "\" target=\"LOGIN\" >");
	}
</script>

<script language="javascript" >
	if ( Br == "IE" ) {
		document.writeln("<span id=\"speciallinks\">");
		document.writeln("<input type=\"hidden\" name=\"WELCOME_MESSAGE\" value=\"" + (WELCOME_MESSAGE) + "\" >");
		document.writeln("<input type=\"hidden\" name=\"SERVICE\" value=\"" + (SERVICE) + "\" >");
		document.writeln("<input type=\"hidden\" name=\"INFORMATION_MSGS\" value=\"" + (INFORMATION_MSGS) + "\" >");
		document.writeln("<input type=\"hidden\" name=\"RELSERVICELOCUS\" value=\"" + gServiceBase + "\" >");
		document.writeln("<input type=\"hidden\" name=\"phpfile\" value=\"" + SITE_LOGIN_HANDLER + "\" >");
		document.writeln("<input type=\"hidden\" name=\"windowView\" value=\"" + SITE_WINDOW_VIEW + "\" >");
		document.writeln("<input type=\"hidden\" name=\"windowView\" value=\"" + SITE_WINDOW_VIEW + "\" >");
		document.writeln("<input  class=\"buttonLike\" style=\"margin-top:8px;\"  onclick=\"start_waiting_index();\"  type=\"submit\" value=\"Personal and Private Listings\" >");
		document.writeln("</span>");
	} else {
		document.writeln("<span onclick=\"start_waiting_index();loginopener();\"  class=\"buttonLike\" style=\"margin-top:8px;\"  >");
		document.writeln("Personal and Private Listings");
		document.writeln("</span>");
	}
</script>
<script language="javascript" >
	if ( Br == "IE" ) {
		document.writeln("</form>");
	}
</script>



</li>
<li>
<a href="http://www.copious-systems.com/" target="_blank" ><img src="/hosted/img/logo.jpg"></a>
</li>
		</ul>
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
				<span class="buttonLike" id="adBtn" onmouseover="titleStatus('adBtn')" onmouseout="resetTitleStatus()">Post an Advertisement</span>
			</td>
			<td style="text-align:center;width:20%">
				<span class="buttonLike" id="searchBtn" onmouseover="titleStatus('searchBtn')" onmouseout="resetTitleStatus()">Search</span>
			</td>
			<td style="text-align:center;width:20%">
				<a href="signup.php" target="_blank"  class="buttonLike" style="font-style:normal">
				<span id="sellerBtn" onmouseover="titleStatus('sellerBtn')" onmouseout="resetTitleStatus()">Make Money</span>
				</a>
			</td>
			<td  style="text-align:center;width:20%">
				<a href="http://www.sudokudots.com" target="_blank"  class="buttonLike" style="font-style:normal">
				<span id="coolLinkBtn" onmouseover="titleStatus('coolLinkBtn')" onmouseout="resetTitleStatus()">Cool Link</span>
				</a>
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

<div id="mapplacement" style="width: 100%; height: 400px;border:solid 1px lightgray;" >
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
		In order to post an advertisment, first click on an Ad category under the word 'Classification'.
		Then click on the button just below this text.
	</div>
	<div style="margin-left:20px;padding-top:10px;padding-bottom:10px;" >
	<span id="posterHitBtn" class="buttonLike">Post an Ad for the following category: Not Selected</span>
	</div>
	<div id="placementobject" >
	&nbsp;&nbsp;&nbsp;&nbsp;&lt;&lt;-----------------------------------------------------------------
	</div>
</div>
</div>

<!-- My Places - business -->
<div id="topic1_2" class="topicclass"  >
<div style="overflow:auto" >
	<div style="background-color:white;border: solid 2px navy;" >
	<div class="howto_message">
		You can search for information from more than one category at a time. Click on a category under the word "Classifications". To select more
than one category, hold down the ctrl key and click on several cateogries. Then click on the button below this text in order for the program 
to find entries for your.
	</div>
	<div style="margin-left:20px;padding-top:10px;padding-bottom:10px;" >
	<span id="searcherHitBtn" class="buttonLike" onmouseover="correctCatNames()">Fetch Ads from the following categories: Not Selected</span>
	&nbsp;&nbsp;&nbsp;&nbsp;<span id="specialSearchHitBtn" class="buttonLike" onclick="getSearchFilters('search_list')" onmouseover="correctCatNames()">Fetch advanced search options</span>
	</div>
	<div id="search_list" >
	&nbsp;&nbsp;&nbsp;&nbsp;&lt;&lt;-----------------------------------------------------------------
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

<!-- My Places - business -->
<div id="topic1_4" class="topicclass"  >
<div style="overflow:auto" >
	<div id="docpages" style="background-color:#FAFAFD;border: dotted 2px orange;" >

	Waiting for form from the database

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
	<span id="singleItemEntrySpan">&nbsp;TEST</span>
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

	try {
		set_page_map_type(G_SATELLITE_TYPE);
		mapManagerStart("mapplacement",countyLat,countyLong,countyStartZoom);
	} catch(e) {
	}
/**/

</script>

</html>
