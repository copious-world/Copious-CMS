<?php

/// THEMES

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


	<script language="JavaScript" type="text/javascript" src="/hosted/js/dimensions.js"> </script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/jsresources.js"> </script>
	<script type="text/javascript" >
		var featureList=["tab","panelbar","dimmer","dialog","window","mswin","rectwin","roundwin","tab","panelbar","ghostdrag","tree"];
	</script>

	<script type="text/javascript" language="JavaScript" src="/hosted/js/oat/loader.js"></script>
	<script type="text/javascript" language="JavaScript" src="/hosted/js/infowindow.js"></script>
	<script type="text/javascript" language="JavaScript" src="/hosted/js/drupal_oat.js"></script>
	<script type="text/javascript" language="javascript" src="/hosted/js/content_type.js"></script>
	<script type="text/javascript" src="app2.js"></script>
	<script type="text/javascript" language="JavaScript" src="/hosted/js/classydex/classydex.js"></script>
	
	<script language="JavaScript" type="text/javascript" src="/hosted/js/docjax.js"></script>
	<script language="javascript" type="text/javascript" src="/hosted/js/windowshades.js"></script>

	<script language="JavaScript" type="text/javascript" src="/hosted/js/rolled_oats_admin.js"></script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/trans_drupal/blockbar.js"></script>

	<script language="javascript" type="text/javascript" src="/hosted/js/tinymce/jscripts/tiny_mce/plugins/foreignkey/kbvariants.js"></script>
	<script language="javascript" type="text/javascript" src="/hosted/js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>


	<link REL="stylesheet" TYPE="text/css" HREF="style2.css" TITLE="Style">
	<META NAME="Description" content="classified advertising with sections germain to green technology">
	<META NAME="keywords" content="classified ads buy and sell person to person advertising">
	<META NAME="robots" content="All">
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">

	<title>Copious Themes</title>

</head>



<!--  -->
<script type="text/javascript" language="javascript">

g_theme_tinyMCE_settings = 
{
	mode : "exact",
	elements : "thm_topic1_1",
	theme : "advanced",
	width : "99%",
	height : "99%",
	plugins : "style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,foreignkey,oatdroptarget",
	theme_advanced_buttons1_add_before : "save,newdocument,separator",
	theme_advanced_buttons1_add : "fontselect,fontsizeselect,foreignkeys",
	theme_advanced_buttons2_add : "separator,insertdate,inserttime,preview,separator,forecolor,backcolor",
	theme_advanced_buttons2_add_before: "cut,copy,paste,pastetext,pasteword,separator,search,replace,separator",
	theme_advanced_buttons3_add_before : "tablecontrols,separator",
	theme_advanced_buttons3_add : "oattarget,emotions,iespell,media,advhr,separator,print,separator,ltr,rtl,separator,fullscreen",
	theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,|,code",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_path_location : "bottom",
	content_css : "example_full.css",
	plugin_insertdate_dateFormat : "%Y-%m-%d",
	plugin_insertdate_timeFormat : "%H:%M:%S",
	extended_valid_elements : "hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
	external_link_list_url : "example_link_list.js",
	external_image_list_url : "example_image_list.js",
	flash_external_list_url : "example_flash_list.js",
	media_external_list_url : "example_media_list.js",
	template_external_list_url : "example_template_list.js",
	file_browser_callback : "fileBrowserCallBack",
	theme_advanced_resize_horizontal : false,
	theme_advanced_resizing : true,
	nonbreaking_force_tab : true,
	hide_selects_on_submit : true,
	convert_on_click : true,
	relat2ive_urls : false,
	rem2ove_script_host : false
}




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
var SITE_LOGIN_RESULT = encodeURIComponents("themes/inuse.php");
var SITE_USE_CUSTOM_LOGO = false;



var loginScrn = "https://" + gHostbase + "index.php";
var countyLat =  "19.27376";
var countyLong = "-149.03476";
var countyStartZoom = 1;




/// Removed Login Opener



</script>


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

<h1><a class="site-name title" style='padding-left:8px;' href="http://www.opensource-copious.org/">Copious Themes</a></h1>
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
<div class="blockbar-title blockbar-2-title" onclick="blockbar_toggle('_block2_sub1','2')">      <div align="center" class="blockbar-head-img collapse" id="blockbarhead__block2_sub1">      </div>    <div class="blockbar-head blockbar-2-head" nowrap>Content Type Taxonomy Tree</div></div><div class="blockbar-content blockbar-2-content" id="_block2_sub1" style="display:none;">
<div class="menucontainer" style="width:95%" >

<div id="content_type_taxonomy" style="background-color:#FEEECC;padding:3px;max-height:350px;min-height:350px;">

Select a content type from the drop down menu titled, <span class="sys_describe">Content Type Selection</span>

</div>

</div>
</div>
<div class="blockbar-title blockbar-2-title" onclick="blockbar_toggle('_block2_sub2','2')">      <div align="center" class="blockbar-head-img collapse" id="blockbarhead__block2_sub2">      </div>    <div class="blockbar-head blockbar-2-head" nowrap>Administration</div></div><div class="blockbar-content blockbar-2-content" id="_block2_sub2" style="display:none;">
<div class="menucontainer" style="width:95%" >

<div id="OPS1" class="menutitle collapsed">Export as Business Front Page</div>
<div id="OPS3" class="menutitle collapsed">Store Content Type</div>
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
			<td id="statusMsg" style="text-align:right;width:20%;padding-right:20px;padding-top:2px;">
				<span class="buttonLike" style="height:60%" onclick="theme_editing_preview(this);">Preview and Target Editing</span>
			</td>
			<td style="text-align:center;width:40%;padding-top:2px;">
<span style="font-weight:bold;color:darkgreen" >Content Type Selection</span>
				<select id="select_content_type" onchange="var name = this.options[this.selectedIndex].value; content_type_vars(name);">
<?php
	global $content_type_display_kind;
	$content_type_display_kind = "options";
	include "../taxonomy/content_type_selection.php";
?>
				</select>
			</td>
			<td style="text-align:right;width:15%;padding-right:20px;padding-top:2px;">
				&nbsp;
			</td>
			</table>
		</div>

<div style="max-height:600px;overflow:auto;">
<div style="margin:8px;padding:3px;text-align:center;vertical-align:top;background-color:orange;width: 97%;border:solid 3px navy;">
<table width="99%">
<tr>
<td width="70%">
<div id="draw_area" style="width: 98%; height: 500px;border:solid 3px darkgreen;background-color:white;" >
<textarea id="thm_topic1_1" name="thm_topic1_1" style="width:100%;height:100%">

</textarea>
<div id="thm_topic1_1_preview" style="visibility:hidden;text-align:left" >

</div>

</div>



</td>
<td width="30%" style="vertical-align:top">
<div style="border:solid 1px brown;padding:2px;background-color:#FEFEEE">
Variables for the Selected Content Type
</div>
<div id="content_type_elements" style="width: 98%; min-height:400px; max-height:450px;overflow:auto;border:solid 3px darkgreen;background-color:white;text-align:left" >
Select a content type from the drop down menu. Some variables will appear for the content type. Others will appear when you click on the leaf of the content type taxonomy.

</div>

</td>
</tr>
</table>



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
	<form id="add_vocab" method="POST" action="asfront_page_theme.php" target="frontpagereport"
			onsubmit="return check_form_and_send(this,{ prefix: 'add_theme',
					 elements: [
							{id: 'name', required: true },
							{id: 'description', required: false },
							{id: 'help', required: false}
							]
						})">

		<span style="font-weight:bold" >Theme Name:</span> <input type="text" name="name" id="add_theme-name" ><br><br>
		<span style="font-weight:bold" >Description Text:</span><br>
		<textarea type="text" name="description" id="add_theme-description" style="width:80%" ></textarea><br><br>
		<span style="font-weight:bold" >Help Text:</span><br>
		<textarea type="text" name="help" id="add_theme-help" style="width:80%" ></textarea><br><br>
		<input type="submit" name="vocab_add" value="save">
	</form>
	</div>
</div>
</div>





<!-- My Places - business -->
<div id="topic1_3" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu6" >
	<div style="padding:8px;padding-left:20px;background-color:#EFEFEA;">
		<div>
			All forms types are stored as pre-forms either in files or in the database.
		</div>

		<div>
			Default Theme Form: <input type="checkbox" >
		</div>
		<div>
			Content Form: <input type="checkbox" >
		</div>
		<div>
			Search Form: <input type="checkbox" >
		</div>

		<span class="buttonLike" onclick="save_themes_and_forms();">Accept Themes and Forms</span>
	</div>
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


<div id="Topic_fieldDetails" class="topicclass" style="visibility:visible;">
<div style="overflow:auto" >
<table width="100%" class="sys_table">
<tr>
<td class="sys_td" width="100%" style='padding:8px' >
	<div class="sys_describe" >Field Name: <span id="oat_field_detail_name" class="oat_detail" style="width:40%">&nbsp;</span></div>
	<div class="sys_describe" >Field Type: <span id="oat_field_detail_type" class="oat_detail" style="font-weight:bold" class="sys_label" >type goes here</span></div>

	<div class="sys_describe" >Selected Term: 
	<span id="oat_field_detail_term" class="oat_detail" style="font-weight:bold" class="sys_label" >term goes here</span></div>
	<span id="oat_field_detail_target" style="visibility:hidden" >&nsbps;</span>
</td>
</tr>
<tr>
<td class="sys_td" width="100%" style='padding:8px' >
<div>
	<span class="buttonLike" onclick="supply_field_detail_substitutions();">Edit Substitutions</span>
	<span class="buttonLike" onclick="supply_field_detail_parameters();">Edit Parameters</span>
<span class="buttonLike" onclick="store_oat_detail_edits();">save edits</span>
</div>
	<div class="sys_describe" >Currently Editing: <span id="oat_field_detail_edit">nothing</span> </div>
	<textarea id="oat_field_detail_edit_area" style="width:80%;border:darkgreen solid 2px;padding:4px;">







	</textarea>
</td>

</tr>
</table>
</div>
</div>




<script language="javascript" >
tinyMCE.init(g_theme_tinyMCE_settings);
</script>

</body>
</html>
<script >
$('select_content_type').selectedIndex = 0;
</script>
