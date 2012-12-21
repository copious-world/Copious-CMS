<?php

/// ACCOUNTTYPE

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";


require_once("../admin_header.php");


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

var olData = null;

var g_role_taxonomy = <?php echo $bus_focussed_roles; ?>;
var g_role_taxonomy_name = "<?php echo $bus_focussed_role_name; ?>";
var g_role_business_name = "<?php echo $role_bname; ?>";
var g_business = "<?php echo $bus_appdir; ?>";
var g_service_id = <?php echo $serviceid; ?>;

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
	<script language="JavaScript" type="text/javascript" src="/hosted/js/dimensions.js"> </script>
	<script type="text/javascript" >
		var g_classydex_session_id = 0;
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
	<script language="JavaScript" type="text/javascript" src="/hosted/js/drupal_oat.js"></script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/classydex/classydex.js"></script>
	<script language="javascript" type="text/javascript" src="/hosted/js/content_type.js"></script>
	<script src="app2.js" type="text/javascript"></script>
	

	<link REL="stylesheet" TYPE="text/css" HREF="style2.css" TITLE="Style">
	<META NAME="Description" content="classified advertising with sections germain to green technology">
	<META NAME="keywords" content="classified ads buy and sell person to person advertising">
	<META NAME="robots" content="All">
	<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
	<title>Account Type Administration Authorized</title>

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
var SITE_LOGIN_RESULT = encodeURIComponents("accounttype/inuse.php");
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

<h1><a class="site-name title" style='padding-left:8px;' href="http://www.opensource-copious.org/">Account Type Administration (Authorized:
<span style="color:black;font-weight:bolder;font-size:0.70em;margin:2px;"><?php echo $bus_appdir; ?></span>)</a></h1>
</td>
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

<div id="OPS1" class="menutitle collapsed">Add Account Type</div>
<div id="OPS2" class="menutitle collapsed">Account Type (Role Editing)</div>
<div id="OPS3" class="menutitle collapsed">Drop Account Type</div>

<div id="OPS4" class="menutitle collapsed">Content Types for Accounts</div>

<div id="OPS6" class="menutitle collapsed">Publish Account Types</div>
<div id="OPS7" class="menutitle collapsed">Users by Account Types</div>
<div id="OPS8" class="menutitle collapsed">Users Needing Approval</div>


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
global $g_show_menus;
$g_responsive_table = true;
$g_show_menus = false;
include "accounts.php";

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
	<form id="add_accounttype" method="POST" action="addaccounttype.php" target="taxresponse"
			onsubmit="populate_roles();
						return check_form_and_send(this,{ prefix: 'add_accounttype',
						elements: [
								{id: 'name', required: true },
								{id: 'description', required: false },
								{id: 'help', required: false},
								{id: 'needs_form', required: false},
								{id: 'needs_approval', required: false},
								{id: 'needs_pay', required: false},
								{id: 'price', required: false}]
							});">

		<span style="font-weight:bold" >Account type Name:</span> <input type="text" name="name" id="add_accounttype-name" ><br><br>
		<span style="font-weight:bold" >Description Text:</span><br>
		<textarea type="text" name="description" id="add_accounttype-description" style="width:80%" ></textarea><br><br>
		<div style="border-bottom: 1px solid darkgreen;margin-top:4px">
		<span style="font-weight:bold" >Use Input Form:</span> <input type="checkbox" checked name="needs_form"  id="add_accounttype-needs_form" >&nbsp;&nbsp;
		<span style="font-weight:bold" >Require Administration Approval:</span>
		<input type="checkbox" name="needs_approval"  id="add_accounttype-needs_approval" >&nbsp;&nbsp;
		<span style="font-weight:bold" >Requires Payment:</span> <input type="checkbox" name="needs_pay"  id="add_accounttype-needs_pay" >
		</div>

		<span style="font-weight:bold" >Help Text:</span><br>
		<textarea type="text" name="help" id="add_accounttype-help" style="width:80%" ></textarea><br><br>

		<div style="border-bottom: 1px solid darkgreen;margin-top:4px">
		<span style="font-weight:bold" >Account type Price:</span> <input type="text" name="price" id="add_accounttype-price" ><br><br>
		</div>
		<input type="submit" name="vocab_add" value="save">
		<input type="hidden" name="serviceid" value="<?php echo $serviceid; ?>">
		<input type="hidden" name="sess" value="<?php echo $sess; ?>">
		<input type="hidden"  id="add_accounttype-roles" name="roles" value="">
	</form>
</td>
<td width="50%" style="vertical-align:top">
	<table  >
	<tr>
	<td width="100%" class="form_container boxy" >
Existing account types:
		<div style="margin-top:8px" >
		<span class="buttonLike" id="acc_part_A" >A</span>
		<span class="buttonLike" id="acc_part_B" >B</span>
		<span class="buttonLike" id="acc_part_C" >C</span>
		<span class="buttonLike" id="acc_part_D" >D</span>
		<span class="buttonLike" id="acc_part_E" >E</span>
		<span class="buttonLike" id="acc_part_F" >F</span>
		<span class="buttonLike" id="acc_part_G" >G</span>
		<span class="buttonLike" id="acc_part_H" >H</span>
		<span class="buttonLike" id="acc_part_I" >I</span>
		<span class="buttonLike" id="acc_part_J" >J</span>
		<span class="buttonLike" id="acc_part_K" >K</span>
		<span class="buttonLike" id="acc_part_L" >L</span>
		<span class="buttonLike" id="acc_part_M" >M</span>
		<span class="buttonLike" id="acc_part_N" >N</span>
		<span class="buttonLike" id="acc_part_O" >O</span>
		<span class="buttonLike" id="acc_part_P" >P</span>
		<span class="buttonLike" id="acc_part_Q" >Q</span>
		<span class="buttonLike" id="acc_part_R" >R</span>
		<span class="buttonLike" id="acc_part_S" >S</span>
		<span class="buttonLike" id="acc_part_T" >T</span>
		<span class="buttonLike" id="acc_part_U" >U</span>
		<span class="buttonLike" id="acc_part_V" >V</span>
		<span class="buttonLike" id="acc_part_W" >W</span>
		<span class="buttonLike" id="acc_part_X" >X</span>
		<span class="buttonLike" id="acc_part_Y" >Y</span>
		<span class="buttonLike" id="acc_part_Z" >Z</span>
		</div>

		<div id="permission_list_placement1"  style="margin-top:8px;max-height:350px;overflow:auto;" >
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
<div id="topic1_2" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu2" >

<table width="100%">
<tr>
<td width="50%" style="vertical-align:top">
	<table  width="100%"><tr><td width="50%"><div id="taxo_name" class="role_name" >none</div></td><td><input type="submit" value="save roles" onclick="save_role_tree()"></td></tr></table>
	<div id="taxonomy_content_div" class="form_container boxy" style="max-height:350px;overflow:auto;" >
		<ul id="current_taxonomy1" >

		</ul>
	</div>
</td>
<td width="50%"  style="vertical-align:top">
	<table  >
	<tr>
	<td width="100%" class="form_container boxy" style="margin-bottom:4px">
		<span id="wordsource">put word</span><span id="trashbucketContainer" class="trashbucket">trash bucket</span>
	</td>
	</tr>
	<tr>
	<td width="100%" class="form_container boxy" >
		Select an account type from the alphabetical lists:
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

		<div id="permission_list_placement2"  style="margin-top:8px;max-height:350px;overflow:auto;" >
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
<div style="overflow:auto" >
	<div id="menu4" class="form_container" >
	<form id="drop_accounttype" method="POST" action="javascript:"
			onsubmit="return check_form_and_send(this,{ prefix: 'drop_accounttype',
					 elements: [
							{id: 'name', required: true }
						})">

		<span style="font-weight:bold" >Type the name of the account:</span> <input type="text" name="name" id="drop_accounttype-name" ><br><br>
	</form>
	</div>
</div>
</div>


<!-- My Places - business -->
<div id="topic1_4" class="topicclass"  >
<div style="overflow:auto" >


<table class="sys_table">
<tr>

<td class="sys_td" width="20%" >
<table class="sys_table" >
<?php
	global $cts_call_count;
	$cts_call_count = 2;

	global $content_type_display_kind;
	$content_type_display_kind = "pushbutton";

	include "../taxonomy/content_type_selection.php";

?>
</table>
</td>

<td class="sys_td" width="35%" >
<div class="form_container_tab" style="border:1px solid gold">
<table>
<tr>
<td  class="sys_describe" style="width:60%;padding:3px;" >
Select from the content type tree below in order to get an editing form:
</td>
<td style="width:40%;padding:3px;">
<span class="buttonLike" onclick="store_account_content_types();">Store Content Type Access</span>
</td>
</tr>
</table>
</div>
<div id="content_type_area3" >

</div>
</td>

<td class="sys_td" width="35%" >
List of Account Types to Apply to the Tree Selection:
<div id="Publication_SelectionList" style="visibility:inherit;text-align:left;max-height:350px;overflow:auto;" >
<?php

global $g_responsive_table;
global $g_business_focus;
global $g_show_menus;
global $g_account_drop_targets;
global $g_prefix;

$g_responsive_table = "content_type";
$g_business_focus = $bus_appdir;
$g_show_menus = false;
$g_account_drop_targets = false;
$g_prefix = "ct_";
include "../accounttype/accounts.php";
unset($g_prefix);
?>
</div>
</td>
</tr>
</table>

</div>
</div>



<script type="text/javascript" language="javascript">
var g_taxo_array_from_db = null;
</script>
<!-- My Places - business -->
<div id="topic1_6" class="topicclass"  >
<div style="overflow:auto" >
	<div id="menu2" >

<table width="100%">
<tr>
<td width="90%" class="form_container boxy" style="margin-bottom:4px">
	<form action="publish_accounts.php" method="POST" target="self">
		<div style="border-bottom:2px gray solid;">
	
			<div style="float:left;margin-right:18px;margin-bottom:18px;" >
			<input type="submit" value="publish changes" name="accpublisher" > 
			</div>
			<span style="font-weight:bold;margin-bottom:18px;" >Account Type Selection:</span> Select for Publication.
	
		</div>

		<div id="account_type_selector"  style="clear:left;margin:8px;max-height:350px;overflow:auto;" >
<?php

global $g_responsive_table;
global $g_business_focus;
global $g_show_menus;
global $g_account_drop_targets;

$g_responsive_table = "publisher";
$g_business_focus = $bus_appdir;
$g_show_menus = false;
$g_account_drop_targets = true;
include "../accounttype/accounts.php";

?>
		</div>
		<input type="hidden" name="serviceid" value="<?php echo $serviceid; ?>">
		<input type="hidden" name="bfocus" value="<?php echo $g_business_focus; ?>">
	</form>
</td>
</tr>
</table>

	</div>
</div>
</div>
<script type="text/javascript" language="javascript">
		INFOGROUP.topic_account_sources = {
			needs:["window"],
			wind: null,
			save_width: 0,
			dontOpen: false,
			app_action: null,
			cb:function() {
				if ( ( g_account_drop_complex != null ) && ( g_taxo_array_from_db != null ) ) {
					var dummyReference = function() {};
					var n = g_taxo_array_from_db.length;
					for ( var i = 0; i < n; i++ ) {
						var taxname = g_taxo_array_from_db[i];
						$(taxname).style.cursor = "pointer";
						var successReference = function(target, x, y) { target.value = $(taxname).innerHTML; }
						g_account_drop_complex.addSource(taxname, dummyReference, successReference);
					}
				}
			}
		}
</script>


<!-- My Places - business -->
<div id="topic1_7" class="topicclass"  >
<div style="overflow:auto" >
	<div id="user_list_placement" >

	</div>
</div>
</div>



<!-- My Places - business -->
<div id="topic1_8" class="topicclass"  >
<div style="overflow:auto" >
<table>
<tr>
<td width="40%">
<form action="../accounttype/approveusers.php" method="POST" target="_aprepframe" onsubmit="return confirm('You are giving access to these users for their requested account types.');">
	<div id="user_approval_placement" >

	</div>
<input type="hidden" name="sess" value="<?php echo $sess;?>">
<input type="submit" value="approve selected users" name="approveit">
</form>
</td>
<td>
<iframe name="_aprepframe" id="_aprepframe" >
TEST
</iframe>
</td>
</tr>
</table>
</div>
</div>



<div id="singleItemEntry" class="topicclass" style="visibility:visible;">
<div style="overflow:auto" >
	<span id="singleItemEntrySpan">&nbsp;TEST</span>
</div>
</div>



</body>

	<script language="JavaScript" type="text/javascript" src="/drupal/sites/all/modules/contextlinks/contextlinks.js"></script>
	<script language="JavaScript" type="text/javascript" src="/drupal/sites/all/modules/copious_rolled_oats/rolled_oats_admin.js"></script>
	<script language="JavaScript" type="text/javascript" src="/drupal/sites/all/modules/blockbar/blockbar.js"></script>
	<script language="JavaScript" type="text/javascript" src="/drupal/sites/all/modules/dhtml_menu/dhtml_menu.js"></script>
	<script language="JavaScript" type="text/javascript" src="/drupal/sites/all/modules/event/eventblock.js"></script>

	<script language="JavaScript" type="text/javascript" src="/drupal/sites/all/modules/taxonomy_dhtml/menuExpandable4.js"></script>
	<script language="JavaScript" type="text/javascript" src="/hosted/js/docjax.js"></script>
	<script language="javascript" type="text/javascript" src="/hosted/js/windowshades.js"></script>

<script language="javascript">
/*
	g_monthoffset = 0;
	refreshEvents();
*/
</script>
</html>
