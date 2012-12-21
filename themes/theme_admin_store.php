<?php

include "../admin_header.php";


$content_type = $_POST['content_type'];
$term = $_POST['term'];
$formatted_text = $_POST['formatted_text'];
$editing_text = $_POST['editing_text'];
$drop_spots = $_POST['drop_spots'];

$RR = "( content_type = '$content_type' ) AND ( term = '$term' ) AND ( serviceid = '$serviceid' )";


$QQ = "SELECT id FROM theme_editing_data WHERE $RR";
$id = db_query_value($QQ);
///------->

$formatted_text = urlencode($formatted_text);
$editing_text = urlencode($editing_text);

if ( $id < 0 ) {	
	$EX = "INSERT INTO theme_editing_data (id,serviceid,content_type,term,formatted_text,editing_text,drop_spots) VALUES (0,$serviceid,'$content_type','$term','$formatted_text','$editing_text','$drop_spots')";
} else {
	$EX = "UPDATE theme_editing_data SET content_type = '$content_type', term = '$term',formatted_text = '$formatted_text',editing_text = '$editing_text',drop_spots = '$drop_spots' WHERE id = '$id'";
}

db_query_exe($EX);

$formgenerator = "form_from_theme.php?sess=$sess&content_type=$content_type&term=$term";
file_get_contents("http://$webhost/hosted/themes/$formgenerator");

?> 
Data Stored <span style="font-weight:bold;font-size:0.65em;color:green"><?php echo $RR ?></span>
