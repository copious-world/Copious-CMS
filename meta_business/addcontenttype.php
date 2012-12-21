<?php


include '../admin_header.php';

/*
*/
global $db_connection;

$name = $_POST['name'];
$description = $_POST['description'];
$help = $_POST['help'];

$hierarchy = (isset($_POST['hierarchy'])) ? ($_POST['hierarchy'] == "on") : 0;
$relations = (isset($_POST['relations'])) ? ($_POST['relations'] == "on") : 0;
$multiple = (isset($_POST['multiple'])) ? ($_POST['multiple'] == "on") : 0;
$required = (isset($_POST['required'])) ? ($_POST['required'] == "on") : 0;
$tags = (isset($_POST['tags'])) ? ($_POST['tags'] == "on") : 0;
$weight = $_POST['weight'];

switch_db_connection("taxonomy");





///------------------------------------------------------------>>>
$QQ = "SELECT count(*) FROM content_type WHERE name = '$name'";
$nc = db_query_value($QQ);
///------------------------------------------------------------>>>
$QQ = "SELECT count(*) FROM vocabulary WHERE name = '$name'";
$nt = db_query_value($QQ);
///------------------------------------------------------------>>>




if ( ( $nc > 0 ) && ( $nt > 0 ) ) {
	echo "This content type already exists. Delete it's vocabulary before recreating it.<br>";
$out =<<<EOTD
<td  style="text-align:center;width:15%">
	<a href="/hosted/taxonomy/inuse.php?sess=$sess&appdir=taxonomy&busdir=$bus_appdir" class="buttonLike" style="text-decoration:none;color:darkgreen" target="BUSINESS_TAXONOMY" >Taxonomy</a>
</td>
EOTD;
echo $out;
} else {

	if ( $nt == 0 ) {
		$url = "http://$webhost/hosted/taxonomy/addtaxonomy.php";

		$sep = "?";
		foreach ( $_POST as $key => $value ) {
			if ( $key == "description" ) { $value = urlencode(urlencode($value)); }
			if ( $key == "help" ) { $value = urlencode(urlencode($value)); }

			if ( strlen($value) == 0 ) continue;

			$url .= $sep . $key . "=" . $value;
			$sep = "&";
		}

		$text = file_get_contents($url);

	}

	$QQ = "SELECT id FROM vocabulary WHERE name = '$name'";
	$vid = db_query_value($QQ);

	if ( $nc == 0 ) {
		$EX = "INSERT INTO content_type (id,vid,name) VALUES (0,$vid,'$name')";
	} else {
		$EX = "UPDATE content_type SET vid = $vid where name='$name'";
	}

	db_query_exe($EX);

}


?>

SUCCESSFUL OPERATION.

