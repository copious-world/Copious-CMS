
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


////
INFOGROUP.topic1_5W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: null,
	cb:function() {
		universalWindow(this,"Create Content Type","topic1_5","OPS5","click");
	}
}


////
INFOGROUP.topic1_6W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: function() { pick_vocabulary(g_rolled_oat_taxonomy_name,g_rolled_oat_taxonomy,"oat_source",true); },
	cb:function() {
		universalWindow(this,"Drop a Business","topic1_6","OPS6","click");
	}
}







function secondary_taxonomy_render() {
	pick_vocabulary('forums',8,"current_content_type",false);  /// From a content type...
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
		var div = $('Topic_fieldType');
		div.style.visibility = "inherit";
		div.style.width = "90%";
		g_edit_field_detail_dialog = new OAT.Dialog("Edit Rolled Oat Field Details", div,
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


function open_up_details(detailer) {
	$('oat_field_detail_term').innerHTML = detailer.getLabel();
	g_edit_field_detail_dialog.show();
}

function edit_field_detail_substitutions() {

}

function edit_field_detail_parameters() {

}

function store_oat_detail_edits() {

}



INFOGROUP.oatgrid = {
	needs:["grid"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		//----------------------------------------------------
		var grid = new OAT.Grid($('oat_grid_container'),1,0);
		grid.createHeader(g_unclassified_oat_header,{align:OAT.GridData.ALIGN_CENTER});

		var n = g_unclassified_oat_array.length;
		for (var i=0;i<n;i++) {
			grid.createRow(g_unclassified_oat_array[i]);
		}
		for (i=0;i<n;i++) {
			var cell = grid.rows[i].cells[1];
			cell.html.style.cursor = "pointer";
			cell.html.style.color = "darkgreen";
			cell.html.style.fontWeight = "bold";
			cell.html.style.width = "100px";
			var oat_select = (function(oatcomp) {
									return( function()	{
												var descr = oatcomp;
												$('wordsource').innerHTML = descr[0];
											} );
								})(g_unclassified_oat_array[i]);
			OAT.Dom.attach(cell.html,"click",oat_select);
		}
		g_oat_field_grid = grid;
		//----------------------------------------------------
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


INFOGROUP.topic1_2W_panels = {
	needs:["window"],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: null,
	cb:function() {
		OAT.Dom.attach('TAB_1_1_1','click',
				function(){
					OAT.Dom.hide('rolled_oat_main','rolled_oat_datafunction','rolled_oat_authorship','rolled_oat_remoteeval');
					OAT.Dom.show('rolled_oat_main');
				});
		OAT.Dom.attach('TAB_1_1_2','click',
				function(){
					OAT.Dom.hide('rolled_oat_main','rolled_oat_datafunction','rolled_oat_authorship','rolled_oat_remoteeval');
					OAT.Dom.show('rolled_oat_datafunction');
				});
		OAT.Dom.attach('TAB_1_1_3','click',
				function(){
					OAT.Dom.hide('rolled_oat_main','rolled_oat_datafunction','rolled_oat_authorship','rolled_oat_remoteeval');
					OAT.Dom.show('rolled_oat_authorship');
				});
		OAT.Dom.attach('TAB_1_1_4','click',
				function(){
					OAT.Dom.hide('rolled_oat_main','rolled_oat_datafunction','rolled_oat_authorship','rolled_oat_remoteeval');
					OAT.Dom.show('rolled_oat_remoteeval');
				});

		OAT.Dom.hide('rolled_oat_datafunction','rolled_oat_authorship','rolled_oat_remoteeval');
	}
}


INFOGROUP.topic1_3W_panels = {
	needs:["window"],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: null,
	cb:function() {
		OAT.Dom.attach('TAB_1_2_1','click',
				function(){
					OAT.Dom.hide('rolled_oat_lib_main','rolled_oat_lib_function','rolled_oat_lib_authorship');
					OAT.Dom.show('rolled_oat_lib_main');
				});
		OAT.Dom.attach('TAB_1_2_2','click',
				function(){
					OAT.Dom.hide('rolled_oat_lib_main','rolled_oat_lib_function','rolled_oat_lib_authorship');
					OAT.Dom.show('rolled_oat_lib_function');
				});
		OAT.Dom.attach('TAB_1_2_3','click',
				function(){
					OAT.Dom.hide('rolled_oat_lib_main','rolled_oat_lib_function','rolled_oat_lib_authorship');
					OAT.Dom.show('rolled_oat_lib_authorship');
				});

		OAT.Dom.hide('rolled_oat_lib_function','rolled_oat_lib_authorship');
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
							return( function(){ fetch_word_subsection(cc,"rolled_oat_list_placement2"); } );
						})(char) );
			letter++;
		}

	}
}



var g_rolled_oats = null;
var g_rolled_oats_char = "A";
var g_rolled_oats_list = null;
var g_unclassified_oat_array = null;

function unclassify_new_oat(oatname) {
	if ( g_unclassified_oat_array == null ) {
		g_unclassified_oat_array = new Array();
	}

	var n = 0;
	for ( var i = 0; i < n; i++ ) {
		if ( g_unclassified_oat_array[i] == oatname ) {
			alert("Unclassied Oat already exists");
			return(false);
		}
	}

	g_unclassified_oat_array.push(oatname);
	return(true);
}



function fetch_word_subsection(char,div_location) {
	if ( g_rolled_oats != null ) {
		g_rolled_oats_list = new Object();
		g_rolled_oats_char = char;
		$(div_location).innerHTML = g_rolled_oats[char];
	}
}



function edit_rolled_oat(oatname) {
	////
	$("statusMsg").innerHTML = "Fetching Rolled Oat: " + vocname;
	////
	var tree_com = rolled_oats_locus + "one_rolled_oat" + ".php?sess=" + g_classydex_session_id + "&name=" + oatname;
	makeDocEvalRequest( tree_com );
	////
	
}


function extract_permission_list() {
	if ( g_rolled_oats == null ) return(null);
	if ( g_rolled_oats_list == null ) return(null);

	var permarray = new Array();
	for ( perm in g_rolled_oats_list ) {
		if ( g_rolled_oats_list[perm] ) {
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



///////////////////////////////
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
var g_vocname = g_rolled_oat_taxonomy;
var g_vocid = g_rolled_oat_taxonomy;

var g_current_taxonomy_tree = null;
var g_fetched_term_ids = null;

var g_oat_content_type_ghost_drag;

	INFOGROUP.addGhostDrags = {
		needs:[],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			g_oat_content_type_ghost_drag = new OAT.GhostDrag(); // This is the first ghostDrag...
		}
	}




var g_current_select = "";

var g_tree_containers = {
		current_taxonomy:	{
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:1,onClick:"select",onDblClick:"toggle"},
			drag_drop_arrangement: function(tree) {
				///-----------------------------------------------------
				var procRef = function(elm) {};
				var backRef = function(target,x,y) { /* ghostdrag ended; some re-structuring? */
					var node = target.obj;
					if ( node.isLeaf ) return;

					var newnodelabel = strim($("wordsource").innerHTML);
					if ( ( newnodelabel.length > 0 ) && (!node.findChild(newnodelabel)) ) {
						var child = node.createChild(newnodelabel,false,0);
						child['term_id'] = newnodelabel;
						child.isLeaf = true;
						node.expand();
					}
				}
				tree.gd.addSource($("wordsource"),procRef,backRef);
				tree.setTrasher($("trashbucketContainer"));
			}
		},
		current_content_type:	{
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"},
			drag_drop_arrangement: function(tree) {
				tree.walk("select");
				var element_list = tree.selectedNodes;
				var n = element_list.length;
				for ( var i = 0; i < n; i++ ) {
					g_oat_content_type_ghost_drag.addTarget(element_list[i]._div);

					var edit_details = (function(detailer) {
								return(function(){ open_up_details(detailer); });
							})(element_list[i]);

					OAT.Dom.attach(element_list[i]._div,"click",edit_details);
				}
				tree.walk("toggleSelect");
			}
		},
		oat_source:	{
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"},
			drag_drop_arrangement: function(tree) {

				var procRef = function(elm) {
					g_current_select = elm.innerHTML.replace("<span","").replace("</span>","");
					g_current_select = g_current_select.substring(g_current_select.indexOf(">") + 1);
				};
				var backRef = function(target,x,y) { /* ghostdrag ended; some re-structuring? */

					var newnodelabel = strim(g_current_select);
					var node = target.obj;
					if ( node.isLeaf ) return;
	
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

				tree.walk("select");
				var element_list = tree.selectedNodes;
				var n = element_list.length;
				for ( var i = 0; i < n; i++ ) {
					g_oat_content_type_ghost_drag.addSource(element_list[i]._label, procRef, backRef);
					element_list[i]._label.style.cursor = "pointer";
				}
				tree.walk("toggleSelect");

			}
		}
	};


function render_vocabulary_tree(taxocontainer) {

	if ( taxocontainer == null ) {
		alert("Supply a parameter to: render_vocabulary_tree");
		return(false);
	}

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





function set_form_values(objectdata) {
	var prfx = objectdata.prefix;;
	var elarray = objectdata.elements;
	var n = elarray.length;
	for ( var i = 0; i < n; i++ ) {
		var elobj = elarray[i];
		var el = $(prfx + elobj.id);
		el.value = elobj.value;
		if ( el.type == 'checkbox' ) {
			el.checked = (el.value == 1);
		}
	}
}




