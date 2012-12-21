<?php

	// INCLUDED FILE.
	// 
	require_once("textConvert.php");

	//////////
	//
	class phrases {
		var $index = 0;
		//
		function front() {
			$i = rand(0,3);
			$str = "";
			//
			switch ( $i ) {
				case 0: { $str = "aplsijktlelw"; break; }
				case 1: { $str = "dfpynetlnnjo"; break; }
				case 2: { $str = "uiaofkbsdfbc"; break; }
				default: { $str = "hfjdkfjhryqj"; break; }
			}
			//
			return($str);
		}
		function back() {
			$i = rand(0,3);
			$str = "";
			//
			
			switch ( $i ) {
				case 0: { $str = "oiupoiierqws"; break; }
				case 1: { $str = "cnagpqwilemx"; break; }
				case 2: { $str = "yruisbsndmbc"; break; }
				default: { $str = "psoskdfdhfnl"; break; }
			}
			//
			return($str);
		}
	}
	

	////  Just pick out one of several prime numbers used to transform 
	////  blocks of random numbers.
	function pick_prime() {
		$primes = array(13,17,23,29,43,57,71);
		$i = rand(0,6);
		$j = $primes[$i];
		return($j);
	}
	

	// Make a list of 64 indecies in a random permutation.
	
	function make_permutation() {
		//
		$permutation = array(-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,
							 -1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,
							 -1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,
							 -1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1,-1);
		//
		for ( $i = 0; $i < 64; $i++ ) {
			$idx = 0;
			while ( $idx != -1 ) {
				$j = rand(0,64);
				if ( $j == 64 ) $j--;
				$idx = $permutation[$j];
				if ( $idx == -1 ) $permutation[$j] = $i;
			}
		}
		//
		//
		$permstr = "";
		for ( $i = 0; $i < 64; $i++ ) {
			 $j = $permutation[$i];
			 if ( $i > 0 ) {
				$permstr .= ',';
			 }
			 $permstr .= $j;
		}
		
		return($permstr);
	}


  // ===========================================================================================
	$phrase_parts = new phrases;
	$sessPhrase_front = $phrase_parts->front();
	$sessPhrase_back = $phrase_parts->back();
	//
	//
	$sessPrime = pick_prime();
	$sessRandom = rand(12345,55555);
	$permuter_str = make_permutation();
  // ===========================================================================================


?>