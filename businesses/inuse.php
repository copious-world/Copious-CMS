<?php

/// BUSINESS

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
global $g_sname_depth;
$g_sname_depth = '..';
require_once("../admin_header.php");

global $g_caller;

$g_caller = "businesses/inuse.php";
$g_caller = crypt($g_caller,$g_caller_salt);

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

<script language="JavaScript" type="text/javascript" src="/hosted/js/serverdata.js"></script>
<script language="javascript" type="text/javascript" src="/hosted/js/browserid.js"></script>

<script type="text/javascript" language="javascript">
//////////////////////////////////////////////////////

var olData = null;
var g_business = "<?php echo $bus_appdir; ?>";

var gHostbase = homevars.basic.toString();
gHostbase = gHostbase.substring(gHostbase.indexOf('//') + 2);
gHostbase = gHostbase.substring(0,gHostbase.lastIndexOf('/',gHostbase.lastIndexOf('/')-1)+1);

var appDir = homevars.basic.toString();
appDir = appDir.substring(appDir.lastIndexOf('/',appDir.lastIndexOf('/')-1));
tree_locus = tree_locus.replace("@app",appDir);

var gServiceBase = homevars.basic.toString();
gServiceBase =  gServiceBase.substring(gServiceBase.indexOf('//') + 2,gServiceBase.lastIndexOf('/'));
gServiceBase =  gServiceBase.substring(gServiceBase.lastIndexOf('/')+1);

//////////////////////////////////////////////////////
</script>


	<script language="JavaScript" type="text/javascript" src="/hosted/js/jsresources.js"> </script>
	<script type="text/javascript" >
<?php 
	if ( isset($sessionid) ) {
?>
		g_classydex_session_id = <?php echo $sessionid; ?>;
<?php 
	}
?>
		var featureList=["tab","panelbar","dimmer","dialog","window","mswin","rectwin","roundwin","tab","panelbar","ghostdrag","tree"];
	</script>

	<script language="JavaScript" type="text/javascript" src="/hosted/js/oat/loader.js"></script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/infowindow.js"></script>
	<script type="text/javascript" language="JavaScript" src="/hosted/js/drupal_oat.js"></script>
	<script type="text/javascript" src="app2.js"></script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/classydex/classydex.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="/hosted/js/dimensions.js"> </script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/docjax.js"></script>
	<script language="javascript" type="text/javascript" src="/hosted/js/windowshades.js"></script>

	<script language="JavaScript" type="text/javascript" src="/hosted/js/rolled_oats_admin.js"></script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/trans_drupal/blockbar.js"></script>

	<script language="javascript" type="text/javascript" src="/hosted/js/tinymce/jscripts/tiny_mce/plugins/foreignkey/kbvariants.js"></script>
	<script language="javascript" type="text/javascript" src="/hosted/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<script language="javascript" >

function fileBrowserCallBack(field_name, url, type, win) {
	// This is where you insert your custom filebrowser logic
	alert("Example of filebrowser callback: field_name: " + field_name + ", url: " + url + ", type: " + type);

	// Insert new URL, this would normaly be done in a popup
	win.document.forms[0].elements[field_name].value = "someurl.htm";
}

</script>

	<link REL="stylesheet" TYPE="text/css" HREF="style2.css" TITLE="Style">
	<META NAME="Description" content="classified advertising with sections germain to green technology">
	<META NAME="keywords" content="classified ads buy and sell person to person advertising">
	<META NAME="robots" content="All">
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<title>Business Administration:  <?php echo $bus_appdir; ?> </title>

</head>

<!--  -->
<script type="text/javascript" language="javascript">

var gHostbase = homevars.basic.toString();
gHostbase = gHostbase.substring(gHostbase.indexOf('//') + 2);
gHostbase = gHostbase.substring(0,gHostbase.lastIndexOf('/',gHostbase.lastIndexOf('/')-1)+1);

var gServiceBase = homevars.basic.toString();
gServiceBase =  gServiceBase.substring(gServiceBase.indexOf('//') + 2,gServiceBase.lastIndexOf('/'));
gServiceBase =  gServiceBase.substring(gServiceBase.lastIndexOf('/')+1);

var securityWindow = null;

var WELCOME_MESSAGE = "Welcome to Your<br>Software Development Community";
var SERVICE  = "Open Source Copious";
var INFORMATION_MSGS  = "This is an open source software community";
var SITE_LOGIN_HANDLER = "communityconnect";
var SITE_WINDOW_VIEW = "div";
var SITE_USE_BACKNAV = false;
var SITE_LOGIN_RESULT = encodeURIComponents("businesses/inuse.php");
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


<h1><a class="site-name title" style='padding-left:8px;' href="http://www.opensource-copious.org/">Business <span class="businessdir"><?php echo $bus_appdir; ?></span> Administration (Authorized)</a></h1>
</td>
<td width="2%">&nbsp;</td>
<td width="45%">
<div class="site-slogan" align='center' style='padding-right:8px;'>
<a class="site-name title" style="color:gold;" href="http://www.copious-systems.com/">Copious Systems</a><span style="margin-left:8px"> [ On the Net  &curren; Off the Gridt  &curren; Safe and Secure ]</span></div>
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
		<div style="text-align:center;background-color:darkgreen;color:gold;border:1px solid gold;font-weight:bold;font-size:1.2em" >Menu</div>



 <div class="content">


<span id="block_bar_num" class="5">





<div class="blockbar-title blockbar-2-title" onclick="blockbar_toggle('_block2_sub2','2')">      <div align="center" class="blockbar-head-img collapse" id="blockbarhead__block2_sub2">      </div>    <div class="blockbar-head blockbar-2-head" nowrap>Administration</div></div><div class="blockbar-content blockbar-2-content" id="_block2_sub2" style="display:none;">
<div class="menucontainer" style="width:95%" >

<div id="OPS1" class="menutitle collapsed">Edit Basic Business Information</div>
<div id="OPS3" class="menutitle collapsed">Edit Business Book</div>
<div id="OPS4" class="menutitle collapsed">Theme Choices</div>
<div id="OPS5" class="menutitle collapsed">Business Features...</div>
<div id="OPS6" class="menutitle collapsed">Payment Processing</div>

<?php
	if ( $bus_appdir == "copious" ) {
?>
<div id="OPS7" class="menutitle collapsed">
<a href="/hosted/meta_business/inuse.php?sess=<?php echo $sess; ?>&appdir=taxonomy&busdir=<?php echo $bus_appdir; ?>&window_opener=subscribe"  style="text-decoration:none;color:darkgreen" target="METABUSINESS" >Meta Business Processing</a></div>
<?php
	}
?>
<div id="OPS8" class="menutitle collapsed">
	<a href="/hosted/taxonomy/inuse.php?sess=<?php echo $sess; ?>&appdir=taxonomy&busdir=<?php echo $bus_appdir; ?>&window_opener=subscribe"  style="text-decoration:none;color:darkgreen" target="BUSINESS_TAXONOMY" >Taxonomy Subscription</a>
</div>

</div>
</div>



</div></span><span id=block_bar_panel2 class=3></span><span id=block_bar_sticky2 class=block_sticky></span><span id=block_bar_unique2 class=block_unique></span></div>
</div>


	</td>
	<td width="80%" valign="top" style="border:1px solid gold;margin-left:20px;" >
		<div class="controlbar" style="background-color:lightgray;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
			<tr>
			<td  style="text-align:center;width:15%">
				<span class="buttonLike" id="helpBtn" onmouseover="titleStatus('helpBtn')" onmouseout="resetTitleStatus()">Help</span>
			</td>

<?php

$include_themes = true;
include "../admin_top_menu.php";

?>

			<td  style="text-align:center;width:15%">
<a href="javascript: var w = self.open('','LOGIN','width=900,height=420,resizeble,status'); w.focus();" title="Open the security window with buttons for display." class="buttonLike">Controls</a>
			</td>
			</tr>
			</table>
		</div>
		<div id="urlselections" class="navbar" >
			<table width="100%" border="0" cellspacing="0" cellpadding="0" >
			<tr>
			<td id="statusMsg" style="text-align:right;width:25%;padding-right:20px;padding-top:2px;">
				no message
			</td>
			<td style="text-align:right;width:25%;padding-right:20px;padding-top:2px;">
				<img src="/sharedimages/goleft.jpg" style="cursor:pointer" onclick="goprev();">
			</td>
			<td style="text-align:left;width:25%;padding-left:20px;padding-top:2px;">
				<img src="/sharedimages/goright.jpg" style="cursor:pointer" onclick="gonexts();" >
			</td>
			<td style="text-align:right;width:25%;padding-right:20px;padding-top:2px;">
				&nbsp;
			</td>
			</table>
		</div>
		<div style="max-height:600px;overflow:auto;">

<div style="margin:12px;padding:12px;text-align:center;width:98%">
<div id="urlselections" style="overflow:hidden" >

<div id="accounts" style="width: 98%; height: 400px;border:solid 1px lightgray;" >
<?php

global $g_responsive_table;
$g_responsive_table = "responsive";
include "business_details.php";

global $g_business_object;
global $g_business_focus;
$g_business_focus = $bus_appdir;
include "../accounttype/accounts.php";

?>
</div>

		</div>
	</td>
</tr>
</table>
</div>


<!-- My Places - business -->
<div id="topic_search" class="topicclass"  >
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
<div id="topic_help" class="topicclass"  >
<div   style="overflow:auto;background-color:white" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
<td width="65%" valign="top" style="border:1px solid gold;" >
<div class="helpText" >
	This Page provides tools that allow account types to be managed for your busines.
	<br>
	<p>
	The menu on the right provides access to several subwindows providing for the following operations:
	<ol>
		<li> Add an account type.</li>
		<li> Adjust permissions for the account type.</li>
		<li> Change the menus with regard to an account type.</li>
		<li> Drop an account type.</li>
	</ol>
	</p>
	<p>
	More help is available on each subwindow.
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
<div id="topic_published_taxo" class="topicclass"  >
<div style="overflow:auto" >
	<div id="taxoobject" style="background-color:#FCFCFA;border: solid 2px orange;" >

	Waiting for entries from the database

	</div>
</div>
</div>


<div id="topic1_1" class="topicclass" >
<div style="overflow:auto">
	<div id="menu1" class="form_container" >
<table width="100%">
<tr>
<td width="50%" style="vertical-align:top">
	<form id="populate_business_details" method="POST" action="populate_business_details.php" target="taxresponse"
			onsubmit="populate_roles();
						return check_form_and_send(this,{ prefix: 'edit_business',
						elements: [
								{id: 'url', required: true },
								{id: 'hasQuestionaire', required: false},
								{id: 'needs_form', required: false},
								{id: 'needs_approval', required: false},
								{id: 'needs_pay', required: false},
								{id: 'price', required: false},
								{id: 'questionaire_url', required: true },
								]
							});">

		<span style="font-weight:bold" >Service URL:</span> <input type="text" name="name" id="edit_business-url" ><br><br>

		<div style="border-bottom: 1px solid darkgreen;margin-top:4px">
		<span style="font-weight:bold" >Use Questionaire:</span>
		<input type="checkbox" checked name="needs_form"  id="edit_business-hasQuestionaire" >&nbsp;&nbsp;
		<span style="font-weight:bold" >Use Input Form:</span>
		<input type="checkbox" checked name="needs_form"  id="edit_business-needs_form" >&nbsp;&nbsp;
		<span style="font-weight:bold" >Require Administration Approval:</span>
		<input type="checkbox" name="needs_approval"  id="edit_business-needs_approval" >&nbsp;&nbsp;
		<span style="font-weight:bold" >Requires Payment:</span> <input type="checkbox" name="needs_pay"  id="add_accounttype-needs_pay" >
		</div>

		<div style="border-bottom: 1px solid darkgreen;margin-top:4px">
		<span style="font-weight:bold" >Questionaire Handler:</span> <input type="text" name="name" id="edit_business-questionaire_url" ><br><br>
		</div>

		<input type="submit" name="vocab_add" value="save">
		<input type="hidden" name="serviceid" value="<?php echo $serviceid; ?>">
	</form>
</td>

</tr>
</table>
	</div>

</div>
</div>
<?php

global $g_responsive_table;
$g_responsive_table = true;
include "populate_business_details.php";

?>
</div>



<!-- My Places - business -->
<div id="topic1_3" class="topicclass"  >
<div style="overflow:auto" >
<form id="bookform" method="POST" action="/hosted/themes/updateapppage.php" target="_blank" onsubmit="return prepare_business_theme_fields();">
<input type="submit" name="publishaction" value="make default">
<input type="submit" name="publishaction" value="new version">
<span class="buttonLike" onclick="preview_book_theme(this)">Preview</span>
<?php

	global $g_current_theme;
	include("bookprep.php");

?>
	<input type="hidden" name="busdir"  value="<?php echo $bus_appdir; ?>" >
	<input type="hidden" name="sess" value="<?php echo $sessionid; ?>" >
	<input type="hidden" name="appdir" value="<?php echo $appdir; ?>" >
	<input type="hidden" name="validkey" value="<?php echo $MYUNPUBLISHEDSECRET; ?>" >
</form>
</div>
</div>
<script language="javascript" >
tinyMCE.init(g_theme_tinyMCE_settings);
</script>



<!-- My Places - business -->
<div id="topic1_4" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu4" class="form_container" >
<form method="POST" action="http://<?php echo $webhost; ?>/hosted/themes/rebuild_output_theme.php" target="_blank" >
<table width="95%">
<tr>
<td width="20%" valign="top" >
<?php
	include("../themes/displays_themes.php");
?>
	<input type="hidden" name="busdir"  value="<?php echo $bus_appdir; ?>" >
	<input type="hidden" name="sess" value="<?php echo $sessionid; ?>" >
	<input type="hidden" name="appdir" value="<?php echo $appdir; ?>" >
	<input type="hidden" name="validkey" value="<?php echo $MYUNPUBLISHEDSECRET; ?>" >
</td>
<td width="80%"  valign="top" >
<div class="varexplainer">
These variables are updated in your pages.data file. They are used in setting the theme. You will not be able to
change these variables in the book editing area. In the book editing area, you may change fixed front page menu items,
content areas, and ad areas.
</div>
<?php

	global $replacers;

	$replacers = array();
	$replacers['@theme_var_DIRECTORY'] = $appdir;

	include("../themes/current_site_vars.php");

?>
</td>
</tr>
</table>
</form>
	</div>
</div>
</div>


<!-- My Places - business -->
<div id="topic1_5" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu5" class="form_container"  >
Business Features
	</div>
</div>
</div>


<!-- My Places - business -->
<div id="topic1_6" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu6" >
	&nbsp;&nbsp;&nbsp;&nbsp;&lt;&lt;-----------------------------------------------------------------
	</div>
</div>
</div>



<!-- My Places - business -->
<div id="topic1_7" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu6" >
<div class="message_type">
In order to subscribe to vocabularies, select the items below. If you want to own and manage a vocabulary,
then, click on the "Taxonomy" button and create a vocabulary to add to the list.
</div>
<form method="POST" action="../taxonomy/subscriber.php" target="BUSINESS_POST">
<input type="submit" value="subscribe to taxonomies" class="elegant_submit">
<?php
///include "../taxonomy/subscriptions.php";
?>
<input type="hidden" name="business" value="<?php echo $bus_appdir; ?>">
</form>
	</div>
</div>
</div>




</body>

<script language="javascript">
/*
	g_monthoffset = 0;
	refreshEvents();
*/



</script>
</html>
