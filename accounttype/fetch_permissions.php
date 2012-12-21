<?php


include "../admin_header.php";

$effector = "perm";
if ( isset($_GET['effector']) ) {
	$effector = $_GET['effector'];
}

unset($divloc);
if ( isset($_GET['divloc']) ) {
	$divloc = $_GET['divloc'];
}



function load_accounttypesknown_from_db() {
	$QQ = "SELECT name,wid FROM copious.accounttypeknown ORDER BY name";
	$accobjlist = db_query_object_list($QQ);

	$acclist = array();
	foreach ( $accobjlist as $acobj ) {
		$acclist[$acobj->name] = $acobj->wid;
	}

	return($acclist);
}

function render_choices($permarray,$permsmap,$effector = "perm") {

	$n = count($permarray);
	$output = "<table class='permTABLE'>";
	$selall = "";
	$sep = "";
	$c = $effector[0];
	$output .= "<tr><td class='permEL' id='permEL_ALL' style='background-color:#E0E4FC;border:solid 1px green;' onclick=\"toggle_select_all('@selalllist')\" >Select All</td></tr>";
	for ( $i = 0; $i < $n; $i++ ) {
		$perm = $permarray[$i];
///
		$wid = $permsmap[$perm];
///
		$output .= "<tr><td class='permEL' onclick=\"$('$perm-$c').checked = !($('$perm-$c').checked); if ( $('$perm-$c').checked ) { add_$effector('$perm',$wid); } else { remove_$effector('$perm'); } \" ><input type='checkbox' id='$perm-$c'>&nbsp;$perm</td></tr>";
///
		$selall .= $sep . $perm;
		$sep = ",";
	}
	$output .= "</table>";

	$output = str_replace('@selalllist',$selall,$output);

	return($output);
}

	$permsmap = load_accounttypesknown_from_db();
	$perms = array_keys($permsmap);

	sort($perms);

	$partitions = array();

	$n = count($perms);
	for ( $i = 0; $i < $n; $i++ ) {
		$perm = $perms[$i];
		$c = strtolower($perm[0]);
		if ( !isset($partitions[$c]) ) {
			$partitions[$c] = array();
		}
		$partitions[$c][] = $perm;
	}


$letters = array(
	'a',
	'b',
	'c',
	'd',
	'e',
	'f',
	'g',
	'h',
	'i',
	'j',
	'k',
	'l',
	'm',
	'n',
	'o',
	'p',
	'q',
	'r',
	's',
	't',
	'u',
	'v',
	'w',
	'x',
	'y',
	'z',
);

	$output = "{ ";
	$sep = "";
	foreach ( $letters as $let ) {
		$letC = strtoupper($let);
		if ( isset($partitions[$let]) ) {
			$choices = render_choices($partitions[$let],$permsmap,$effector);
			$choices = urlencode($choices);
			$choices = str_replace("+"," ",$choices);
			$output .= $sep . " $letC: decodeURIComponent('$choices')";
		} else {
			$output .= $sep . " $letC: 'none' ";
		}
		$sep = ", ";
	}
	$output .= " }";

if ( !(isset($divloc)) ) {
?>
g_permissions = <?php echo $output ?>;
<?php 
} else {
?>
	g_permissions["<?php echo $divloc; ?>"] = <?php echo $output ?>;
	init_permissions_next_step();
<?php
}
?>
