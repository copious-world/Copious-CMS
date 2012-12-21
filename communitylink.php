<?php


	global $db_connection;
	require_once('admin_header_lite.php');
	require_once("identity.php");
	require_once("copiousauth/userdata.php");


	function insert_secondary_login_sync($uid,$appdir) {

		$status = "executing";

		$qq = "select u.username, a.password, u.email from users AS u INNER JOIN authpass as a on (u.id = a.uid) where u.id = '$uid'";
		$userObject = db_query_object($qq);
	
		$processor = "http://localhost/drupal/";

		$readyin = false;

		$params = '?appdir=' . $appdir . '&op=create&name=' . $userObject->username . "&mail=" . $userObject->email . "&pass=" . $userObject->password;

		$status = file_get_contents( $processor . "hostedops.php" . $params);

		return($status);
	}


	function reset_secondary_password($uid) {
		global $db_select;
		global $dbspecific;
		global $secondaryDB;
		global $db_prefix;
		global $db_connection;

		$qq = "select u.username, a.password, u.email from users AS u INNER JOIN authpass as a on (u.id = a.uid) where u.id = '$uid'";
		$userObject = db_query_object($qq);

		$db_select = mysqli_select_db($db_connection,$secondaryDB) or die (mysqli_error($db_connection));

		$tables = array();
		$tables[] = "users";

		$pass = md5($userObject->password);
	
		$qq = "update {users} set pass = '$pass' where (name = '$userObject->username') AND (mail = '$userObject->email')";
		$sql = plainSql($db_prefix,$tables,$qq);
		db_query_exe($sql);

		$db_select = mysqli_select_db($db_connection,$dbspecific) or die (mysqli_error($db_connection));
	}

	////reset_secondary_password(15);
?>

