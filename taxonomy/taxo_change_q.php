<?php


$dbspecific = "taxonomy";
include "../admin_header_lite.php";

function append_marker_data($termdata,$tasklist) {
	$jsonstring = "";

	return($jsonstring);
}


$QQ = "select * from taxo_change_q";
$tasks = db_query_object_list($QQ);

$maxwhen = 0;
$collectvids = array();
foreach ( $tasks as $task ) {
	$vid = $task->vid;
	$maxwhen = ( $maxwhen < $task->when ) ? $task->when : $maxwhen;
	///----->
	if ( !isset($collectvids[$vid]) ) {
		$collectvids[$vid] = array();
	}
	$collectvids[$vid][] = $task;
}

$DD = "DELETE FROM taxo_change_q where when < '$maxwhen'";
	db_query_exe($DD);


foreach ( $collectvids as $vid => $tasklist ) {
	$QQ = "select * from vocabulary where id = $vid";
	$voc = db_query_object($QQ);
	$jsondata = $voc->JSON;

	$jsondata = urldecode($jsondata);
	$termdata = json_decode($jsondata);

	$taxonomy = $vid;
	$taxoname = "for report";
	$jsondata = append_marker_data($termdata,$tasklist);

	$procurl = "http://$webhost/taxonomy/saveTaxoTree.php?taxonomy=$vid&taxoname=$taxoname&jsondata=$jsondata";
	$report = file_get_contents($procurl);
	///
	///
}

$procurl = "http://$webhost/boot_db/taxonomy_apc.php";
$report = file_get_contents($procurl);

?> 
