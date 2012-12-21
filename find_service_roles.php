<?



function roles_taxonomy_id_for_service($sess) {
	global $user;
	global $sessobj;

	if ( !isset($user) ) {
		echo "NO KNOWN USER";
		exit();
	}
	$signup_service = $user->original_source;
	$roletaxo = "roles";
	$id = 0;
	///

	$QQ = "SELECT id FROM serivcesource where servicename = '$signup_service'";
	$service_id = db_query_value($QQ);
	if ( $service_id > 0 ) {
		if ( $sessobj->service_entry == $service_id ) {  // They came from the same place...
			$roletaxo = "roles_$signup_service";
			switch_db_connection('taxonomy');
			$QQ = "SELECT id from vocabulary where name = '$roletaxo' AND serviceid = '$service_id'";
			$id = db_query_value($QQ);
			if ( $id > 0 ) {
				switch_db_connection('copious');
				return(array($roletaxo,$id,$signup_service));
			} else {
				$roletaxo = "roles";
				switch_db_connection('taxonomy');
				$QQ = "SELECT id from vocabulary where name = 'roles' AND serviceid = '$service_id'";
				$id = db_query_value($QQ);
				switch_db_connection('copious');
				return(array($roletaxo,$id,$signup_service));
			}
		}
	}

	switch_db_connection('taxonomy');
	$QQ = "SELECT id from vocabulary where name = 'roles' AND serviceid = '$service_id'";
	$id = db_query_value($QQ);
	switch_db_connection('copious');



	return(array($roletaxo,$id,$signup_service));

}




?>