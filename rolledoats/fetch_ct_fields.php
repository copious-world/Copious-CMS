<?php
	include "../admin_header.php";


	$term = $_GET['term'];
	$content_type = $_GET['content_type'];
	$all = $_GET['all'] == "false" ? false : true;

	$QQ = "SELECT * FROM rolled_oat_field_lists WHERE ( content_type = '$content_type' )";
	if ( !($all) )  {
		$QQ .= " AND ( term = '$term' )";
	}

	$objects = db_query_object_list($QQ);
	$type_objects = array();

	if ( $objects != null ) {
		foreach ( $objects as $obj ) {
			$type_objects[$obj->term] = $obj->field_list; // Originally stored this list in a SQL table field.
		}
	}

	if ( count($type_objects) ) { /// put the variables into the editing panel.
		$type_objects = json_encode($type_objects);

?>
content_type_callback_field_data(<?php echo $type_objects; ?>);

<?php 

	} else {  /// If there is nothing in terms of fields for this types, then just get standard variables...
?>
content_type_vars("<?php echo $content_type; ?>");

<?php 

	}
?>
