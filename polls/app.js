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

function tree_render() {
/*
		var tdata = $("initial_tree_data").innerHTML;
		$("tree_content").innerHTML = tdata;
*/
		var t = new OAT.Tree({imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"});
		t.assign("tree_content",0);
		g_special_ad_categories_tree = t;
}



INFOGROUP.tree = {
	panel:0,
	tab:0,
	div:"tree",
	needs:["tree"],
	cb:function() {
		filtered_taxo_pick("polls",g_poll_taxo_id,"content_type_area","W");
	}
}

	////////////////////////////////////////////////////////////////////////////////
	////   
	INFOGROUP.topic1_1W = {
		needs:["window"],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			universalWindow(this,"Topic Posting","topic1_1","adBtn","click");
		}
	}
	////   
	INFOGROUP.topic1_2W = {
		needs:["window"],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {

			OAT.Dom.attach($('search_button'),'click',function(){ search_current_topics(); });

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


function poll_topic_check_and_submit() {

	var chck = $('topic_submit_term').value;

	if ( chck.length < 2 ) {
		alert("You need to select a poll to post to.");
		return;
	}

	chck = $('topic_submit_entry').value;
	if ( chck.length < 10 ) {
		alert("Do you have something to say?");
		return;
	}

	chck = $('topic_submit_title').value;
	if ( chck.length < 10 ) {
		alert("A title is required.");
		return;
	}

	var frm = $('topic_submit_form').submit();

}


	INFOGROUP.topic1_4W = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: function () { poll_topic_check_and_submit(); },
		cb:function() {
			universalWindow(this,"Post a Topic","topic1_4","posterHitBtn","click");
		}
	}


var g_lower_bound_date = "";
var g_upper_bound_date = "";


	INFOGROUP.dateRange = {
		needs:["calendar"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: null,
		cb:function() {
			///
			var c = new OAT.Calendar({popup:true});
			c.dayNames = ["Mon","Tue","Wed","Thu","Fri","Sat","Sun"];
			c.monthNames = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
			c.specialDays = [0,0,0,0,0,1,1];
			c.dayZeroIndex = 6;
			c.weekStartIndex = 6;

			OAT.Dom.attach($('search_lb_date'),'click',function(){ 
				var xy = OAT.Dom.position($('search_lb_date'));
				c.show(xy[0], xy[1], function(adate){
									var dd = adate;
									g_lower_bound_date = dd + " 00:00:00";
									g_lower_bound_date = g_lower_bound_date.replace(',','-').replace(',','-');
									$('search_lb_value').value = g_lower_bound_date;
								});
			});
			OAT.Dom.attach($('search_ub_date'),'click',function(){
				var xy = OAT.Dom.position($('search_ub_date'));
				c.show(xy[0], xy[1], function(adate){
									var dd = adate;
									g_upper_bound_date = dd + " 00:00:00";
									g_upper_bound_date = g_upper_bound_date.replace(',','-').replace(',','-');
									$('search_ub_value').value = g_upper_bound_date;
								});
			});

//			c.show(100, 100, function(){});
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






function show_details(topicid) {
	spanID = "singleItemEntrySpan";
	showWindowProc('singleItemDetail');
	var requrl = poll_locus + "pollserver/details.php?sess=" + g_classydex_session_id + "&topicid=" + topicid;
	makeDocRequest(requrl);
}





function get_search_entries(term,title_keys,key_keys,search_lb_value,search_ub_value) {

	spanID = "searchResults";

	var requrl = poll_locus + "fetchentries.php?sess=" + g_classydex_session_id + "&poll=" + g_poll_taxo_id + "&term=" + term;
	if ( title_keys.length ) { 
		requrl += "&title_keys=" + title_keys;
	}
	if ( key_keys.length ) { 
		requrl += "&key_keys=" + key_keys;
	}
	if ( search_lb_value.length ) { 
		requrl += "&search_lb_value=" + search_lb_value;
	}
	if ( search_ub_value.length ) { 
		requrl += "&search_ub_value=" + search_ub_value;
	}

	makeDocRequest(requrl);

}




var g_currently_selected_poll = "";

function get_poll_topics(term,taxo) {

	setPosterBtnText(term);
	$('pollTitle').innerHTML = term;

	$('topic_submit_term').value = term;
	$('search_poll').innerHTML = term;
	g_currently_selected_poll = term;
	get_search_entries(g_currently_selected_poll,"","","","");

}


function search_current_topics() {

	// Check for the selected search fields and apply them ...

	var use_title = $("include-search_form-title").checked;
	var use_keys = $("include-search_form-keys").checked;

	var title_keys = "";
	if ( use_title ) {
		title_keys = $("search_form-title" ).value;
	}
	var key_keys = "";
	if ( use_keys ) {
		key_keys = $("search_form-keys").value;
	}

	var search_lb_value = $("search_lb_value").value;
	var search_ub_value = $("search_ub_value").value;

	get_search_entries(g_currently_selected_poll,title_keys,key_keys,search_lb_value,search_ub_value);

}



var realTitle = "";
var gButtonExplainer = {
							adBtn: "<span style='font-size:0.45em;color:brown;letter-spacing:1.5px;font-family:courier' >Place your ad here.</span>",
							searchBtn: "<span style='font-size:0.45em;color:brown;letter-spacing:1.5px;font-family:courier' >Detailed search for topics on this site.</span>",
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




function setPosterBtnText(catname) {
	$("posterpoll").innerHTML = catname;
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



g_tree_containers = {
		content_type_area:	{
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"},
			drag_drop_arrangement: function(tree) {

				g_tree_containers.content_type_area.tree = tree;
				g_content_rw_state = "W";

				var accessor = g_ct_access_list["content_type_area1"];

				tree.walk("select");
				var element_list = tree.selectedNodes;
				var n = element_list.length;
				for ( var i = 0; i < n; i++ ) {
					var node = element_list[i];
					var name = node.getLabel();

					if ( ( accessor == null ) || accessor.hasOwnProperty(name) ) {
						var fetch_fields = (function(term,taxo) {
									return(function(){ get_poll_topics(term,taxo); });
								})(name,g_vocname);
						OAT.Dom.attach(node._div,"click",fetch_fields);
						/// TURN THIS INTO A CLASS NAME
						node._label.style.cursor = "pointer";
						node._label.style.border = "1px solid navy";
						node._label.style.backgroundColor = "#FEFECC";
						node._label.style.marginTop = "8px";
						node._label.style.paddingLeft = "4px";
						node._label.style.paddingRight = "4px";
						node._label.style.color = "darkred";
						node._label.style.fontWeight = "bold";
					} else {
						node._label.style.backgroundColor = "lightgrey";
						node._label.style.color = "gray";
					} 
				}

				tree.walk("toggleSelect");
			}
		},
		content_type_area2:	{
			tree: null,
			parameters: {imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"},
			drag_drop_arrangement: function(tree) {

				g_tree_containers.content_type_area2.tree = tree;
				g_content_rw_state = "R";

				var accessor = g_ct_access_list["content_type_area2"];

				tree.walk("select");
				var element_list = tree.selectedNodes;
				var n = element_list.length;
				for ( var i = 0; i < n; i++ ) {
					var name = element_list[i]._label.innerHTML;
					var node = element_list[i];

					if ( ( accessor == null ) || accessor.hasOwnProperty(name) ) {
						parameters = "'" + name + "','" + g_vocname + "'";
						var newhtml = "<input type='submit' class='buttonLike' value='" + name + "' onclick=\"get_form(" + parameters + ",'search','formDepositorDiv');\">";
						element_list[i]._label.innerHTML = newhtml;
						element_list[i]._label.style.cursor = "pointer";
					} else {
						node._label.style.backgroundColor = "lightgrey";
						node._label.style.color = "gray";
					} 
				}
				tree.walk("toggleSelect");
			}
		}
	};


