
var DEMO = {};
window.cal = false;

var g_saving_roles = true;
var g_saving_menus = true;

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
	app_action: function() { go_get_role_tree_text('select_role_taxonomy','roles'); },
	cb:function() {
		universalWindow(this,"Add Account Type","topic1_1","OPS1","click");
	}
}



////
INFOGROUP.topic1_2W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: function() { pick_vocabulary(g_role_taxonomy_name,g_role_taxonomy,"current_taxonomy1"); },
	cb:function() {
		universalWindow(this,"Role Permissions Editing","topic1_2","OPS2","click");
	}
}


////
INFOGROUP.alphSetup = {
	needs:[],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {

		var base = "acc_part_";	//  English alphabet
		var letter = "A".charCodeAt(0);
		for ( var i = 0; i < 26; i++ ) {
			var char = String.fromCharCode(letter);
			var id = base + char;
			OAT.Event.attach(id, "click", (function(cc) {
							return( function(){ fetch_word_subsection(cc,"permission_list_placement1"); } );
						})(char) );
			letter++;
		}

		var base = "vocab_part_";	//  English alphabet
		var letter = "A".charCodeAt(0);
		for ( var i = 0; i < 26; i++ ) {
			var char = String.fromCharCode(letter);
			var id = base + char;
			OAT.Event.attach(id, "click", (function(cc) {
							return( function(){ fetch_word_subsection(cc,"permission_list_placement2"); } );
						})(char) );
			letter++;
		}

	}
}



var g_permissions = {
	permission_list_placement1: null,
	permission_list_placement2: null
};


var g_current_perm_char = "A";
var g_perm_list = null;


function fetch_word_subsection(char,div_location) {
	if ( g_permissions[div_location] != null ) {
		g_perm_list = new Object();
		g_current_perm_char = char;
		var glist = g_permissions[div_location];
		$(div_location).innerHTML = glist[char];
	}
}

function init_permissions_list(effector,divlocation) {
	var url = "fetch_permissions.php?sess=" + g_classydex_session_id + "&divloc=" + divlocation;
	if ( effector != null ) {
		url += "&effector=" + effector;
	}
	makeDocEvalRequest(url);
}

////		

function init_permissions_next_step() {
	init_permissions_list('putword','permission_list_placement2');
}


function add_perm(perm,wid) {
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

function add_acc(perm,wid) {
	var url = "populate_acc_form.php?sess=" + g_classydex_session_id + "&serviceid=" + g_service_id;
	if ( perm != null ) {
		url += "&acctype=" + perm;
	}
	makeDocEvalRequest(url);
}


function remove_acc(perm) {
	var elements = [ {id: 'name', required: true },
					{id: 'description', required: false },
					{id: 'help', required: false},
					{id: 'needs_form', required: false},
					{id: 'needs_approval', required: false},
					{id: 'needs_pay', required: false},
					{id: 'price', required: false}];
	var n = elements.length;
	for ( var i = 0; i < n; i++ ) {
		var elid = 'add_accounttype' + '-' + elements[i].id;
		var elem = $(elid);
		if ( elem ) {
			elem.value = "";
		}
	}

}

function add_putword(perm,wid) {
	g_current_word_id = wid;
	$("wordsource").innerHTML = perm;
}

function remove_putword(perm) {
	$("wordsource").innerHTML = "put word";
}

///

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


INFOGROUP.menuInit = {
	needs:[],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		init_permissions_list('acc','permission_list_placement1');
	}
}



////   
INFOGROUP.topic1_3W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Map Vocabulary","topic1_3","OPS3","click");
	}
}

////   
INFOGROUP.topic1_4W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Vocabulary to Account Type","topic1_4","OPS4","click");
	}
}


////   
INFOGROUP.topic1_6W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
		universalWindow(this,"Publish Account Types","topic1_6","OPS6","click");
	}
}


////   
INFOGROUP.topic1_7W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action:  function() { go_get_user_list('user_list_placement'); },
	cb:function() {
		universalWindow(this,"Users by Account Types","topic1_7","OPS7","click");
	}
}


////   
INFOGROUP.topic1_8W = {
	needs:["window"],
	wind: null,
	save_width: 0,
	app_action:  function() { go_get_approval_list('user_approval_placement'); },
	cb:function() {
		universalWindow(this,"Users Needing Approval","topic1_8","OPS8","click");
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



function go_get_page_text(reporter,url) {

	spanID = reporter;
	var provider = community_reports + "contentpart.php?q=" + url;
	makeDocEvalRequest( provider );

}


function go_get_user_list(reporter) {

	spanID = reporter;
	var provider = role_ops + "userlist.php?sess=" + g_classydex_session_id + "&busdir=" + g_role_business_name;
	makeDocRequest( provider );

}


function go_get_approval_list(reporter) {

	spanID = reporter;
	var provider = role_ops + "userapprovallist.php?sess=" + g_classydex_session_id + "&busdir=" + g_role_business_name;
	makeDocRequest( provider );

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
var g_vocname = g_role_taxonomy_name;
var g_vocid = g_role_taxonomy;

var g_current_taxonomy_tree = null;
var g_fetched_term_ids = null;


g_tree_containers = {
		current_taxonomy1: {
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:1,onClick:"select",onDblClick:"toggle"},
			drag_drop_arrangement: function(tree) {
				g_tree_containers.current_taxonomy1.tree = tree;
				var t = tree;
			
				var procRef = function(elm) {};
				var backRef = function(target,x,y) { /* ghostdrag ended; some re-structuring? */
					var node = target.obj;
					while ( node && ( node.isLeaf ) ) {
						node = node.parent;
					}
			
					var targname = node.getLabel();
			
					var newword = $('wordsource').innerHTML;
					if ( !node.findChild(newword) ) {
						var child = node.createChild(newword,true,0);  // Build a tree of non leaf elements, for form detailing.
						child._label.style.cursor = "pointer";
						child.isLeaf = false;
						child['term_id'] = g_current_word_id;
			
						node.expand();
			
					}
			
					node.expand();
				};
				t.gd.addSource($("wordsource"),procRef,backRef);
				t.setTrasher($("trashbucketContainer"));
			
				tree.walk("select");
				var element_list = tree.selectedNodes;
				var n = element_list.length;
				for ( var i = 0; i < n; i++ ) {
					element_list[i]._label.style.cursor = "pointer";
				}
				tree.walk("toggleSelect");
			
				$("statusMsg").innerHTML = "Current Vocabulary: " + g_vocname;
				$("taxo_name").innerHTML = g_vocname;
			
			}
		},
		content_type_area3:	{
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:0,onClick:"select",
							onDblClick:"toggle",checkboxMode:true,checkNOI:true,
							ascendSelection:false,chaseUncheckDown:true,chaseCheckDown:true},
			drag_drop_arrangement: function(tree) {
				g_tree_containers.content_type_area3.tree = tree;
				tree.walk("select");
				var element_list = tree.selectedNodes;
				var n = element_list.length;
				for ( var i = 0; i < n; i++ ) {
					var name = element_list[i]._label.innerHTML;

					element_list[i]._label.style.cursor = "pointer";
				}
				tree.walk("toggleSelect");
			}
		}
	};
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
		if ( g_vocname.substring(0,5) != "roles" ) { return; }

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


function save_role_tree_callback() {
	/// Make the role taxonomy into a content type.
	var postdata = "business=" + g_business + "&" + "taxoselect[0]=" + g_vocid;
	postdata += "&deletecond=" + "(name = 'roles')"
	var url = taxonomy_ops + "contentassigner.php";
	spanID = "statusMsg";
	makePOSTRequest(url,postdata);
}



function save_role_tree() {
	// If the Role tree is a new tree based on the system role tree... 
	// Then the taxonomy for the role tree has to be created...
	special_ops_key = "RoleTreeSaveOps2";
	special_ops[special_ops_key] = save_role_tree_callback;
	save_taxonomy_tree();
}



function get_account_to_menu_name() {
	var menu_name = "menus_" + g_role_business_name + "_" + g_selected_account_type;
	return(menu_name);
}

function is_menu_tree(taxoname) {	
	var fronter = taxoname.substring(0,5);
	if ( fronter == "menus" ) return(true);
	return(false);
}

function get_new_vocabulary_name() {
	var name = prompt("Enter a taxonomy name:","generic");
	return(name);
}



function save_taxonomy_tree_as() {
	//
	if ( is_menu_tree(g_vocname) ) {
		g_saving_menus = true;
		g_saving_roles = false;
		g_vocname = get_account_to_menu_name();
	} else {
		g_vocname = get_new_vocabulary_name();
	}
	//
	store_new_named_tree(g_vocname);
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



function show_account_dataq(acctype_id,acctype_name) {
/*
	var account_com = accounts_details + "?sess=" + g_classydex_session_id + "&id=" + acctype_id;
	makeDocEvalRequest( account_com );
*/
}



function set_business_account_dit(acctype_id,acctype_name,businessname) {
	var special_menu_link = $('menu_nav_link');
	var shref = special_menu_link.href;
	shref = shref.substring(0,shref.lastIndexOf('='));
	shref += "=" +  acctype_name;
	special_menu_link.href = shref;
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



function selPermString(perm) {
	$('permission_label_field').innerHTML = perm;
}



var g_account_name_list;
var g_account_type_selected = "";
var g_tag_type_for_RW = "";

function store_account_content_types() {
///
	var tree = g_tree_containers.content_type_area3.tree;
///

	var checked_items = tree.checkedNOI;
	var n = checked_items.length;
	var terms = "";
	var sep = "";
	for ( var i = 0; i < n; i++ ) {
		var node = checked_items[i];
		var term = node.getLabel();
		terms += sep + term;
		sep = ",";
	}

	var taggersR = "r_" + g_tag_type_for_RW;
	var taggersW = "w_" + g_tag_type_for_RW;

	var RW = "";
	if ( $(taggersR).checked ) {
		RW = "R";
	} else if ( $(taggersW).checked ) {
		RW = "W";
	}

	if ( RW.length == 0 ) {
		alert("These permissions need to be selected for read and write.");
		return;
	}

	spanID = "statusMsg";

	var postData = "sess=" + g_classydex_session_id + "&taxoid=" + g_vocid + "&serviceid=" + g_service_id;
	postData += "&accounttype=" + g_account_type_selected;
	postData += "&RW=" + RW;
	postData += "&terms=" + terms;

	var postTarget = role_ops + "storeaccessrules.php";
	makePOSTRequest(postTarget,postData);

}


var g_access_taggers = {};

function showRWchecks(accounttype,taggers) {

	g_account_type_selected = accounttype;

	var taggersR = "r_" + taggers;
	var taggersW = "w_" + taggers;

	g_tag_type_for_RW = taggers;

	if ( !g_access_taggers.hasOwnProperty(taggersR) ) {
		$(taggersR).checked = true;
	}

	for ( var tag in g_access_taggers ) {
		var at = g_access_taggers[tag];
		if ( at == "on" ) {
			g_access_taggers[tag] = "off"
			OAT.Dom.hide(tag);
		}
	}

	g_access_taggers[taggersR] = "on";
	g_access_taggers[taggersW] = "on";

	OAT.Dom.show(taggersR);
	OAT.Dom.show(taggersW);

}


