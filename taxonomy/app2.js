
var DEMO = {};
window.cal = false;


var g_subscribe_taxos = new Object();
var g_content_type_taxos = new Object();



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

	tree_com += "&bus_id=" + g_service_id;

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
		universalWindow(this,"Add Vocabulary","topic1_1","OPS1","click");
	}
}


////
INFOGROUP.topic1_2W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Vocabulary Term Editing","topic1_2","OPS2","click");
	}
}



////
INFOGROUP.topic1_3W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Subscribe to Vocabularies","topic1_3","OPS3","click");
	}
}


////
INFOGROUP.topic1_4W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Map Vocabulary to Content Type","topic1_4","OPS4","click");
	}
}


////
INFOGROUP.topic1_5W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: null,
	cb:function() {
		universalWindow(this,"Drop Vocabulary","topic1_5","OPS5","click");
	}
}


////
INFOGROUP.topic1_6W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Batch Vocabulary Operations","topic1_6","OPS6","click");
	}
}


var g_save_as_dialog = null;
var g_dialog_button_is = "";
////
INFOGROUP.taxo_tree_as = {
	needs:["dialog","dimmer"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		var div = $('taxotree_renamer');
		div.style.visibility = "inherit";
		div.style.width = "90%";
		g_save_as_dialog = new OAT.Dialog("Save the taxonomy tree", div,
												{
														modal:1,
														buttons:1,
														zIndex:80000,
														onhide: function (){ if ( g_dialog_button_is == "OK" ) { taxo_tree_save_as_action() }; },
														width:700,
														height:400
												}
											);

		g_save_as_dialog.ok = function () { g_dialog_button_is = "OK"; g_save_as_dialog.hide(); };
		g_save_as_dialog.cancel = function () { g_dialog_button_is = "CANCEL"; g_save_as_dialog.hide(); };

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


INFOGROUP.menuInit = {
	needs:[],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		menu_fetch_next();
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
								return( function(evnt){ fetch_word_section(evnt,cc,"word_list_placement"); } );
						})(char) );
			letter++;
		}
		letter = "A".charCodeAt(0);
		for ( var i = 0; i < 26; i++ ) {
			var char = String.fromCharCode(letter);
			var id = base + "A" + char;
			OAT.Event.attach(id, "click", (function(cc) {
								return( function(evnt){ fetch_word_subsection(evnt,cc,"word_list_placement"); } );
						})(char) );
			letter++;
		}

	}
}


var g_current_char = "A";
function fetch_word_section(evnt,char,div_location) {
	if ( evnt.shiftKey ) {
	} else {
		char = char.toLowerCase();  // started with uppercase
	}
	g_current_char = char;
	spanID = div_location;
	var word_com = word_locus + "?sess=" + g_classydex_session_id + "&char=" + char + "A";
	makeDocRequest( word_com );
}


function fetch_word_subsection(evnt,char,div_location) {
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


function render_vocabulary_tree() {

	if ( g_current_taxonomy_tree != null ) {
		g_current_taxonomy_tree.walk("removeEvents");
	}

	var t = new OAT.Tree({imagePath:"/sharedimages/",allowDrag:1,onClick:"select",onDblClick:"toggle"});
	t.assign("current_taxonomy",0);
	
	g_current_taxonomy_tree = t;

	var procRef = function(elm) {}
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
//			special_ops[special_ops_key] = save_role_tree_callback;
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
	var namer = $('taxo_renamer_current_name');

	namer.innerHTML = g_vocname;
	g_save_as_dialog.show();
	//
}

function taxo_tree_save_as_action() {

	var g_vocname_new = $('taxo_renamer_new_name').value;

	if ( g_vocname.length > 0 ) {
		if ( confirm( "Saving taxonomy: " + g_vocname + " to " + g_vocname_new ) ) {
			// Save the newly named taxonomy...
			$('taxo_name').innerHTML = g_vocname_new;
	
			// The evaluation will call save_taxo_tree with the current data.

			var postTarget = taxonomy_ops + "cloneTaxoTree.php";
			//
			var saver_data = "based_on_taxonomy=" + g_vocid + "&taxoname=" + g_vocname_new;

			g_vocname = g_vocname_new;
			makePOSTEvalRequest(postTarget,saver_data);
		}
	} else {
		alert("No taxonomy selected");
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

	if ( postdata.length ) {
		postdata = "business=" + g_business + "&" + postdata;
		var url = taxonomy_ops + "subscriber.php";
		spanID = "statusMsg";
		makePOSTRequest(url,postdata);
	} else {
		alert("No taxonomies selected");
	}
}



function pick_content(idx,taxo_id) {
	var mfield = "T" + taxo_id;
	var sel = "ct_bselect_" + idx;
	var tt =  $(sel).checked;

	g_content_type_taxos[mfield] = tt;

}

function contenttypetaxonomies() {
	var i = 0;
	var postdata = "";
	var sep = "";
	for ( field in g_content_type_taxos ) {
		var taxostate = g_content_type_taxos[field];
		if ( taxostate ) {
			postdata += sep  + "taxoselect[" + i + "]=" + field.substring(1);
			i++;
			sep = "&";
		}
	}

	if ( postdata.length ) {
		postdata = "business=" + g_business + "&" + postdata;
		var url = taxonomy_ops + "contentassigner.php";
		spanID = "statusMsg";
		makePOSTRequest(url,postdata);
	} else {
		alert("No taxonomies selected");
	}

}





