/*
 * menuExpandable4.js - implements an expandable menu based on a HTML list
 * rewritten for Drupal 5 using jQuery
 * Author: subspaceeddy / subspaceeddy@yahoo.co.uk
 */


var g_dhtml_prevselected = null;
var g_dhtml_prev_index = -1;
var taxopanelcount = 0;

var dhtml_tree_list = {};


function add_taxodhtml_tree_to_list(divname,tree) {
	dhtml_tree_list[divname] = tree;
}

function show_taxo_tree(refdex) {
	if ( refdex >= 0 ) {
		var divname = "taxotree_" + refdex;
		var taxo = dhtml_tree_list[divname];
		if ( taxo != null ) taxo.tree.children[0].expand();
	}
}

function hide_taxo_tree(refdex) {
	if ( refdex >= 0 ) {
		var divname = "taxotree_" + refdex;
		var taxo = dhtml_tree_list[divname];
		if ( taxo != null ) {
			taxo.tree.children[0].collapse();
		}
	}
}


function selectTaxonomy(selector,refdex) {
	var obj = selector;
	var styleclass = obj.className;
	
	if ( obj != g_dhtml_prevselected ) {
		if ( ( styleclass == null ) || ( styleclass == "taxodhtmlcell" ) ) {
			styleclass =  "taxodhtmlcellselected";
			if ( g_dhtml_prevselected != null ) {
				g_dhtml_prevselected.className = "taxodhtmlcell";
				g_dhtml_prevselected.referenced.style.visibility = "hidden";
				hide_taxo_tree(g_dhtml_prev_index);
			}


			if ( g_dhtml_prev_index >= 0 ) {
				var refobj = $("taxopanel_" + g_dhtml_prev_index);
				refobj.style.height = "0%";
				refobj.style.width = "0%";
				OAT.Dom.unlink(refobj);
				$("return_taxopanel_keeper").appendChild(refobj);
			}

			var refobj = $("taxopanel_" + refdex);
			if ( refobj == null ) refobj = obj.referenced;
			$("taxopanel_keeper").appendChild(refobj);
			refobj.style.height = "98%";
			refobj.style.width = "98%";
			refobj.style.visibility = "inherit";

			obj.referenced = refobj;
			show_taxo_tree(refdex);
		} else {
			styleclass =  "taxodhtmlcell";
			obj.referenced.style.visibility = "hidden";
		}
		obj.className = styleclass;

		g_dhtml_prevselected = obj;
		g_dhtml_prev_index = refdex;
	}
}





function initialize_dhtml_panels() {
	selectTaxonomy($('taxotd0'),0);
}







function addtaxotree(divname) {
	try {
		var t = new OAT.Tree({imagePath:"../../../../sharedimages/",imagePrefix:"",ext:"png",
							allowDrag:0,onClick:"select",onDblClick:"toggle",onlyOneOpened:false });
	} catch(e) {
		alert(e.message);
	}
	t.assign(divname,true);
	add_taxodhtml_tree_to_list(divname,t);
}



