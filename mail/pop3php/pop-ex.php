<?php
	include("pop.php");

	$username = "someuser";
	$password = "123";
	$host = "127.0.0.1";

	// Make new instance of POP3 class
	$myConnect = new pop($username, $password, $host);

	// Lets connect, and see how many messages await us.
	$messages = $myConnect->connect();

	switch ( $message )
	{
		case "-1":
			echo "Can't connect to server $server";
			break;
		case "-2":
			echo "Can't read anything from server?";
			break;
		case "-3":
			echo "Bad User!";
			break;
		case "-4":
			echo "Bad Password!";
			break;
		default:
			// Looks like it worked, and you may have some email now!
			// $messages from above contains how many e-mails you have.

			echo "Connection Successful! <br>\n";
			echo "You have $messages E-Mail(s) <br>\n";
			echo "<br>\n";
			echo "Reading some random piece of email<br>\n";

			// If you wish to delete e-mail after you read it, uncomment next line.
			// $myConnect->delete();

			// To load an email, use this next command
			$message = $myConnect->getmessage("1");

			// $message is an array, which contains all of the elements an email
			// would, like "from", "to", "subject", etc.  To see them all, use
			// print_r($message);

			echo "From: $message[from] <br>\n";
			echo "Subject: $message[subject] <br>\n";
			echo "<br>\n";
			echo nl2br($message[body]) . "<br>\n";
			echo "<br>\n";
			echo "Closing Connection ... <br>\n";

			// Now, properly disconnect!!!
			$myConnect->disconnect();

			echo "<br><br>\n";
			echo "Lets see the log .. <br>\n";

			// This isn't complete, if you can't see the entire log
			echo nl2br($myConnect->showlog()) . "<br>\n";
			break;		
	}
?>
