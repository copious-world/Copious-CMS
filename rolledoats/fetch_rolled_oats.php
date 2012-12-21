<?php

/// For the editors...

function render_choices($permarray) {

	$n = count($permarray);
	$output = "<table class='permTABLE'>";
	$selall = "";
	$sep = "";
	$output .= "<tr><td class='permEL' id='permEL_ALL' style='background-color:#E0E4FC;border:solid 1px green;' onclick=\"toggle_select_all('@selalllist')\" >Select All</td></tr>";
	for ( $i = 0; $i < $n; $i++ ) {
		$perm = $permarray[$i];
		$output .= "<tr><td class='buttonLike' onclick=\"edit_rolled_oat('$perm');\" > $perm </td></tr>";
		
		$selall .= $sep . $perm;
		$sep = ",";
		
	}
	$output .= "</table>";

	$output = str_replace('@selalllist',$selall,$output);

	return($output);
}

	$rolled_oats_source = apc_fetch("all_rolled_oats");

	$namesarray = (array)$rolled_oats_source;
	$perms = array_keys($namesarray);
	sort($perms);

	$partitions = array();

	$n = count($perms);
	for ( $i = 0; $i < $n; $i++ ) {
		$perm = $perms[$i];
		$c = $perm[0];
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
			$choices = render_choices($partitions[$let]);
			$choices = urlencode($choices);
			$choices = str_replace("+"," ",$choices);
			$output .= $sep . " $letC: decodeURIComponent('$choices')";
		} else {
			$output .= $sep . " $letC: 'none' ";
		}
		$sep = ", ";
	}
	$output .= " }";



?>

g_rolled_oats = <?php echo $output ?>;
