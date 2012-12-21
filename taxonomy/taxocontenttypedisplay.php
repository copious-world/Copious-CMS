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

$appdir = false;
if ( isset($_GET['appdir']) ) {
	$appdir = $_GET['appdir'];
}


$serviceid = 0;
$condition = "";
if ( isset($_GET['serviceid']) ) {
	$serviceid = $_GET['serviceid'];
	$condition = " WHERE ( ( serviceid = $serviceid ) OR ( serviceid = 0 ) )";
}

	$QQ = "select id, name, description from vocabulary " . $condition;
	$vlist = db_query_object_list($QQ);

	$vidlist = array();
	foreach ( $vlist as $vobj ) {
		$vidlist[] = $vobj->id;
	}

	$vidcond = implode(",",$vidlist);
	$QQ = "select vid from content_type where vid in ($vidcond)";
	$cvlist = db_query_list($QQ);

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
				$output .= "<tr><td  class='vocab_element' style='width:40px'><input type='checkbox' name='taxoselect[$i]' id='ct_bselect_$i'></td><td id='ct_taxo_a_$id' class='vocab_element' onclick=\"$('ct_bselect_$i').checked = !$('ct_bselect_$i').checked;pick_content($i,$id);\">$vocab->name</td><td id='ct_taxo_b_$id' class='vocab_descr' >$vocab->description</td></tr>\n";
			} 
			$taxolist[] = "ct_taxo_a_$id";
		}
		$output .= "</table>\n";

		$taxos = implode("','",$taxolist);
$jspart =<<<EOJS
<script type="text/javascript">
g_contentype_taxo_array_from_db = ['$taxos'];
</script>
EOJS;

$jspart_buttons = "";
		if ( $dobuttons ) {
$jspart_buttons =<<<EOJS
<script type="text/javascript">

EOJS;

			for ( $i = 0; $i < $n; $i++ ) {
				$vocab = $vlist[$i];
				$id = $vocab->id;

				$truth = "false";
				if ( $appdir ) {
					if ( in_array($id,$cvlist) ) {
						$truth = "true";
					}
				}

$jspart_buttons .=<<<EOJS
				$('ct_bselect_$i').checked = $truth; pick_content($i,$id);

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
