<?php

global $g_responsive_table;
global $g_business_focus;
global $bus_appdir;
global $g_show_menus;
global $g_account_drop_targets;
global $g_ig_entry_name;
global $g_prefix;

if ( !isset($g_prefix) ) {
	$g_prefix = "";
}

if ( !isset($g_ig_entry_name) ) {
	$g_ig_entry_name = 'topic_account_drops';
}

if ( isset($_GET['bfocus']) ) {
	$g_responsive_table = "responsive";
	$g_business_focus = $_GET['bfocus'];
}

if ( isset($_GET['pushbuttons']) ) {
	$g_responsive_table = "submitters";
}

if ( isset($_GET['condition']) ) {
	$conditioner = $_GET['condition'];
}


include '../servicename.php';

try {
	include '../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
/*
*/
global $db_connection;
$QQ = "SELECT ac.*, srv.servicename FROM accounttypes ac INNER JOIN serivcesource srv ON ( ac.serviceid = srv.id ) ";


if ( isset($g_business_focus) ) {
	$QQ .= "WHERE ( srv.servicename = '$g_business_focus' ) ";
}

if ( isset($conditioner) ) {
	$QQ .= " AND " . $conditioner;
}


$QQ .=  " ORDER BY srv.servicename ";
$bobjects = db_query_object_list($QQ);


if ( !isset($g_account_drop_targets) ) {
	$g_account_drop_targets = false;
}
if ( !isset($g_show_menus) ) {
	$g_show_menus = false;
}


$i = 0;
$output = "";

if ( $g_account_drop_targets ) {
	$drop_elements =<<<EOSTARTINOGROUP
INFOGROUP.$g_ig_entry_name = {
	needs:["window"],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: null,
	cb:function() {
		var gd = new OAT.GhostDrag();

EOSTARTINOGROUP;
}


foreach ( $bobjects as $bobj ) {

	$name = $bobj->type_name;
	$descr = $bobj->description;
	$descr = urldecode($descr);
	$busname = $bobj->servicename;
	$id = $bobj->id;


if ( isset($g_responsive_table) ) {

	switch ( $g_responsive_table ) {
		case "responsive": {

$business_responder = "";
$busiclass = "";
if ( isset($bus_appdir) && ($bus_appdir == $busname) ) {
	$business_responder = "set_business_account($id,'$name','$bus_appdir');";

$business_responder = "set_business_account_dit($id,'$name','$bus_appdir');";
	$busiclass = " mybusiness";
}


$txt =<<<EOBOBJ
<tr>
	<td class="businessName$busiclass" onclick="$business_responder show_account_dataq($id,'$name');">$name</td><td class="businessName$busiclass" >$busname</td><td class="businessURL"><span style="font-weight:bold;color:gray;" >$descr</span></td>
</tr>
EOBOBJ;
			break;
		}

		case "submitters": {

/*
$business_responder = "";
$busiclass = "";
if ( isset($bus_appdir) && ($bus_appdir == $busname) ) {
	$business_responder = "set_business_account($id,'$name','$bus_appdir');";

$business_responder = "set_business_account_dit($id,'$name','$bus_appdir');";
	$busiclass = " mybusiness";
}

*/
$txt =<<<EOBOBJ
<tr>
	<td class="businessName$busiclass" ><input type="submit" name="accounttype[$name]" value="$name"></td><td class="businessName$busiclass" >$busname</td><td class="businessURL"><span style="font-weight:bold;color:gray;" >$descr</span></td>
</tr>
EOBOBJ;
			break;
		}

		case "layoutdrop": {

			$pp = $bobj->published;

$txt =<<<EOBOBJ
<tr>
	<td class="businessName" width="15%" >$busname</td>
 	<td class="businessURL" width="50%" ><span style="font-weight:bold;color:gray;" >$descr</span></td>
 	<td class="businessURL" width="50%" ><input type='text' id='account_dr_$i' name='account_dr_$i' style="font-weight:bold;color:navy;" ></td>
</tr>
EOBOBJ;


if ( $g_account_drop_targets ) {
	$drop_elements .=<<<EOSTARTINOGROUP
		gd.addTarget("account_dr_$i");

EOSTARTINOGROUP;
}

			break;
		}


		case "content_type": {

			if ( !isset($js_account_name_list) ) {
				$js_account_name_list = array();
			}

$txt =<<<EOBOBJ
<tr>
	<td class="businessName" width="15%" onclick="showRWchecks('$name','$g_prefix$name');">$name</td>
	<td><input style="visibility:hidden;" type="checkbox" name="acclist_read[$i]" id="r_$g_prefix$name" value ="$id" onclick="$('w_$g_prefix$name').checked = false;" ></td>
	<td><input style="visibility:hidden;" type="checkbox" name="acclist_write[$i]" id="w_$g_prefix$name" value ="$id" onclick="$('r_$g_prefix$name').checked = false;" ></td>
</tr>
EOBOBJ;

			$js_account_name_list[] = $name;

			break;
		}

		case "publisher": {

			$pp = $bobj->published;
			$on = ( $pp == 1 ) ? "checked" : "";
			$m1 = $bobj->base_menu_1;
			$m2 = $bobj->base_menu_2;

$txt =<<<EOBOBJ
<tr>
	<td class="businessName" width="15%" onclick="$('$name').checked = !$('$name').checked"><input type="checkbox" name="acclist[$i]" id="$name" $on value ="$id" >$name</td>
	<td class="businessName" width="15%" >$busname</td>
 	<td class="businessURL" width="50%" ><span style="font-weight:bold;color:gray;" >$descr</span></td>

EOBOBJ;


if ( $g_account_drop_targets ) {
	$drop_elements .=<<<EOSTARTINOGROUP
		gd.addTarget("menudrop1_$i");
		gd.addTarget("menudrop2_$i");

EOSTARTINOGROUP;
}


	if ( $g_show_menus ) {


$txt .=<<<EOBOBJ
<td width="20%">
<table width="100%">
<tr>
	<td>Navigation</td><td class="menudrop"><input type="text" id="menudrop1_$i" name="menu_name_list1[$name]" style="font-weight:bold;color:black;" value="$m1"></td>
</tr>
<tr>
	<td>Admin</td><td class="menudrop"><input type="text" id="menudrop2_$i" name="menu_name_list2[$name]" style="font-weight:bold;color:black;" value="$m2"></td>
</td>
</tr>
</table>
</td>
EOBOBJ;
	}

$txt .=<<<EOBOBJ
</tr>
EOBOBJ;

			break;
		}

	}
} else {
$txt =<<<EOBOBJ
<tr>
	<td class="businessName" >$name</td><td class="businessName" >$busname</td><td class="businessURL"><span style="font-weight:bold;color:gray;" >$descr</span></td>
</tr>
EOBOBJ;
} 
	$i++;
	$output .= $txt;
	$output .= "\n";
}

if ( !isset($_GET['bfocus']) ) {
?>
	<script language="javascript" >
	function set_business(bname) {
		gServiceBase = bname;
	}
	</script>
<?php
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
	<td class="businessName" style="background-color:#F7F7FA;border-bottom:solid 1px navy">Account Type</td>
<?php
	if ( $g_responsive_table != "content_type" ) {
?>
	<td class="businessName" style="background-color:#F7F7FA;border-bottom:solid 1px navy">Business</td>
	<td class="businessURL" style="background-color:#F7F7FA;border-bottom:solid 1px navy" >Description</td>
<?php 
	} else {
?>
	<td class="businessName" style="background-color:#F7F7FA;border-bottom:solid 1px navy">read</td>
	<td class="businessURL" style="background-color:#F7F7FA;border-bottom:solid 1px navy" >write</td>
<?php 
	}

	if ( ( $g_responsive_table == "publisher" ) || (( $g_responsive_table == "layoutdrop" )) ) {

if ( !isset($gohst_drag_var) ) {
	$gohst_drag_var = 'g_account_drop_complex';
}

if ( $g_account_drop_targets ) {
	$drop_elements .=<<<EOSTARTINOGROUP
		$gohst_drag_var = gd;
	}
}
EOSTARTINOGROUP;
}

		if ( $g_show_menus ) {
?>
	<td width="20%" style="background-color:#F7F7FA;border-bottom:solid 1px navy" class="businessName">Menus</td>
<?php
		}
	}
?>
</tr>
<?php echo $output; ?>
</table>
<script language="javascript" >
	var g_account_drop_complex = null;
<?php echo $drop_elements; ?>

<?php
	if ( $g_responsive_table == "content_type" ) {
		$js_account_name_list = implode("','",$js_account_name_list);
?>
	g_account_name_list = ['<?php echo $js_account_name_list; ?>'];
<?php
	}
?>


</script>
