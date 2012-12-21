<?php

include "../admin_header.php";

$ftmp = $_FILES['ad_picture']['tmp_name'];
$oname = $_FILES['ad_picture']['name'];

////

list($stemname, $extstrl) = explode(".", $oname);
if ( $extstrl == "JPG" ) {
	$extstrl = "jpg";
}
if ( $extstrl != "jpg" ) {
	echo "The image type needs to be a jpg";
	exit;
}

$fname = 'pictures/profile' . "_" . $username . "_" . $bus_appdir . "." . $extstrl;


if( move_uploaded_file($ftmp, $fname) ){

?>

<html>
<head>
</head>
<body>
<center>
<img src="<?php echo $fname; ?>" height="150" width="150">
</center>
</body>
</html>

<?php
} else {
?>
<html>
<head>
</head>
<body>
<center>
Upload failed.
</center>
</body>
</html>
<?php
}
?>
