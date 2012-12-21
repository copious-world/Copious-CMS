<?


	require_once "admin_header_lite.php";

	$QQ = "SELECT * FROM syscommand_queue";
	$syscoms = db_query_object_list($QQ);

	$deletables = array();
	foreach ( $syscoms as $com ) {

		$id = $com->id;
		$deletables[] = $id;
		$command = $com->command;

		$servicename = $com->servicename;
		$parameters = $com->parameters;
		$data =  $com->data;

		$vars = json_decode($data);
		include_once($command);

	}

	$todelete = implode(",",$deletables);
	$DD = "DELETE FROM syscommand_queue where id in ($todelete)";
	db_query_exe($DD);

?> 
