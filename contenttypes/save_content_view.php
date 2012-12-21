<?php

include "../admin_header.php";


// Allas, the universal form does not have to be rendered into a list of posted variables.
// But, a json encoded array of elements can store the object in perpepituity. Provided it can
// be disected at a later time. 

$id = $_GET['objectid'];
$html = $_GET['html'];
///

/// TITLE

$UU = "UPDATE all_content SET HTML = '$html' where id = '$id'";
db_query_exe($UU);


?>

alert("You entry has been saved.");
