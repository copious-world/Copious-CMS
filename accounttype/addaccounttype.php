<?php

	include "../admin_header.php";


	function get_word_id($name) {
		switch_db_connection('taxonomy');
		$name = strtolower($name);
		$QQ = "SELECT id FROM term_presupose WHERE words = '$name'";
		$wid = db_query_value($QQ);
		if ( $wid <= 0 ) {
			$QQ = "SELECT id FROM term_new WHERE words = '$name'";
			$wid = db_query_value($QQ);
			if ( $wid <= 0 ) {
				$wid = db_fetch_contents("http://$webhost/taxonomy/newword.php?sess=$sess&word=$name");
			}
		}
		switch_db_connection('copious');
		return($wid);
	}

	$name = $_POST['name'];
	$description = $_POST['description'];
	$needs_form = ( $_POST['needs_form'] == 'on' ) ? 1 : 0;
	$needs_approval = ( $_POST['needs_approval'] == 'on' ) ? 1 : 0;
	$needs_pay = ( $_POST['needs_pay'] == 'on' ) ? 1 : 0;
	$price = $_POST['price'];
	$serviceid = $_POST['serviceid'];
	$roles = "default";

	$help = $_POST['help'];

	$description = urlencode($description);
	$needs_form = $needs_form == "on" ? 1 : 0;
	

	$QQ = "SELECT count(*) FROM accounttypeknown WHERE name = '$name'";
	$n = db_query_value($QQ);

	$wid = get_word_id($name);

	if ( $n <= 0 ) {

/// Make sure there is a word id for this name....
/// 
		$help = urlencode($help);
		$ii = "insert into accounttypeknown (id,name,wid,description,formula,help) VALUES (0,'$name','$wid','$description','atom','$help')";
		db_query_exe($ii);
	} else {
		$uu = "update accounttypeknown SET wid = $wid, description = '$description', formula = 'atom', help = '$help' WHERE name = '$name'";
		db_query_exe($uu);
	}

	$qq = "select count(*) from accounttypes where ( type_name = '$name' ) AND ( serviceid = '$serviceid' )";
	$n = db_query_value($qq);

	if ( $n <= 0 ) {
		$ii = "insert into accounttypes (id,type_name,roles,serviceid,description) VALUES (0,'$name','$roles','$serviceid','$description')";
		db_query_exe($ii);
	
		$qq = "select id from accounttypes where ( type_name = '$name' ) AND ( serviceid = '$serviceid' )";
		$acid = db_query_value($qq);
	
		$ii = "insert into authspecials (id,uid,serviceid,account_type_id,needs_form,needs_approval,needs_pay,price) VALUES";
		$ii .= " (0,0,$serviceid,'$acid',$needs_form,$needs_approval,$needs_pay,'$price')";
		db_query_exe($ii);

echo "NEW ACCOUNT TYPE $name INSERTED";

	} else {
		$qq = "select id from accounttypes where ( type_name = '$name' ) AND ( serviceid = '$serviceid' )";
		$acid = db_query_value($qq);

		$uu = "update accounttypes set type_name = '$name', roles = '$roles', serviceid = '$serviceid', description = '$description' where id = '$acid'";
		db_query_exe($uu);

		$qq = "select * from authspecials where ( account_type_id = '$acid' ) AND ( serviceid = '$serviceid' )";
		$objes = db_query_object_list($qq);

		foreach ( $objes as $obj ) {
			$id = $obj->ID;
			if ( $obj->UID == 0 ) {
				$uu = "update authspecials set needs_form = $needs_form, needs_approval = $needs_approval, needs_pay = $needs_pay, price = '$price' where ( id = '$id' )"; 
			} else {
				if ( $price > $obj->price ) $price = $obj->price;
				if ( !($obj->needs_form) ) $needs_form = $obj->needs_form;
				if ( !($obj->needs_approval) ) $needs_approval = $obj->needs_approval;
				if ( !($obj->needs_pay) ) $needs_approval = $obj->needs_pay;
				
				$uu = "update authspecials set needs_form = $needs_form, needs_approval = $needs_approval, needs_pay = $needs_pay, price = '$price' where ( id = '$id' )"; 
			}
			db_query_exe($uu);
		}

echo "ACCOUNT TYPE $name UPDATED";

	}

?>
	