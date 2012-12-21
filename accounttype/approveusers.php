<?php


include "../admin_header.php";


$approval_array = $_POST['approved'];

$appstr = implode("','",array_keys($approval_array));
$appstr = "'$appstr'";

$UU = "UPDATE authspecials SET needs_approval = 0 WHERE UID in ($appstr)";
db_query_exe($UU);


?>


<html>
<head>
</head>
<body>
User Approved...
<?php

echo $appstr;

?>
</body>
</html>
