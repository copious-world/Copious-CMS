<?php

/* rijndael.php      Rijndael Reference Implementation
   Copyright (c) 2001 Fritz Schneider
*/


require_once("textConvert.php");

// Rijndael parameters --  Valid values are 128, 192, or 256

define("keySizeInBits",		128);
define("blockSizeInBits",	128);


// The number of rounds for the cipher, indexed by [Nk][Nb]
$roundsArray = array( 0, 0, 0, 0, array( 0, 0, 0, 0, 10, 0, 12, 0, 14), 0, 
							array( 0, 0, 0, 0, 12, 0, 12, 0, 14), 0, 
							array( 0, 0, 0, 0, 14, 0, 14, 0, 14 )
                        );

////
// Cipher parameters ... do not change these
$Nk = keySizeInBits / 32;                   
$Nb = blockSizeInBits / 32;
//
$Nr = $roundsArray[$Nk][$Nb];

// The number of bytes to shift by in shiftRow, indexed by [Nb][row]
$shiftOffsets = array( 0, 0, 0, 0, array(0, 1, 2, 3), 0, array(0, 1, 2, 3), 0, array(0, 1, 3, 4) );

// The round constants used in subkey expansion
$Rcon = array( 
	0x01, 0x02, 0x04, 0x08, 0x10, 0x20, 
	0x40, 0x80, 0x1b, 0x36, 0x6c, 0xd8, 
	0xab, 0x4d, 0x9a, 0x2f, 0x5e, 0xbc, 
	0x63, 0xc6, 0x97, 0x35, 0x6a, 0xd4, 
	0xb3, 0x7d, 0xfa, 0xef, 0xc5, 0x91
);

// Precomputed lookup table for the SBox
$SBox = array(
 99, 124, 119, 123, 242, 107, 111, 197,  48,   1, 103,  43, 254, 215, 171, 
118, 202, 130, 201, 125, 250,  89,  71, 240, 173, 212, 162, 175, 156, 164, 
114, 192, 183, 253, 147,  38,  54,  63, 247, 204,  52, 165, 229, 241, 113, 
216,  49,  21,   4, 199,  35, 195,  24, 150,   5, 154,   7,  18, 128, 226, 
235,  39, 178, 117,   9, 131,  44,  26,  27, 110,  90, 160,  82,  59, 214, 
179,  41, 227,  47, 132,  83, 209,   0, 237,  32, 252, 177,  91, 106, 203, 
190,  57,  74,  76,  88, 207, 208, 239, 170, 251,  67,  77,  51, 133,  69, 
249,   2, 127,  80,  60, 159, 168,  81, 163,  64, 143, 146, 157,  56, 245, 
188, 182, 218,  33,  16, 255, 243, 210, 205,  12,  19, 236,  95, 151,  68,  
23,  196, 167, 126,  61, 100,  93,  25, 115,  96, 129,  79, 220,  34,  42, 
144, 136,  70, 238, 184,  20, 222,  94,  11, 219, 224,  50,  58,  10,  73,
  6,  36,  92, 194, 211, 172,  98, 145, 149, 228, 121, 231, 200,  55, 109, 
141, 213,  78, 169, 108,  86, 244, 234, 101, 122, 174,   8, 186, 120,  37,  
 46,  28, 166, 180, 198, 232, 221, 116,  31,  75, 189, 139, 138, 112,  62, 
181, 102,  72,   3, 246,  14,  97,  53,  87, 185, 134, 193,  29, 158, 225,
248, 152,  17, 105, 217, 142, 148, 155,  30, 135, 233, 206,  85,  40, 223,
140, 161, 137,  13, 191, 230,  66, 104,  65, 153,  45,  15, 176,  84, 187,  
 22 );

// Precomputed lookup table for the inverse SBox
$SBoxInverse = array(
 82,   9, 106, 213,  48,  54, 165,  56, 191,  64, 163, 158, 129, 243, 215, 
251, 124, 227,  57, 130, 155,  47, 255, 135,  52, 142,  67,  68, 196, 222, 
233, 203,  84, 123, 148,  50, 166, 194,  35,  61, 238,  76, 149,  11,  66, 
250, 195,  78,   8,  46, 161, 102,  40, 217,  36, 178, 118,  91, 162,  73, 
109, 139, 209,  37, 114, 248, 246, 100, 134, 104, 152,  22, 212, 164,  92, 
204,  93, 101, 182, 146, 108, 112,  72,  80, 253, 237, 185, 218,  94,  21,  
 70,  87, 167, 141, 157, 132, 144, 216, 171,   0, 140, 188, 211,  10, 247, 
228,  88,   5, 184, 179,  69,   6, 208,  44,  30, 143, 202,  63,  15,   2, 
193, 175, 189,   3,   1,  19, 138, 107,  58, 145,  17,  65,  79, 103, 220, 
234, 151, 242, 207, 206, 240, 180, 230, 115, 150, 172, 116,  34, 231, 173,
 53, 133, 226, 249,  55, 232,  28, 117, 223, 110,  71, 241,  26, 113,  29, 
 41, 197, 137, 111, 183,  98,  14, 170,  24, 190,  27, 252,  86,  62,  75, 
198, 210, 121,  32, 154, 219, 192, 254, 120, 205,  90, 244,  31, 221, 168,
 51, 136,   7, 199,  49, 177,  18,  16,  89,  39, 128, 236,  95,  96,  81,
127, 169,  25, 181,  74,  13,  45, 229, 122, 159, 147, 201, 156, 239, 160,
224,  59,  77, 174,  42, 245, 176, 200, 235, 187,  60, 131,  83, 153,  97, 
 23,  43,   4, 126, 186, 119, 214,  38, 225, 105,  20,  99,  85,  33,  12,
125 );



// Multiplies the element "poly" of GF(2^8) by x. See the Rijndael spec.

function xtime($poly) {
	$poly =  $poly << 1;
	return ( ($poly & 0x100) ? ($poly ^ 0x11B) : ($poly) );
}

// Multiplies the two elements of GF(2^8) together and returns the result.
// See the Rijndael spec, but should be straightforward: for each power of
// the indeterminant that has a 1 coefficient in x, add y times that power
// to the result. x and y should be bytes representing elements of GF(2^8)

function mult_GF256($x, $y) {
	//
	$result = 0;

	for ( $bit = 1; $bit < 256; $bit *= 2, $y = xtime($y) ) {
		if ( $x & $bit ) $result ^= $y;
	}
	
	return $result;
}

// Performs the substitution step of the cipher. State is the 2d array of
// state information (see spec) and direction is string indicating whether
// we are performing the forward substitution ("encrypt") or inverse 
// substitution (anything else)

function byteSub(&$state, $direction) {
	global $SBox;
	global $SBoxInverse;

	$S = 0;
	if (direction == "encrypt") {        // Point S to the SBox we're using
		$S = $SBox;
	} else {
		$S = $SBoxInverse;
	}
	//
	for ( $i = 0; $i < 4; $i++ ) {           // Substitute for every byte in state
		for ( $j = 0; $j < $Nb; $j++ ) {
			$state[$i][$j] = $S[$state[$i][$j]] & 0xFF;
		}
	}
}


// Performs the row shifting step of the cipher.

function shiftRow(&$state, $direction) {
	////
	global $Nb;
	global $shiftOffsets;
	////
	for ( $i = 1; $i < 4; $i++ ) {              // Row 0 never shifts
		if ( $direction == "encrypt" ) {
			$state[$i] = cyclicShiftLeft($state[$i], $shiftOffsets[$Nb][$i]);
		} else {
			$state[$i] = cyclicShiftLeft($state[$i], $Nb - $shiftOffsets[$Nb][$i]);
		}
	}
}

// Performs the column mixing step of the cipher. Most of these steps can
// be combined into table lookups on 32bit values (at least for encryption)
// to greatly increase the speed. 

function mixColumn(&$state, $direction) {
	global $Nb;

	$b = array();                            // Result of matrix multiplications
	//
	for ( $j = 0; $j < $Nb; $j++ ) {         // Go through each column...
		//
		for ( $i = 0; $i < 4; $i++ ) {        // and for each row in the column...
			if ( $direction == "encrypt" ) {
				$b[$i] = mult_GF256( $state[$i][$j], 2) ^          // perform mixing
							mult_GF256( $state[($i+1)%4][$j], 3) ^ 
								$state[($i+2)%4][$j] ^ 
									$state[(i+3)%4][$j];
			} else {
				$b[$i] = mult_GF256( $state[$i][$j], 0xE) ^ 
							mult_GF256( $state[($i+1)%4][$j], 0xB) ^
								mult_GF256( $state[($i+2)%4][$j], 0xD) ^
									mult_GF256( $state[($i+3)%4][$j], 9);
			}
		}
		//
		for ( $i = 0; $i < 4; $i++ ) $state[$i][$j] = $b[$i] & 0xFF;        // Place result back into column
		//
	}
}



// Adds the current round key to the state information. Straightforward.

function addRoundKey(&$state, $roundKey) {
	global $Nb;
	//
	for ( $j = 0; $j < $Nb; $j++) {                 // Step through columns...
		$state[0][j] ^= ( $roundKey[$j]		 & 0xFF);         // and XOR
		$state[1][j] ^= (($roundKey[$j]>>8)	 & 0xFF);
		$state[2][j] ^= (($roundKey[$j]>>16) & 0xFF);
		$state[3][j] ^= (($roundKey[$j]>>24) & 0xFF);
	}
}



// This function creates the expanded key from the input (128/192/256-bit)
// key. The parameter key is an array of bytes holding the value of the key.
// The returned value is an array whose elements are the 32-bit words that 
// make up the expanded key.

function keyExpansion($key) {
	global $roundsArray;
	global $Nk;
	global $Nb;
	global $Nr;
	global $shiftOffsets;
	global $Rcon;
	global $SBox;
	global $SBoxInverse;
	//
	$expandedKey = array();

	for ( $j = 0; $j < $Nk; $j++ ) {   // Fill in input key first
		$k = 4*$j;
		$expandedKey[$j] = 
			( $key[$k] ) | ( $key[$k+1] << 8) | ( $key[$k+2] << 16 ) | ( $key[$k+3] << 24 );
	}

	// Now walk down the rest of the array filling in expanded key bytes as
	// per Rijndael's spec
	for ( $j = $Nk; $j < ($Nb * ($Nr + 1)); $j++ ) {    // For each word of expanded key
		$temp = $expandedKey[$j - 1];
		
		if ( ( $j % $Nk ) == 0 ) {
			//
			$temp = ( $SBox[(($temp >> 8) & 0xFF)]  |
						( $SBox[($temp >> 16) & 0xFF] << 8 ) |
						( $SBox[($temp >> 24) & 0xFF] << 16 ) |
						( $SBox[$temp & 0xFF] << 24) ) ^ $Rcon[( floor($j / $Nk) - 1) ];
			//
		} else if ( ( $Nk > 6 ) && ( ( $j % $Nk ) == 4 ) ) {
			//
			$temp = ( $SBox[($temp>>24) & 0xFF] << 24 ) |
					( $SBox[($temp>>16) & 0xFF] << 16 ) |
					( $SBox[($temp>>8) & 0xFF] << 8 ) |
					( $SBox[$temp & 0xFF] );
			//
		}

		$expandedKey[$j] = $expandedKey[$j-$Nk] ^ $temp;
	}

	return $expandedKey;
}

// Rijndael's round functions... 

function CryptoRound(&$state, $roundKey) {
	byteSub($state, "encrypt");
	shiftRow($state, "encrypt");
	mixColumn($state, "encrypt");
	addRoundKey($state, $roundKey);
}

function InverseRound(&$state, $roundKey) {
	addRoundKey($state, $roundKey);
	mixColumn($state, "decrypt");
	shiftRow($state, "decrypt");
	byteSub($state, "decrypt");
}

function FinalRound(&$state, $roundKey) {
	byteSub($state, "encrypt");
	shiftRow($state, "encrypt");
	addRoundKey($state, $roundKey);
}

function InverseFinalRound(&$state, $roundKey){
	addRoundKey($state, $roundKey);
	shiftRow($state, "decrypt");
	byteSub($state, "decrypt");  
}

// encrypt is the basic encryption function. It takes parameters
// block, an array of bytes representing a plaintext block, and expandedKey,
// an array of words representing the expanded key previously returned by
// keyExpansion(). The ciphertext block is returned as an array of bytes.

function encrypt($block, $expandedKey) {
	global $Nr;
	global $Nb;

	if ( !($block) || ( count($block)*8 != blockSizeInBits ) ) {
		echo "Bad BLOCK " . count($block) . " <br> ";
		return; 
	}
	if ( !($expandedKey) ) return;

	$block = packBytes($block);
	addRoundKey($block, $expandedKey);
	//
	$j = $Nb;
	for ( $i = 1; $i < $Nr; $i++ ) {
		CryptoRound($block, array_slice($expandedKey, $j, $Nb) );
	}

	FinalRound( $block, array_slice( $expandedKey, ($Nb*$Nr) ) );

	return unpackBytes($block);
}



// decrypt is the basic decryption function. It takes parameters
// block, an array of bytes representing a ciphertext block, and expandedKey,
// an array of words representing the expanded key previously returned by
// keyExpansion(). The decrypted block is returned as an array of bytes.

function decrypt($block, $expandedKey) {
	global $Nb;
	global $Nr;

	if ( !($block) || ( count($block)*8 != blockSizeInBits ) ) return;
	if ( !expandedKey ) return;

	$block = packBytes($block);
	//
	InverseFinalRound($block, array_slice( $expandedKey ,($Nb*$Nr) ) ); 
	$j = ($Nr - 1)*$Nb;
	for ( $i = ($Nr - 1); $i > 0 ; $i-- ) {
		InverseRound($block, array_slice( $expandedKey, $j, $Nb ) );
		$j -= $Nb;
	}
	addRoundKey($block, $expandedKey);
	return unpackBytes($block);
}





// rijndaelEncrypt(plaintext, key, mode)
// Encrypts the plaintext using the given key and in the given mode. 
// The parameter "plaintext" can either be a string or an array of bytes. 
// The parameter "key" must be an array of key bytes. If you have a hex 
// string representing the key, invoke hexToByteArray() on it to convert it 
// to an array of bytes. The third parameter "mode" is a string indicating
// the encryption mode to use, either "ECB" or "CBC". If the parameter is
// omitted, ECB is assumed.
// 
// An array of bytes representing the cihpertext is returned. To convert 
// this array to hex, invoke byteArrayToHex() on it. If you are using this 
// "for real" it is a good idea to change the function getRandomBytes() to 
// something that returns truly random bits.

function rijndaelEncrypt($plaintext, $key, $mode) {
	global $roundsArray;
	global $Nk;
	global $Nb;
	global $Nr;
	global $shiftOffsets;
	global $Rcon;
	global $SBox;
	global $SBoxInverse;

//	try {		//php 5
		//
		// Code following an exception is not executed.
		$n = count($key);

		if ( $n*8 != keySizeInBits ) {
			$error = 'Key size is wrong: $n';
			return("");
//			throw new Exception($error);
		}

		$bpb = blockSizeInBits / 8;          // bytes per block
		if ( $mode == "CBC" ) {
			$ct = getRandomBytes($bpb);             // get IV
		} else {
			$mode = "ECB";
			$ct = array();
		}

		// convert plaintext to byte array and pad with zeros if necessary. 
		//
		$plaintext = formatPlaintext($plaintext);
		$expandedKey = keyExpansion($key);
		//
		$pn = count($plaintext);
		$nb = ( $pn / $bpb );
		
		$sblock = 0;
		for ( $block =  0 ; $block < $nb ; $block++ ) {
			//
			$aBlock = array_slice($plaintext, $sblock, $bpb);

			if ( $mode == "CBC" ) {
				for ( $i = 0; $i < $bpb; $i++ ) $aBlock[$i] ^= ($ct[ $sblock + $i ] & 0xFF);
			}
			
			$ct = array_merge( $ct, encrypt($aBlock, $expandedKey) );
			//
			$sblock += $bpb;
		}
/*
	} catch ( Exception $e ) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
*/

	return $ct;
}

// rijndaelDecrypt(ciphertext, key, mode)
// Decrypts the using the given key and mode. The parameter "ciphertext" 
// must be an array of bytes. The parameter "key" must be an array of key 
// bytes. If you have a hex string representing the ciphertext or key, 
// invoke hexToByteArray() on it to convert it to an array of bytes. The
// parameter "mode" is a string, either "CBC" or "ECB".
// 
// An array of bytes representing the plaintext is returned. To convert 
// this array to a hex string, invoke byteArrayToHex() on it. To convert it 
// to a string of characters, you can use byteArrayToString().

function rijndaelDecrypt($ciphertext, $key, $mode) {
	global $roundsArray;
	global $Nk;
	global $Nb;
	global $Nr;
	global $shiftOffsets;
	global $Rcon;
	global $SBox;
	global $SBoxInverse;

//	try {
		//
		// Code following an exception is not executed.
		$n = count($key);

		if ( $n*8 != keySizeInBits ) {
			$error = 'Key size is wrong: $n';
			return("");
	//		throw new Exception($error);
		}
		
		if ( !isset($mode) ) $mode = "ECB";                         // assume ECB if mode omitted


		$bpb = blockSizeInBits / 8;          // bytes per block
		$pt = "";                   // plaintext array

		$expandedKey = keyExpansion($key);
	 
		// work backwards to accomodate CBC mode 
		$n = count($ciphertext);

		for ( $block = (($n / $bpb) - 1); $block > 0; $block-- ) {
			//
			$aBlock = decrypt( substr($ciphertext, ($block*$bpb), (($block+1)*$bpb) ), $expandedKey );
			//
			if ( mode == "CBC" ) {
				for ( $i = 0; $i < $bpb; $i++ ) {
					$pt[($block-1)*$bpb + $i] = $aBlock[$i] ^ $ciphertext[($block-1)*$bpb + $i];
				}
			} else {
				$pt = $aBlock . $pt;
			}
		}

		// do last block if ECB (skips the IV in CBC)

		if ( $mode == "ECB" ) {
			$pt = decrypt(substr($ciphertext, 0, $bpb), $expandedKey) . $pt;
		}

/*
	} catch ( Exception $e ) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
	}
*/

	return $pt;
}


?>

