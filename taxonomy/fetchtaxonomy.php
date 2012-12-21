<?php


$dbspecific = "taxonomy";
include "../admin_header_lite.php";
global $db_connection;

$sess= $_GET["sess"];
$id = $_GET["id"];
if ( isset($_GET['container']) ) {
	$current_taxonomy = $_GET['container'];
}
$secondary = false;
if ( isset($_GET['secondary']) ) {
	$secondary = $_GET['secondary'];
}





	$termfield = "{}";

	$QQ = "select name, HTML from vocabulary where id = '$id'";

	$textobj = db_query_object($QQ);

	if ( !($textobj) ) {
		$QQ = "select name from vocabulary where id = '$id'";
		$name = db_query_value($QQ);

		if ( $name == -1 ) {
			$name = "NON EXISTANT";
			$text = "&lt;empty&gt;";
		} else {

$text =<<<LNAME
			<li>/<ul>
			</ul></li>
LNAME;
		}

	} else {

		$name = $textobj->name;
		$text = $textobj->HTML;

		$QQ = "select label_id_pairs from vocabulary where id = '$id'";
		$termfield = db_query_value($QQ);
		if ( ( $termfield == -1) || ( strlen($termfield) == 0 ) ) {
			$termfield = "{}";
		}
	}

	//$text = urlencode($text);
	$text = str_replace("+"," ",$text);

	$termfield = str_replace(":","':",$termfield);
	$termfield = str_replace(", ",", '",$termfield);
	$termfield = str_replace("{ ","{ '",$termfield);


?>

g_vocname = "<?php echo $name; ?>";
g_vocid = <?php echo $id; ?>;
g_fetched_term_ids = <?php echo $termfield; ?>;

////
<?php
if ( !isset($current_taxonomy) ) {
?>
$('current_taxonomy').innerHTML = decodeURIComponent('<?php echo $text; ?>');
render_vocabulary_tree();
<?php
	if ( $secondary ) {
		echo "secondary_taxonomy_render();\n";
	}
} else {
?>
$('<?php echo $current_taxonomy; ?>').innerHTML = decodeURIComponent('<?php echo $text; ?>');
render_vocabulary_tree('<?php echo $current_taxonomy; ?>');
<?php
	if ( $secondary ) {
		echo "secondary_taxonomy_render();\n";
	}
}
?>


