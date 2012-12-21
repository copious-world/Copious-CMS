<?php


include "../admin_header.php";

$container = $_GET['container'];
$content_type = $_GET['content_type'];
$classifier = $_GET['term'];

if ( isset($_GET['carryforward']) ) {
	$elements_object =  $_GET['carryforward'];
	$elements_object = urldecode($elements_object);
	$elements_object = str_replace("\\","",$elements_object);
} else $elements_object = "";


$QQ = "SELECT entry_form FROM content_forms WHERE ( content_type = '$content_type' ) AND ( classifier = '$classifier' )"; 
$form_object = db_query_value($QQ);
$form_object = str_replace("+"," ",$form_object);

$QQ = "SELECT entry_js FROM content_forms WHERE ( content_type = '$content_type' ) AND ( classifier = '$classifier' )"; 
$form_js = db_query_value($QQ);

$form_js = urldecode($form_js);

?>

$('form_command').innerHTML = "save";
g_just_for_form_fetch_kind = "save";
OAT.Dom.hide($('date_search'));
OAT.Dom.hide($('title_search'));

var exper = decodeURIComponent("<?php echo $form_object; ?>");
insert_form_into_display('<?php echo $container; ?>',exper,"<?php echo $elements_object; ?>");

update_form_js(<?php echo $form_js; ?>);
