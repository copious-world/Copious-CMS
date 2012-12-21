<?php

/// TAXONOMY

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

<script type="text/javascript" language="javascript">
//////////////////////////////////////////////////////



var g_role_taxonomy = <?php echo $bus_focussed_roles; ?>;
var g_role_taxonomy_name = "<?php echo $bus_focussed_role_name; ?>";
var g_role_business_name = "<?php echo $role_bname; ?>";
var g_business = "<?php echo $bus_appdir; ?>";
var g_service_id = <?php echo $serviceid; ?>;
var g_contentype_taxo_array_from_db = "";
var g_selected_account_type = "SUPER";

var g_classydex_session_id = 0;
<?php 
	if ( isset($sessionid) ) {
?>
g_classydex_session_id = <?php echo $sessionid; ?>;
<?php 
	}
?>

<?php 
	if ( isset($selected_account) ) {
?>
g_selected_account_type = "<?php echo $selected_account; ?>";
<?php
	}

?>

var g_taxo_app_taxo_subset = false;
<?php 

	if ( isset($taxonomy_subset_only) ) {
?>
g_taxo_app_taxo_subset = "<?php echo $taxonomy_subset_only; ?>";
<?php
	}

?>

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
	<title>Taxonomy Administration Authorized</title>

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
var SITE_LOGIN_RESULT = encodeURIComponents("taxonomy/inuse.php");
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

<h1><a class="site-name title" style='padding-left:8px;' href="http://www.opensource-copious.org/">Taxonomy Administration (Authorized:
<span style="color:black;font-weight:bolder;font-size:0.70em;margin:2px;"><?php echo $bus_appdir; ?></span>)</a></h1>
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


<span id="block_bar_num" class="5"><div class="blockbar-title blockbar-2-title" onclick="blockbar_toggle('_block2_sub1','2')">      <div align="center" class="blockbar-head-img collapse" id="blockbarhead__block2_sub1">      </div>    <div class="blockbar-head blockbar-2-head" nowrap>Navigation</div></div><div class="blockbar-content blockbar-2-content" id="_block2_sub1" style="display:none;">
<div class="menucontainer" style="width:95%" >

		<ul id="menutree_1">

		</ul>
</div>
</div><div class="blockbar-title blockbar-2-title" onclick="blockbar_toggle('_block2_sub2','2')">      <div align="center" class="blockbar-head-img collapse" id="blockbarhead__block2_sub2">      </div>    <div class="blockbar-head blockbar-2-head" nowrap>Administration</div></div><div class="blockbar-content blockbar-2-content" id="_block2_sub2" style="display:none;">
<div class="menucontainer" style="width:95%" >

<div id="OPS1" class="menutitle collapsed">Add Vocabulary</div>
<div id="OPS2" class="menutitle collapsed">Vocabulary Term Editing</div>
<div id="OPS3" class="menutitle collapsed">Subscribe to Vocabulary</div>
<div id="OPS4" class="menutitle collapsed">Vocabulary to Content Type</div>
<div id="OPS5" class="menutitle collapsed">Drop Vocabulary</div>
<div id="OPS6" class="menutitle collapsed">Batch Vocabulary Operations</div>

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


<div id="topic1_1" class="topicclass" >
<div style="overflow:auto">
	<div id="menu1" class="form_container" >
	<form id="add_vocab" method="POST" action="addtaxonomy.php" target="taxresponse"
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
		<span style="font-weight:bold" >Has Hierarchy:</span> <input type="checkbox" checked name="hierarchy"  id="add_vocab-hierarchy" >&nbsp;&nbsp;
		<span style="font-weight:bold" >Has Relations:</span> <input type="checkbox" name="relations"  id="add_vocab-relations" >&nbsp;&nbsp;
		<span style="font-weight:bold" >Multiple Hierarchy:</span> <input type="checkbox" name="relations"  id="add_vocab-multiple" >
		</div>
		<div style="border-bottom: 1px solid darkgreen;margin-top:4px">
		<span style="font-weight:bold" >Required for some content types:</span> <input type="checkbox" checked name="required"  id="add_vocab-required" >
		</div>
		<div style="border-bottom: 1px solid darkgreen;margin-top:4px">
		<span style="font-weight:bold" >Tags:</span> <input type="checkbox" name="tags"  id="add_vocab-tags" >
		</div>
		<div style="border-bottom: 1px solid darkgreen;margin-top:4px">
		<span style="font-weight:bold" >Weight (real number [-1,1]):</span> <input type="text" name="weight" value="0.0"  id="add_vocab-weight" >
		</div>
		<input type="submit" name="vocab_add" value="save">

		<input type="hidden" name="bus_id" value="<?php echo $serviceid; ?>" >
	</form>
	</div>
</div>
</div>

<!-- My Places - business -->
<div id="topic1_2" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu2" >

<table width="100%">
<tr>
<td width="50%" style="vertical-align:top">
	<table  width="100%"><tr><td width="50%"><div id="taxo_name" class="taxon_name" >none</div></td><td><input type="submit" value="save taxonomy" onclick="save_taxonomy_tree()"></td><td><input type="submit" value="save taxonomy AS" onclick="save_taxonomy_tree_as()"></td></tr></table>
	<div id="taxonomy_content_div" class="form_container boxy" style="max-height:350px;overflow:auto;" >
		<ul id="current_taxonomy" >

		</ul>
	</div>
</td>
<td width="50%"  style="vertical-align:top">
	<table  >
	<tr>
	<td width="100%" class="form_container boxy" style="margin-bottom:4px">
		Enter a word: <input id="word_input_field" type="text"> <span id="wordsource">put word</span><span id="trashbucketContainer" class="trashbucket">trash bucket</span>
	</td>
	</tr>
	<tr>
	<td width="100%" class="form_container boxy" >
		Select a word from the list:
		<div style="margin-top:8px" >
		<span class="buttonLike" id="vocab_part_A" >A</span>
		<span class="buttonLike" id="vocab_part_B" >B</span>
		<span class="buttonLike" id="vocab_part_C" >C</span>
		<span class="buttonLike" id="vocab_part_D" >D</span>
		<span class="buttonLike" id="vocab_part_E" >E</span>
		<span class="buttonLike" id="vocab_part_F" >F</span>
		<span class="buttonLike" id="vocab_part_G" >G</span>
		<span class="buttonLike" id="vocab_part_H" >H</span>
		<span class="buttonLike" id="vocab_part_I" >I</span>
		<span class="buttonLike" id="vocab_part_J" >J</span>
		<span class="buttonLike" id="vocab_part_K" >K</span>
		<span class="buttonLike" id="vocab_part_L" >L</span>
		<span class="buttonLike" id="vocab_part_M" >M</span>
		<span class="buttonLike" id="vocab_part_N" >N</span>
		<span class="buttonLike" id="vocab_part_O" >O</span>
		<span class="buttonLike" id="vocab_part_P" >P</span>
		<span class="buttonLike" id="vocab_part_Q" >Q</span>
		<span class="buttonLike" id="vocab_part_R" >R</span>
		<span class="buttonLike" id="vocab_part_S" >S</span>
		<span class="buttonLike" id="vocab_part_T" >T</span>
		<span class="buttonLike" id="vocab_part_U" >U</span>
		<span class="buttonLike" id="vocab_part_V" >V</span>
		<span class="buttonLike" id="vocab_part_W" >W</span>
		<span class="buttonLike" id="vocab_part_X" >X</span>
		<span class="buttonLike" id="vocab_part_Y" >Y</span>
		<span class="buttonLike" id="vocab_part_Z" >Z</span>
		</div>
		<div style="margin-top:8px" >
		<span class="buttonLike" id="vocab_part_AA" >A</span>
		<span class="buttonLike" id="vocab_part_AB" >B</span>
		<span class="buttonLike" id="vocab_part_AC" >C</span>
		<span class="buttonLike" id="vocab_part_AD" >D</span>
		<span class="buttonLike" id="vocab_part_AE" >E</span>
		<span class="buttonLike" id="vocab_part_AF" >F</span>
		<span class="buttonLike" id="vocab_part_AG" >G</span>
		<span class="buttonLike" id="vocab_part_AH" >H</span>
		<span class="buttonLike" id="vocab_part_AI" >I</span>
		<span class="buttonLike" id="vocab_part_AJ" >J</span>
		<span class="buttonLike" id="vocab_part_AK" >K</span>
		<span class="buttonLike" id="vocab_part_AL" >L</span>
		<span class="buttonLike" id="vocab_part_AM" >M</span>
		<span class="buttonLike" id="vocab_part_AN" >N</span>
		<span class="buttonLike" id="vocab_part_AO" >O</span>
		<span class="buttonLike" id="vocab_part_AP" >P</span>
		<span class="buttonLike" id="vocab_part_AQ" >Q</span>
		<span class="buttonLike" id="vocab_part_AR" >R</span>
		<span class="buttonLike" id="vocab_part_AS" >S</span>
		<span class="buttonLike" id="vocab_part_AT" >T</span>
		<span class="buttonLike" id="vocab_part_AU" >U</span>
		<span class="buttonLike" id="vocab_part_AV" >V</span>
		<span class="buttonLike" id="vocab_part_AW" >W</span>
		<span class="buttonLike" id="vocab_part_AX" >X</span>
		<span class="buttonLike" id="vocab_part_AY" >Y</span>
		<span class="buttonLike" id="vocab_part_AZ" >Z</span>
		</div>

		<div id="word_list_placement"  style="margin-top:8px;max-height:350px;overflow:auto;" >
		</div>
	</td>
	</tr>
	</table>
</td>

</tr>
</table>

	</div>
</div>
</div>





<!-- My Places - business -->
<div id="topic1_3" class="topicclass"  >
	<div style="padding:8px;padding-left:20px;background-color:#EFEFEA;">
		<span class="buttonLike" onclick="subscribetaxonomies();">Subscribe to Selected Taxonomies</span>
	</div>
<div style="overflow:auto" >
	<div id="menu6" >
<?php
	$cc = urlencode("(serviceid = 0)");
	$url = "http://$webhost/hosted/taxonomy/taxodisplay.php?buttons=yes&appdir=$bus_appdir&condition=$cc";
	$output = file_get_contents($url);
	echo $output;
?>
	</div>
</div>
</div>



<!-- My Places - business -->
<div id="topic1_4" class="topicclass"  >
	<div style="padding:8px;padding-left:20px;background-color:#EFEFEA;">
		<span class="buttonLike" onclick="contenttypetaxonomies();">Select a Taxonomy to be a Content Type</span>
	</div>
<div style="overflow:auto" >
	<div id="menu6" >
<?php
	$url = "http://$webhost/hosted/taxonomy/taxocontenttypedisplay.php?buttons=yes&appdir=$bus_appdir&serviceid=$serviceid";
	$output = file_get_contents($url);
	echo $output;
?>
	</div>
</div>
</div>




<!-- My Places - busines
<div id="topic1_4" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu3" class="form_container" style="background-color:#AADDBF">
	<form id="map_vocab" method="POST" action="maptaxonomy.php" target="taxresponse"
			onsubmit="return check_form_and_send(this,{ prefix: 'map_vocab',
					 elements: [
							{id: 'vocabname', required: true },
							{id: 'appname', required: true },
							{id: 'markup_id', required: true},
							{id: 'label_form', required: false},
							{id: 'use_label_id', required: false},
						})">

		<span style="font-weight:bold" >Vocabulary Name:</span> <input type="text" name="name" id="map_vocab-vocabname" >
Type the name of the vocabulary.
<br><br>
		<span style="font-weight:bold" >Application Name:</span> <input type="text" name="name" id="map_vocab-appname" >
The name of the application for processing this vocabulary.
<br><br>

		<span style="font-weight:bold" >Target Markup Element ID:</span> <input type="text" name="name" id="map_vocab-markup_id" >
The id of the element that will contain the taxonomy. (If blank then [publish_taxo_html.php] will be used.)
<br><br>
		<span style="font-weight:bold" >Label Formula:</span><br>
Enter a form that shows the taxonomy term as a label. And that can be clicked for it to do something.
<br>
		<textarea type="text" name="help" id="map_vocab-label_form" style="width:80%" ></textarea><br><br>
		<div style="border-bottom: 1px solid darkgreen;margin-top:4px">
		<span style="font-weight:bold" >Use Label ID Array:</span> <input type="checkbox" name="use_label_id" checked  id="map_vocab-use_label_id" >
		</div>
	</form>
	</div>
</div>
</div>
 -->

<!-- My Places - business -->
<div id="topic1_5" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu4" class="form_container" >
	<form id="drop_vocab" method="POST" action="drop_vocabulary.php"
			onsubmit="return check_form_and_send(this,{ prefix: 'drop_vocab',
					 elements: [
							{id: 'name', required: true }
						})">

		<span style="font-weight:bold" >Type the name of the Vocabulary:</span>
		<input type="text" name="name" id="drop_vocab-name" >
		<input type="submit" name="dropper" value="erase vocabulary">

<input type="hidden" value="<?php echo $sess; ?>" name="sess">
<input type="hidden" value="<?php echo $bus_appdir; ?>" name="busdir">

		<br><br>
	</form>
	</div>
</div>
</div>


<!-- My Places - business -->
<div id="topic1_6" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu5" class="form_container"  >
		<div class="buttonLike" onclick="submit_taxo_request('build presupposition DB')">Build Presupposition Term DB</div>
		<div class="buttonLike" onclick="submit_taxo_request('import vocabulary definition')">Import Vocabulary Definition (Selected Vocabbulary)</div>
		<div class="buttonLike" onclick="submit_taxo_request('export vocabulary definition')">Export Vocabulary Definition (Selected Vocabbulary)</div>
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




<!-- My Places - business -->
<div id="taxotree_renamer" class="topicclass"  >
	<div id="menu6" >
	<div style="border:1px solid navy;background-color:lightyellow;font-weight:bold;color:navy;margin:2px;padding:3px;" >
	The current taxonomy name is: <span id='taxo_renamer_current_name' class="td_name" style="color:orange" >name here</span>
	</div>
	<div style="border:1px solid navy;background-color:#EFF8EF;font-weight:bold;color:navy;margin:2px;padding:3px;" >
	Enter the new name:<br> <input id='taxo_renamer_new_name' type="text" style="width:80%"> 
	</div>
	</div>
</div>



<div id="singleItemEntry" class="topicclass" style="visibility:visible;">
<div style="overflow:auto" >
	<span id="singleItemEntrySpan">&nbsp;TEST</span>
</div>
</div>


</body>

<script language="javascript">
<?php

$window_list = array(
	"subscribe" => "topic1_3W",
	"editor" => "topic1_2W"
);

if ( isset($_GET['typeid']) ) { /// start out at a parcticular type...

	$typeid = $_GET['typeid'];
	$focustypename= $_GET['focustypename'];

?>

////
INFOGROUP.focusOnVocabulary = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		pick_vocabulary('<?php echo $focustypename ?>','<?php echo $typeid ?>');
	}
}

<?php

}

if ( isset($_GET['window_opener']) ) {
	$which_window = $_GET['window_opener'];




	$which_window = $window_list[$which_window];
	if ( $which_window != "null" ) {
?>

////
INFOGROUP.openAtWindow = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		showWindowProc('<?php echo $which_window ?>');
	}
}

<?php
	}
}
?>
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
