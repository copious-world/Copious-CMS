<?php

$dbspecific = "taxonomy";
include "../../admin_header.php";


$QQ = "SELECT HTML FROM vocabulary WHERE ( serviceid = $serviceid ) AND ( name = forums )";
$output = db_query_value($QQ);

$output = urldecode($output);

echo $output;

?>
