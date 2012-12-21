<?php


require_once('../admin_header.php');


function fetch_account_name($id) {
	$QQ = "SELECT type_name  FROM accounttypes  WHERE ( id = '$id' )";
	$name = db_query_value($QQ);
	return ($name);
}


	$business = $bus_appdir;

	$QQ = "SELECT auts.account_type_id, u.*  FROM authspecials auts INNER JOIN users u ON ( auts.UID = u.id )  WHERE ( auts.needs_approval = 1 ) AND ( auts.serviceid = $serviceid )";
	$userlist = db_query_object_list($QQ);


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
		$account_name = fetch_account_name($user->account_type_id);

$output .=<<<EOTROW
<tr>
		<td class="systd_data name_style"><input type="checkbox" name="approved[$id]" checked>$name</td>
		<td class="systd_data id_style">$id</td>
		<td class="systd_data accountlist_style">$account_name</td>
</tr>
EOTROW;
	}
$output .= "</table>\n";

?>
<?php
	echo $output;
?>



