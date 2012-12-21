<?php


/// TAXONOMY MODULE APC BOOT...

include '../servicename.php';
$dbspecific = "taxonomy";

try {
	include '../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}


global $db_connection;


function taxonomy_load_child_tree(&$vocab, $parent = 0, $depth = -1, $max_depth = NULL) {
///
	$children =& $vocab->children;
	$parents =& $vocab->parents;
	$terms =& $vocab->terms;

	$depth++;

	if ( !isset($vocab->tree) ) {
		$vocab->tree = array();
	}
	$tree =& $vocab->tree;

	$n = count($children);
	$max_depth = (is_null($max_depth)) ? count($children) : $max_depth;

	// Copy of a tree from parent (parameter) on down...
	// This tree is a list of terms (Depth first)
	if ( $n > 0) {
		foreach ($children[$parent] as $child) {
			if ($max_depth > $depth) {
				$term = ($terms[$child]);
				$term->depth = $depth;
				// The "parent" attribute is not useful, as it would show one parent only.
				$term->parents = $parents[$child];
				$tree[] = $term;
				if ($children[$child]) {
					taxonomy_load_child_tree($vocab, $child, $depth, $max_depth);
				}
			}
		}
	}

}

$QQ = "SELECT id, name, description, help, hierarchy, multiple, relations, required, tags, weight, terms, children, parents, names from vocabulary";
$voclist = db_query_object_list($QQ);
$vocabularies = array();


	foreach ( $voclist as $voc ) {
		$vocabularies[$voc->id] = $voc;

		$data = $voc->terms;
		$voc->terms = (array)json_decode($data);
		$voc->children = (array)json_decode($voc->children);
		$voc->parents = (array)json_decode($voc->parents);
		$voc->names = (array)json_decode($voc->names);
		taxonomy_load_child_tree($voc);
	}


$QQ = "SELECT * from subscription order by entity_symbol";
$subscribelist = db_query_object_list($QQ);


	$subscribe_array = array();	
	$bnames = array();
	foreach ( $subscribelist as $subscription ) {
		$bname = $subscription->entity_symbol;
		if ( !isset($subscribe_array[$bname]) ) {
			$subscribe_array[$bname] = array();
			if ( !in_array($bname,$bnames) ) {
				$bnames[] = $bname;
			}
		}
		$vid = $subscription->vid;
		$subscribe_array[$bname][$vid] = $vocabularies[$vid];
	}


	foreach ( $bnames as $bname ) {
		$bname = $subscription->entity_symbol;
		$vocabname = "all_vocabularies_ready_$bname";
		apc_store($vocabname,(object)$subscribe_array[$bname]);
	}



?>
