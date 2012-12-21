<?php

$policy_day_length = 7;	// in days.. the number of days an ad is up.
$delta_time_factor = 5; // in minutes

global $db_connection;
global $g_connection_list;

$g_connection_list = array();


function add_db_connection($host,$user,$pass,$whichdb) {
	global $db_connection;
	global $g_connection_list;
	$db_con = mysqli_connect($host,$user,$pass) or die (mysqli_error($db_con));
	$db_connection = $db_con;
	$g_connection_list[$whichdb] = $db_con;
	mysqli_query($db_connection, 'SET NAMES "utf8"');
}

function store_db_connection($whichd,$db_con) {
	global $g_connection_list;
	global $db_connection;
	$g_connection_list[$whichdb] = $db_con;
	$db_connection = $db_con;
}


function switch_db_connection($key) {
	global $db_connection;
	global $g_connection_list;
	global $dbhost;
	global $dbuser;
	global $dbpass;

	if ( !isset($g_connection_list[$key]) ) {
		add_db_connection($dbhost,$dbuser,$dbpass,$key);
	}

	$db_connection = $g_connection_list[$key];
	$db_select = mysqli_select_db($db_connection,$key) or die (mysqli_error($db_connection));
	return($db_connection);
}


require_once "database.mysqli.inc";

function parse_db_url($connect_url) {
	$connect_url = str_replace('mysql://','',$connect_url);
	list($p1,$whichdb) = explode("/",$connect_url);
	list($user,$p2) = explode(":",$p1);
	list($pass,$host) = explode("@",$p2);
	return(array($host,$user,$pass,$whichdb));
}


function db_set_active($name = 'default') {
	global $db_url, $db_type;
	static $db_conns;
	static $db_keys = array();

	if ( !isset($db_conns[$name]) ) {
		if ( is_array($db_url )) {
			$connect_url = array_key_exists($name, $db_url) ? $db_url[$name] : $db_url['default'];
		} else {
			$connect_url = $db_url;
		}
		list($host,$user,$pass,$whichdb) = parse_db_url($connect_url);
		add_db_connection($host,$user,$pass,$whichdb);
		$db_keys[$name] = $whichdb;
	}

	$key = $db_keys[$name];
	switch_db_connection($key);
	//return array_search($previous_db, $db_conns);
}


if ( !isset($db_connection) ) {
	add_db_connection($dbhost,$dbuser,$dbpass,$dbspecific);
	switch_db_connection($dbspecific);
} else {
	store_db_connection($dbspecific,$db_connection);
	switch_db_connection($dbspecific);
}


function fixtext($txt) {	//
	$txt = urlencode($txt);
	$junk = "";
	$sectkey = split( "%", $txt );
	$txt = $sectkey[0];
	return( $txt );
}

function datetime() {
	return( date("Y-m-d H:i:s"));
}

//
function days_from_now($entrydate,$Ndays) {
	//
	$timestamp = strtotime($entrydate);
	//
	$timestamp = $timestamp + $Ndays*24*3600;
	//
	$finaldate = date("Y-m-d H:i:s",$timestamp);
	return($finaldate);
}

//
function moments_before($entrydate,$Nminutes) {
	//
	$timestamp = strtotime($entrydate);
	//
	$timestamp = $timestamp - $Nminutes*60;
	//
	$finaldate = date("Y-m-d H:i:s",$timestamp);
	return($finaldate);
}



function create_entry($section) {
	//
	$docID = "devdoc";
	$project = "cartstart";
	$docname = fixtext("CartStart 1.0 Developer Documentation");
	$infocontent = "TODO";
	//
	$section_maker = "insert into documents ";
	$section_maker .= "(ID,section,docID,project,docname,infocontent) VALUES (0,'";
	$section_maker .= $section . "','";
	$section_maker .= $docID . "','";
	$section_maker .= $project . "','";
	$section_maker .= $docname . "','";
	$section_maker .= $infocontent . "')";

	$q_result = @mysqli_query($db_connection,$section_maker) or die (mysqli_error($db_connection));  // 
}


function imagelocus() {
	global $webhost;
	global $classifiedserverdir;
	
	$locus = "http://$webhost/" . $classifiedserverdir . "/manager/";
	return($locus);
}

////
function db_query_exe($QQ) {
	global $db_connection;
	$q_result = @mysqli_query($db_connection,$QQ) or die (mysqli_error($db_connection));  // 
}


////
function db_query_rows($QQ) {
	global $db_connection;
	$q_result = @mysqli_query($db_connection,$QQ) or die (mysqli_error($db_connection));  //
	$row = @mysqli_fetch_assoc($q_result);
	return($row);
}


function db_query_value($QQ) {
	global $db_connection;
	$q_result = @mysqli_query($db_connection,$QQ) or die (mysqli_error($db_connection));  //
	$rvals = @mysqli_fetch_row($q_result);
	$v = -1;
	if ( $rvals ) $v = $rvals[0];
	return($v);
}


function db_query_object($QQ) {
	global $db_connection;
	$q_result = @mysqli_query($db_connection,$QQ) or die (mysqli_error($db_connection));  //
	$rvals = @mysqli_fetch_object($q_result);
	return($rvals);
}


////$vals
function db_query_list($QQ) {
	global $db_connection;
	$q_result = @mysqli_query($db_connection,$QQ) or die (mysqli_error($db_connection));  //
	$list = array();
	while ( $row = @mysqli_fetch_row($q_result) ) {
		$list[] = $row[0];
	}
	return($list);
}

////$vals
function db_query_object_list($QQ) {
	global $db_connection;
	$q_result = @mysqli_query($db_connection,$QQ) or die (mysqli_error($db_connection));  //
	$list = array();
	while ( $row = @mysqli_fetch_object($q_result) ) {
		$list[] = $row;
	}
	return($list);
}

////
function db_query_row_lists($QQ) {
	global $db_connection;
	$q_result = @mysqli_query($db_connection,$QQ) or die (mysqli_error($db_connection));  //
	$rowlist = array();
	while ( $row = @mysqli_fetch_assoc($q_result) ) {
		foreach ( $row as $key => $value ) {
			$rowlist[$key][] = $value;
		}
	}

	return($rowlist);
}


////
function db_fetch_row_lists($QQ) {
	global $db_connection;
	$q_result = @mysqli_query($db_connection,$QQ) or die (mysqli_error($db_connection));  //
	$rowlist = array();
	while ( $row = @mysqli_fetch_assoc($q_result) ) {
		foreach ( $row as $key => $value ) {
			$rowlist[$key][] = $value;
		}
	}

	return($rowlist);
}


function db_fetch_object_list($QQ) {
	global $db_connection;
	$q_result = @mysqli_query($db_connection,$QQ) or die (mysqli_error($db_connection));  //
	$list = array();
	while ( $row = @mysqli_fetch_object($q_result) ) {
		$list[] = $row;
	}
	return($list);
}




function plainSql($db_prefix,$tables,$sql) {
	global $db_connection;
	$n = count($tables);
	for ( $i = 0; $i < $n; $i++ ) {
		$nodespec = $tables[$i];
		$nodereal = $db_prefix . $nodespec;
		$nodespec = "{" . $nodespec . "}";
		$sql = str_replace($nodespec,$nodereal,$sql);
	}
	return($sql);
}


function db_value_exists($field,$value,$table) {
	$QQ = "select count(*) from $table where $field = '$value'";
	$n = db_query_value($QQ);
	if ( $n <= 0 ) return(false);
	return(true);
}



function db_tables_exist($tablenames) {
	$QQ = "show tables";
	$list = db_query_list($QQ);
	foreach ( $tablenames as $tname ) {
		$tname = trim($tname);
		if ( strlen($tname) > 0 ) {
			if ( !in_array($tname,$list) ) {
				return($tname);
			}
		}
	}
	return(TRUE);
}


function db_prepare($QQ) {
	global $db_connection;
	
	$stmt = mysqli_prepare ($db_connection, $QQ);
	return($stmt);
}

require_once('copiousmail.php');

?>
