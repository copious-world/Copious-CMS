<?php


// Returns an array containing "howMany" random bytes. YOU SHOULD CHANGE THIS
// TO RETURN HIGHER QUALITY RANDOM BYTES IF YOU ARE USING THIS FOR A "REAL"
// APPLICATION.

function getRandomBytes($howMany) {
	$bytes = array();
	//
	for ( $i = 0; $i < $howMany; $i++ ) {
		$bytes[$i] = round( rand() * 255 );
	}
	return $bytes;
}


function stringToHex($str) {
	$n = strlen($str);
	$result = "";
	
	for ( $i = 0; $i < $n; $i++ ) {
		$c = $str[$i];
		$result .= sprintf( "%02x" ,ord($c) );
	}
	
	return($result);
}


// This method takes a byte array (byteArray) and converts it to a string by
// applying String.fromCharCode() to each value and concatenating the result.
// The resulting string is returned. Note that this function SKIPS zero bytes
// under the assumption that they are padding added in formatPlaintext().
// Obviously, do not invoke this method on raw data that can contain zero
// bytes. It is really only appropriate for printable ASCII/Latin-1 
// values. Roll your own function for more robust functionality :)



function byteArrayToString($byteArray) {
	//////
	$result = "";
	//////
	$n = count($byteArray);
	/////
	for( $i = 0; $i < $n; $i++ ) {
		if ( $byteArray[$i] != 0 ) {
			$result .= chr ( $byteArray[$i] );
		}
	}
	return $result;
}


function stringToByteArray($str) {
	$sa = array();
	$n = strlen($str);
	for ( $i = 0; $i < $n; $i++ ) {
		$sa[$i] = ord($str[$i]);
	}
	return($sa);
}


// This function takes an array of bytes (byteArray) and converts them
// to a hexadecimal string. Array element 0 is found at the beginning of 
// the resulting string, high nibble first. Consecutive elements follow
// similarly, for example [16, 255] --> "10ff". The function returns a 
// string.


function byteArrayToHex($byteArray) {
	//
	$n = count($byteArray);
	$result = "";
	//
	for ( $i = 0; $i < $n; $i++ ) {
		$result .= sprintf("%02x",($byteArray[$i]) );
	}
	//
	return $result;
}


function h2_strsplit($hexString) {
	$ar = array();
	$n = strlen($hexString) >> 1;

	for ( $i = 0; $i < $n; $i++ ) {
		$j = $i*2;
		$ar[$i] = substr($hexString,$j,2);
	}
	
	return($ar);
}


// This function converts a string containing hexadecimal digits to an 
// array of bytes. The resulting byte array is filled in the order the
// values occur in the string, for example "10FF" --> [16, 255]. This
// function returns an array. 

function hexToByteArray($hexString) {
	//
	$byteArray = array();
	//
	if ( strlen($hexString) % 2 ) return;          // must have even length

	// remove leading hexadecimal indicator.
	if ( ( strncmp($hexString,"0x",2) == 0 ) || ( strncmp($hexString,"0X",2) == 0 ) ) {
		$hexString = substring($hexString,2);
	}
	
	///	$prebytes = str_split($hexString,2);  // str_split
	$prebytes = h2_strsplit($hexString);
	$n = count($prebytes);

	for ( $i = 0; $i < $n; $i++ ) {
		list($v) = sscanf($prebytes[$i],"%x");
		$byteArray[$i] = $v;
	}
	return $byteArray;
}

// This function packs an array of bytes into the four row form defined by
// Rijndael. It assumes the length of the array of bytes is divisible by
// four. Bytes are filled in according to the Rijndael spec (starting with
// column 0, row 0 to 3). This function returns a 2d array.

function packBytes($octets) {
	//
	$state = array();
	//
	$n = count($octets);
	
	if ( !( $octets ) || ( $n % 4 ) ) return;
	////
	$state[0] = array();  $state[1] = array(); 
	$state[2] = array();  $state[3] = array();
	////
	for ( $j = 0; $j < $n ; $j += 4 ) {
		$state[0][($j/4)] = $octets[$j];
		$state[1][($j/4)] = $octets[$j + 1];
		$state[2][($j/4)] = $octets[$j + 2];
		$state[3][($j/4)] = $octets[$j + 3];
	}

	return $state;  
}


///////////////////////
//
// This function unpacks an array of bytes from the four row format preferred
// by Rijndael into a single 1d array of bytes. It assumes the input "packed"
// is a packed array. Bytes are filled in according to the Rijndael spec. 
// This function returns a 1d array of bytes.
//
///////////////////////

function unpackBytes($packed) {
	//
	$result = array();
	$n = count($packed[0]);
	//
	$k = 0;
	for ( $j = 0; $j <$n ; $j++ ) {
		$result[$k++] = $packed[0][$j];
		$result[$k++] = $packed[1][$j];
		$result[$k++] = $packed[2][$j];
		$result[$k++] = $packed[3][$j];
	}
	////
	return $result;
}


// This method circularly shifts the array left by the number of elements
// given in its parameter. It returns the resulting array and is used for 
// the ShiftRow step. Note that shift() and push() could be used for a more 
// elegant solution, but they require IE5.5+, so I chose to do it manually. 

function cyclicShiftLeft($theArray, $positions) {
	$frontpart = array_slice($theArray, 0, $positions);
	$backpart = array_slice($theArray,$positions);
	$theArray = array_merge($backpart,$frontpart);
	return $theArray;
}


// This function takes a prospective plaintext (string or array of bytes)
// and pads it with zero bytes if its length is not a multiple of the block 
// size. If plaintext is a string, it is converted to an array of bytes
// in the process. The type checking can be made much nicer using the 
// instanceof operator, but this operator is not available until IE5.0 so I 
// chose to use the heuristic below. 

function formatPlaintext($plaintext) {
	//
	$bpb = blockSizeInBits / 8;               // bytes per block

	$bintextout = array();
	
	// Assume the parameter is a text string.
	
	$n = strlen($plaintext);
	//
	for ( $i = 0; $i < $n; $i++ ) {
		$c = $plaintext[$i];
		$textout[$i] = ord($c) & 0xFF;
	}

	if ( ($n % $bpb) > 0 ) {
		$j = 0;
		for ( $i = ( $bpb - ($n % $bpb) ); ( $i > 0 ) ; $i-- ) {
			$textout[$n + $j++] = 0;
		}
	}

	return $textout;
}

?>