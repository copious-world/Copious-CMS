<?


include "../admin_header.php";

$title = $_POST['title'];
$entry = $_POST['entry'];
$term = $_POST['term'];
$taxo = $_POST['taxo'];

switch_db_connection("taxonomy");
$QQ = "SELECT id FROM content_type WHERE (vid = $taxo)";
$ctid = db_query_value($QQ);
switch_db_connection("copious");

$title = urlencode($title);

$url = "http://$webhost/hosted/contenttypes/save_content.php?sess=$sess&storage_format=&content_type=forums&ctid=$ctid&term=$term&title=$title&nojs=true";
$id = file_get_contents($url);
$id = trim($id);

///
$html = urlencode($entry);
$UU = "UPDATE copious.all_content SET HTML = '$html' WHERE id = '$id'";
db_query_exe($UU);
/*
*/
echo $UU . "<br>";
?>
This topic has been saved.
