
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
		universalWindow(this,"Add Vocabulary","topic1_1","OPS1","click");
	}
}


////
INFOGROUP.topic1_2W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: function() { pick_vocabulary(g_rolled_oat_taxonomy_name,g_rolled_oat_taxonomy,"current_taxonomy",false); },
	cb:function() {
		universalWindow(this,"Rolled Oat Classification","topic1_2","OPS2","click");
	}
}


////
INFOGROUP.topic1_3W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Edit Rolled Oat","topic1_3","OPS3","click");
	}
}


////
INFOGROUP.topic1_4W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Manage Rolled Oat Library","topic1_4","OPS4","click");
	}
}




////
INFOGROUP.topic1_6W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: function() { pick_vocabulary(g_rolled_oat_taxonomy_name,g_rolled_oat_taxonomy,"oat_source",true); },
	cb:function() {
		universalWindow(this,"Add Fields to Content Types","topic1_6","OPS6","click");
	}
}




function secondary_taxonomy_render() {
	pick_vocabulary('forums',8,"current_content_type",false);  /// From a content type...
}




var g_oat_field_grid = null;
var g_unclassified_oat_header = null;
var g_unclassified_oat_array = null;
var g_classified_oat_components = {}; /// Load these before the trees.  form is classifier => oat

function set_classified_oat_components(obj) {
	g_classified_oat_components = obj;
}

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
												if ( !oat_comp_classified(oatcomp) ) {
													$('wordsource').innerHTML = descr[0];
												}
											} );
								})(g_unclassified_oat_array[i]);
			OAT.Dom.attach(cell.html,"click",oat_select);
		}
		g_oat_field_grid = grid;
		//----------------------------------------------------
	}
}

var g_oats_classified_this_session = {};

function oat_comp_classified(oatcomp) {
	if ( g_oats_classified_this_session.hasOwnProperty(oatcomp) ) {
		var compclass = g_oats_classified_this_session[oatcomp];
		if ( compclass == null ) return(false);
		return(true);
	}
	return(false);
}

function oat_comp_classify(oatcomp,classification) {
	g_oats_classified_this_session[oatcomp] = classification;
}

function oat_comp_unclassify(oatcomp) {
	g_oats_classified_this_session[oatcomp] = null;
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
					OAT.Dom.show('rolled_oat_remoteeval');
				});
		OAT.Dom.attach('TAB_1_1_4','click',
				function(){
					OAT.Dom.hide('rolled_oat_main','rolled_oat_datafunction','rolled_oat_authorship','rolled_oat_remoteeval');
					OAT.Dom.show('rolled_oat_authorship');
				});

		OAT.Dom.hide('rolled_oat_datafunction','rolled_oat_authorship','rolled_oat_remoteeval');
	}
}

INFOGROUP.topic1_2W_sub_panels = {
	needs:[],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: null,
	cb:function() {
		OAT.Dom.attach('TAB_1_1_5','click',
				function(){
					OAT.Dom.hide('rolled_oat_intial_limits','rolled_oat_data_representation','rolled_oat_search_parameters');
					OAT.Dom.show('rolled_oat_intial_limits');
				});
		OAT.Dom.attach('TAB_1_1_6','click',
				function(){
					OAT.Dom.hide('rolled_oat_intial_limits','rolled_oat_data_representation','rolled_oat_search_parameters');
					OAT.Dom.show('rolled_oat_data_representation');
				});
		OAT.Dom.attach('TAB_1_1_7','click',
				function(){
					OAT.Dom.hide('rolled_oat_intial_limits','rolled_oat_data_representation','rolled_oat_search_parameters');
					OAT.Dom.show('rolled_oat_search_parameters');
				});

		OAT.Dom.hide('rolled_oat_data_representation','rolled_oat_search_parameters');
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
	$("statusMsg").innerHTML = "Fetching Rolled Oat: " + oatname;
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
var g_oat_component_ghost_drag;

	INFOGROUP.addGhostDrags = {
		needs:[],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			g_oat_content_type_ghost_drag = new OAT.GhostDrag(); // This is the first ghostDrag...
			g_oat_component_ghost_drag = new OAT.GhostDrag(); // This is the first ghostDrag...
		}
	}




// The tree is up showing the structure of the content type,
// but the fields that go in it have yet to be retreived.
// So, they must be called for.
var g_content_type_tree_on_display = null;
function content_type_populate_existing_fields(tree) {
	g_content_type_tree_on_display = tree;
	var content_type = g_vocname;
	var url = rolled_oats_locus + "fetch_ct_fields.php?sess=" + g_classydex_session_id + "&content_type=" + content_type;
	url += "&all=true&term=*";
	makeDocEvalRequest(url);
}
////---------------------------------------------------------->>>
var g_content_type_field_detail_list = null;

function content_type_callback_field_data(field_data_obj) {
	g_content_type_field_detail_list = field_data_obj;
	var tree = g_tree_containers.content_type_area1.tree;
	///
	tree.walk("select");
	var element_list = tree.selectedNodes;
	var n = element_list.length - 1;
	for ( var i = 0; i < n; i++ ) {
		var classlabel = element_list[i].getLabel();
		if ( field_data_obj.hasOwnProperty(classlabel) ) {
			var oatcomponent_list = field_data_obj[classlabel].split(",");
			var node = element_list[i];
			if ( oatcomponent_list.length > 0 ) {
				var m = oatcomponent_list.length;
				for ( var j = 0; j < m; j++ ) {
					oatcomponent = oatcomponent_list[j];  // A pair fieldname:type;
					add_component_to_node(oatcomponent,node) 
				}
			}
		}
	}
	tree.walk("toggleSelect");
}


function get_a_field_name(oatcomponent) {
	// OAT Component is the type, but the field needs a name...
	var new_name = prompt("Enter a name for this field","");
	new_name = strim(new_name);
	return(new_name);
}


function extract_fields(fieldcontainer) {
	var extraction = "";
	var sep = "";
	for ( fld in fieldcontainer ) {
		extraction += sep + fld.replace(":","!");
		sep = "@";
	}
	return(extraction);
}


function ro_extract_field_defs(content_data) {
	var extraction = new Object();
	for ( ky in content_data ) {
		extraction[ky] = extract_fields(content_data[ky]);  /// Separate the fields that hook to a term
	}

	return(extraction);
}

function field_list_data(content_data) {
	var output = "";
	var sep = "";
	for ( fld in content_data ) {
		output +=   sep + fld + " : " + content_data[fld] ; // separate the data of the fields...
		sep = ",";
	}
	return( output );
}


function save_content_type_tree() {
// Actually just save the mapping of the tree to the field definitions...
	// Now for the first phase of storage... Store just the list from the tree, keeping the details for another storage procedure.
	var content_data = ro_extract_field_defs(g_current_field_assigments);
	content_data = field_list_data(content_data);

	var detailstring = encodeURIComponent(content_data);

	var content_type = g_vocname;
	var url = rolled_oats_locus + "store_ct_fields.php?sess=" + g_classydex_session_id + "&content_type=" + content_type;
	url += "&details=" + detailstring;
alert(url);
	makeDocEvalRequest(url);

}


function show_oat_classifications(tree) {
	tree.walk("select");
	var element_list = tree.selectedNodes;
	var n = element_list.length;
	for ( var i = 0; i < n; i++ ) {
		var classlabel = element_list[i].getLabel();
		if ( g_classified_oat_components.hasOwnProperty(classlabel) ) {
			var oatcomponent = g_classified_oat_components[classlabel];
			oatcomponent = removespace(oatcomponent);
			var node = element_list[i];
			if ( ( oatcomponent.length > 0 ) && !(node.findChild(oatcomponent))  ) {
				var child = node.createChild(oatcomponent,false,0);
				//g_oat_content_type_ghost_drag.addSource(child._label, procRef, backRef);
				child._label.style.cursor = "pointer";
			}
		}
	}
	tree.walk("toggleSelect");
}



////////////////////////////////
var g_existing_field_names = {};
var g_current_field_assigments = {};  // field lists per node..
var g_field_content_type = "";

function ro_edit_get_name_for_field(compname) {

	var keepgoing = true;
	while ( keepgoing ) {
		var fname = prompt("Enter a name for this field:");

		var n = fname.length - 2;

		if ( n > 0 ) {
			var j =  fname.indexOf(".")
			if ( j > 0 ) {
				var fname_array = fname.split(".");
				fname = fname_array[0] + "_1d0t3_"; // as unlikely as possible...
				fname += fname_array[1];
			}
		}

		var okform = eval("/^[a-z]+[a-z0-9_]{" + n + ",24}$/i.test(fname)");

		if ( (fname.length > 0) && okform ) {
			if ( g_existing_field_names.hasOwnProperty(fname) ) {
				keepgoing = confirm("This name is taken. Would you like to another name?");
			} else {
				g_existing_field_names[fname] = compname;
				return(fname + ":" + compname);
			}
		} else {
			keepgoing = confirm("This name cannot be used as a field. Would you like to another name?");
		} 
	}

	return("");
}



/// Open details editor...
///
function open_details_editor(fielddata) {
	///
	alert(fielddata);
}



function add_component_to_node(field_with_type,node) {
	if ( node.isLeaf ) return;
	var term = node.getLabel();
	if ( !g_current_field_assigments.hasOwnProperty(term) ) {
		g_current_field_assigments[term] = new Object();
	}
	var objlist = g_current_field_assigments[term];
	if ( !objlist.hasOwnProperty(field_with_type) ) {
		objlist[field_with_type] = new Object();
	}

	field_with_type = removespace(field_with_type);
	if ( ( field_with_type.length > 0 ) && !(node.findChild(field_with_type))  ) {
		field_with_type = strim(field_with_type);
		var child = node.createChild(field_with_type,false,0);
		child.isLeaf = true;
		child._label.style.cursor = "pointer";
		OAT.Dom.attach(child._label,'click', (function(fielddata) { return(
									function() { open_details_editor(fielddata); }
								);})(field_with_type)
						);
	}

}

function rebuild_field_definitions(fielddefs,tree) {
	tree.walk("select");
	var element_list = tree.selectedNodes;
	var n = element_list.length;
	for ( var i = 1; i < n; i++ ) {
		var node = element_list[i];
		var field_list =  fielddefs[node.getLabel()];
		for ( var fwt in field_list ) {
			add_component_to_node(fwt,node);
		}
	}
	tree.walk("toggleSelect");
}


function add_ro_field_to_taxonomy_term(component,tree) {
	///
	var field_with_type = ro_edit_get_name_for_field(component); //fieldname, typename pair
	field_with_type = removespace(field_with_type);
	if ( field_with_type.length == 0 ) return;

	var n = tree.checkedNOI.length;
	for ( var i = 0; i < n; i++ ) {
		var tnode = tree.checkedNOI[i];
		add_component_to_node(field_with_type,tnode);
		//add_to_field_details_grid(fieldname,tnode);
	}
}

var g_current_select = "";

var g_tree_containers = {
		current_taxonomy:	{
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:1,onClick:"select",onDblClick:"toggle"},
			drag_drop_arrangement: function(tree) {
				g_tree_containers.current_taxonomy.tree = tree;
				///-----------------------------------------------------
				var procRef = function(elm) {};
				var backRef = function(target,x,y) {
					var node = target.obj;
					if ( node.isLeaf ) return;

					parentName = node.getLabel();
					if ( oat_comp_classified(newnodelabel) ) return;

					var newnodelabel = strim($("wordsource").innerHTML);
					if ( ( newnodelabel.length > 0 ) && (!node.findChild(newnodelabel)) ) {
						oat_comp_classify(newnodelabel,parentName);
						var child = node.createChild(newnodelabel,false,0);
						child['term_id'] = newnodelabel;
						child.isLeaf = true;
						node.expand();
					}
				}
				tree.gd.addSource($("wordsource"),procRef,backRef);
				tree.setTrasher($("trashbucketContainer"));
				show_oat_classifications(tree);
			}
		},
		content_type_area1:	{
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:0,onClick:"select",
							onDblClick:"toggle",checkboxMode:true,checkNOI:true,
							ascendSelection:false,chaseUncheckDown:true,chaseCheckDown:true},
			drag_drop_arrangement: function(tree) {
				g_tree_containers.content_type_area1.tree = tree;
				tree.walk("select");
				var element_list = tree.selectedNodes;
				var n = element_list.length;
				for ( var i = 0; i < n; i++ ) {
					g_oat_content_type_ghost_drag.addTarget(element_list[i]._div);
				}
				tree.walk("toggleSelect");
				content_type_populate_existing_fields(tree);
				if ( g_vocname == g_field_content_type ) {
					rebuild_field_definitions(g_current_field_assigments,tree);
				} else {
					g_current_field_assigments = {};
				}
				g_field_content_type = g_vocname;
			}
		},
		oat_source:	{
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"},
			drag_drop_arrangement: function(tree) {
				g_tree_containers.oat_source.tree = tree;
///
				var procRef = function(elm) {
					g_current_select = elm.innerHTML.replace("<span","").replace("</span>","");
					g_current_select = g_current_select.substring(g_current_select.indexOf(">") + 1);
				};
				var backRef = function(target,x,y) { 
					add_ro_field_to_taxonomy_term(g_current_select,g_tree_containers.content_type_area1.tree);
				}

				show_oat_classifications(tree);

				tree.walk("select");
				var element_list = tree.selectedNodes;
				var n = element_list.length;
				for ( var i = 0; i < n; i++ ) {
					g_oat_component_ghost_drag.addSource(element_list[i]._label,procRef,backRef);
				}
				tree.walk("toggleSelect");
				g_oat_component_ghost_drag.addTarget($("content_type_area1"));

/// Really just need to install these elements into the classified oats.

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
		var backRef = function(target,x,y) { 
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


function save_oat_classification_tree() {
	var oatlist = "";
	var oatclasses = "";
	var sep = "";

	for ( var oatcomp in g_oats_classified_this_session ) {
		var oatclassifier = g_oats_classified_this_session[oatcomp];
		if ( oatclassifier != null ) {
			oatclasses += sep + "\"" + oatclassifier + "\""  +  ":"  + "\"" + oatcomp + "\"";
			oatlist += sep + oatcomp;
			sep = "','";
		}
	}

	oatclasses = encodeURIComponent("{" + oatclasses + "}");

	var saver_data = "sess=" + g_classydex_session_id;
	saver_data += "&oatlist=" + oatlist + "&oatclass=" + oatclasses;

	var postTarget = rolled_oats_locus + "store_oat_classifications.php"
	makePOSTEvalRequest(postTarget,saver_data);

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
		var el = $(prfx + "-" + elobj.id);
		el.value = elobj.value;
		if ( el.type == 'checkbox' ) {
			el.checked = (el.value == 1);
		}
	}
}
