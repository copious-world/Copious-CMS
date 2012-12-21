<?php



include 'servicename.php';
$dbspecific = "taxonomy";

try {
	include '../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}

/*
*/
global $db_connection;

$dobuttons = false;
if ( isset($_GET['buttons']) ) {
	$dobuttons = true;
}

	$QQ = "select id, name, description from vocabulary";
	$vlist = db_query_object_list($QQ);

	$n = count($vlist);
	$taxolist = array();
	if ( $n > 0 ) {
		$output = "<table width='100%'>\n";
		for ( $i = 0; $i < $n; $i++ ) {
			$vocab = $vlist[$i];
			$id = $vocab->id;
			if ( !$dobuttons ) {
				$output .= "<tr><td id='taxo_a_$id' class='vocab_element' onclick=\"set_taxo($id)\">$vocab->name</td><td id='taxo_b_$id' class='vocab_descr' >$vocab->description</td></tr>\n";
			} else {
				$output .= "<tr><td  class='vocab_element' style='width:40px'><input type='checkbox' name='taxoselect[$i]' id='bselect_$i'></td><td id='taxo_a_$id' class='vocab_element' onclick=\"$('bselect_$i').checked = !$('bselect_$i').checked;pick_taxo($i,$id);\">$vocab->name</td><td id='taxo_b_$id' class='vocab_descr' >$vocab->description</td></tr>\n";
			} 
			$taxolist[] = "taxo_a_$id";
		}
		$output .= "</table>\n";

		$taxos = implode("','",$taxolist);
$jspart =<<<EOJS
<script type="text/javascript">
g_taxo_array_from_db = ['$taxos'];
</script>
EOJS;

		echo $jspart;
		echo $output;
	} else {
		echo "No Vocabularies specified yet";
	}


?>
