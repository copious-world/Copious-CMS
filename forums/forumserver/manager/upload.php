<?php

include '../servicename.php';
try {
	include '../../../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}


$ftmp = $_FILES['ad_picture']['tmp_name'];
$oname = $_FILES['ad_picture']['name'];


////
$refnumber = $_POST['refnumber'];
$section_number = $_POST['section_number'];

$section_number = str_replace(".","_",$section_number);

function record_last_seqname($refnumber,$fname) {
	global $db_connection;
	//
	$section_q = "select count(*) from classifieds_images where ( refnum = '$refnumber' )";
	//
	$q_result = @mysqli_query($section_q) or die (mysqli_error($db_connection));  // 
	$row = @mysqli_fetch_row($q_result);
	$counter = $row[0];

	if ( $counter <= 0 ) {
		$section_maker = "insert into classifieds_images (ID,refnum,filename) VALUES (0,$refnumber,'$fname')";
		$q_result = @mysqli_query($db_connection,$section_maker) or die (mysqli_error($db_connection));  // 
	} else {
		$section_maker = "update classifieds_images set filename = '$fname' where ( refnum = '$refnumber' )";
		$q_result = @mysqli_query($db_connection,$section_maker) or die (mysqli_error($db_connection));  // 
	}
}



list($stemname, $extstrl) = explode(".", $oname);
$fname = 'pictures/'. $stemname . "_" . $refnumber . "_" . $section_number . "." . $extstrl;

$seq = 1;
$tmp = $fname;
while ( file_exists($tmp) ) {
	$seq++;
	$tmp = 'pictures/'. $stemname . "_" . $refnumber . "_" . $section_number . $seq . "." . $extstrl;
}
$fname = $tmp;


if( move_uploaded_file($ftmp, $fname) ){
	record_last_seqname($refnumber,$fname);
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
