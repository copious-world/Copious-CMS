<?php

	switch_db_connection("taxonomy");

	$QQ = "SELECT vid FROM subscription WHERE entity_symbol = '$bus_appdir'";
	$subscriptions = db_query_list($QQ);

	$QQ = "SELECT id,name,description FROM vocabulary";
	$vocabs = db_query_object_list($QQ);


	switch_db_connection("copious");

$table = "<table class='systable' >\n";
$i = 0;

	foreach ( $vocabs as $vocab ) {
		$checked = "";
		$id = $vocab->id;
		$taxoname = $vocab->name;
		$description = $vocab->description;
		
		if ( in_array($id,$subscriptions) ) $checked = "checked";

		$i++;
		$name = "taxo_subscribe_$i";
$table .=<<<EOROW
<tr>
<td class='systable td_check' ><input id='$name' type="checkbox" $checked name="taxoselect[$i]" value="$id"></td>
<td class='systable td_name' onclick="$('$name').checked = !$('$name').checked" ).checked;" >$taxoname</td>
<td class='systable td_descrbe'>$description</td>
</tr>
EOROW;
	}

$table .= "</table>\n";

echo $table;
?>
