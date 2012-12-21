<?php


include "../admin_header.php";


$oatlist = $_POST['oatlist'];
$oatclass = $_POST['oatclass'];


/// Each time a classification is stored, the whole classification structure is stored.
/// Each classification structure is a list of class name,typename pairs, colon separated, "A" : " B"
/// This results in a list of classifications made each session.
/// When the list is loaded (recalled), the sessions are restored in an order of oldest to newest; so that,
/// newer classifcations mask older classification in case of a change. (which should be rare)

$now = datetime();
$II = "INSERT INTO rolled_oat_classifier (id,classifier,date) VALUES (0,'$oatclass','$now')";
db_query_exe($II);

/// Finally, mark the rolled oat as classified...
$UU = "UPDATE rolled_oats SET classified = 1 WHERE name in ('$oatlist')";
db_query_exe($UU);


?>
