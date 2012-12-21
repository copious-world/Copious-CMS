<?php

/// User's Own

$leftLogo = "/hosted/img/logo.jpg";
$rightLogo = "/hosted/img/logo.jpg";


include "../admin_header.php";

$vid = $_GET['poll'];
$term =  $_GET['term'];

switch_db_connection("taxonomy");
$QQ = "SELECT id FROM content_type WHERE vid = $vid";
$ctid = db_query_value($QQ);


switch_db_connection("copious");
$QQ = "SELECT id, date, title FROM all_content WHERE ( ct_id = $ctid ) AND ( classifier = '$term' ) ORDER BY date"; 
$forum_elements = db_query_object_list($QQ);

$sectionText = "";

foreach ( $forum_elements as $elem ) {
	///------------
	$id = $elem->id;
	$date = $elem->date;
	$title = $elem->title;

$row =<<<EOLISTERROW
<tr>
<td width="15%" class="lister_date" onclick="show_details($id);">$date</td><td width="85%" class="lister_title" onclick="show_details($id);">$title</td>
</tr>

EOLISTERROW;

	$sectionText .= $row;

}
/*
var_dump($_GET);
*/

?>


<table border="0" cellspacing="0" cellpadding="0" width="100%" ID="Table1">
<tbody>
<?php echo $sectionText; ?>
</tbody>
</table>
