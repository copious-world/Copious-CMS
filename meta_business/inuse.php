<?php
/// META BUSINESS

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

global $g_sname_depth;
$g_sname_depth = '..';
require_once("../admin_header.php");

if ( isset($_GET['narrowtaxo']) ) {
	$taxonomy_subset_only = $_GET['narrowtaxo'];
}

if ( isset($_GET['narrowaccount']) ) {
	$selected_account = $_GET['narrowaccount'];
}


switch_db_connection('taxonomy');
$QQ = "SELECT id FROM vocabulary WHERE name = 'rolled_oats'";
$rolled_oat_taxo_id = db_query_value($QQ);
switch_db_connection('copious');

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

<script type="text/javascript" language="javascript">
//////////////////////////////////////////////////////



var g_rolled_oat_taxonomy_name = "rolled_oats";
var g_rolled_oat_taxonomy = "<?php echo $rolled_oat_taxo_id; ?>";


var olData = null;

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

	<link REL="stylesheet" TYPE="text/css" HREF="style2.css" TITLE="Style">
	<META NAME="Description" content="classified advertising with sections germain to green technology">
	<META NAME="keywords" content="classified ads buy and sell person to person advertising">
	<META NAME="robots" content="All">
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">

	<title>Meta Business Processing</title>

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
var SITE_LOGIN_RESULT = encodeURIComponents("classydex/inuse.php");
var SITE_USE_CUSTOM_LOGO = false;



var loginScrn = "https://" + gHostbase + "index.php";
var countyLat =  "19.27376";
var countyLong = "-149.03476";
var countyStartZoom = 1;




/// Removed Login Opener



</script>


<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAlh2xI8YCDMn3x7RGvkr_-hQAU1maTd0nj_B7oHhb_x6jUexdvhRr493pZ8Ms3tn5VV4YiBJapu9bDg"
      type="text/javascript"></script>
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

<h1><a class="site-name title" style='padding-left:8px;' href="http://www.opensource-copious.org/">Meta Business Processing</a></h1>
</td>
<td width="2%">&nbsp;</td>
<td width="45%">
<div class="site-slogan" align='center' style='padding-right:8px;'>
<a class="site-name title" style="color:gold;" href="http://www.copious-systems.com/">Copious Systems</a><span style="margin-left:8px"> [ On the Net  &curren; Off the Grid  &curren; Safe and Secure ]</span></div>
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
<div class="blockbar-title blockbar-2-title" onclick="blockbar_toggle('_block2_sub1','2')">      <div align="center" class="blockbar-head-img collapse" id="blockbarhead__block2_sub1">      </div>    <div class="blockbar-head blockbar-2-head" nowrap>Content Type Admin</div></div><div class="blockbar-content blockbar-2-content" id="_block2_sub1" style="display:none;">
<div class="menucontainer" style="width:95%" >

<div id="OPS5" class="menutitle collapsed">Create a Content Type</div>

<div id="OPS8" class="menutitle collapsed">
	<a href="/hosted/rolledoats/inuse.php?sess=<?php echo $sess; ?>&appdir=rolledoats&busdir=<?php echo $bus_appdir; ?>"  style="text-decoration:none;color:darkgreen" target="ROLLED_OATS" >Rolled Oats</a>
</div>

</div>
</div>
<div class="blockbar-title blockbar-2-title" onclick="blockbar_toggle('_block2_sub2','2')">      <div align="center" class="blockbar-head-img collapse" id="blockbarhead__block2_sub2">      </div>    <div class="blockbar-head blockbar-2-head" nowrap>Administration</div></div><div class="blockbar-content blockbar-2-content" id="_block2_sub2" style="display:none;">
<div class="menucontainer" style="width:95%" >

<div id="OPS6" class="menutitle collapsed">Drop a Business</div>

</div>
</div>

</div></span>

<span id=block_bar_panel2 class=3></span><span id=block_bar_sticky2 class=block_sticky></span><span id=block_bar_unique2 class=block_unique></span></div>
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

$ommit_businesses = true;
$ommit_accounttype = true;
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

<div id="mapplacement" style="width: 98%; height: 400px;border:solid 1px lightgray;" >

<table class="sys_table" > <tr>
<td class="sys_td" style="width:50%" >

<div>
<form method="POST" action="business_ops" target="_blank">
<?php
include "mbusinesses.php"
?>
</form>
</div>

</td>
<td class="sys_td" style="width:50%" >

<div class="navbar sys_describe" style="padding-left:20px" >Select a content type for taxonomy editing</div>
<table class="sys_td"  style="width:100%" >
<?php
global $pick_action;
$content_type_display_kind ="pushbutton";
$pick_action =<<<EOLINK
var w = self.open("/hosted/taxonomy/inuse.php?sess=$sess&appdir=taxonomy&busdir=$bus_appdir&window_opener=editor&typeid=@content_type_id&focustypename=@content_type",'BUSINESS_TAXONOMY'); w.focus();
EOLINK;

include "../taxonomy/content_type_selection.php"
?>
</table>
</td>

</tr> </table>

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
<div id="topic_published_taxo" class="topicclass"  >
<div style="overflow:auto" >
	<div id="taxoobject" style="background-color:#FCFCFA;border: solid 2px orange;" >

	Waiting for entries from the database

	</div>
</div>
</div>



<!-- My Places - business -->
<div id="topic1_5" class="topicclass"  >
<div style="overflow:auto" >
	<div style="background-color:#FEFEAA;border-bottom:1px solid magenta;padding:3px">
		Every content type is some type of taxonomy. But, there are taxonomies which are not used for content types, but may be use for classifying content as for searching. Use of this form to create a taxonomy specifically as a content type.
	</div>
	<div id="menu4" class="form_container" >
	<form id="add_vocab" method="POST" action="addcontenttype.php" target="taxresponse"
			onsubmit="return check_form_and_send(this,{ prefix: 'add_vocab',
					 elements: [
							{id: 'name', required: true },
							{id: 'description', required: false },
							{id: 'help', required: false},
							{id: 'hierarchy', required: false},
							{id: 'relations', required: false},
							{id: 'multiple', required: false},
							{id: 'required', required: false},
							{id: 'tags', required: false},
							{id: 'weight', required: false}]
						})">

		<span style="font-weight:bold" >Vocabulary Name:</span> <input type="text" name="name" id="add_vocab-name" ><br><br>
		<span style="font-weight:bold" >Description Text:</span><br>
		<textarea type="text" name="description" id="add_vocab-description" style="width:80%" ></textarea><br><br>
		<span style="font-weight:bold" >Help Text:</span><br>
		<textarea type="text" name="help" id="add_vocab-help" style="width:80%" ></textarea><br><br>
		<div style="border-bottom: 1px solid darkgreen;margin-top:4px">
		<span style="font-weight:bold" >Has Hierarchy:</span>yes <input type="hidden" value="on" name="hierarchy"  id="add_vocab-hierarchy" >&nbsp;&nbsp;
		<span style="font-weight:bold" >Has Relations:</span>no <input type="hidden" value=""  name="relations"  id="add_vocab-relations" >&nbsp;&nbsp;
		<span style="font-weight:bold" >Multiple Hierarchy:</span>no <input type="hidden" value="" name="multiple"  id="add_vocab-multiple" >
		</div>
		<div style="border-bottom: 1px solid darkgreen;margin-top:4px">
		<span style="font-weight:bold" >Required for some content types:</span>yes<input type="hidden" value="on" name="required"  id="add_vocab-required" >
		</div>
		<div style="border-bottom: 1px solid darkgreen;margin-top:4px">
		<span style="font-weight:bold" >Tags:</span> <input type="checkbox" name="tags"  id="add_vocab-tags" >
		</div>
		<div style="border-bottom: 1px solid darkgreen;margin-top:4px">
		<span style="font-weight:bold" >Weight (real number [-1,1]):</span> <input type="text" name="weight" value="0.0"  id="add_vocab-weight" >
		</div>
		<input type="submit" name="vocab_add" value="save">
		<input type="hidden" value="<?php echo $sess; ?>" name="sess">
		<input type="hidden" value="<?php echo $bus_appdir; ?>" name="busdir">
	</form>
	</div>
</div>
</div>


<!-- My Places - business -->
<div id="topic1_6" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu5" class="form_container"  >
<table width="100%">
<tr>
<td width="50%" style="vertical-align:top">
<div class="sys_describe title_header" >
<table  width="100%"><tr><td width="33%"><div class="role_name" >Content Type Taxonomy</div></td><td width="33%"><div id="taxo_name" class="role_name" >none</div></td><td><input type="submit" value="save content type field declaration" onclick="save_content_type_tree()"></td></tr></table>
</div>
	<div id="taxonomy_content_div" class="form_container boxy" style="max-height:350px;overflow:auto;" >
		<ul id="current_content_type" >

		</ul>
	</div>
</td>
<td width="50%"  style="vertical-align:top;padding-top:8px;">
<div class="sys_describe title_header" >
Rolled Oats Components
</div>
<div id="oat_source" class="Form_tablist">

</div>
</td>
</tr>
</table>
	</div>
</div>
</div>


<!-- My Places - business -->
<div id="topic1_7" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu6" >
	&nbsp;&nbsp;&nbsp;&nbsp;&lt;&lt;-----------------------------------------------------------------
	</div>
</div>
</div>


<div id="Topic_fieldType" class="topicclass" style="visibility:visible;">
<div style="overflow:auto" >
<table width="100%" >
<tr>
<td width="50%" >
	<div class="sys_describe" >Field Name</div>
	<span style="font-weight:bold" class="sys_label" >Name:</span><input type="text" id="oat_field_detail_name" style="width:40%">

	<div class="sys_describe" >Field Type: The oat field type name from it's definition</div>
	<span id="oat_field_detail_type" style="font-weight:bold" class="sys_label" >type goes here</span>

	<div class="sys_describe" >Select Term: The term you clicked in the content type taxonomy</div>
	<span id="oat_field_detail_term" style="font-weight:bold" class="sys_label" >term goes here</span>

	<span class="buttonLike" onclick="edit_field_detail_substitutions();">Edit Substitutions</span>
	<span class="buttonLike" onclick="edit_field_detail_parameters();">Edit Parameters</span>

</td>
<td width="50%" >
	<div class="sys_describe" >Current Editing: <span id="oat_field_detail_edit">editing</span> <span class="buttonLike" onclick="store_oat_detail_edits();">store edits</span></div>
	<textarea id="oat_field_detail_edit_area" >
	</textarea>
</td>
</tr>
</table>
</div>
</div>


</body>

<script language="javascript">
/*
	g_monthoffset = 0;
	refreshEvents();

	try {
		set_page_map_type(G_SATELLITE_TYPE);
		mapManagerStart("mapplacement",countyLat,countyLong,countyStartZoom);
	} catch(e) {
	}
*/

</script>
</html>
