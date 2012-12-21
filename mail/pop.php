<?php
/*
	Really generic POP class, instead of using IMAP/SOCKETS
*/

class pop {
	#####################
	## Class Variables ##
	#####################

	var $username = "";
	var $password = "";
	var $host = "";
	var $port = "";

	var $pop_connect = "";
	var $log = "";
	var $delete = "0";

	#############################
	## Used to create new clas ##
	#############################

	function pop ( $user, $pass, $host = "127.0.0.1", $port = "110" )
	{
		if ( $user == "" ) { return 0; }
		if ( $pass == "" ) { return 0; }
		if ( $host == "" ) { return 0; }
		$this->port = $port;
		$this->username = $user;
		$this->password = $pass;
		$this->host = $host;
		return 1;
	}

	##################################
	## Connect to your pop server,  ##
	## return how many messages, or ##
	## an error code                ##
	##################################

	function connect ()
	{
		$this->pop_connect = fsockopen($this->host, $this->port, $error_number, $error_string, 30);
		if ( !$this->pop_connect )
		{
			echo "$error_string ($error_number)<br>\n";
			return -1;
		}
		$results = $this->_read();
		if ( $this->_check($results) )
		{
			$this->_write("USER $this->username");
			$results = $this->_read();
			if ( $this->_check($results) )
			{
				$this->_write("PASS $this->password");
				$results = $this->_read();
				if ( $this->_check($results) ) 
				{
					return $this->_howmany($results);
				}
				else
					return -4;
			} else
				return -3;
		} 			
		return -2;
	}

	##################################
	## Check to see how many emails ##
	## there are in your inbox      ##
	##################################

	function _howmany ()
	{
		$this->_write("STAT");
		$results = $this->_read();
		list ( $results, $messages, $bytes ) = split(" ", $results);
		return $messages;
	}

	####################################
	## check to make sure it returned ##
	## an "OK" from server            ##
	####################################

	function _check ( $results )
	{
		if ( preg_match("/\+OK/", $results) )
			return 1;
		else
			return 0;
	}

	##################################
	## Used to read from connection ##
	##################################

	function _read ( $bytes = 128 )
	{
		$results = "";
		$results = fread($this->pop_connect, $bytes);
		$this->log .= $results;
		return $results;
	}

	#################################
	## Used to write to connection ##
	#################################

	function _write ( $message )
	{
		$this->log .= $message . "\n";
		fwrite($this->pop_connect, $message . "\n");
	}

	####################################
	## Lets see this log we have made ##
	####################################

	function showlog ()
	{
		return $this->log;
	}

	#################################
	## By default, it won't delete ##
	## any e-mails stored.  If you ##
	## want to, just call this     ##
	## function.                   ##
	#################################

	function delete ()
	{
		$this->delete = "1";
	}

	##################################
	## Returns the email, including ##
	## headers and body back in an  ##
	## array                        ##
	##################################

	function getmessage ( $id )
	{
		$this->_write("RETR $id");
		$body_len = $this->_read();
		preg_match_all("/([0-9]+)/", $body_len, $matches);
		$length = $matches[0][0];
		if ( $length <= 1024 ) {
			$email = $this->_read($length);
		} else {
			list($loop, $dec) = split("\.", $length / 1024);
			for ( $i = 0; $i < $loop; $i++ ) { $email .= $this->_read(1024); }
			if ( $dec ) {
				$read = 1024 * $loop;
				$length = $length - $read;
				$email .= $this->_read($length);
			}
		}
		if ( $this->delete ) {
			$this->_write("DELE $id");
			$results = $this->_read();
		}
		list($headers, $body, $end) = split("\r\n\r\n", $email);
		$email = "";
		$array = split("\n", $headers);
		$count = count($array);
		for ( $i = 0; $i < $count; $i++ ) {
			if ( preg_match("/: /", $array[$i]) ) {
				list($index, $contents) = split(":", $array[$i]);
				$index = strtolower($index);
				$email[$index] = $contents;
				$contents = "";
			} else {
				$contents = trim($array[$i]);
				$email[$index] .= $contents . "\n";
				$contents = "";
			}
		}
		$email["body"] = $body;
		return $email;
	}

	##################################
	## Disconnects from your server ##
	##################################

	function disconnect ()
	{
		$this->_write("QUIT");
		$this->_read();
	}
}
