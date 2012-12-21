<?php


$dbspecific = "taxonomy";
include "../admin_header_lite.php";
global $db_connection;

/*
$text = file_get_contents ("worddata/part-of-speech.txt");
$text = trim($text);
$aposto = urlencode("'");
$text = str_replace("'",$aposto,$text);
$text = str_replace("|","",$text);
$text = str_replace("\t","','",$text);
$text = "insert into term_presupose (id,words,part_of_speech) VALUES ('0','" . str_replace("\n","'),('0','",$text);
$text .= "')";

db_query_exe($text);

file_put_contents ("worddata/output.txt",$text);
*/


/*
	$n = db_query_value("select count(*) from term_presupose");
echo $n;


	for ( $j = 0; $j < $n; $j += 1000 ) {
echo $j . "\n";
		$QQ = "select id,words from term_presupose LIMIT $j, 1000";
		$list = db_query_object_list($QQ);
		for ( $i = 0; $i < 1000; $i++ ) {
			$obj = $list[$i];
			$wc = str_word_count($obj->words);
			$flag = substr($obj->words,0,24);
			$QS = "update term_presupose set word_count = '$wc', key_front = '$flag' where id = '$obj->id'";
			db_query_exe($QS);
		}
		unset($list);
	}

*/

	$alpha = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	$NA = ord("Z");
	$lNA = ord("a");

	$n = count($alpha);
	for ( $i = 0; $i < $n; $i++ ) {
		///
		$char = $alpha[$i];
		$lchar = strtolower($char);
		for ( $j = 0; $j < $n; $j++ ) {
		///
			$char1 = $lchar . $alpha[$j];
			$char2 = $char . $alpha[$j];
			$QQ = "select id,words from term_presupose where (LOCATE('$char2',key_front) = 1)";
			$q_result = @mysqli_query($db_connection,$QQ) or die (mysqli_error($db_connection));  //
			///
			$k = 0;
			$textupper = "<table width='100%'>\n";
			$text = "<table width='100%'>\n";
			while ( $row = @mysqli_fetch_row($q_result) ) {
				$id = $row[0];
				$words = $row[1];

				$c = $words[0];
				if ( ord($c) > $NA ) {
					$text .= "<tr><td id=\"W$id\" class=\"vocabword\" onclick=\"selword('$id','$words')\">$words</td></tr>\n";
				} else {
					$textupper .= "<tr><td id=\"W$id\" class=\"vocabword\" onclick=\"selword('$id','$words')\">$words</td></tr>\n";
				}

				$k++;
			}
			$text .= "</table>";
			$textupper .= "</table>";
echo $k . "\n";

			file_put_contents ("worddata/$char1.txt",$text);
			file_put_contents ("worddata/$char2.txt",$textupper);
		}

	}


?>