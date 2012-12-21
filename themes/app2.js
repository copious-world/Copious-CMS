
var DEMO = {};
window.cal = false;


var g_subscribe_taxos = new Object();



popRef = "urlselections";

INFOGROUP = {};

var g_special_ad_categories_tree = null;

function tree_render(thespan) {
	var t = new OAT.Tree({imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"});
	t.assign(thespan,1);
}


var g_menu_index = 0;

function is_universal_admin_business(bname) {
	return(true);
}

// Heuristics here.(Set up ahead of time.)
function business_authorized_for_taxonomy(taxoname) {

	var focus_base = g_taxo_app_taxo_subset;
	if ( focus_base == false ) {
		return(true);
	}
	var derived_taxo = focus_base + "_" + g_role_business_name;
	if ( derived_taxo == taxoname ) return(true);

	if ( is_universal_admin_business(g_role_business_name) ) {
		return(true)
	}

	return(false);
}



function fetch_index(sessionNum) {
	if ( g_menu_index == 0 ) { spanID = "menutree_1"; g_menu_index++ }
	else if ( g_menu_index == 1 ) { spanID = "menutree_2"; g_menu_index++ }
	else { g_menu_index = 0; return; }

	var tree_com = tree_locus + "?sess=" + sessionNum + "&menunum=" + g_menu_index;
	if ( g_taxo_app_taxo_subset != false ) {
		tree_com += "&taxosubset=" + g_taxo_app_taxo_subset;
	}

	makeDocRequest( tree_com );
}

function menu_fetch_next() {

	fetch_index(g_classydex_session_id);
}


g_expansionlist = [];	/// This is here for historical reasons...


INFOGROUP.menutree1 = {
	div:"menutree_1",
	needs:["tree"],
	drawn: false,
	cb:function() {
		//addmenutree("menutree_1");
	}
}


////////////////////////////////////////////////////////////////////////////////
////

INFOGROUP.topic_searchW = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Search","topic_search","searchBtn","click");
	}
}

////
INFOGROUP.topic_helpW = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Help","topic_help","helpBtn","click");
	}
}


INFOGROUP.topic_published_taxoW = {
	needs:["window"],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: function() { go_get_page_text('taxoobject','taxonomy_dhtml'); },
	cb:function() {
		universalWindow(this,"Taxonomic Indecies","topic_published_taxo","indexBtn","click");
	}
}



////   
INFOGROUP.topic1_1W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Add a Theme for a Business Front Page","topic1_1","OPS1","click");
	}
}



////
INFOGROUP.topic1_3W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Save Content Type Editing","topic1_3","OPS3","click");
	}
}


INFOGROUP.startclock = {
	needs:[],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		setInterval("local_update_clock();",1000);
	}
}


var g_oat_content_type_ghost_drag = null;

INFOGROUP.addGhostDrags = {
	needs:[],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		g_oat_content_type_ghost_drag = new OAT.GhostDrag(); // This is the first ghostDrag...
	}
}




INFOGROUP.alphSetup = {
	needs:[],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		var base = "vocab_part_";	//  English alphabet
		var letter = "A".charCodeAt(0);
		for ( var i = 0; i < 26; i++ ) {
			var char = String.fromCharCode(letter);
			var id = base + char;
			OAT.Event.attach(id, "click", (function(cc) {
								return( function(){ fetch_word_section(cc,"word_list_placement"); } );
						})(char) );
			letter++;
		}
		letter = "A".charCodeAt(0);
		for ( var i = 0; i < 26; i++ ) {
			var char = String.fromCharCode(letter);
			var id = base + "A" + char;
			OAT.Event.attach(id, "click", (function(cc) {
								return( function(){ fetch_word_subsection(cc,"word_list_placement"); } );
						})(char) );
			letter++;
		}

	}
}


var g_current_char = "A";
function fetch_word_section(char,div_location) {
	g_current_char = char;
	spanID = div_location;
	var word_com = word_locus + "?sess=" + g_classydex_session_id + "&char=" + char + "A";
	makeDocRequest( word_com );
}


function fetch_word_subsection(char,div_location) {
	spanID = div_location;
	var word_com = word_locus + "?sess=" + g_classydex_session_id + "&char=" + g_current_char + char;
	makeDocRequest( word_com );
}


var realTitle = "";
var gButtonExplainer = {
	adBtn: "<span style='font-size:0.45em;color:brown;letter-spacing:1.5px;font-family:courier' >Place your ad here.</span>",
	searchBtn: "<span style='font-size:0.45em;color:brown;letter-spacing:1.5px;font-family:courier' >Detailed search for ads on this site.</span>",
	sellerBtn: "<span style='font-size:0.45em;color:brown;letter-spacing:1.5px;font-family:courier' >Be your own ad business.</span>",
	coolLinkBtn: "<span style='font-size:0.45em;color:brown;letter-spacing:1.5px;font-family:courier' >A link to today's special web site.</span>",
	helpBtn: "<span style='font-size:0.45em;color:brown;letter-spacing:1.5px;font-family:courier' >Information about how to use this web site.</span>"
};

function titleStatus(controller) {
	if ( realTitle.length == 0 ) {
		realTitle = $("titleSpot").innerHTML;
	}

	var hh = $("titleSpot").offsetHeight;

	var explainer = "<div style=' height: " + hh +  "px;overflow:clip;'>";
	explainer += gButtonExplainer[controller];
	explainer += "</div>";

	$("titleSpot").innerHTML = explainer;
	
}

function resetTitleStatus() {
	$("titleSpot").innerHTML = realTitle;
}



var g_search_selection_level = 0;
var g_search_selection = Array();
var g_classydex_current_search_sections = Array();



function format_section_numbers() {
	var str = g_classydex_current_search_sections.join(",");
	return(str);
}


function clear_search_possibilies() {
	////
	while ( g_search_selection.length > 0 ) {
		g_search_selection.pop();
	}
	////
	while ( g_classydex_current_search_sections.length > 0 ) {
		g_classydex_current_search_sections.pop();
	}
	////
}



function go_get_post_form(btnTexter) {
	var btnText = $(btnTexter).innerHTML;
	if ( btnText.indexOf('Not Selected') > -1 ) {
		INFOGROUP.topic1_4W.dontOpen = true;
		alert("No category has been selected yet");
	} else {

		if ( g_special_ad_categories_tree != null ) {
			g_special_ad_categories_tree.walk('deselect');
			g_search_selection_level = 0;  // Keep it in synch
			setPosterBtnText('Not Selected');
			setSearchBtnText('Not Selected');
			clear_search_possibilies();
		}

		getPosterForm();
		////
	}
}



function go_get_search_result(btnTexter) {
	var btnText = $(btnTexter).innerHTML;
	if ( btnText.indexOf('Not Selected') > -1 ) {
		INFOGROUP.topic1_5W.dontOpen = true;
		alert("No category has been selected yet");
	} else {
		if ( g_special_ad_categories_tree != null ) {
			g_special_ad_categories_tree.walk('deselect');
			g_search_selection_level = 0;  // Keep it in synch
			setPosterBtnText('Not Selected');
			setSearchBtnText('Not Selected');
			
			retrieve_classified_index(format_section_numbers())

			clear_search_possibilies();
		}
	}
}



function go_get_page_text(reporter,url) {

	spanID = reporter;
	var provider = community_reports + "contentpart.php?q=" + url;
	makeDocEvalRequest( provider );

}


function setPosterBtnText(catname) {
	var btnText = "Post and Ad for the following category: " + catname;
	$("posterHitBtn").innerHTML = btnText;
}



function setSearchBtnText(catname) {
	var btnText = $('searcherHitBtn').innerHTML;
	if ( ( btnText.indexOf('Not Selected') > -1 ) || ( catname == "Not Selected" ) || ( g_search_selection.length == 0 ) ) {
		btnText = "Fetch Ads from the following categories: " + catname;
	} else {
		btnText = "Fetch Ads from the following categories: ";
		var n = g_search_selection.length;
		var sep = "";
		for ( var i = 0; i < n; i++ ) {
			var cname = g_search_selection[i];
			btnText += sep + cname;
			sep = ",";
		}
		if ( catname.length ) {
			btnText += sep + catname;
		}
	}
	$("searcherHitBtn").innerHTML = btnText;
}


function correctCatNames() {
	var btnText = $('searcherHitBtn').innerHTML;
	if ( btnText.indexOf('Not Selected') < 0 ) {
		setSearchBtnText("");
	}
}

function getSearchFilters() {
}





var g_current_processing_section = "1";
function process_classified_index(catTextHolder,section) {
	////
	g_current_processing_section = section;
	////
	var catText = catTextHolder.innerHTML;
	catTextHolder["savesection"] = section;

	if ( g_special_ad_categories_tree != null ) {
		var n = g_special_ad_categories_tree.selectedNodes.length;
		if ( n == 0 ) {
			setPosterBtnText(catText);
		} else {
			var tnode = g_special_ad_categories_tree.selectedNodes[0];
			var catname = tnode.getLabel();
			catname = catname.substring(catname.indexOf(">") + 1);
			catname = catname.substring(0,catname.indexOf("<"));
			setPosterBtnText(catname);
		}
		if ( g_search_selection.length > n ) {
			clear_search_possibilies();
			for ( i = 0; i < n; i++ ) {
				var tnode = g_special_ad_categories_tree.selectedNodes[i];
				var catname = tnode.getLabel();
				catname = catname.substring(catname.indexOf(">") + 1);
				catname = catname.substring(0,catname.indexOf("<"));
				g_search_selection.push(catname);
			}
		} else if ( g_search_selection.length < n ) {
			var tnode = g_special_ad_categories_tree.selectedNodes[g_special_ad_categories_tree.selectedNodes.length - 1];
			var catname = tnode.getLabel();
			catname = catname.substring(catname.indexOf(">") + 1);
			catname = catname.substring(0,catname.indexOf("<"));
			g_search_selection.push(catname);
		} else {
			setSearchBtnText(catText);
		}
	}

}



function node_remember(catTextHolder) {
	if ( g_special_ad_categories_tree != null ) {
		var n = g_special_ad_categories_tree.selectedNodes.length;
		if ( n != 0 ) {
			var tnode = g_special_ad_categories_tree.selectedNodes[0];
			var catname = tnode.getLabel();
			catname = catname.substring(catname.indexOf(">") + 1);
			catname = catname.substring(0,catname.indexOf("<"));
			setPosterBtnText(catname);
			save_poster_section(g_current_processing_section);
		}
	}

	if ( catTextHolder.hasOwnProperty("savesection") ) {
		g_classydex_current_search_sections.push(catTextHolder.savesection);
	}

	return(false);
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
var g_vocname = "";
var g_vocid = 0;
var g_current_taxonomy_tree = null;
var g_fetched_term_ids = null;


var g_current_select = "";

g_tree_containers = {

		content_type_taxonomy:	{
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"},
			drag_drop_arrangement: function(tree) {
				///-----------------------------------------------------

				tree.walk("select");
				var element_list = tree.selectedNodes;
				var n = element_list.length;
				for ( var i = 0; i < n; i++ ) {
					var node = element_list[i];
					var fetch_fields = (function(term,taxo) {
								return(function(){ get_content_type_fields(term,taxo); });
							})(node.getLabel(),g_vocname);
	
					OAT.Dom.attach(node._div,"click",fetch_fields);
					node._label.style.cursor = "pointer";

				}
				tree.walk("toggleSelect");

			}
		}

	};


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


function save_role_tree_callback() {
	if ( g_current_taxonomy_tree != null ) {
		g_prepared_nodes = new Array();
		g_current_taxonomy_tree.mapwalk_apply(prepare_node_save,0);

		var node_data = g_prepared_nodes.toString();
		var postTarget = role_ops + "saveRoleTree.php";
		spanID = "statusMsg";

		var saver_data = "jsondata=" + encodeURIComponent(node_data);

		makePOSTRequest(postTarget,saver_data);
	}
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


function store_new_role_tree() {
	var txt_description = "Role Taxonomy for the business, " + g_role_business_name;
	var txt_help = "Permissions for the Role Taxonomy for business, " + g_role_business_name + ", are stored here.";

	g_vocname += "_" + g_role_business_name;
	store_new_named_tree(g_vocname);
}


function save_role_tree() {
	// If the Role tree is a new tree based on the system role tree... 
	// Then the taxonomy for the role tree has to be created...
	if ( g_vocname == "roles" ) {
		store_new_role_tree();
	} else {
		save_taxonomy_tree();
	}
}


function save_taxonomy_tree_as() {
	//
	//
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
function pick_vocabulary(vocname,vocid) {
	////
	$("statusMsg").innerHTML = "Fetching Vocabulary: " + vocname;
	////
	var tree_com = taxonomy_locus + "?sess=" + g_classydex_session_id + "&id=" + vocid;
	makeDocEvalRequest( tree_com );
	////
}


var g_batch_operations = {
	buildpresuppositionDB: function () {
		alert("Not yet implemented");
	},
	
	importvocabularydefinition: function () {
	
		var dbname = prompt("What is the data base name containing the taxonomy HTML?");
		var tablename = prompt("What is the table name containing the taxonomy HTML?");
		var fieldname = prompt("What is the field name containing the taxonomy HTML?");
		var qualifier = prompt("Is there a SQL qualifier like an id or a name symbol?");
		var taxoname = prompt("What should the new taxonomy be named?");
	
	
		var conf = " Making vocabulary " + taxoname + " from DB: " + dbname + " from TABLE: " + tablename + " from FIELD: " + fieldname + ". Continue?";
	
		if ( confirm(conf) ) {
			var qq = "select " + fieldname + " from " + tablename;
			if (  qualifier.length > 0 ) { qualifier += " where " + qualifier };
	
			var url = taxonomy_ops + "importDBFieldsTaxo.php?DB=" + dbname;
			url += "&taxo=" + taxoname;
			url += "&query=" + qq;
	
			spanID = "statusMsg";
			makeDocRequest(url);
	
		}

	},

	exportvocabularydefinition: function () {
		alert("Not yet implemented");
	}

};



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

function subscribetaxonomies() {
	var i = 0;
	var postdata = "";
	var sep = "";
	for ( field in g_subscribe_taxos ) {
		var taxostate = g_subscribe_taxos[field];
		if ( taxostate ) {
			postdata += sep  + "taxoselect[" + i + "]=" + field.substring(1);
			i++;
			sep = "&";
		}
	}

	postdata = "business=" + g_business + "&" + postdata;
	var url = taxonomy_ops + "subscriber.php";
	spanID = "statusMsg";

	makePOSTRequest(url,postdata);

}



var g_theme_tinyMCE_settings = null;
var n_optional_view_sections = 0;


function extract_index(str) {
	var bpos = str.indexOf('[') + 1;
	var epos = str.lastIndexOf(']');

	var indx = str.substring(bpos,epos);
	return(indx);
}



////////////////////////////////////////////////////////////////////////////////


function build_content_drag_and_drop_sources(prfx,n) {
	for ( var i = 0; i < n; i++ ) {
		var compholder = prfx + i;
		compholder = $(compholder);
		if ( compholder ) {
			add_OAT_target_source(compholder);
		}
	}
}


var g_variable_source_parameters = {};
var g_variable_details_parameters = {};


function SubParameter(editing_data,params) {
	this.substitutions = "";
	this.parameters = "";
	this.id_data = editing_data;

	if ( params ) {
		this.substitutions = params.substitutions;
		this.parameters = params.parameters;
	}
}


function detail_editor(target,label) {
	var info = label.split(':');
	$('oat_field_detail_name').innerHTML = info[0];
	$('oat_field_detail_type').innerHTML = info[1];
	$('oat_field_detail_term').innerHTML = g_term_from_callback;
	$('oat_field_detail_target').innerHTML = target;

	var url = rolled_oats_locus + "fetch_parameters_and_subs.php?sess=" + g_classydex_session_id;
	url += "&droptarget=" + target;
	url += "&roatname=" + info[1];
	url += "&fieldname=" + info[0];
	url += "&term=" + g_term_from_callback;
	url += "&content_type=" + g_content_type_for_callback;

	makeDocEvalRequest(url);
}


function remote_store_details(editing_data,detailer) {
	var subs = detailer.substitutions;
	var params = detailer.parameters;

	subs = encodeURIComponent(subs);
	params = encodeURIComponent(params);
	
	var url = rolled_oats_locus + "store_parameters_and_subs.php?sess=" + g_classydex_session_id;
	url += "droptarget=" + editing_data;
	url += "roatname=" + info[1];
	url += "fieldname=" + info[0];
	url += "term=" + g_term_from_callback;
	url += "content_type=" + g_content_type_for_callback;	
	url += "substitutions=" + subs;	
	url += "parameters=" + params;

	makeDocRequest(url);
}


function detail_editor_callback(editing_data,params) {
///---
	detailer = new SubParameter(editing_data,params);
	g_variable_details_parameters[editing_data] = detailer;
///--
	g_edit_field_detail_dialog.show();
}


var g_editing_field_part = "substitutions";
var g_editing_dirty = false;
///
function supply_field_detail_substitutions() {
	if ( g_editing_dirty ) {
		var store = confirm("Store Editing of Subsititutions?");
		if ( store ) store_oat_detail_edits() ;
	}
	g_editing_field_part = "substitutions";
	g_editing_dirty = true;
	var editing_data = $('oat_field_detail_target').innerHTML;
	var detailer = g_variable_details_parameters[editing_data];
	$('oat_field_detail_edit').innerHTML = "substitutions"
	$('oat_field_detail_edit_area').value = detailer.substitutions;
}


function supply_field_detail_parameters() {
	if ( g_editing_dirty ) {
		var store = confirm("Store Editing of Parameters?");
		if ( store ) store_oat_detail_edits() ;
	}
	g_editing_field_part = "parameters";
	g_editing_dirty = true;
	var editing_data = $('oat_field_detail_target').innerHTML;
	var detailer = g_variable_details_parameters[editing_data];
	$('oat_field_detail_edit').innerHTML = "parameters"
	$('oat_field_detail_edit_area').value = detailer.details;
}


function store_oat_detail_edits() {
	var editing_data = $('oat_field_detail_target').innerHTML;

	var detailer = g_variable_details_parameters[editing_data];

	if ( detailer == null ) {
		detailer = new SubParameter(editing_data);
		g_variable_details_parameters[editing_data] = detailer;
	}

	if ( g_editing_field_part == "substitutions" ) {
		detailer.substitutions = $('oat_field_detail_edit_area').innerHTML;
	} else {
		detailer.details = $('oat_field_detail_edit_area').innerHTML;
	}
	g_editing_field_part = "none";
	g_editing_dirty = false;

	remote_store_details(editing_data,detailer);
}


function copy_object(obj) {
	var copyobj = new Object();
	for( var i in obj ) {
		copyobj[i] = obj[i];
	}
	return(copyobj);
}

/////---------------------------------------------------------->>>
function OAT_pre_form_information(target,oat_component_provider) {
	var label = oat_component_provider.innerHTML;
	// Create a control so that parameters for the thing can be defined.
	label = label.substring(label.indexOf(">") + 1,label.lastIndexOf("</sp"));
	var parameters = '\"' + target.id + '\",\"' + label +  '\"';
	var labeltxt = label + "<span class='drop_oat_details' onclick='detail_editor(" + parameters + ");' >details</span>";
	///
	g_variable_details_parameters[target.id] = copy_object(g_variable_source_parameters[label]);
	///
	return(labeltxt);
}



var g_oat_field_grid = null;
var g_unclassified_oat_header = null;
var g_unclassified_oat_array = null;

var g_dialog_button_is;
var g_edit_field_detail_dialog = null;


INFOGROUP.Topic_fieldTypeW = {
	needs:["grid","dialog"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {

		var div = $('Topic_fieldDetails');
		div.style.visibility = "inherit";
		div.style.width = "90%";
		g_edit_field_detail_dialog = new OAT.Dialog("Specify Field Details", div,
												{
														modal:1,
														buttons:1,
														zIndex:80000,
														onhide: function (){ if ( g_dialog_button_is == "OK" ) { store_oat_detail_edits() }; },
														width:700,
														height:400
												}
											);

		g_edit_field_detail_dialog.ok = function () { g_dialog_button_is = "OK"; g_edit_field_detail_dialog.hide(); };
		g_edit_field_detail_dialog.cancel = function () { g_dialog_button_is = "CANCEL"; g_edit_field_detail_dialog.hide(); };
	}
}



function submit_for_OAT_targets(list_of_objects) {
	//
	var n = list_of_objects.length;

	for ( var i = 0; i < n; i++ ) {
		g_oat_content_type_ghost_drag.addTarget(list_of_objects[i]);
	}

}


var g_current_oat_source = null;



function add_OAT_target_source(obj) {

	var procRef = function(elm) {
		g_current_oat_source = elm;
	};
	var backRef = function(target,x,y) { /* ghostdrag ended; some re-structuring? */
		target.innerHTML = OAT_pre_form_information(target,g_current_oat_source);
	}

	g_oat_content_type_ghost_drag.addSource(obj, procRef, backRef);
}


/////---------------------------------------------------------->>>

var g_drop_spot_instances = [];
var g_count_drops = 0;

// Finds the image link and turns it into a drop target span component.
// The oat_drop_container{i} will contain the variable and a details editing 
// button.
function replace_drop_targets(txt) {
	var i = 0;
	///
	while ( txt.indexOf('<a id="oat_drop_') > 0 ) {
		txt = txt.replace('<a id="oat_drop_','<span id="oat_drop_');
		g_count_drops++;
	}

	for ( i = 0; i < g_count_drops; i++ ) {
		var id = '<span id="oat_drop_container' + i;
		var j = txt.indexOf("</a",txt.indexOf(id));
		txt = txt.substring(0,j) + "</span>" + txt.substring(j+4)
	}

	return(txt);
}




function theme_editing_preview(button) {
	var el = "thm_topic1_1";
	if (  button.innerHTML.indexOf("Preview") >= 0 ) {
		button.innerHTML = "Edit";

		var id = tinyMCE.getEditorId(el);
		tinyMCE.removeMCEControl(id);

		OAT.Dom.hide(el);
		var txt = $(el).value;
		var preview = $(el + "_preview");

		/// replace the drop link with a drop span.
		g_count_drops = 0;
		txt = replace_drop_targets(txt);
		preview.innerHTML = txt;
		OAT.Dom.show(preview);
		n = g_count_drops;

		var n_stored = g_drop_spot_instances.length;
		for ( var i = 0; i < n; i++ ) {
			var b = $('oat_drop_container' + i);
			b.className = "buttonLike";
			if ( i < n_stored ) {
				b.innerHTML = g_drop_spot_instances[i].innerHTML;
			} else {
				b.innerHTML = "{Var Drop[" + i + "]}";
			}
			g_drop_spot_instances[i] = b;
		}

		submit_for_OAT_targets(g_drop_spot_instances);

	} else {
		button.innerHTML = "Preview and Target Editing";

		OAT.Dom.show(el);
		var preview = $(el + "_preview")
		OAT.Dom.hide(preview);

		tinyMCE.init(g_theme_tinyMCE_settings);
	}
}





function  data_from_element(ctlid) {
	var obj = $(ctlid);
	var tn = obj.nodeName.toLowerCase();
	if ( tn == 'textarea' ) {
		return(""); // These are being handled as tinyMCE areas.
	} else {
		var txt = obj.innerHTML;
		txt = encodeURIComponent(txt);
		return(txt);
	} 
}

function prepare_business_theme_fields() {
	var vdata = "{";
	var sep = '';
	for ( var i = 0; i < n_optional_view_sections; i++ ) {
		var checkname = "book_checkbox_" + (i+1) + "_sel";
		var  btnobj = $(checkname);
		var showTxtCtl = btnobj.checked;
		
		var ctlid = extract_index(btnobj.name); //

		vdata += sep + " " + ctlid + ": " + (showTxtCtl ? "1" : "0" );

		btnobj.value = data_from_element(ctlid);

		sep = ',';
	}
	vdata += "}";

	$('theme_vars').value = vdata;

	return(true);
}

//g_drop_spot_instances, g_count_drops
function serialize_drop_spots(dropspot_list) {
	///
	var n = dropspot_list.length;  // The number of drop spots used.
	var output = "{ count_drops: " + g_count_drops + ", used_drops: ['"; // The number of drops spots that are available.
		///
	var sep = "";
	for ( var i = 0; i < n; i++ ) {
		var id = dropspot_list[i].id;
		output += sep + id;
		sep = "','";
	}
	///
	output += "'] }";
	return(output);
}


function unserialize_drop_spots(dropspotinfo) {
	var dropspotlist = dropspotinfo.used_drops;
	var n = dropspotlist.length;
	g_drop_spot_instances = [];
	for ( var i = 0; i < n; i++ ) {
		var dropobject = dropspotlist[i];
		var b = $(dropobject);
		g_drop_spot_instances.push(b);
	}
}


function content_type_taxonomy(type_name) {
	//
	$("statusMsg").innerHTML = "Fetching Content Type Taxonomy : " + type_name;
	var tree_com = taxonomy_ops + "content_type_taxonomy.php?sess=" + g_classydex_session_id + "&content_type=" + type_name;
	tree_com += "&container=content_type_taxonomy";
	makeDocEvalRequest( tree_com );
}




var g_content_type_for_callback = "";
var g_term_from_callback = "";

function get_content_type_fields(term,taxo) {
	g_term_from_callback = term;
	var url = theme_locus + "theme_admin_fetch.php?sess=" + g_classydex_session_id + "&content_type=" + taxo;
	url += "&all=false&term=" + term;
	makeDocEvalRequest(url);

}

function get_content_type_fields_callback(term,taxo) {
	var url = rolled_oats_locus + "fetch_ct_fields.php?sess=" + g_classydex_session_id + "&content_type=" + taxo;
	url += "&all=false&term=" + term;
	makeDocEvalRequest(url);
}


/// Calls up the default varialbles for the particular content type...
///
function content_type_vars(type_name) {
	//
	g_content_type_for_callback = type_name;
	$("statusMsg").innerHTML = "Fetching Content Type Vars : " + type_name;
	var tree_com = taxonomy_ops + "content_types.php?sess=" + g_classydex_session_id + "&content_type=" + type_name;
	makeDocEvalRequest( tree_com );
}


/// This is a special case of the above...
function content_type_callback_field_data(field_data_obj) {

	var type_name = g_content_type_for_callback;

	for ( var classlabel in field_data_obj ) {   /// Just called once should be field_data_obj[classlabel] // where classlabel known
		var oatcomponent_list = field_data_obj[classlabel]
		// From here there are 
		g_term_from_callback = classlabel;
		$("statusMsg").innerHTML = "Fetching Content Type Vars : " + type_name;
		var tree_com = taxonomy_ops + "content_types.php?sess=" + g_classydex_session_id + "&content_type=" + type_name;
		tree_com += "&component_list=" + oatcomponent_list + "&term=" + classlabel;
		makeDocEvalRequest( tree_com );

		break;
	}

}




//g_drop_spot_instances

// Save the current form that is being edited with the current content type and theme
function save_themes_and_forms() {
	var ct = g_content_type_for_callback;
	var term = g_term_from_callback;

	var formatted_text = $('thm_topic1_1_preview').innerHTML;
	var editing_text = $('thm_topic1_1').value;

	var url = theme_locus + "theme_admin_store.php";

	var drop_spots = serialize_drop_spots(g_drop_spot_instances);

	spanID = "statusMsg";
	var postData = "sess=" + g_classydex_session_id + "&content_type=" + ct;
	postData += "&term=" + term;
	postData += "&formatted_text=" + encodeURIComponent(formatted_text);
	postData += "&editing_text=" + encodeURIComponent(editing_text);
	postData += "&drop_spots=" + encodeURIComponent(drop_spots);

	makePOSTRequest(url,postData);
}


