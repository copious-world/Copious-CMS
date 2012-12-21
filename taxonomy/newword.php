<?


include "../admin_header_lite.php";

	$wordlist = $_POST['word'];

	switch_db_connection("taxonomy");

function add_to_new_terms($newtermnames) {

	$II = "insert into term_new (id,part_of_speach,key_front,words,word_count,occurance) VALUES ";
	$vals = "";
	$sep = "";

	$term_lookup = "";
	foreach ( $newtermnames as $termwords ) {
		$wc = str_word_count($termwords);

		$store_term_words = strtolower($termwords);
		$flag = substr($store_term_words,0,24);

		$vals .= $sep . "(0,'N?','$flag','$store_term_words',$wc,1)";
		$term_lookup .= $sep . "'$flag'";
		$sep = ", "; 
	}
	db_query_exe($II);

	return($term_lookup);
}

	$wordlist = explode(',',$wordlist);
	$lookups = add_to_new_terms($wordlist);

	$QQ = "SELECT id FROM term_new WHERE key_front in ($lookups)";
	$widlist = db_query_list($QQ);
	$widliststr = implode(",",$widlist);

echo $widliststr;

?>