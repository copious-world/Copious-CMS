<?php



$dbspecific = "taxonomy";
include "../admin_header_lite.php";
global $db_connection;



function taxo_name_has_account_type($vid) {

	$QQ = "SELECT count(*) FROM account_menu WHERE menu_taxo_id = '$vid'";
	$n = db_query_value($QQ);

	return($n > 0);
}



function retrieve_taxo_menu_account($vid) {
	$QQ = "SELECT base, business, account_type from account_menu WHERE menu_taxo_id = '$vid'";
	$values = db_query_row($QQ);
	return(array_merge(array(),$values));
}



$vid_list = $_GET['vidlist'];
$data = $_GET['custom_data'];

$QQ = "SELECT * FROM taxo_map where (HTML = 'process') AND vid in ($vid_list)";
$vidlist = db_query_object_list($QQ);

foreach ( $vidlist as $map_obj ) {
	
	$form = $map_obj->label_form;
	$vid = $map_obj->vid;

	$QQ = "SELECT name, JSON from vocabulary where id = $vid";
	$obj = db_query_object($QQ);

	$taxoname = $obj->name;
	$jsondata = $obj->JSON;

	$url = "fromatMappedMenuHTML.php?taxonomy=$vid&taxoname=$taxoname&form=$form&jsondata=$jsondata";
	$HTML = file_get_contents("http://$webhost/hosted/taxonomy/$url");

	$id = $map_obj->id;
	$UU = "UPDATE taxo_map set HTML = $HTML where id = $id";
	db_query_exe($UU);

	switch_db_connection("copious");

	/// STORE IT IN PUBLICATIONS.... account type, business, etc...
	if ( taxo_name_has_account_type($vid) ) {  // This includes business and account type 
		list($basetaxo,$business,$acctype) = retrieve_taxo_menu_account($vid);  // Get this from a separate little table...
		$QQ = "SELECT acc.id FROM accounttypes acc INNER JOIN serivcesource srv ON ( acc.serviceid = srv.id ) where ( srv.srvicename = '$business' )";
		$QQ .= " AND ( acc.name = '$acctype')";
		$acid = db_query_value($QQ);

		$tag = datetime();
		$II = "INSERT INTO publications_stored (id,account_type,file,HTML) VALUES (0,$acid,'$tag','$HTML')";
		db_query_exe($II);

		$QQ = "SELECT id from publications_stored where ( account_type = $acid ) AND ( file = 'menu_text$tag' )";
		$bid = db_query_value($QQ);

		$QQ = "INSERT INTO publications (id,bid,srcurl,datakey,pubtype,pubdate) VALUES (0,$bid,'menu_text$tag','menu_text',4,'$tag')";
		db_query_exe($QQ);
	}
}

?>
