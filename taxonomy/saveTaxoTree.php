<?php

$dbspecific = "taxonomy";
include "../admin_header_lite.php";

/*
*/

$whichtaxo = $_POST['taxonomy'];
$taxoname = $_POST['taxoname'];
$jsondata = $_POST['jsondata'];

$jsondata = str_replace("\\","",$jsondata);

/*
*/
global $db_connection;

///
///=====================///---->
///
global $g_children, $g_parents, $g_names;
$g_children = array(); $g_parents = array(); $g_names = array();
///=====================///---->


class term {
	public $tid;
	public $vid;
	public $name;
	public $description;
	public $weight;
	public $parent;
	public $depth;

	function __construct($tid,$vid,$name,$description,$weight,$parent,$depth) {
		$this->tid = $tid;
		$this->vid = $vid;
		$this->name = $name;
		$this->description = $description;
		$this->weight = $weight;
		$this->parent = $parent;
		$this->depth = $depth;
	}

};


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



function convert_tree($top) {
	$name = $top->label;
	$children = "";
	$n = count($top->children);
	for ( $i = 0; $i < $n; $i++ ) {
		$children .= convert_tree($top->children[$i]);
	}
$text =<<<LNAME
			<li>$name<ul>
			$children
			</ul></li>
LNAME;

	return($text);
}


$text = $jsondata;
$jsondata = urlencode($jsondata);


$QQ = "update vocabulary set JSON = '$jsondata' where id = '$whichtaxo'";
db_query_exe($QQ);

	$text = str_replace(":","\" :",$text);
	$text = str_replace("'","\"",$text);
	$text = str_replace("{ ",'{ "',$text);
	$text = "[ " . str_replace(", ",', "',$text) . " ]";
	$array = json_decode($text, false);


	$n = count($array);
	$markers = array();	// $markers is a flat array whose elements contain arrays of elements in markers.
	for ( $i = 0; $i < $n; $i++ ) {
		$node = $array[$i];
		$node->data->label = str_replace("+"," ",$node->data->label);  // Clean up label
		$markers[$node->mark] = &$node->data;  // A marker may be an index, or other... it comes from client...
		$node->data->children = array();
	}

	foreach ( $markers as $mark => $data ) {
		$pmark = $data->parent_mark;
		if ( $pmark > 0 ) {
			$parent = &$markers[$pmark];
			$parent->children[] = $data;
		}
	}

	// Build HTML taxonomy tree from the list of markers...
	$text = convert_tree($markers[1]);
	$text = urlencode($text);
	$QQ = "update vocabulary set HTML = '$text' where id = '$whichtaxo'";
	db_query_exe($QQ);


	/// Find terms that are not yet mapped into the presupposition word base...
	$termnames = array();
	$backref = array();
	foreach ( $markers as $mark => $data ) {
		if ( $data->id <= 0 ) {
			///
			if ( $data->label == "/" ) continue;
			if ( $data->parent_mark == -1 ) continue;
			///
			$termnames[] = $data->label;  // Gather up the undefined words..
			$backref[$data->label] = $mark;	// Identify the mark by the label for later reference in markers
		}
	}

	$n_terms = count($termnames);
///
	if ( $n_terms > 0 ) {
		$terms = implode("','",$termnames);
		$QQ = "select id, words from term_presupose where words in ('$terms')";
		$found_objects = db_query_object_list($QQ);
///
///TERMFINDER
		$n = count($found_objects);
		for ( $i = 0; $i < $n; $i++ ) {
			$termobj = $found_objects[$i];
			$marker = $backref[$termobj->words];
			if ( $marker == NULL ) {	// Sometimes words are just a case difference. 
				$termobj->words = strtoupper($termobj->words);
				$marker = $backref[$termobj->words];
			}
			$data = &$markers[$marker];
			$data->id = $termobj->id;
		}
	}


	if ( $n < $n_terms ) {  /// These must have been typed...
							/// This means they were not in term_presupose
		$newtermnames = array();
					/// Make a list of names that are not identified, id <= 0
		foreach( $termnames as $tname ) {
			$marker = $backref[$tname];
			$data = $markers[$marker];
			if ( $data->id <= 0 ) {
				if ( $data->label == "/" ) continue;
				$newtermnames[] = $data->label;  // Gather up the undefined words..
			}
		}

		$term_lookup = add_to_new_terms($newtermnames);
				/// term new is the same structure as term_presupose. But, it starts at a much higher index.
		$QQ = "select id, words from term_new where key_front in ($term_lookup)";
		$found_objects = db_query_object_list($QQ);
	
		$n = count($found_objects);
		for ( $i = 0; $i < $n; $i++ ) {	/// This code is a copy of TERMFINDER
			$termobj = $found_objects[$i];
			$marker = $backref[$termobj->words];
			if ( $marker == NULL ) {	// Sometimes words are just a case difference. 
				$termobj->words = strtoupper($termobj->words);
				$marker = $backref[$termobj->words];
			}
			if ( $marker != NULL ) {
				$data = &$markers[$marker];
				$data->id = $termobj->id;
			}
		}
	}

	$sep = "";
	$pair_store = "{ ";
	$NEWQ = "insert into term_data (id,tid,vid,weight) VALUES ";

	$count_newQ_markers = 0;

	foreach ( $markers as $mark => $data ) {

		$id = $data->id;
		if ( $id <= 0 ) continue;
		$label = $data->label;
		$count_newQ_markers++;
		
		$pair_store .= $sep . $label . ': ' . $id;
		$NEWQ .=  $sep . "(0,$id,$whichtaxo,0.05)";

		$sep = ", ";
	}
	$pair_store .= " }";

	$QQ = "update vocabulary set label_id_pairs = '$pair_store' where id = '$whichtaxo'";
	db_query_exe($QQ);

	$Qclear = "delete from term_data where vid = '$whichtaxo'";
	db_query_exe($Qclear);
	
	$Qclear = "delete from term_hierarchy where vid = '$whichtaxo'";
	db_query_exe($Qclear);

	$PARENTQ = "insert into term_hierarchy (tid,pid,vid) VALUES ";
	$sep = " ";

	$term_object_list = array(); /// Make this at the same time as the heirachy DB
	$count_Parent_markers = 0;
	foreach ( $markers as $mark => $data ) {
		$id = $data->id;
		if ( $id == -1 ) continue;
		$count_Parent_markers++;
		$pmark = $data->parent_mark;
		$pid = 0;
		if ( $pmark > 0 ) {
			$parent = $markers[$pmark];
			$pid = $parent->id;
		}

		$term = new term($id,$whichtaxo,$data->label,"From taxonomy manager",0.05,$pid);
		$term_object_list[$id] = $term;

		$PARENTQ .=  $sep . "($id,$pid,$whichtaxo)";
		$sep = ", ";
	}


	if ( $count_newQ_markers > 0 ) {
		db_query_exe($NEWQ);
	}
	if ( $count_Parent_markers > 0 ) {
		db_query_exe($PARENTQ);
	}


	if ( count($term_object_list) > 0 ) {
	///
		$term_data = json_encode($term_object_list);
		$QQ = "update vocabulary set terms = '$term_data' where id = '$whichtaxo'";
		db_query_exe($QQ);

		foreach( $term_object_list as $tid => $term ) {
			$g_children[$term->parent][] = $tid;
			$g_parents[$tid][] = $term->parent;
			$name = $term->name;
			if ( !isset($g_names[$name]) ) {
				$$g_names[$name] = array();
			}
			$g_names[$name][] = $term;
		}

		$js_data = json_encode($g_children);
		$QQ = "update vocabulary set children = '$js_data' where id = '$whichtaxo'";
		db_query_exe($QQ);

		$js_data = json_encode($g_parents);
		$QQ = "update vocabulary set parents = '$js_data' where id = '$whichtaxo'";
		db_query_exe($QQ);

		$js_data = json_encode($g_names);
		$QQ = "update vocabulary set names = '$js_data' where id = '$whichtaxo'";
		db_query_exe($QQ);

	}

echo "TAXONOMY $taxoname saved." ;
/*
*/

?>
