<?php
	$QQ = "SELECT count(*) FROM rolled_oats WHERE classified = 0";
	$n = db_query_value($QQ);

	$oat_list_txt = "";


$n = 1;

	if ( $n > 0 ) {
		//$QQ = "SELECT name, author, date FROM rolled_oats WHERE classified = 0";
		//$oat_list = db_query_object_list($QQ);

	$oat_list = array(	);
	for( $i = 0; $i < 3; $i++ ) {
		$oat_list[] = (object)array("name" => "test$i", "author" => "test$i", "date" => "test$i" );
	}

$rows = "";
$oat_list_txt = "[";
$oat_list_names = array();
///---------------------------------------
		foreach ( $oat_list as $oatobj ) {
			$oat_list_names[] = "[ '" . $oatobj->name . "','" . $oatobj->author . "','" . $oatobj->date . "' ]";
///
		}
///---------------------------------------

		$oat_list_txt = implode(",",$oat_list_names);

	} else {
		echo "There are no rolled oats requiring classification at this time.";
	}
?>

<script language="JavaScript" type="text/javascript" >
g_unclassified_oat_header = ["Name","Author","Date"];
g_unclassified_oat_array = [<?php echo $oat_list_txt ?>];
</script>
