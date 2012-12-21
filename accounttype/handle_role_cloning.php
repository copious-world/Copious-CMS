<?php

include '../servicename.php';
$dbspecific = "taxonomy";

try {
	include '../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}

	$whichtaxo = $_GET['taxo'];
/** ---------------------------------------- */
global $db_connection;
///

	$QQ = "SELECT terms, parents FROM vocabulary where id = $whichtaxo";
	$vocdata = db_query_object($QQ);

	$terms = json_decode($vocdata->terms);
	$parents = json_decode($vocdata->parents);

	switch_db_connection($secondaryDB);

	///
	$rolenames = array();
	$nametoterm = array();
	foreach( $terms as $tid => $termobj ) {
		$rname = $termobj->name;
		if ( $rname == "root" ) continue;
		$rolenames[] = $rname;
		$nametoterm[$rname] = $termobj;
	}

	$dbtablename1 = $db_prefix . "roles";
	$dbtablename2 = $db_prefix . "permission";

	$taxoroles = implode("','",$rolenames);
	$QQ = "SELECT * from $dbtablename1 r INNER JOIN $dbtablename2 ON p ( r.rid = p.rid ) where name in ('$taxoroles')";
	$rolepermlist = db_query_object_list($QQ);

	$existingroles = array();
	$role_name_to_perms = array();
	foreach ( $rolepermlist as $roleitem ) {
		$existingroles[] = $roleitem->name;
		$role_name_to_perms[$roleitem->name] = $roleitem;
	}

	$newroles = array_intersect($existingroles,$rolenames);

	if ( count($newroles) > 0 ) {
		$II = "INSERT INTO $dbtablename1 (rid,name) VALUES ";
		$sep = "";
		foreach ( $newroles as $rname ) {
			$II .= $sep . "(0,'$rname')";
			$sep = ", ";
		}
		db_query_exe($II);
	}

	$newrolesstr = implode("','",$newroles);
	$QQ = "SELECT * from $dbtablename1 where name in ($newrolesstr)";
	$roles = db_query_object_list($QQ);
	
	///
	$II = "INSERT INTO $dbtablename2 (rid,perm) VALUES ";
	$sep = "";
	foreach ( $roles as $role ) {
		$rname = $role->name;
		$term = $nametoterm[$rname];

		$pids = $parents[$term->id];
		$permcollection = array();
		foreach ( $pids as $pid ) {
			$pterm = $terms[$pid];
			$roleitem = $role_name_to_perms[$pterm->name];
			$permcollection = array_merge($permcollection,explode(",",$roleitem->perm));
		}
		$perms = implode(",",$permcollection);

		$II .= $sep . "($rid,'$perms')";
	}
	db_query_exe($II);

?>
