<?php

include "../admin_header.php";

$name = $_POST['name'];
$description = $_POST['description'];
$help = $_POST['help'];

$formatted_text = $_POST['formatted_text'];
$editing_text = $_POST['editing_text'];

/// Just make some random types of symbols not likely to be used as the function indicates, content_type, term.
/// Then, use the same table as for content types and terms. This will have a lot of data.
$content_type = '_sys_front_page_not_CT1543657';
$term = $name;

$QQ = "SELECT id FROM theme_editing_data WHERE ( content_type = '$content_type' ) AND ( term = '$term' )";
$id = db_query_value($QQ);

$formatted_text = urlencode($formatted_text);
$editing_text = urlencode($editing_text);

if ( $n < 0 ) {	
	$EX = "INSERT INTO theme_editing_data (id,content_type,term,formatted_text,editing_text) VALUES (0,'$content_type','$term','','')";
} else {
	$EX = "UPDATE theme_editing_data SET content_type = '$content_type', term = '$term',formatted_text = '$formatted_text' ,editing_text = '$editing_text' WHERE id = '$id'";
}
db_query_exe($EX);

?> 
