<?php



	function payer_recordation($serviceid,$paydata) {
		list($uid,$acid) = explode("_",$paydata);
		$QQ = "update authspecials set needs_pay = 0 where (uid = $uid) and (account_type_id = $acid) and ( serviceid = '$serviceid' )";
		db_query_exe($QQ);
	}



?>
