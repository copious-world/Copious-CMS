<?php

// addtaxonomy.php


$dbspecific = "taxonomy";
include "../admin_header_lite.php";
global $db_connection;


if ( isset($_POST['name']) ) {
	$name = $_POST['name'];
	$description = $_POST['description'];
	$help = $_POST['help'];
	$hierarchy = (isset($_POST['hierarchy'])) ? ($_POST['hierarchy'] == "on") : 0;
	$relations = (isset($_POST['relations'])) ? ($_POST['relations'] == "on") : 0;
	$multiple = (isset($_POST['multiple'])) ? ($_POST['multiple'] == "on") : 0;
	$required = (isset($_POST['required'])) ? ($_POST['required'] == "on") : 0;
	$tags = (isset($_POST['tags'])) ? ($_POST['tags'] == "on") : 0;
	$weight = $_POST['weight'];
	$serviceid = $_POST['bus_id'];
} else {
	$name = $_GET['name'];
	$description = $_GET['description'];
	$help = $_GET['help'];
	$hierarchy = (isset($_GET['hierarchy'])) ? ($_GET['hierarchy'] == "on") : 0;
	$relations = (isset($_GET['relations'])) ? ($_GET['relations'] == "on") : 0;
	$multiple = (isset($_GET['multiple'])) ? ($_GET['multiple'] == "on") : 0;
	$required = (isset($_GET['required'])) ? ($_GET['required'] == "on") : 0;
	$tags = (isset($_GET['tags'])) ? ($_GET['tags'] == "on") : 0;
	$weight = $_GET['weight'];
	$serviceid = $_GET['bus_id'];
} 

$text =<<<LNAME
			<li>root<ul>
			</ul></li>
LNAME;
$text = urlencode($text);

$QQ = "select id from vocabulary where name = '$name' AND (serviceid = $serviceid)";
$id = db_query_value($QQ);

if ( $id > 0 ) {
	$DD = "DELETE FROM vocabulary WHERE name = '$name'";  /// AND BUSINESS ID ....  Tie to each business...
	db_query_exe($DD);
}

$QQ = "insert into vocabulary (id, name, serviceid, description, help, hierarchy, multiple, relations, required, tags, weight,HTML)";
$QQ .= " VALUES              (0,'$name','$serviceid','$description','$help',$hierarchy,$multiple,$relations,$required,$tags,$weight,'$text')";

db_query_exe($QQ);

$QQ = "select id from vocabulary where name = '$name' AND (serviceid = $serviceid)";
$id = db_query_value($QQ);


if ( isset($_GET['name']) ) {
?>

g_vocid = <?php echo $id; ?>;
//if ( g_saving_roles ) save_role_tree();
//else if ( g_saving_menus ) save_taxonomy_tree();
alert("Taxonomy <?php echo $name; ?> Created");

<?php 
} else {
?>
"Taxonomy <?php echo $name; ?> Created"
<?php 
}
?>
