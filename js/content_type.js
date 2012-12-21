

function fetch_content_type_classifier(ctname,ct_vid) {

	pick_vocabulary(ctname,ct_vid,"content_type_tree",false,"&buttons=submit");

}


function open_submitter_window(from_obj) {

}


///////////////////////////////////////////////////////////////////////////////////////////////////////////

var g_current_word_id = 0;
var g_current_words = "";
function selword(id,words) {
	g_current_words = words;
	g_current_word_id = id;
	$('word_input_field').value = g_current_words;
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////
var g_vocname = "empty";
var g_vocid = 0;

var g_current_taxonomy_tree = null;
var g_fetched_term_ids = null;


var g_current_select = "";

var g_tree_containers = null;
var g_current_container = "";



function render_vocabulary_tree(taxocontainer) {
	if ( taxocontainer == null ) {
		alert("Supply a parameter to: render_vocabulary_tree");
		return(false);
	}

	g_current_container = taxocontainer;

	if ( g_tree_containers[taxocontainer].tree != null ) {
		g_current_taxonomy_tree = g_tree_containers[taxocontainer].tree;
		g_current_taxonomy_tree.walk("removeEvents");
	}

	if ( taxocontainer != null ) {
		var t = new OAT.Tree(g_tree_containers[taxocontainer].parameters);
		t.assign(taxocontainer,0);
		g_current_taxonomy_tree = t;
		g_tree_containers[taxocontainer].tree = t;
	} else {
		var t = new OAT.Tree({imagePath:"/sharedimages/",allowDrag:1,onClick:"select",onDblClick:"toggle"});
		t.assign("current_taxonomy",0);
		g_current_taxonomy_tree = t;
	}

	if ( taxocontainer != null ) {
		g_tree_containers[taxocontainer].drag_drop_arrangement(t);
	} else {

		var procRef = function(elm) {};
		var backRef = function(target,x,y) { /* ghostdrag ended; some re-structuring? */
			var node = target.obj;
			if ( node.isLeaf ) return;
	
			var newnodelabel = strim($("word_input_field").value);
			if ( newnodelabel.length > 0 ) {
				var child = node.createChild(newnodelabel,true,0);
				child['term_id'] = g_current_word_id;
				// Now copy the leafy children of the target node to the child 
				// provided this is a role tree...
				if ( g_vocname.substring(0,5) == "roles" ) {
					child.createChildren(node.children,true);
				}
				node.expand();
			}
		}

		t.gd.addSource($("wordsource"),procRef,backRef);
		t.setTrasher($("trashbucketContainer"));
	}

	$("statusMsg").innerHTML = "Current Vocabulary: " + g_vocname;
	$("taxo_name").innerHTML = g_vocname;
	
	prepare_taxonomy_tree(g_fetched_term_ids);
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////

var g_prepared_nodes = null;


function prepare_node_save(node,param) {
	if ( node ) {
		node['mark'] = param;
		var labeltxt = strim(tabtrim(remove_returns(node._label.innerHTML)));
		var parent = node.parent;
		var id = node.term_id;
		var pmark = -1;
		if ( parent ) {
			if ( parent.mark ) pmark = parent.mark;
		}
		var jsontxt = "{ mark: " + param + ", data: { isleaf: " + node.isLeaf + ", depth: " + node.depth + ", id: " + id + ", label: '" + labeltxt + "', parent_mark: " + pmark + "}}";
		g_prepared_nodes.push(jsontxt);
	}
	return(param + 1);
}


function save_taxonomy_tree() {
	if ( g_current_taxonomy_tree != null ) {
		if ( g_vocname.substring(0,5) == "roles" ) {
			special_ops_key = "RoleTreeSaveOps2";
			special_ops[special_ops_key] = save_role_tree_callback;
		}

		g_prepared_nodes = new Array();
		g_current_taxonomy_tree.mapwalk_apply(prepare_node_save,0);

		var node_data = g_prepared_nodes.toString();
		var postTarget = taxonomy_ops + "saveTaxoTree.php";
		spanID = "statusMsg";

		var saver_data = "taxonomy=" + g_vocid + "&taxoname=" + g_vocname;
		saver_data += "&jsondata=" + encodeURIComponent(node_data);

		g_saving_roles = true;  // Part of the evaluated
		makePOSTRequest(postTarget,saver_data);
	}
}



function store_new_named_tree(taxo_new_name) {

	var saver_data = "name=" + taxo_new_name;
	saver_data += "&taxonomy=" + txt_description + "&help=" + txt_help;
	saver_data += "&hierarchy=on" + "&relations=off" + "&multiple=on" + "&required=on" + "&tags=on"

	var node_data = g_prepared_nodes.toString();
	var postTarget = role_ops + "addtaxonomy.php";
	spanID = "statusMsg";

	makePOSTEvalRequest(postTarget,saver_data);
}


function prepare_node_edit(node,term_ids) {
	if ( node ) {
		var labeltxt = strim(tabtrim(remove_returns(node._label.innerHTML)));
		var id = term_ids[labeltxt];
		if ( id == null ) id = -1;
		node['term_id'] = id;
	}
	return(term_ids);
}


function prepare_taxonomy_tree(term_ids) {
	g_current_taxonomy_tree.mapwalk_apply(prepare_node_edit,term_ids);
}









///////////////////////////////////////////////////////////////////////////////////////////////////////////
function pick_vocabulary(vocname,vocid,container,secondary_step,additionalparameters) {
	////
	$("statusMsg").innerHTML = "Fetching Vocabulary: " + vocname;
	////
	var tree_com = taxonomy_locus + "?sess=" + g_classydex_session_id + "&id=" + vocid;

	if ( container != null ) {
		tree_com += "&container=" + container;
	}

	if ( ( secondary_step != null ) && ( secondary_step == true ) ) {
		tree_com += "&secondary=true";
	}

	if ( additionalparameters != null ) {
		tree_com += additionalparameters;
	}

	makeDocEvalRequest( tree_com );
	////
}





function submit_taxo_request(tag) {
	var cmd = remove_spaces(tag);
	var f = g_batch_operations[cmd];
	if ( f == null ) {
		alert("Undefined Operation");
		return;
	}
	f();
}




function pick_taxo(idx,taxo_id) {
	var mfield = "T" + taxo_id;
	var sel = "bselect_" + idx;
	var tt =  $(sel).checked;

	g_subscribe_taxos[mfield] = tt;

}



function get_publication_list(tagname,vocname,reporter,formplacer) {

g_just_for_form_fetch_content_type = vocname;
g_just_for_form_fetch_term = tagname;
g_form_conatainer_just_for_store = formplacer;

	var datalocus = usersown + "worksinprogress.php?sess=" + g_classydex_session_id + "&reporter=" + reporter;
	datalocus += "&vocname=" + vocname;
	datalocus += "&tagname=" + tagname;
	datalocus += "&formplacer=" + formplacer;
 	makeDocEvalRequest( datalocus );

}


function prepare_form_editor(elementobject) {
	for ( var el in elementobject ) {
		var el_descr = elementobject[el];
		var elname = "editing_form-" + el;
		$(elname).value = el_descr;
	}
}



function get_data_object(pubid,vocname,tagname) {
	var datalocus = usersown + "wip_content_object.php?sess=" + g_classydex_session_id + "&publication=" + pubid;
	datalocus += "&vocname=" + vocname;
	datalocus += "&tagname=" + tagname;
 	makeDocEvalRequest( datalocus );

}


///  Fetch the form from the database... (One at a time).
var g_just_for_form_fetch_content_type = "";
var g_just_for_form_fetch_term = "";
var g_just_for_form_fetch_kind = "";
var g_just_for_form_fetch_container = "";
var g_form_conatainer_just_for_store;
///

function get_form(term,content_type,formtype,container,carryforward) {

g_just_for_form_fetch_content_type = content_type;
g_just_for_form_fetch_term = term;
g_just_for_form_fetch_kind = formtype;
g_form_conatainer_just_for_store = container;


	var form_url = form_locus + "forms_" + formtype + ".php?sess=" + g_classydex_session_id + "&content_type=" + content_type;
	form_url += "&term=" + term;
	form_url += "&container=" + container; // The place where html will be rendered.

	if ( carryforward != null ) {
		form_url += "&carryforward=" + carryforward;
	}

	makeDocEvalRequest( form_url );

}

var g_saving_pub_id = 0;

function insert_form_into_display(container,formobject,extra_elements) {

	g_saving_pub_id = 0;

	var html = (formobject);
	if ( extra_elements.length ) html += extra_elements;  // These may be special value holder pass through such as session numbers.
	$(container).innerHTML = html;
	$("sys_required-title").value = "";
}

//---------------------------------------------------------------------------

var g_remoter_eval_responder;

function end_of_remote_evaluation(reporter) {
	////
	if ( g_remoter_eval_responder.check_limits(reporter) ) {  /// Note that remote evaluators take a text parameter
		form_processing();
	}
	////
}


function pop_remote_eval(remoter_list) {
	var remoter = remoter_list.pop();

	special_ops_key = "pop_remote_eval"
	special_ops[special_ops_key] = end_of_remote_evaluation;

	if ( remoter.method == "GET" ) {
		makeDocRequest(remoter.validation_source + "?" + remoter.validator_parameters)
	} else {
		makeDocPostRequest(remoter.validation_source,remoter.validator_parameters)
	}
}


var g_remoteEvals = null;
function ct_check_value_types_and_limits() {

	if ( g_remoteEvals == null ) {
		g_remoteEvals = new Array();

		for ( obname in ENTRYFORMGROUP ) {
			var obj = ENTRYFORMGROUP[obname];
			if ( obj.remote_validation ) {
				remoteEvals.push(obj);
			} else {
				if ( (obj.check_limit != null) && !obj.check_limits(obj.element) ) {
					g_remotedformObject = null;
					return(false);
				}
			}
		}

		if ( g_remoteEvals.length > 0 ) {
			pop_remote_eval(g_remoteEvals);
			return(false);
		}

	} else {
		if ( g_remoteEvals.length > 0 ) {
			pop_remote_eval(g_remoteEvals);
			return(false);
		}
	}

	g_remoteEvals = null;
	return(true);

} 




var ENTRYFORMGROUP = null;
function update_form_js(js_object) {
	ENTRYFORMGROUP = {};
	for ( var entry in js_object ) {
		var elid = "elem-" + entry;
		$(elid).value = "ready";
		var jstxt = js_object[entry];
		try {
			eval(jstxt);
		} catch ( e ) {
			alert(e);
			alert("Script evaluation error.");
			alert(jstxt);
		}
/*
*/
	}
}

var SEARCHFORMGROUP = null;
function update_search_form_js(js_object) {

	SEARCHFORMGROUP = {};
	for ( var entry in js_object ) {
		var elid = "search-elem-" + entry;
		$(elid).value = "enter terms";
		var jstxt = js_object[entry];
		eval(jstxt);
/*
*/
	}
}



//g_just_for_form_fetch_content_type = content_type;
//g_just_for_form_fetch_term = term;
//g_just_for_form_fetch_kind = formtype;


function search_form_processing() {
///
	if ( !ct_check_value_types_and_limits() ) {
		return;
	}
///

	var vtitle = $("sys_required-title").value;
	var use_title = $("search_title").checked;
	///
	var v_date_lb = $("search_lb_value").title;
	var v_date_ub = $("search_ub_value").title;

	var content_type = g_just_for_form_fetch_content_type;
	var term = g_just_for_form_fetch_term;

	var fields = "";
	var output = "{";
	if ( SEARCHFORMGROUP != null ) {
		var sep = "";
		for ( var fid in SEARCHFORMGROUP ) {
			var obj = SEARCHFORMGROUP[fid];
			var elid = "search-elem-" + fid;
			var if_elid = "use-elem-" + fid;
			var fobj = $(if_elid);
			if ( fobj && fobj.checked ) {
				var val = $(elid).value;  /// Need to incorporate the whole ROAR data storage process.
				var fkey = obj.field_info.replace(":","-");
				output += sep + '"' + fkey + '" : "' + val + '"';
				fields += sep + fkey;
				sep = ", ";
			}
		}
	}
	output += "}";

	var form_url = form_locus + "search_content.php";
///
	var form_data = "sess=" + g_classydex_session_id + "&content_type=" + content_type;
	form_data += "&term=" + term;

	if ( use_title ) {
		form_data += "&title=" + vtitle;
	}
	if ( v_date_lb.length ) {
		form_data += "&date_lb=" + v_date_lb;
	}
	if ( v_date_ub.length ) {
		form_data += "&date_ub=" + v_date_ub;
	}
	if ( fields.length ) {
		form_data += "&search_object=" + encodeURIComponent(output);
		form_data += "&fields=" + encodeURIComponent(fields);
	}

	showWindowProc('searchReports');
	spanID = "uo_search_results";
	form_url += "?" + form_data;
	makeDocRequest(form_url);
}



function form_processing() {

	if ( g_just_for_form_fetch_kind == "search" ) {
		search_form_processing();
		return;
	}

	var content_type = g_just_for_form_fetch_content_type;
	var term = g_just_for_form_fetch_term;

	var vtitle = $("sys_required-title").value;
	if ( vtitle.length == 0 ) {
		alert("Each item requires a title for displaying in lists. This is the only system wide entry requirement for content types.");
		return;
	}
	vtitle = encodeURIComponent(vtitle);

///
	if ( !ct_check_value_types_and_limits() ) {
		return;
	}
///

	var output = '{ ';
	if ( ENTRYFORMGROUP != null ) {
		var sep = "";
		for ( var fid in ENTRYFORMGROUP ) {
			///
			var obj = ENTRYFORMGROUP[fid];
			var val = "";

			var elid = "elem-" + fid;
			if ( ( obj != null ) && (  obj.data_representation != null ) ) {
				val = obj.data_representation(elid); // Get an array of strings or a single string.
/*
				if ( val != "nothing" ) {
					var j = (val.indexOf(",]")-1);  // Just in case a badly formatted array is returned..
					if ( j > 0 ) {
						val = val.slice(0,j);
						val += "] ";
					}
					var j = (val.indexOf(", ]")-1);
					if ( j > 0 ) {
						val = val.slice(0,j);
						val += "] ";
					}
				}
*/
			} else {
				val = $(elid).value;  /// Need to incorporate the whole ROAR data storage process.
			}

			output += sep  + '"' + obj.field_info + '" : "' + val + '"';
			sep = ", ";

		}

	} else {
		var vtext = $("sys_required-default");
		if ( vtext == null ) {
			alert("The text entry area does not exist. Please refresh your display.");
			return;
		}
		vtext = strim(vtext.value);

		if ( vtext.length == 0 ) {
			alert("This system will not store default entries without content and just a title. Please enter some content.");
			return;
		}

		content_type = "default";
		term = "default";

		vtext = encodeURIComponent(vtext);
		output += '"default:default"' + '" : "' + vtext + '"';
	}

	output += ' }';

	///
	var form_url = form_locus + "save_content.php";
///
	var form_data = "sess=" + g_classydex_session_id + "&content_type=" + content_type;
	form_data += "&term=" + term;
	form_data += "&title=" + vtitle;

	if ( g_saving_pub_id > 0 ) {
		form_data += "&pubid=" + g_saving_pub_id;
	}

	form_data += "&storage_format=" + encodeURIComponent(output);

	form_url += "?" + form_data;

	makeDocEvalRequest(form_url);
}


// Make the form into HTML by reading the value of the object or the rendering of the object.
function content_form_html_preview(dataid) { 
	if ( ENTRYFORMGROUP != null ) {
		var sep = "";

		for ( var fid in ENTRYFORMGROUP ) {
			var obj = ENTRYFORMGROUP[fid];
			var elid = "elem-" + fid;
			var val = "";

			if ( obj.data_representation ) {
				val = obj.data_representation(elid);
			} else val = $(elid).value;

			var outputform = obj.presentation;

			var valholder = "parent-" + fid;
			if ( obj.javascript_render_data != null ) {
				val = obj.javascript_render_data(elid,val,outputform);  // Get a rendering of the data....
			} else if ( outputform != null ) {
				val = outputform.replace("@value",val);
			} 
			$(valholder).innerHTML = val;
		}

		var html = $(g_form_conatainer_just_for_store).innerHTML;
		var form_url = form_locus + "save_content_view.php";
	///
		var form_data = "sess=" + g_classydex_session_id + "&objectid=" + dataid;
		form_data += "&html=" + encodeURIComponent(html);

		form_url += "?" + form_data;

		makeDocEvalRequest(form_url);
	}	
}



function set_default_form_values(fobjdata) {
	var k = "";
	k = "var obj = " + fobjdata + ";";
	eval(k);
	for ( var fld in obj ) {
		var val = obj[fld];
		var fldid = "elem-" + fld;
		$(fldid).value = val;
	}
}




var g_content_rw_state = "R";

var g_ct_access_list = {};


function object_from_array(arkeys,ival) {
	var obj = new Object();
	var n = arkeys.length;
	for ( i = 0; i < n; i++ ) {
		obj[arkeys[i]] = ival;
	}

	return(obj);
}

var g_ct_access_vocname = "";
var g_ct_access_voc_id = 0;
function access_limit_tree_selections(container,aclist,RW) {
	if ( aclist != null ) {
		g_ct_access_list[container] = object_from_array(aclist.split(","),RW);
	} else {
		g_ct_access_list[container] = null;
	}

 	pick_vocabulary(g_ct_access_vocname,g_ct_access_voc_id,container);
}

function filtered_taxo_pick(vocname,vocid,container,RW) {
//
	g_ct_access_vocname = vocname;
	g_ct_access_voc_id = vocid;

	var provider = role_ops + "accesslimits.php?sess=" + g_classydex_session_id + "&serviceid=" + g_s_i;
	provider += "&vid=" + vocid;
	provider += "&RW=" + RW;
	provider += "&container=" + container;
	provider += "&accounttype=" + g_account_type;

	makeDocEvalRequest( provider );
}


function promote_current_group() {
	var provider = role_ops + "account_info.php?sess=" + g_classydex_session_id + "&serviceid=" + g_s_i;
	makeDocEvalRequest(provider);
}

