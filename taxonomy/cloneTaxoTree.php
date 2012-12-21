<?php


$dbspecific = "taxonomy";
include "../admin_header_lite.php";
global $db_connection;



if ( isset($_POST) ) {
$whichtaxo = $_POST['based_on_taxonomy'];
$taxoname = $_POST['taxoname'];
} else {
$whichtaxo = $_GET['based_on_taxonomy'];
$taxoname = $_GET['taxoname'];
} 
/*
*/



$QQ = "SELECT name, description, help, hierarchy, multiple, relations, required, tags, weight, FROM vocabulary where id = $whichtaxo";
$taxo = db_query_object($QQ);

$name = $taxo->name;
$decsription = "similar to $name which is described as: " . $taxo->description;
$name = $taxoname;

$help = $taxo->help;
$hierarchy = $taxo->hierarchy;
$relations = $taxo->relations;
$multiple = $taxo->multiple;
$required = $taxo->required;
$tags = $taxo->tags;
$weight = $taxo->weight;

$text =<<<LNAME
			<li>root<ul>
			</ul></li>
LNAME;
$text = urlencode($text);

$QQ = "insert into vocabulary (id, name, description, help, hierarchy, multiple, relations, required, tags, weight,HTML)";
$QQ .= " VALUES              (0,'$name','$description','$help',$hierarchy,$multiple,$relations,$required,$tags,$weight,'$text')";

db_query_exe($QQ);

$QQ = "select id from vocabulary where name = '$name'";
$id = db_query_value($id);


if ( isset($_POST) ) {
?>

g_vocid = <?php echo $id; ?>;
save_taxonomy_tree();

<?php
}
?>
