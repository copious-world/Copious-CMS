<?php



include "../admin_header.php";



$pubid = $_GET['publication'];
$vocname = $_GET['vocname'];
$tagname = $_GET['tagname'];

///

$form_url = "http://localhost/hosted/contenttypes/forms_content.php?sess=$sess&content_type=$vocname&term=$tagname&container=formDepositorDiv";
$jsPage = file_get_contents($form_url);

$QQ = "SELECT title,object_data FROM all_content where ( id = '$pubid' )"; 
$pub = db_query_object($QQ);

$title = $pub->title;
$jdata = $pub->object_data;

$jdata = urldecode($jdata);
$jdata = str_replace('{ \"\"','{ \"',$jdata);
$jdata = str_replace('\"\" }','\" }',$jdata);
$jdata = str_replace(':','',$jdata);
$jdata = str_replace('\"  \"','\" : \"',$jdata);

echo $jsPage;
?>

$('sys_required-title').value = "<?php echo $title; ?>";
g_saving_pub_id = <?php echo $pubid; ?>;
set_default_form_values("<?php echo $jdata; ?>");
