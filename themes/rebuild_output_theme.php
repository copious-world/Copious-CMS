<?php

echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

require_once("../admin_header.php");

$theme = $_POST['themename'];
$vars = $_POST['vars'];
$validationkey = $_POST['validkey'];

$varstr = json_encode($vars);

$II = "INSERT INTO syscommand_queue (id,command,servicename,parameters,data) VALUES (0, 'themes/theme_changer.php', '$bus_appdir', 'appdir=$appdir&theme=$theme&newdataphp=false' ,'$varstr')";
db_query_exe($II);


$UU = "UPDATE serivcesource SET theme = '$theme' WHERE servicename = '$bus_appdir'";
db_query_exe($UU);


?>
Ready for chron job processing...
