<?php

include "../servicename.php";
include "../database.php";



function transformer($data) {
$fieldinfo = strstr($data,">");
$fieldinfo = trim(substr($fieldinfo,1,strpos($fieldinfo,"<")-1));

$output =<<<EOFTYPEFORM
<input type="text" id="oatcomp-$id" name="$name" class="oatdrop" value="$fieldinfo">
EOFTYPEFORM;
	return($output);
}


$QQ = "SELECT * FROM theme_editing_data WHERE ( content_type = 'blog' ) AND ( term = 'root' )";
$theme_editing = db_query_object($QQ);

$output = urldecode($theme_editing->formatted_text);
$output = str_replace("\\\"",'"',$output);
$output = str_replace("\'","'",$output);

//echo $output;

$marker =<<<OESPANMARK
<span class="buttonLike" id="oat_drop_container
OESPANMARK;
$marker = trim($marker);


while ( ($offset = strpos($output,$marker))!== false ) {
	$prefx = substr($output,0,$offset);
/*
echo "\n";
echo "ECHO PRE $prefx";
echo "\n";
*/
	$rest = substr($output,$offset);
/*
echo "ECHO REST $rest";
echo "\n";
*/
	$postfx = substr(strstr($output,"</span></span>"),strlen("</span></span>"));
/*
echo "ECHO POST $postfx";
echo "\n";
*/
	$ee = strpos($rest,"</span></span>");
	$data = substr($rest,0,$ee);
/*
echo "ECHO DATA ( $ee ) $data";
echo "\n<BR><BR>\n";
*/
	$output = $prefx . transformer($data) . $postfx;
//break;
}

echo $output;
?>


