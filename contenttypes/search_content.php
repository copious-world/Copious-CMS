<?php


include "../admin_header.php";


function field_calculator($search_object,$fields) {
	///
	return(array(false,""));
}


$content_type = $_GET['content_type'];
$classifier = $_GET['term']; 

$titlecond = "";
if ( isset($_GET['title']) ) {
	$title = $_GET['title']; 
	$titlecond = " AND ( ( LOCATE('$title',title) > 0 ) OR ( title REGEXP '$title') )";
}


$conditions = array();
if ( isset($_GET['date_lb']) ) {
	$date_lb = $_GET['date_lb'];
	$conditions[] = "('$date_lb' <= date )";
}

if ( isset($_GET['date_ub']) ) {
	$date_ub = $_GET['date_ub'];
	$conditions[] = "(date >= '$ubdate')";
}

$disjoints = array();

if ( isset($_GET['fields']) ) {
	$search_object = $_GET['search_object'];
	$fields = $_GET['fields'];

	$fields = urldecode($fields);
	$fields = explode(",",$fields);
	$fields = implode("','",$fields);

	$conditions[] = "( search_on in ('$fields') )";
//
	$search_object = urldecode($search_object);
	$search_object = str_replace("\\","",$search_object);
	$search_object = (array)json_decode($search_object);
	foreach ( $search_object as $ff => $keydat ) {
		$disjoints[] = "((search_on = '$ff') AND ( keydata REGEXP '$keydat' ))";
	}

//
}


///------------------------------------------>>
///------------------------------------------>>

	$conditions[] = "( content_type = '$content_type' )";
	$conditions[] = "( classifier = '$classifier')";

	if ( count($disjoints) ) {
		$conditions[] =  implode( " OR ", $disjoints);
	}

	$cond = implode( " AND ", $conditions);

	$QQ = "SELECT co_id FROM search_content_types WHERE $cond GROUP BY co_id";
	$ctlist = db_query_list($QQ);

	if ( count($ctlist) > 0 ) {
		$ctliststr = implode(",",$ctlist);
	
		$QQ = "SELECT id, date, title FROM all_content WHERE (id in ($ctliststr)) $titlecond ORDER BY date";
		$selectors = db_query_object_list($QQ);
	

	/// Information tag...
/// LIMITS ...
?>
<table class="searchReport" >
<?php
	foreach ( $selectors as $found ) {
$line =<<<EOL
<tr>
<td class="searchReport td id" onclick="display_content('$found->id')">$found->id</td>
<td class="searchReport td date" onclick="display_content('$found->id')">$found->date</td>
<td class="searchReport td title" onclick="display_content('$found->id')">$found->title</td>
</tr>

EOL;
			echo $line;
		}
?>
</table>

<?php
	} else {
		echo "No results match this query";
	}
?>
