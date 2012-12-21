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




function fetch_index(sessionNum) {
	spanID = "tree_content";
	var tree_com = tree_locus + "?sess=" + sessionNum;
	sendClassifiedsCommand(tree_com);
}

	////////////////////////////////////////////////////////////////////////////////
	////   
	INFOGROUP.topic1_1W = {
		needs:["window"],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			universalWindow(this,"Make an Ad","topic1_1","adBtn","click");
		}
	}
	////   
	INFOGROUP.topic1_2W = {
		needs:["window"],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			universalWindow(this,"Search","topic1_2","searchBtn","click");
		}
	}
	////   
	INFOGROUP.topic1_3W = {
		needs:["window"],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			universalWindow(this,"Help","topic1_3","helpBtn","click");
		}
	}


	INFOGROUP.topic1_4W = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: function() { go_get_post_form('posterHitBtn'); },
		cb:function() {
			universalWindow(this,"Post an Ad","topic1_4","posterHitBtn","click");
		}
	}


	INFOGROUP.topic1_5W = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: function() { go_get_search_result('searcherHitBtn'); },
		cb:function() {
			universalWindow(this,"Search Results","topic1_5","searcherHitBtn","click");
		}
	}


	INFOGROUP.singleItemDetail = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: null,
		cb:function() {
			universalWindow(this,"Details","singleItemEntry",null,"click");
		}
	}



	INFOGROUP.contactForm = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: null,
		cb:function() {
			universalWindow(this,"Make Contact","contactDiv",null,"click");
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
	helpBtn: "<span style='font-size:0.45em;color:brown;letter-spacing:1.5px;font-family:courier' >Information about how to use this web site.</span>"
	searchBtn: "<span style='font-size:0.45em;color:brown;letter-spacing:1.5px;font-family:courier' >Detailed search for ads on this site.</span>",
	forumsBtn: "<span style='font-size:0.45em;color:brown;letter-spacing:1.5px;font-family:courier' >Forums for discussion groups.</span>",
	bookBtn: "<span style='font-size:0.45em;color:brown;letter-spacing:1.5px;font-family:courier' >Books available on this site.</span>",
	indexBtn: "<span style='font-size:0.45em;color:brown;letter-spacing:1.5px;font-family:courier' >The Taxonomies.</span>",
	controls: "<span style='font-size:0.45em;color:brown;letter-spacing:1.5px;font-family:courier' >The main controls window.</span>"
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


