<?php


$QQ = "SELECT name FROM rolled_oats";
$oatnames = db_query_list($QQ);


function render_choices($oatarray) {

	$n = count($oatarray);
	$output = "<table class='permTABLE'>";
	$selall = "";
	$sep = "";
	for ( $i = 0; $i < $n; $i++ ) {
		$oat = $oatarray[$i];
		$output .= $sep . "<tr><td class='permEL' ><span id='$oat' class='buttonLike' onclick=\"edit_rolled_oat('$oat');\">$oat</span></td></tr>";
		$sep = ",";
		
	}
	$output .= "</table>";

	return($output);
}


	sort($oatnames);

	$partitions = array();

	$n = count($oatnames);
	for ( $i = 0; $i < $n; $i++ ) {
		$oatname = $oatnames[$i];
		$c = $oatname[0];
		if ( !isset($partitions[$c]) ) {
			$partitions[$c] = array();
		}
		$partitions[$c][] = $oatname;
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
