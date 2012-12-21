<?php
	//
	$application = "Copious Mail";

if ( isset($_GET["sess"]) ) {
	$sess = $_GET["sess"];
	$grouplabel = $_GET['mailgroup'];

	$username = $_GET['username'];
	$grouplabel = $_GET['grouplabel'];
	$recipients = $_GET['recipients'];
}
include 'servicename.php';
try {
	include '../database.php';
	include 'emailutils.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
require_once('../user_from_session.php');

	$senddate = datetime();
	
	$blocked_members = get_blocking_members($userid,$grouplabel);
	$recipients = nonblocked_emails($recipients,$blocked_members);
	//
	$message = "";
	$message .= "You are invited by user, $username, to be a group mail user.\n";
	$message .= "$username would like to exchange messages in group, $grouplabel.\n\n";
	$message .= "If you are new to $application, please follow this link to sign up: http://www.copious-systems.com/mail/newuser.html .\n";
	$message .= "Otherwise, create a group $grouplabel if you haven't and add $username to your member list.";

	copious_db_mail($recipients,"Invitation to join $username as a user of $application",$message);

	unset($blocked_members);
	echo  "$recipients have been invited";

?>
