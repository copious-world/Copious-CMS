/*
 *  $Id: demo.js,v 1.10 2007/06/26 13:35:36 source Exp $
 *
 *  This file is part of the OpenLink Software Ajax Toolkit (OAT) project.
 *
 *  Copyright (C) 2005-2007 OpenLink Software
 *
 *  See LICENSE file for details.
 */


var DEMO = {};
window.cal = false;

popRef = "urlselections";

INFOGROUP = {};

var g_special_ad_categories_tree = null;

function tree_render(thespan) {
	var t = new OAT.Tree({imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"});
	t.assign(thespan,1);
}


var g_menu_index = 0;


function fetch_index(sessionNum) {
	if ( g_menu_index == 0 ) { spanID = "menutree_1"; g_menu_index++ }
	else if ( g_menu_index == 1 ) { spanID = "menutree_2"; g_menu_index++ }
	else { g_menu_index = 0; return; }

	var tree_com = tree_locus + "?sess=" + sessionNum + "&menunum=" + g_menu_index;

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




/// Render the role tree for selecting roles.
var g_role_selector = null;

function render_role_tree(abc) {
	var t = new OAT.Tree({imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle",checkboxMode:true,defaultCheck:false,chaseCheckUp:false});
	g_role_selector = t;
	t.assign("select_role_taxonomy",0);
}


function populate_roles() {
	if ( g_role_selector != null ) {
		var checked_items = g_role_selector.checkedNOI;
		var n = checked_items.length;
		var roles = "";
		var sep = "";
		for ( var i = 0; i < n; i++ ) {
			var node = checked_items[i];
			var role = node.getLabel();
			roles += sep + role;
		}
		$('add_accounttype-roles').value = roles;
	}
}









function go_get_role_tree_text(reporter,url) {

	special_ops_key = "RoleTreeTextRender";
	special_ops[special_ops_key] = render_role_tree;

	spanID = reporter;
	var provider = taxonomy_ops + "pubtree.php?nametaxo=" + url;

	makeDocRequest( provider );

}


////
INFOGROUP.topic1_1W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: null,
	cb:function() {
		universalWindow(this,"Basic Business Information","topic1_1","OPS1","click");
	}
}




////
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
							return( function(){ fetch_word_subsection(cc,"permission_list_placement"); } );
						})(char) );
			letter++;
		}

	}
}



var g_permissions = null;
var g_current_perm_char = "A";
var g_perm_list = null;


function fetch_word_subsection(char,div_location) {
	if ( g_permissions != null ) {
		g_perm_list = new Object();
		g_current_perm_char = char;
		$(div_location).innerHTML = g_permissions[char];
	}
}

function init_permissions_list() {
	var url = "fetch_permissions.php?sess=" + g_classydex_session_id;
	makeDocEvalRequest(url);
}


function add_perm(perm) {
	if ( g_perm_list == null ) return(null);
	g_perm_list[perm] = true;

}

function remove_perm(perm) {
	if ( g_perm_list == null ) return(null);

	if ( g_perm_list.hasOwnProperty(perm) ) {
		g_perm_list[perm] = false;
	}

	$('permEL_ALL').innerHTML = "Select All";

}


function extract_permission_list() {
	if ( g_permissions == null ) return(null);
	if ( g_perm_list == null ) return(null);

	var permarray = new Array();
	for ( perm in g_perm_list ) {
		if ( g_perm_list[perm] ) {
			permarray.push(perm);
		}
	}

	return(permarray);
}


function toggle_select_all(permlisttxt) {

	var op = $('permEL_ALL').innerHTML;
	if ( op == "Select All" ) {
		$('permEL_ALL').innerHTML = "Uncheck All";
		permlist = permlisttxt.split(",");
		while ( permlist.length ) {
			var perm = permlist.pop();
			$(perm).checked = true;
			add_perm(perm);
		}
	} else {
		$('permEL_ALL').innerHTML = "Select All";
		permlist = permlisttxt.split(",");
		while ( permlist.length ) {
			var perm = permlist.pop();
			$(perm).checked = false;
			remove_perm(perm);
		}
	} 

}


////   
INFOGROUP.topic1_3W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: null,
	cb:function() {
		universalWindow(this,"Edit Business Book","topic1_3","OPS3","click");
	}
}




INFOGROUP.topic1_4W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: null,
	cb:function() {
		universalWindow(this,"Theme Choices","topic1_4","OPS4","click");
	}
}


////   
INFOGROUP.topic1_5W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Business Features...","topic1_5","OPS5","click");
	}
}


////   
INFOGROUP.topic1_6W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Payment Processing","topic1_6","OPS6","click");
	}
}



INFOGROUP.startclock = {
	needs:[],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		//setInterval("local_update_clock();",1000);
	}
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
	var provider = community_reports + "contentpart.php?q=" + url + "&sess=" + g_classydex_session_id;
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
//var g_vocname = g_role_taxonomy_name;
//var g_vocid = g_role_taxonomy;

var g_current_taxonomy_tree = null;
var g_fetched_term_ids = null;




function render_vocabulary_tree() {

	var t = new OAT.Tree({imagePath:"/sharedimages/",allowDrag:1,onClick:"select",onDblClick:"toggle",checkLeafDrop:true});
	t.assign("current_taxonomy",0);

	g_current_taxonomy_tree = t;

	var procRef = function(elm) {};
	var backRef = function(target,x,y) { /* ghostdrag ended; some re-structuring? */
		var node = target.obj;
		while ( node && ( node.isLeaf ) ) {
			node = node.parent;
		}

		var targname = node.getLabel();
		if ( targname == "root" ) return;

		var permission_list = extract_permission_list(); // Currently selected...
		if ( permission_list == null ) return;
		var perm = "";
		while ( permission_list.length ) {
			perm = permission_list.pop();
			if ( !node.findChild(perm) ) {
				var child = node.createChild(perm,false,0);
			}
		}

		node.expand();
	};

	t.gd.addSource($("wordsource"),procRef,backRef);
	t.setTrasher($("trashbucketContainer"));

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




function store_new_role_tree() {
	var txt_description = "Role Taxonomy for the business, " + g_role_business_name;
	var txt_help = "Permissions for the Role Taxonomy for business, " + g_role_business_name + ", are stored here.";

	g_vocname += "_" + g_role_business_name;

	var saver_data = "name=" + g_vocname;
	saver_data += "&taxonomy=" + txt_description + "&help=" + txt_help;
	saver_data += "&hierarchy=on" + "&relations=off" + "&multiple=on" + "&required=on" + "&tags=on"

	makePOSTEvalRequest(saver_data);
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


function save_role_tree() {
	// If the Role tree is a new tree based on the system role tree... 
	// Then the taxonomy for the role tree has to be created...
	if ( g_vocname == "roles" ) {
		store_new_role_tree();
	} else {
		special_ops_key = "RoleTreeSaveOps2";
		special_ops[special_ops_key] = save_role_tree_callback;
		save_taxonomy_tree();
	}
}


function save_taxonomy_tree() {
	if ( g_current_taxonomy_tree != null ) {
		g_prepared_nodes = new Array();
		g_current_taxonomy_tree.mapwalk_apply(prepare_node_save,0);

		var node_data = g_prepared_nodes.toString();
		var postTarget = taxonomy_ops + "saveTaxoTree.php";
		spanID = "statusMsg";

		var saver_data = "taxonomy=" + g_vocid + "&taxoname=" + g_vocname;
		saver_data += "&jsondata=" + encodeURIComponent(node_data);

		makePOSTRequest(postTarget,saver_data);
	}
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


function show_account_dataq(acctype_id,acctype_name) {

	var account_com = accounts_details + "?sess=" + g_classydex_session_id + "&id=" + acctype_id;
	makeDocEvalRequest( account_com );

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


function selPermString(perm) {
	$('permission_label_field').innerHTML = perm;
}


var g_theme_tinyMCE_settings = null;
var n_optional_view_sections = 0;


function extract_index(str) {
	var bpos = str.indexOf('[') + 1;
	var epos = str.lastIndexOf(']');

	var indx = str.substring(bpos,epos);
	return(indx);
}

function preview_book_theme(button) {

	if (  button.innerHTML == "Preview" ) {
		button.innerHTML = "Edit";
		var i = 0;
		for ( i = 0; i < n_optional_view_sections; i++ ) {
			var checkname = "book_checkbox_" + (i+1);
			var  btnobj = $(checkname);
			OAT.Dom.hide(btnobj);

			btnobj = $(checkname + "_sel");
			var showTxtCtl = btnobj.checked;
			if ( !showTxtCtl ) {
				var ctlid = extract_index(btnobj.name); //
				OAT.Dom.hide(ctlid);
			}
		}

		var els = $('element_entries').value;
		els = els.split(',');
	
		var n = els.length;
		for ( i = 0; i < n; i++ ) {
			var el = els[i];
			var id = tinyMCE.getEditorId(el);
			tinyMCE.removeMCEControl(id);
			
			OAT.Dom.hide(el);
			var txt = $(el).value;
			var preview = $(el + "_preview")
			preview.innerHTML = txt;
			OAT.Dom.show(preview);
		}
	} else {
		button.innerHTML = "Preview";
		var i = 0;
		for ( i = 0; i < n_optional_view_sections; i++ ) {
			var checkname = "book_checkbox_" + (i+1);
			var  btnobj = $(checkname);
			OAT.Dom.show(btnobj);
			var showTxtCtl = btnobj.checked;
			btnobj = $(checkname + "_sel");
			var ctlid = extract_index(btnobj.name); //
			OAT.Dom.show(ctlid);
		}
		var els = $('element_entries').value;
		els = els.split(',');
		var n = els.length;
		for ( i = 0; i < n; i++ ) {
			var el = els[i];
			OAT.Dom.show(el);
			var preview = $(el + "_preview")
			OAT.Dom.hide(preview);
		}
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

