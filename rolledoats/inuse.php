<?php

/// ROLLED OATS

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

	<title>Rolled Oats Repository</title>

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

<h1><a class="site-name title" style='padding-left:8px;' href="http://www.opensource-copious.org/">Rolled Oat Repository</a></h1>
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

<div class="blockbar-title blockbar-2-title" onclick="blockbar_toggle('_block2_sub2','2')">      <div align="center" class="blockbar-head-img collapse" id="blockbarhead__block2_sub2">      </div>    <div class="blockbar-head blockbar-2-head" nowrap>Administration</div></div><div class="blockbar-content blockbar-2-content" id="_block2_sub2" style="display:none;">
<div class="menucontainer" style="width:95%" >

<div id="OPS1" class="menutitle collapsed">Create Rolled OAT</div>
<div id="OPS2" class="menutitle collapsed">Rolled OAT Classification</div>
<div id="OPS3" class="menutitle collapsed">Edit Rolled Oat</div>
<div id="OPS4" class="menutitle collapsed">Manager Oat Library Functions</div>
<div id="OPS6" class="menutitle collapsed">Add Fields to Content Type</div>

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
	<form id="rolled_oat" method="POST" action="add_rolled_oat.php" target="rolled_oat"
			onsubmit="return( unclassify_new_oat($('rolled_oat-name').value) && check_form_and_send(this,{ prefix: 'rolled_oat',
					 elements: [
							{id: 'name', required: true },
							{id: 'javascript', required: true },
							{id: 'codepart', required: true },
							{id: 'cloneable', required: true },
							{id: 'datasource', required: false},
							{id: 'data_source_parameters', required: false},
							{id: 'remote', required: false},
							{id: 'valsource', required: false},
							{id: 'valparameters', required: false},
							{id: 'author', required: true},
							{id: 'author_email', required: true}
						]
						}))">

<div class="Form_tablist" >
<span class="buttonLike" id="TAB_1_1_1">main</span>
<span class="buttonLike" id="TAB_1_1_2">data function</span>
<span class="buttonLike" id="TAB_1_1_3">remote evaluation</span>
<span class="buttonLike" id="TAB_1_1_4">authorship</span>
</div>


<div id="rolled_oat_main" class="form_container_tab" >
		<span style="font-weight:bold" class="sys_label" >Name:</span><input type="text" name="name" id="rolled_oat-name" size="64" >
		<input type="submit" name="rolled_oat_add" value="save">
<br>
		<span style="font-weight:bold" class="sys_label" >cloneable:</span> <input type="checkbox" checked name="cloneable"  id="rolled_oat-cloneable" >&nbsp;&nbsp;This widget may be cloned
<br>
		<span style="font-weight:bold" class="sys_label" >has value:</span> <input type="checkbox" checked name="has_value"  id="rolled_oat-has_value" >&nbsp;&nbsp;This element returns a value&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<br>
		<input type="hidden" name="clone_index" value="0" >

		<span style="font-weight:bold" class="sys_label" >Javascript Code:</span> (Component Specific Javascript)
<div class="Form_tablist" >
<span class="buttonLike" id="TAB_1_1_5">Initialization and Limits</span>
<span class="buttonLike" id="TAB_1_1_6">Data Representation and Rendering</span>
<span class="buttonLike" id="TAB_1_1_7">Search Parameters</span>
</div>

<div id="rolled_oat_intial_limits" class="form_container_tab" >
<table class="sys_table" >
<tr>
<td class="sys_td" >
	<div style="font-weight:bold" class="sys_describe">
	The Initialization Function (cb)
	</div>
	<textarea type="text" name="javascript_cb" id="rolled_oat-javascript_cb" style="width:95%;font-size:1.1em;padding:2px;text-wrap:false;" rows="4">
// %component_initializer
default_initializer();
	</textarea>
</td>
<td class="sys_td" >
	<div style="font-weight:bold" class="sys_describe">
	Check limits or other web page available validity checking.
	</div>
	<textarea type="text" name="javascript_check_limits" id="rolled_oat-javascript_check_limits" style="width:95%;font-size:1.1em;padding:2px;text-wrap:false;" rows="4">
// %limit checker (returns true when it it's ok)
return(true);
	</textarea>
</td>
</tr>
</table>


<div class="sys_describe" >Here is a list of text variables which can be substituted in all HTML rendered as the result of this component. For each instance of the component, a user may specify values for these variables, when the user is designing a form.</div>
<span style="font-weight:bold" class="sys_label" >Substitution Variables:</span><br>
<input type="text" name="substitution_vars" id="rolled_oat-substitution_vars" style="width:80%;font-size:1.1em;padding:2px;text-wrap:false;" >

<div class="sys_describe" >Here is a list of form input element id's occuring in the form. These are named and should occur in the HTML of the next entry.</div>
<span style="font-weight:bold" class="sys_label" >Form Elements ID's:</span><br>
<input type="text" name="element_list" id="rolled_oat-element_list" style="width:80%;font-size:1.1em;padding:2px;text-wrap:false;" >



<div class="sys_describe" >This is HTML for containing the data from the Rolled OAT on a form. This element may contain substitution variables which are described as part of the parameters in field details.</div><span style="font-weight:bold" class="sys_label" >Form Elements and Description Text:</span><br>
<textarea type="text" name="element" id="rolled_oat-element" style="width:80%;font-size:1.1em;padding:2px;text-wrap:false;" rows="4">

</textarea>


</div>

<div id="rolled_oat_data_representation" class="form_container_tab" >
<table class="sys_table" >
<tr>
<td class="sys_td" >
	<div style="font-weight:bold" class="sys_describe">
	The representation of the data as it will be stored within the server.
	The default is to return nothing.
	</div>
	<textarea type="text" name="javascript_data_rep" id="rolled_oat-javascript_data_rep" style="width:80%;font-size:1.1em;padding:2px;text-wrap:false;" rows="4">
return("nothing");
	</textarea>

</td>
<td class="sys_td" >
	<div style="font-weight:bold" class="sys_describe">
	A function to be applied to render data derived from the the data representation. (Assume parameters: elid, val, outputform )
	</div>
	<textarea type="text" name="javascript_render_data" id="rolled_oat-javascript_render_data" style="width:80%;font-size:1.1em;padding:2px;text-wrap:false;" rows="4">
default_render(input);  //
	</textarea>
</td>
</tr>
</table>

<div class="sys_describe" >This is HTML for displaying the value of a form element.</div><span style="font-weight:bold" class="sys_label" >Presentation Text:</span><br>
<textarea type="text" name="presentation" id="rolled_oat-presentation" style="width:80%;font-size:1.1em;padding:2px;text-wrap:false;" rows="4">

</textarea>


</div>


<div id="rolled_oat_search_parameters" class="form_container_tab" >
<table class="sys_table" >
<tr>
<td class="sys_td" >
	<div style="font-weight:bold" class="sys_describe">
	JavaScript Components that will take the data entry 
	</div>
	<textarea type="text" name="javascript_searcher" id="rolled_oat-javascript_searcher" style="width:80%;font-size:1.1em;padding:2px;text-wrap:false;" rows="4">
// Components that will be used to take in parameters
	</textarea>
</td>
<td class="sys_td" >
	<div style="font-weight:bold" class="sys_describe">
	HTML components that will host the input components.
	</div>
	<textarea type="text" name="javascript_searcher_html" id="rolled_oat-javascript_searcher_html" style="width:80%;font-size:1.1em;padding:2px;text-wrap:false;" rows="4">
<!-- Java script code -->
	</textarea>
</td>
</tr>
</table>

</div>

<br><br>
<div style="font-weight:bold" class="sys_describe" >
If there is a URL containing javascript code for this component that must be included as a script entry on the page, enter it here.
</div>
<span style="font-weight:bold" class="sys_label" >required source url:</span><input type="text" name="required_source_url" id="rolled_oat-required_source_url" size="128" >

</div>
</div>

<div id="rolled_oat_datafunction" class="form_container_tab" >
	<div style="font-weight:bold" class="sys_describe">
	The name of a function which provides the data text for this component.
	</div>
	<span style="font-weight:bold" class="sys_label" >Data Source Function Name:</span>
	<input type="text" name="datasource" id="rolled_oat-datasource" size="128" value="rolled_oats_identity">
	<div style="font-weight:bold" class="sys_describe" >
	The text parameters needed by the datasource function for focusing. This should be in map syntax, e.g. key : value, key : value as in a JSON array.
	</div>
	<span style="font-weight:bold" class="sys_label" >Data Source parameters:</span><input type="text" name="data_source_parameters" id="rolled_oat-data_source_parameters" size="128" value="" >
</div>

<div id="rolled_oat_remoteeval" class="form_container_tab" >
	<div style="font-weight:bold"  class="sys_describe" >
	Set this to true if the OAT component will use a server based validity check, such as lisence number, credit card, etc.
	</div>
<span style="font-weight:bold" class="sys_label">remote:</span> <input type="checkbox" name="remote"  id="rolled_oat-remote" >&nbsp;&nbsp;Use remote evaluation.
<br>
	<div style="font-weight:bold"  class="sys_describe" >
	This is the URL that executes the validation.
	</div>
	<span style="font-weight:bold" class="sys_label">Validation Source:</span><input type="text" name="valsource" id="rolled_oat-valsource" size="128" value="">
<br>
	<div style="font-weight:bold"  class="sys_describe" >
	When required, this is a list of parameter value pairs passed to the URL.
	</div>
	<span style="font-weight:bold" class="sys_label" >Validation parameters:</span><input type="text" name="valparameters" id="rolled_oat-valparameters" size="128" value="">

</div>

<div id="rolled_oat_authorship" class="form_container_tab" >
	<div style="font-weight:bold"  class="sys_describe" >
	If you are the author of this Rolled OAT, please put your name here. Otherwise, enter the name of the actual author.
	</div>
	<span style="font-weight:bold" class="sys_label">Author Name:</span><input type="text" name="author" id="rolled_oat-author" size="128" value="">
<br>
	<div style="font-weight:bold"  class="sys_describe" >
	Please enter your e-mail for support and potential payment. Your e-mail will be kept private.
	</div>
	<span style="font-weight:bold" class="sys_label">Author E-mail:</span><input type="text" name="author_email" id="rolled_oat-author_email" size="128" value="">
</div>

<input type="hidden" value="<?php echo $sess; ?>" name="sess">
<input type="hidden" value="<?php echo $bus_appdir; ?>" name="busdir">

	</form>
	</div>
</div>
</div>
<script>
//
////
</script>


<!-- My Places - business -->
<div id="topic1_2" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu2" >
<table width="100%">
<tr>
<td width="50%" style="vertical-align:top">
	<table  width="100%"><tr><td width="50%"><div id="taxo_name" class="role_name" >none</div></td><td><input type="submit" value="save rolled oat classification" onclick="save_oat_classification_tree()"></td></tr></table>
	<div id="taxonomy_content_div" class="form_container boxy" style="max-height:350px;overflow:auto;" >
		<ul id="current_taxonomy" >

		</ul>
	</div>
</td>
<td width="50%"  style="vertical-align:top;padding-top:8px;">
		<span id="wordsource">put word</span><span id="trashbucketContainer" class="trashbucket">trash bucket</span>
<div class="sys_describe title_header" >
Unclassified Rolled Oats
</div>
<div class="Form_tablist"  id="oat_grid_container">
<?php
include "unclassified_oats.php";
?>
</div>
</td>

</tr>
</table>

	</div>
</div>
</div>






<!-- My Places - business -->
<div id="topic1_3" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu6" >
	<table  >
	<tr>
	<td width="100%" class="form_container boxy" >
		Select a rolled oat from the alphabetical lists:
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

		<div id="rolled_oat_list_placement2"  style="margin-top:8px;max-height:350px;overflow:auto;" >
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

<script language="javascript" >

<?php

include "rolled_oat_alpha_list.php"

?>
</script>


<!-- My Places - business -->
<div id="topic1_4" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu3" class="form_container" style="background-color:#AADDBF">
	<form id="rolled_oat_lib" method="POST" action="add_rolled_oat_lib.php" target="rolled_oat_lib"
			onsubmit="return( check_form_and_send(this,{ prefix: 'rolled_oat',
					 elements: [
							{id: 'name', required: true },
							{id: 'codepart', required: true },
							{id: 'infopart', required: false },
							{id: 'author', required: true},
							{id: 'author_email', required: true}
						]
						}))">

<div class="Form_tablist" >
<span class="buttonLike" id="TAB_1_2_1">main</span>
<span class="buttonLike" id="TAB_1_2_2">function</span>
<span class="buttonLike" id="TAB_1_2_3">authorship</span>
</div>


<div id="rolled_oat_lib_main" class="form_container_tab" >
		<span style="font-weight:bold" class="sys_label" >Name:</span><input type="text" name="name" id="rolled_oat_lib-name" size="64" >
		<input type="submit" name="rolled_oat_add" value="save">
<br>
		<span style="font-weight:bold" class="sys_label" >The Info function returns parameter checking arrays:</span> (This is an array with parameter checking routines. For examples, see copious_rolled_oats_lib)<br>
		<textarea type="text" name="infopart" id="rolled_oat_lib-infopart" style="width:80%;font-size:1.1em;padding:2px;text-wrap:false;" rows="5">
		</textarea>

</div>

<div id="rolled_oat_lib_function" class="form_container_tab" >
		<div class="sys_describe" >(This a function that returns HTML, either from substitution on OAT code text.)</div><span style="font-weight:bold" class="sys_label" >Component Specific Code:</span><br>
		<textarea type="text" name="codepart" id="rolled_oat_lib-codepart" style="width:80%;font-size:1.1em;padding:2px;text-wrap:false;" rows="20">

		</textarea>
</div>

<div id="rolled_oat_lib_authorship" class="form_container_tab" >
	<div style="font-weight:bold"  class="sys_describe" >
	If you are the author of this Rolled OAT Library function, please put your name here. Otherwise, enter the name of the actual author.
	</div>
	<span style="font-weight:bold" class="sys_label">Author Name:</span><input type="text" name="valsource" id="rolled_oat-author" size="128" value="">
<br>
	<div style="font-weight:bold"  class="sys_describe" >
	Please enter your e-mail for support and potential payment. Your e-mail will be kept private.
	</div>
	<span style="font-weight:bold" class="sys_label">Author E-mai:</span><input type="text" name="valparameters" id="rolled_oat-author_email" size="128" value="">
</div>

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
<td class="sys_td" width="20%" >
<table class="sys_table" >
<?php

	global $content_type_display_kind;
	global $cts_call_count;
	$cts_call_count = 0;
	$content_type_display_kind = "pushbutton";
	include "../taxonomy/content_type_selection.php";

?>
</table>
</td>
<td width="40%" style="vertical-align:top">
<div class="sys_describe title_header" >
<table  width="100%"><tr><td width="33%"><div class="role_name" >Content Type Taxonomy</div></td><td width="33%"><div id="taxo_name" class="role_name" >none</div></td><td><input type="submit" value="save content type field declarations" onclick="save_content_type_tree()"></td></tr></table>
</div>
	<div id="taxonomy_content_div" class="form_container boxy" style="max-height:350px;overflow:auto;" >
		<ul id="content_type_area1" >

		</ul>
	</div>
</td>
<td width="40%"  style="vertical-align:top;padding-top:8px;">
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
<?php include "load_classified_oats.php"; ?>
</script>
</html>
