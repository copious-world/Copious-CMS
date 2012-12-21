<?php


$dbspecific = "taxonomy";
include "../admin_header_lite.php";

/*
*/
global $db_connection;

$dobuttons = false;
if ( isset($_GET['buttons']) ) {
	$dobuttons = true;
}

$condition = "";
if ( isset($_GET['condition']) ) {
	$condition = "  " . $_GET['condition'];
}


$appdir = false;
if ( isset($_GET['appdir']) ) {
	$appdir = $_GET['appdir'];
}


if ( isset($condition) && ( strlen($condition) > 1 ) ) $condition = " where " . $condition;


	$QQ = "select id, name, description from vocabulary" . $condition;
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

$jspart_buttons = "";

		if ( $dobuttons ) {
$jspart_buttons =<<<EOJS
<script type="text/javascript">

EOJS;
			if ( $appdir ) {
				$QQ = "SELECT vid FROM subscription WHERE entity_symbol = '$appdir'";
				$subscribers = db_query_list($QQ);
				if ( count($subscribers) == 0 ) unset($subscribers);
			}

			for ( $i = 0; $i < $n; $i++ ) {
				$vocab = $vlist[$i];
				$id = $vocab->id;

				$truth = "false";
				if ( $appdir ) {
					if ( in_array($id,$subscribers) ) {
						$truth = "true";
					}
				}

$jspart_buttons .=<<<EOJS
				$('bselect_$i').checked = $truth; pick_taxo($i,$id);

EOJS;

			}
$jspart_buttons .=<<<EOJS
</script>

EOJS;
		}

		echo $jspart;
		echo $output;
		echo $jspart_buttons;
	} else {
		echo "No Vocabularies specified yet";
	}


?>
