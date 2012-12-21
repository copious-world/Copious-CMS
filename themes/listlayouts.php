<?php


	$reporttype = $_GET['type'];

/*
	$QQ = "SELECT name FROM rolled_oat_panels";
	$layouts_array = db_query_list($QQ);

	$layouts = implode("','",$layouts_array);

	echo "['" . $layouts ."']";

*/



	$layouts_array = array('basic','copious');

	if ( $reporttype == "array" ) {
	
		$layouts = implode("','elid_",$layouts_array);
		echo "['elid_" . $layouts ."']";

	} else if ( $reporttype == "active_table" ) {
		$output = "<table class='systable' > ";
		foreach ( $layouts_array as $layout ) {

			$output .= "<tr>";
			$output .=<<<EODATA
<td id="elid_$layout" class="sys_td" >
$layout
</td>
EODATA;
			$output .= "</tr>";


		}
		$output .= "</table> ";

		echo $output;
	}

?>
