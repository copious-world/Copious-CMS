<?php

include "../admin_header.php";



$reporter = $_GET['reporter'];
$content_type = $_GET['vocname'];
$classifier = $_GET['tagname'];

$formplacer = $_GET['formplacer'];


$QQ = "SELECT date,id,title FROM all_content where ( content_type = '$content_type' ) AND ( classifier = '$classifier' ) ORDER BY date"; 
$pubsarray = db_query_object_list($QQ);

$sarray = array();
foreach ( $pubsarray as $pub ) {
$k = $pub->date . $pub->id;
$sarray[$k] = $pub;
}

krsort($sarray);

$i = 0;
foreach ( $sarray as $k => $pub ) {
$i++;

$id = $pub->id;
$title = $pub->title;
$date = $pub->date;

$element_list .=<<<EOROWDATA
<tr>
<td class="sys_td" style="width:25%" >
<span class="buttonLike" id="content_$i" onclick="get_data_object($id,'$content_type','$classifier');" >$date</span>
</td>
<td class="sys_td" >
$title
</td>
</tr>

EOROWDATA;

}


$dataobject_selector =<<<EOFDOBJ
<div style="text-align:left;padding:8px;border:2px #AFAFCC solid;" >
<table class="sys_table" >
$element_list
</table>
</div>
EOFDOBJ;


$tagged_data = urlencode($dataobject_selector);
$tagged_data = str_replace("+"," ",$tagged_data);


?>

// List of types... 
$('<?php echo $reporter; ?>').innerHTML = decodeURIComponent('<?php echo $tagged_data; ?>');

