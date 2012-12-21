<?php


include "../admin_header.php";



function set_up_content_search($citid,$now,$content_type,$classifier,$object_data) {

	$object_data = str_replace(" ","",$object_data);
	$object_data = str_replace("{","",$object_data);
	$object_data = str_replace("}","",$object_data);

	$object_data = explode(",",$object_data);
	$n = count($object_data);

	$DD = "DELETE FROM search_content_types WHERE co_id = $citid";
	db_query_exe($DD);

	$values = array();
	$values[] = "(0,'$now','$content_type','$classifier',$citid,'date','$now')";

	for ( $i = 0; $i < $n; $i++ ) {
		$element = $object_data[$i];
		list($key,$value) = explode('\":\"',$element);
		$key = trim($key);
		$key = str_replace('\"',"",$key);
		$key = str_replace(':',"-",$key);
		$value = chop($value,'\"');
		$values[] = "(0,'$now','$content_type','$classifier','$citid','$key','$value')";
	}
	$II = "INSERT INTO search_content_types (id,date,content_type,classifier,co_id,search_on,keydata) VALUES ";
	$II .= implode(", ",$values);
		///

	db_query_exe($II);

}


// Allas, the universal form does not have to be rendered into a list of posted variables.
// But, a json encoded array of elements can store the object in perpepituity. Provided it can
// be disected at a later time. 

$storage_format = $_GET['storage_format'];
$content_type = $_GET['content_type'];
$classifier = $_GET['term'];
$title = $_GET['title'];

$g_saving_pub_id = 0;
if ( isset($_GET['pubid']) ) {
	$g_saving_pub_id = $_GET['pubid'];
}

///

if ( !isset( $_GET['ctid'] ) ) {
	switch_db_connection("taxonomy");
	$QQ = "SELECT id FROM content_type WHERE (name = '$content_type') AND (entity_symbol = '$bus_appdir')";
	$ctid = db_query_value($QQ);
	switch_db_connection("copious");
} else {
	$ctid = $_GET['ctid'];
}


$now = datetime();
$object_data = urlencode($storage_format);

$tag = sha1("$now" . "$content_type" . "$classifier" . "$tag" . "$object_data");

if ( $g_saving_pub_id == 0 ) {
	$EX = "INSERT INTO all_content (id,date,ct_id,content_type,classifier,tag,object_data,title) VALUES (0,'$now',$ctid,'$content_type','$classifier','$tag','$object_data','$title')";
} else {
	$EX = "UPDATE all_content SET date = '$now', ct_id = $ctid, content_type = '$content_type',classifier = '$classifier',tag = '$tag',object_data = '$object_data',title = '$title' WHERE id = $g_saving_pub_id";
}
db_query_exe($EX);

$QQ = "SELECT id FROM all_content WHERE ( date = '$now' ) AND ( content_type = '$content_type' ) AND ( classifier = '$classifier') AND ( tag = '$tag' )";
$citid = db_query_value($QQ);

if ( strlen($storage_format) ) {
	set_up_content_search($citid,$now,$content_type,$classifier,$storage_format);
}

if ( !isset($_GET['nojs']) ) {

?>

content_form_html_preview(<?php echo $citid; ?>);

<?php
} else {
	echo $citid;
}
?>
