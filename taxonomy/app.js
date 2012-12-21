/*
 * 
 *
 *  See LICENSE file for details.
 */


var DEMO = {};
window.cal = false;


popRef = "urlselections";

INFOGROUP = {};

var g_special_ad_categories_tree = null;




function fetch_index(sessionNum) {
	spanID = "tree_content";
	var tree_com = tree_locus + "?sess=" + sessionNum;
	sendClassifiedsCommand(tree_com);
} 

	////////////////////////////////////////////////////////////////////////////////
	////   



var g_taxo_array_from_db = null;
var g_current_char = "A";

function fetch_word_section(char,div_location) {
	g_current_char = char;
	spanID = div_location;
	var word_com = word_locus + "?sess=" + g_classydex_session_id + "&char=" + char + "A";
	makeDocRequest( word_com );
}


///////////////////////////////////////////////////////////////////////////////////////////////////////////

function render_vocabulary_tree(abc) {
	var t = new OAT.Tree({imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"});
	t.assign("current_taxonomy",0);
}

function go_get_page_text(reporter,url) {

	special_ops_key = "VocabTextRender";
	special_ops[special_ops_key] = render_vocabulary_tree;

	spanID = reporter;
	var provider = taxonomy_ops + "pubtree.php?taxo=" + url;
	makeDocRequest( provider );

}



var g_taxo_select = 0;
function set_taxo(tt) {
	g_taxo_select = tt;
}


INFOGROUP.topic_published_taxoW = {
	needs:["window"],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: function() { go_get_page_text('current_taxonomy',g_taxo_select); },
	cb:function() {
		universalWindow(this,"Taxonomy","topic_published_taxo",g_taxo_array_from_db,"click");
	}
}


popRef = "repository_data";
