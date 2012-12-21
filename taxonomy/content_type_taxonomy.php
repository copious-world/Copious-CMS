<?


include '../admin_header.php';



function get_taxonomy_from_content_type($typename) {
	switch_db_connection("taxonomy");

	$QQ = "SELECT vid FROM content_type where name = '$typename'";
	$vocid = db_query_value($QQ);

	switch_db_connection("copious");
	return($vocid);
}

$typename = $_GET['content_type'];
$sess= $_GET["sess"];
$container= $_GET["container"];

$taxonomy_tree = "RENDERED THIS TAXONOMY...";


$content_elements=<<<EOLIST
<div style="font-weight:bold;text-align:center;border-bottom:3px solid darkgreen;background-color:#FEDCBA" >$typename</div>
<div id="current_taxonomy" class="taxovars_selector" >
$taxonomy_tree
</div>
EOLIST;

$content_elements = urlencode($content_elements);
$content_elements = str_replace("+"," ",$content_elements);

$vocid = get_taxonomy_from_content_type($typename);

$url = "http://$webhost/hosted/taxonomy/fetchtaxonomy.php?sess=$sess&id=$vocid&container=$container";
$controltext = file_get_contents($url);
?>

$('content_type_taxonomy').innerHTML = decodeURIComponent("<?php echo $content_elements ?>");
<?php
	echo $controltext;
?>
