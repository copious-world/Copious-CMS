<?php


require_once("../servicename.php");

require_once('../identity.php');
require_once('../userfeatures.php');


global $db_connection;


$servicename = $_GET['servicename'];
$serviceurl = $_GET['serviceurl'];
$uid = $_GET['fiz'];
///

// There needs to be a SUPER for each Business ADMIN....
// SO Find business without SUPER account types, determined by serviceid in account types...
$QQ = "SELECT id,servicename from serivcesource where ( servicename = '$servicename' )";
$service = db_query_object($QQ);
$id = $service->id;
$name = $service->servicename;

$II = "INSERT into accounttypes (ID,type_name,roles,serviceid,description) VALUES (0,'SUPER','admin','$id','Super User for business $name.')";
db_query_exe($II);
///
$QQ = "SELECT id,serviceid from accounttypes where ( type_name = 'SUPER' ) AND ( serviceid = '$id' )";
$acc = db_query_object($QQ);

$II = "INSERT into authspecials (ID,uid,serviceid,account_type_id) VALUES (0,0,$serviceid,$actid)";
db_query_exe($II);
$II = "INSERT into authspecials (ID,uid,serviceid,account_type_id) VALUES (0,$uid,$serviceid,$actid)";
db_query_exe($II);


/// Make sure that the owner of his business can access the business manager pages of his account.
/// The user effectively signs up from his own new business...
$UU = "UPDATE users SET orginal_source = '$name' WHERE id = '$uid'";
db_query_exe($UU);

$new_business_dir = get_file_contents("http://$webhost/hosted/businesses/newdir.php?servicename=$servicename&key=$validationkey");

?>
