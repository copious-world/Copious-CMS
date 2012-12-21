<?php

$dbspecific = "taxonomy";
include "../admin_header_lite.php";
global $db_connection;

$whichtaxo = $_POST['taxonomy'];
$taxoname = $_POST['taxoname'];
$jsondata = $_POST['jsondata'];
$form = $_POST['form'];

/*
*/
///
///=====================///---->
///
global $g_children, $g_parents, $g_names;
$g_children = array(); $g_parents = array(); $g_names = array();

///=====================///---->

global $g_user_made_paths;

$g_user_made_paths = array();


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




function menu_convert_tree($top,$form,$path = "") {
	
	global $g_user_made_paths;

	///
	$name = $top->label;
	if ( isset($path) ) {
		$g_user_made_paths[ $path . "/$name"] = $name;
	}

	///
	$children = "";
	$n = count($top->children);
	for ( $i = 0; $i < $n; $i++ ) {
		$children .= menu_convert_tree($top->children[$i],$form,$path . "/$name");
	}

	$path = "";

$lableform = str_replace("@menu_label",$name,$form);
$lableform = str_replace("@menu_item_locus",$path,$form);

$text =<<<LNAME
			<li>$name<ul>
			$children
			</ul></li>
LNAME;

	return($text);
}



$text = $jsondata;
$jsondata = urlencode($jsondata);

	
	$text = str_replace(":","\" :",$text);
	$text = str_replace("'","\"",$text);
	$text = str_replace("{ ",'{ "',$text);
	$text = "[ " . str_replace(", ",', "',$text) . " ]";
	$array = json_decode($text, false);
	$n = count($array);
	$markers = array();	// $markers is a flat array whose elements contain arrays of elements in markers.
	for ( $i = 0; $i < $n; $i++ ) {
		$node = $array[$i];
		$node->data->label = str_replace("+"," ",$node->data->label);
		$markers[$node->mark] = $node->data;
		$node->data->children = array();
	}

	foreach ( $markers as $mark => $data ) {
		$pmark = $data->parent_mark;
		if ( $pmark > 0 ) {
			$parent = $markers[$pmark];
			$parent->children[] = $data;
		}
	}

	// Build HTML taxonomy tree from the list of markers...
	$text = menu_convert_tree($markers[1],$form);


	/// STORE THE PATH ARRAY for this menu
	$array_text = json_encode($g_user_made_paths);
	$UU = "UPDATE account_menu SET paths = '$array_text' WHERE menu_taxo_id = '$whichtaxo'";
	db_query_exe($UU);

	$text = urlencode($text);
	echo $text;

?>
