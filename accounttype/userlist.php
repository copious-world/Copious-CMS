<?php


require_once('../admin_header.php');


function fetch_accounts($id,$serviceid) {
	$QQ = "SELECT act.type_name  FROM authspecials auts INNER JOIN accounttypes act ON ( auts.account_type_id = act.id )  WHERE ( auts.uid = '$id' ) AND ( auts.serviceid = $serviceid )";
	$actlist = db_query_list($QQ);
	return (implode(",",$actlist));
}


	$business = $bus_appdir;

	$QQ = "SELECT * FROM users WHERE original_source = '$business' ORDER BY username";
	$userlist = db_query_object_list($QQ);

	$QQ = "SELECT id from serivcesource where ( servicename = '$business' )";
	$serviceid = db_query_value($QQ);

$output = "<table class='systemtable' >\n";
$output .=<<<EOTROW
<tr>
		<td class="systd_data name_style header_style">name</td>
		<td class="systd_data id_style header_style">id</td>
		<td class="systd_data accountlist_style header_style">Account Types</td>
</tr>
EOTROW;
	foreach ( $userlist as $user ) {
		$name = $user->username;
		$id = $user->ID;

		$account_types = fetch_accounts($id,$serviceid);

$output .=<<<EOTROW
<tr>
		<td class="systd_data name_style">$name</td>
		<td class="systd_data id_style">$id</td>
		<td class="systd_data accountlist_style">$account_types</td>
</tr>
EOTROW;
	}
$output .= "</table>\n";


	echo $output;
?>
