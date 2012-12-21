<?php

// DocEvalRequest..

include "../admin_header.php";

/// Same as storage...

$content_type = $_GET['content_type'];
$name = $_GET['name'];

$content_type = '_sys_front_page_not_CT1543657';
$term = $name;

$QQ = "SELECT * FROM theme_editing_data WHERE ( content_type = '$content_type' ) AND ( term = '$term' )";
$theme_editing = db_query_object($QQ);


$editing_text = str_replace("+"," ",$theme_editing->editing_text);
$formatted_text = str_replace("+"," ",$theme_editing->formatted_text);

?>

$('thm_topic1_1_preview').innerHTML = decodeURIComponent("<?php echo $formatted_text ?>");
$('thm_topic1_1').value = decodeURIComponent("<?php echo $editing_text ?>");

