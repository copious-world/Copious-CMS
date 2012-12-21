<?php


$dbspecific = "taxonomy";
include "../admin_header_lite.php";
global $db_connection;


/// Find all the taxonomies that are formualically named for menu use.

$QQ = "SELECT id FROM vocabulary where SUBSTRING(name,1,5) = 'menus'";
$idlist = db_query_list($QQ);
$idliststr = implode(",",$idlist);

$QQ = "SELECT vid FROM taxo_map where vid in ($idliststr)";
$vidlist = db_query_list($QQ);

$resultant = array();
foreach ( $idlist as $id ) {
	if ( !in_array($vidlist) ) {
		$resultant[] = $id;
	}
}


$label_form =<<<EOFFORM
<span onclick="linkReactor('@menu_item_locus');" style="cursor:pointer;font-size:0.82em">@menu_label</span>
EOFFORM;

$label_form = urlencode($label_form);

$resultant_str = implode(",",$resultant);
$QQ = "SELECT name FROM vocabulary where id in ($resultant_str)";
$voc_names = db_query_list($QQ);

foreach ( $voc_names as $vocabname ) {
	$url = "http://$webhost/hosted/taxonomy/maptaxonomy.php?vocabname=$vocabname";
	$url .= "&appname=/accounttype/menu_publication&markup_id=menutree_%d";
	$url .= "&label_form=$label_form&use_label_id=true";

	$report = file_get_contents($url);
}


?>
