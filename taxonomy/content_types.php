<?php

include "../admin_header.php";


function content_type_variables($typename,$bus_appdir) {
	global $variable_details;

	$variable_details = array();
///=====>>>
	$content_elements = file_get_contents("../themes/basic_system_vars.txt");
	include "../themes/basic_system_vars.php";

	$n = count($variable_details);
	switch_db_connection("taxonomy");

	$QQ = "SELECT id FROM content_type WHERE ( name = '$typename' ) AND ( entity_symbol = '$bus_appdir')";
	$ctid = db_query_value($QQ);

	if ( $ctid != -1 ) {

		$QQ = "SELECT * FROM content_type_variables WHERE ( ctid = '$ctid' )";
		$varobjlist = db_query_object_list($QQ);

		foreach ( $varobjlist as $varobj )  {
			///
			$n++;
			$symbol = $varobj->symbol;

$content_elements .=<<<EOLIST
	<li><span id="var_dnd_src_$n" class="buttonLike" style="cursor:pointer;" >$symbol</span></li>
EOLIST;
	
			$variable_details[$varobj->symbol] = array("name" => $varobj->symbol, "details" => $varobj->details, "substitutions" =>  $varobj->substitutions );
		}
	}

	switch_db_connection("copious");
	return(array($variable_details,$content_elements,$n));
}


$n = 0;

$typename = $_GET['content_type'];
$added_component = "";
if ( isset($_GET['component_list']) ) {   /// Got a component list to disassemble...
	
	/// This is returned from rolled oat system when the user clicks a term.
	$term = $_GET['term'];
	$term_specific_components = $_GET['component_list'];
	
	$term_list_array = explode(",",$term_specific_components);
	$added_component = "";
	$variable_details_added = array();
	///
	foreach ( $term_list_array as $fielddef ) {
		$n++;
$added_component .=<<<EOLIST
<li><span id="var_dnd_src_$n" class="buttonLike" style="cursor:pointer;" >$fielddef</span></li>

EOLIST;
		$variable_details_added[$fielddef] = array("name" => "$fielddef", "details" => "details $fielddef", "substitutions" => "SUBS $fielddef" );
	}

} /// Otherwise, the content type is getting these variables for the whole tree.

$content_elements_container =<<<EOLIST
<div style="font-weight:bold;text-align:center;border-bottom:3px solid darkgreen;background-color:#FEDCBA" >$typename</div>
<ul>
EOLIST;




list($variable_details,$content_elements_rest,$m) = content_type_variables($typename,$bus_appdir);
$content_elements = $content_elements_rest;
$n += $m;

///
$content_elements = $added_component . $content_elements;
$content_elements = $content_elements_container . $content_elements . "</ul>";

if ( isset($variable_details_added) ) {
	$variable_details = array_merge($variable_details,$variable_details_added);
}

///
$variable_details = json_encode($variable_details);

$content_elements = urlencode($content_elements);
$content_elements = str_replace("+"," ",$content_elements);

?>

g_variable_source_parameters = <?php echo $variable_details ?>;
$('content_type_elements').innerHTML = decodeURIComponent("<?php echo $content_elements ?>");
build_content_drag_and_drop_sources('var_dnd_src_',<?php echo $n ?>);

<?php
if ( !isset($term_specific_components) ) {
?>
	content_type_taxonomy("<?php echo $typename ?>");
<?php
}
?>
