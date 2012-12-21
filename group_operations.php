<?php


function copy_group_members($group_user_origin,$uid,$group_origin) {

	$QQ = "SELECT group_list, group_id_list FROM users_mail_groups WHERE ( UID = '$group_user_origin' ) AND ( groupNumber = '$group_origin')";
	$lists = db_query_object($QQ);

	$group_list = $lists->group_list;
	$group_id_list = $lists->group_id_list;

	/// This operation makes the general group "Everyone" have the same members as the group being copied.
	$II = "INSERT into users_mail_groups (id,UID,groupNumber,group_list,group_id_list) VALUE (0,$uid,1,'$group_list','$group_id_list')";
	db_query_exe($II);

}


function set_account_type($acctype,$uid,$serviceid) {

/// Bipass some account type operations. 
	$QQ = "SELECT id FROM accounttypes WHERE ( serviceid = $serviceid ) AND ( type_name = '$acctype' )";
	$acid = db_query_value($QQ);

	$II = "INSERT INTO authspecials (id,UID,serviceid,account_type_id,needs_form,needs_approval,needs_pay,price,registered) VALUES ";
	$II .= " (0,$uid,$serviceid,$acid,0,0,0,0,1)";
	db_query_exe($II);

}


?>