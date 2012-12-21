<?php


///@elname
///@fieldinfo
/// These are two variables that must be replaced in form elements producing values for a particular field.
/// ////




/// included in form from theme...


function extract_id_name($var_data) {
	$fieldinfo = strstr($var_data,">");
	$fieldinfo = trim(substr($fieldinfo,1,strpos($fieldinfo,"<")-1));
	return(explode(":",$fieldinfo));
}



function load_data_source_function($ro_datasrc) {
	static $loadedfuncs = array();

	if ( !isset($loadedfuncs[$ro_datasrc]) ) {
		$QQ = "SELECT subroutine FROM rolled_oats_lib WHERE name = '$ro_datasrc'";
		$funcbody = db_query_value($QQ);
	
		$funform = "function $ro_datasrc(\$txt,\$datasource_params,\$var_data,\$form_kind) { $funcbody }";
		eval($funform);
		$loadedfuncs[$ro_datasrc] = "in";
	}

}


function load_oat_components($name) {
	static $rolled_oats = array();

	if ( isset($rolled_oats[$name]) ) {
		$rolledoat = $rolled_oats[$name];
	} else {
		$QQ = "SELECT * FROM rolled_oats WHERE name = '$name'";
		$rolledoat = db_query_object($QQ);
		$rolled_oats[$name] = $rolledoat;
	}

	$rolledoat->datasource = trim($rolledoat->datasource);

	if ( strlen($rolledoat->datasource) > 0 ) {
		load_data_source_function($rolledoat->datasource);
	}

	return($rolledoat);
}


function figure_parameters($defaults,$specials) {

	$defaults = json_decode($defaults);
	$specials = json_decode($specials);

	foreach ( $defaults as $elm => $val ) {
		if ( isset($specials[$elm]) ) {
			$defaults[$elm] = $specials[$elm];
		}
	}

	return($defaults);
}


function load_specialization($term,$content_type,$fieldname,$rolledoat,$fieldname) {
	static $special_parts = array();
	global $webhost;
	global $sess;

	$roatname = $rolledoat->name;


	$key = "$term-$content_type-$roatname-$fieldname";

	if ( isset($special_parts[$key]) ) {
		$obj = $special_parts[$key];
	} else {
		$params = "&term=" . $term;
		$params .= "&content_type=" . $content_type;
		$params .= "&droptarget=" . $droptarget;
		$params .= "&roatname=" . $roatname;
		$params .= "&fieldname=" . $fieldname;
		$params .= "&nojs=true";
	///-------------------------------------->
		$objlines = file_get_contents("http://$webhost//hosted/rolledoats/fetch_parameters_and_subs.php?sess=$sess" . $params);
		$objarry = explode("!!!",$objlines);
	///-------------------------------------->
		$obj = array();
		$obj['substitutions'] = trim($objarry[0]);
		$obj['parameters'] = trim($objarry[1]);
		$special_parts[$key] = $obj;
	}

	return($obj);
}




function datasource_transformation($txt,$datasource,$datasource_params,$var_data,$form_kind) {

	if ( strlen(trim($datasource)) == 0 ) {
		return($txt);
	}
	if ( $datasource == "identity" ) {
		return($txt);
	}

	load_user_function($datasource); /// Get a function out of the data base...

	$txt = call_user_func_array($datasource,array($txt,$datasource_params,$var_data,$form_kind));
	return($txt);

}

/// Producing the form with elements and their associated javascript.
/// The result is HTML to be insterted into the entry display.

function data_gathering_elements($id,$name,$rolledoat,$var_data,$specials) {
	global $entry_js;

	if ( $rolledoat != null ) {

		/// php hanlder...
		$datasource_params = figure_parameters($datasource->data_source_parameters,$specials->parameters);
		$datasource = $rolledoat->datasource;

		$substitutions = $specials->substitutions;
		if ( strlen($substitutions) ) {
			$substitutions = json_decode($substitutions);
		} else {
			$substitutions = false;
		} 
	
		$jscb = trim($rolledoat->javascript_cb);
		$jscb = urldecode($jscb);
		if ( $substitutions != false ) {
			$jscb = handle_substitutions($jscb,$substitutions);
		}
		
		$rm = $rolledoat->remote_validation == 1 ? "true" : "false";
		
		$limits = $rolledoat->javascript_check_limits;
		if ( strlen($limits) == 0 ) {
			$limits = "return(true);";
		} else {
			$limits = urldecode($limits);
			if ( $substitutions != false ) {
				$limits = handle_substitutions($limits,$substitutions);
			}
		} 
		
		$datarep = trim($rolledoat->javascript_data_rep);

		if ( strlen($datarep) == 0 ) {
			$datarep = 'return("nothing");';
		} else {
			$datarep = urldecode($datarep);
			if ( $substitutions != false ) {
				$datarep = handle_substitutions($datarep,$substitutions);
			}
		}

		$renderdata = $rolledoat->javascript_render_data;  /// javascript for constructing HTML view.
		if ( strlen($renderdata) == 0 ) {
			$renderdata =<<<EOFRENDER
			if ( ( outputform != null ) && ( outputform.length > 0 ) ) {
				val = ouputform.replace("@value",val);	
			}

EOFRENDER;

		} else {
			$renderdata = urldecode($renderdata);
			if ( $substitutions != false ) {
				$renderdata = handle_substitutions($renderdata,$substitutions);
			}
		}

		$presentation = $rolledoat->presentation;
		if ( $presentation != false ) {
			$presentation = urldecode($presentation);
			$presentation = datasource_transformation($presentation,$datasource,$datasource_params,"presenter");
			if ( $substitutions != false ) {
				$presentation = handle_substitutions($presentation,$substitutions);
			}
			$presentation = urlencode($presentation);
			$presentation = str_replace("+"," ",$presentation);
		}

		$elementlist = "null";
		if ( strlen($rolledoat->element_list) > 0 ) {
			$ellist = explode(",",$rolledoat->element_list);
			$ellist = implode("','",$ellist);
			$elementlist = "[ '" . $ellist . "' ]";
		}

		$required_js_src = trim($rolledoat->required_source_url);
		if ( strlen($required_js_src) > 0 ) {
$required_js_src =<<<EOURLINCLUDE
	OAT.Dom.include("$required_js_src");
EOURLINCLUDE;
		}

$entry_js["$id$name"] =<<<EOFTYPEJS
	ENTRYFORMGROUP.$id$name = {
		needs:["window"],
		field_info: "$fieldinfo",
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			$required_js_src
			$jscb
		},
		remote_validation: $rm,
		presentation: decodeURIComponent("$presentation"),
		element: $elementlist,
		check_limits:function(element) {
			$limits
		},

		javascript_render_data: function (elid,val,outputform) {
			$renderdata
			return(val);
		},

		data_representation:function(elid) {
			$datarep
		}
EOFTYPEJS;


		if ( $rolledoat->remote_validation ) {
			///------------------------------------------------>
			$entry_js["$id$name"] .= ",";
			///------------------------------------------------>
			$validation_source = $rolledoat->validation_source;
			$validation_parameters = $rolledoat->validation_parameters;
			$method = $rolledoat->http_method == 0 ? "GET" : "POST";

$entry_js["$id$name"] .=<<<EOFTYPEJS
		validation_source: "$validation_source",
		validation_parameters: "$validation_parameters",
		http_method: "$method",

EOFTYPEJS;
///------------------------------------------------>
		
		}


$entry_js["$id$name"] .=<<<EOFTYPEJS
	};
EOFTYPEJS;
		
		$element = trim($rolledoat->element);

		if ( strlen($element) == 0 ) {
			///-------------------------------->
/// Get the text of the element...
$output =<<<EOFTYPEFORM
<span style="color:gold"id="parent-$id$name" >$id: <input type="text" id="elem-$id$name" class="oatdrop" value="$fieldinfo"></span>
EOFTYPEFORM;
			///-------------------------------->
		} else {
///-------->
			$element = urldecode($element);
			$element = str_replace("@elname","$id$name",$element);
			$element = str_replace("@fieldinfo",$fieldinfo,$element);
			if ( $datasource ) {
				$element = datasource_transformation($element,$datasource,$datasource_params,"form");
			}
			if ( $substitutions != false ) {
				$element = handle_substitutions($element,$substitutions);
			}

$output =<<<EOFTYPEFORM
<span style="color:gold"id="parent-$id$name" >$id: $element</span>
EOFTYPEFORM;
		}

echo $element;
echo "<br>";
			///-------------------------------->
	} else {
			///-------------------------------->
/// Get the js components and assemble them 
$entry_js["$id$name"] =<<<EOFTYPEJS
	ENTRYFORMGROUP.$id$name = {
		needs:["window"],
		field_info: "$fieldinfo",
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			
		},
		remote_validation: false,
		element: null,
		check_limits:function(element) {
			return(true);
		},
		javascript_render_data: null,
		data_representation:function() {
			return("nothing");
		}
	}
EOFTYPEJS;

/// Get the text of the element...
$output =<<<EOFTYPEFORM
<span style="color:gold"id="parent-$id$name" >$id: <input type="text" id="elem-$id$name" class="oatdrop" value="$fieldinfo"></span>
EOFTYPEFORM;
			///-------------------------------->
	}

	return($output);
}





function data_searching_elements($id,$name,$rolledoat,$var_data,$specials) {
	global $search_js;

	if ( $rolledoat != null ) {

		/// php hanlder...
		$datasource_params = $datasource->data_source_parameters;
		$datasource_params = figure_parameters($datasource->data_source_parameters,$specials->parameters);
		$datasource = $rolledoat->datasource;

		$substitutions = $specials->substitutions;
		if ( strlen($substitutions) ) {
			$substitutions = json_decode($substitutions);
		} else {
			$substitutions = false;
		}


		$jscb = trim($rolledoat->javascript_cb); 
		$jscb = urldecode($jscb);
		if ( $substitutions != false ) {
			$jscb = handle_substitutions($jscb,$substitutions);
		}
		
		$rm = $rolledoat->remote_validation == 1 ? "true" : "false";
		
		$limits = $rolledoat->javascript_check_limits;
		if ( strlen($limits) == 0 ) {
			$limits = "return(true);";
		}
		if ( $substitutions != false ) {
			$limits = handle_substitutions($limits,$substitutions);
		}
		
		$datarep = trim($rolledoat->javascript_searcher);  /// Saying that the searcher produces values relvant to search...
		$datarep = urldecode($datarep);
		if ( strlen($datarep) == 0 ) {
			$datarep = 'return("nothing");';
		} else {
			if ( $substitutions != false ) {
				$datarep = handle_substitutions($datarep,$substitutions);
			}
		}

		$elementlist = "null";
		if ( strlen($rolledoat->element_list) > 0 ) {
			$ellist = explode(",",$rolledoat->element_list);
			$ellist = implode("','",$ellist);
			$elementlist = "[ '" . $rolledoat->element_list . "' ]";
		}

$search_js["$id$name"] =<<<EOFTYPEJS
SEARCHFORMGROUP.$id$name = {
	needs:["window"],
	field_info: "$fieldinfo",
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		$jscb
	},
	element: $elementlist,
	check_limits:function(element) {
		$limits
	},
	data_representation:function() {
		$datarep
	}
}
EOFTYPEJS;

		$element = trim($rolledoat->search_html);
		
		$element = urldecode($element);
		if ( strlen($element) == 0 ) {
			///-------------------------------->
/// Get the text of the element...
$output =<<<EOFTYPEFORM
<input type="checkbox" id="use-elem-$id$name" > $id: <input type="text" id="search-elem-$id$name" class="oatdrop" value="$fieldinfo">
EOFTYPEFORM;
			///-------------------------------->
		} else {
///-------->
			$element = str_replace("@elname","$id$name",$element);
			$element = str_replace("@fieldinfo",$fieldinfo,$element);
			if ( $datasource ) {
				$element = datasource_transformation($element,$datasource,$datasource_params,"search");
			}

			if ( $substitutions != false ) {
				$element = handle_substitutions($element,$substitutions);
			}



$output =<<<EOFTYPEFORM
<input type="checkbox" id="use-elem-$id$name" > $id: $element
EOFTYPEFORM;

		}

	} else {

$search_js["$id$name"] =<<<EOFTYPEJS
SEARCHFORMGROUP.$id$name = {
	needs:["window"],
	field_info: "$fieldinfo",
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		
	},
	remote_validation: false,
	element: null,
	check_limits:function(element) {
		return(true);
	},
	data_representation:function() {
		return("nothing");
	}
}
EOFTYPEJS;


$output =<<<EOFTYPEFORM
<input type="checkbox" id="use-elem-$id$name" > $id: <input type="text" id="search-elem-$id$name" class="oatdrop" value="$fieldinfo">
EOFTYPEFORM;

	}

	return($output);
}



?>
