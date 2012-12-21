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
var g_current_group_object = null;




function checkFilledFields(divobjname,txt) {
	var divobj = $(divobjname);
	if ( divobj.value.length == 0 ) {
		alert(txt);
		return(false);
	}
	
	return(true);
}




function tree_render(thespan) {
/*
		var tdata = $("initial_tree_data").innerHTML;
		$("tree_content").innerHTML = tdata;
*/
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


	////   
	INFOGROUP.topic_helpDIV = {
		needs:["window"],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			universalWindow(this,"Help","helpDIV","helpBtn","click");
		}
	}








	////////////////////////////////////////////////////////////////////////////////
	////   
	INFOGROUP.topic_menu1 = {
		needs:["window"],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			universalWindow(this,"Mail From Group","topic1_1","mail_menu1","click");
		}
	}


	////   
	INFOGROUP.topic_menu2 = {
		needs:["window"],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			universalWindow(this,"Mail Sent to Group","topic1_2","mail_menu2","click");
		}
	}

	INFOGROUP.topic_menu3 = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: null,
		cb:function() {
			universalWindow(this,"Members of Group","topic1_3","mail_menu3","click");
		}
	}


	INFOGROUP.topic_menu4 = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: null,
		cb:function() {
			universalWindow(this,"Change Name of Group","topic1_4","mail_menu4","click");
		}
	}


	INFOGROUP.topic_menu5 = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: null,
		cb:function() {
			universalWindow(this,"Group Member Editor","topic1_5","mail_menu5","click");
		}
	}



	INFOGROUP.topic_menu6 = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: function() { go_get_page_text('usersobject','site_user_list'); },
		cb:function() {
			universalWindow(this,"List of Site Users","topic1_6","mail_button6","click");
		}
	}


	INFOGROUP.topic_menu7 = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: null,
		cb:function() {
			universalWindow(this,"Create Content","topic1_7","mail_menu7","click");
		}
	}


	INFOGROUP.groupPromote = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: function () { promote_current_group(); },
		cb:function() {
			universalWindow(this,"Group Promotion","topic1_8","group_promoter","click");
		}
	}


	INFOGROUP.topic_menu9 = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: null,
		cb:function() {
			universalWindow(this,"Search for Content","topic1_9","mail_menu9","click");
		}
	}



	INFOGROUP.topic_menu10 = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: null,
		cb:function() {
			universalWindow(this,"Select Content for Editing","topic1_10","mail_menu10","click");
		}
	}



	INFOGROUP.topic_menu11 = {
		needs:["window"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: function () { fetch_deleted_group_mail(); },
		cb:function() {
			universalWindow(this,"View Mail Marked for Deletion","topic1_11","mail_menu11","click");
		}
	}


////////////////////////////////////////////////////

var g_lower_bound_date = "";
var g_upper_bound_date = "";


	INFOGROUP.dateRange = {
		needs:["calendar"],
		wind: null,
		save_width: 0,
		dontOpen: false,
		app_action: function () { fetch_deleted_group_mail(); },
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





	INFOGROUP.startclock = {
		needs:[],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			setInterval("local_update_clock();",1000);
		}
	}


	INFOGROUP.statusReport = {
		needs:[],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			init_status_reporting();
		}
	}




	INFOGROUP.formaction = {
		needs:[],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			OAT.Dom.attach($("form_command"),"click",form_processing);
		}
	}




function checkCell(teststr) {
	if ( teststr.indexOf("¤") > 0 ) {
		alert("This cell is not initialized for a group");
		return(false);
	}
	return(true);
}


// GhostDrag Operations...
var member_dummyReference = function() {};
var member_successReference = function(target, x, y) {
	var teststr = target.innerHTML;
	if ( checkCell(teststr) ) {
		memberToGroup(teststr);
	}
}


var message_dummyReference = function() {};
var message_successReference = function(target, x, y) {
	var teststr = target.innerHTML;
	if ( checkCell(teststr) ) {
		messageToGroup(teststr);
	}
 }



	INFOGROUP.addGhostDrags = {
		needs:[],
		wind: null,
		save_width: 0,
		app_action: null,
		cb:function() {
			var obj = $('memberCopyToken');
			var gd = new OAT.GhostDrag(); // This is the first ghostDrag...
			gd.addSource(obj, member_dummyReference, member_successReference);
			var i = 0;
			for ( ;i < 16; i++ ) {
				var grpcontainer = "groupTD" + (i+1);
				gd.addTarget(grpcontainer);
			}

			obj = $('messageCopyToken');
			gd = new OAT.GhostDrag(); // This is the first ghostDrag...
			gd.addSource(obj, message_dummyReference, message_successReference);
			for ( i = 0; i < 16; i++ ) {
				var grpcontainer = "groupTD" + (i+1);
				gd.addTarget(grpcontainer);
			}

			obj = $('sent_messageCopyToken');
			gd = new OAT.GhostDrag(); // This is the first ghostDrag...
			gd.addSource(obj, message_dummyReference, message_successReference);
			for ( i = 0; i < 16; i++ ) {
				var grpcontainer = "groupTD" + (i+1);
				gd.addTarget(grpcontainer);
			}

			obj = $('deleted_messageCopyToken');
			gd = new OAT.GhostDrag(); // This is the first ghostDrag...
			gd.addSource(obj, message_dummyReference, message_successReference);
			for ( i = 0; i < 16; i++ ) {
				var grpcontainer = "groupTD" + (i+1);
				gd.addTarget(grpcontainer);
			}
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
	var provider = "http://localhost/drupal/contentpart.php?q=" + url;
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


///////////////////////////////////////////////////////////////////////////


/// MAIL FUNCTIONS



var spanID = "";
var postID = "";
//
var deletingMessageState = false;



/*
/////////////////////////////////////////   ARRAYS
*/

function splitSubject(subjTxt) {
	return(subjTxt.split("|",6));
}

////////////////////////////////////////////////////



var grouperOnDisplay = false;
//
var globalGroupObj = null;
var draggingMessage = false;
var dropType = "empty";
var copyAction = "";
//
var savecolor;

function rollover(obj) {
	savecolor = obj.style.borderColor;
	obj.style.borderColor = "darkgreen";
}

function rollout(obj) {
	obj.style.borderColor = savecolor;
}

//

////////////////////////////////////////////////////

var groupListSelections = new Object();

function clearGroupSelections() {
	groupListSelections = new Object();
}




var allFriendsSelected = false;
var g_ReaderPrevStyle = "";
var viewingSent = false;

var POP3FetchingState = false;

var specialResponse = null;


var orig_animate_msg = "";

function animate_report3() {
	var obj = $("statusMsg");
	obj.innerHTML = orig_animate_msg;
}

function animate_report2() {
	var obj = $("statusMsg");
	var tmp = obj.innerHTML;

	tmp += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:red;background-color:orange;"> <b>&lt;==</b></span>'
	obj.innerHTML = tmp;
	setTimeout("animate_report3()",500);
}

function animate_report() {
	var obj = $("statusMsg");
	var tmp = obj.innerHTML;
	
	orig_animate_msg = tmp;

	tmp += "&nbsp;&nbsp;&nbsp;&nbsp;<b>&lt;==</b>";
	obj.innerHTML = tmp;
	setTimeout("animate_report2()",500);
}


//==============================


var sections_array = new Array();

var currentLabel = "";
var gSelectedNum = 1;
var gRollGroupLabel = "";
var gRollGroupLabelText = "";

var g_special_response_message = "";
var g_allow_groupLabel = true;
var g_stored_selected_num = 1;


// Itialize the group array.....
/// mailGroupListSpan
	

function msgsend_rollover(targetObj) {

	var x = targetObj.innerHTML;
	var c_pre = '- ';
	if ( targetObj.style.color == "black" ) {
		c_pre = '+ ';
	}
	targetObj.innerHTML = c_pre + x;

	rollover(targetObj);
}

function msgsend_rollout(targetObj) {

	var x = targetObj.innerHTML;
	var c = x.charAt(0);
	if ( ( c == '+' ) || ( c == '-' ) ) {
		x = x.substr(2,x.length);
	}

	targetObj.innerHTML = x;

	rollout(targetObj);
}





function invitations(emailList) {
	emailList = strim(emailList);
	if ( emailList.length == 0 ) {
		alert("No e-mails in list. Click on 'Extern E-mails under Special Commands.");
	} else {
		var xx = "This action will send an e-mail in to each e-mail address in the list suggesting that the recipient join your list of friends.";
		if ( confirm(xx) ) {
			//
			spanID = "statusMsg";
			var group = g_current_group_object;
							
			var url = "emailinvitations.php?sess=" + g_classydex_session_id + "&grouplabel=" + group.name + "&recipients=" + emailList;
			makeDocRequest(url);
		}
	}
}


var g_message_recipients = "";
var g_attachment = "";

function sendToUrl(url_file) {

	var divname = "message_subject";
	var divobj = $(divname);
	var subjtxt = divobj.value;
	
	if ( subjtxt.length == 0 ) {
		alert("No subject entered.");
		return;
	}

	divname = "message_text";
	divobj = $(divname);
	var msgtxt = divobj.value;

	if ( msgtxt.length == 0 ) {
		alert("No message entered.");
		return;
	}

	var externalEmail = strim($("emaillist").innerHTML);  /// There are explicitly not users of the community software...
	if ( ( g_message_recipients.length > 0 ) || ( externalEmail.length > 0 ) ) {
		///
		spanID = "statusMsg";
		
		msgtxt = replace_returns(msgtxt);
		var group = g_current_group_object;
		
		var url = url_file + ".php?sess=" + g_classydex_session_id + "&grouplabel=" + group.name + "&recipients=" + g_message_recipients;
		url += "&subject=" + subjtxt + "&message=" + msgtxt;
		
		if ( externalEmail.length > 0 ) {
			url += "&externemails=" + encodeURI(externalEmail);  // This is appropriately encoded file on a server path.
		}
		if ( g_attachment.length > 0 ) {
			url += "&attachment=" + encodeURI(g_attachment);  // This is appropriately encoded file on a server path.
		}

		group.out_mail_ids = null;
		group.mail_out_descr = null;

		special_ops_key = "update_sent_messages";
		special_ops[special_ops_key] = fetch_group_cascade;
		////
		makeDocRequest(url);
		////
	} else {
		alert("No recipients selected.");
	}

}




//////////////////////////////////////////////////////////////
var g_clearObj = null;
function clearEntry() {
	if ( g_clearObj != nul ) g_clearObj.value = "test";
	g_clearObj = null;
}

////
//// HANDLE THESE RESPONSES IN CASE OF UPLOAD OF ATTACHMENT FIRST
////
function MessageSender(returnFile) {
	g_attachment = returnFile;
	////
	var url_file = "sendMailMessage";
	sendToUrl(url_file);
	//
}
////////////////////////////////////////////////////////////////////


function checkExt(extlist,obj) {
	var ss = obj.value;
	
	var sparts = ss.split(".");
	var ext = sparts[sparts.length - 1];
	
	var extensions = extlist.split(",");
	var n = extensions.length;
	
	for ( var i = 0; i < n; i++ ) {
		var cext = extensions[i];
		if ( cext == ext ) return(true);
	}
	
	alert(ss + " is not a zip file type.");
	
	obj = $("uploaderForm");
	obj.reset();

	return(false);
}

/////////////////////////////////////////////////////////

function MessageAndAttach_Sender(url_file) {
	////
	if ( !( checkFilledFields("message_subject","No subject entered.") ) ) return;
	if ( !( checkFilledFields("message_text","No message entered.") ) ) return;
	////
	var recip;
	g_message_recipients = "";
	var sep = "";
	for ( recip in groupListSelections ) {
		if ( groupListSelections[recip] ) {
			g_message_recipients += sep + recip;
			sep = ",";
		}
	}
	////
	if ( g_message_recipients.length == 0 ) {
		alert("No recipients selected.");
		return;
	}

	////
	var attach_obj = $("uploaderDisplay");
	var visattach = attach_obj.style.visibility;
	
	attach_obj = $("uploaderFile");
	var attachValue = attach_obj.value;

	if ( ( visattach == "hidden" ) || ( attachValue.length == 0 )  ) {
		sendToUrl("sendMailMessage");
	} else {
		//
		postID = "";

		special_ops_key = "mailmsgsender";
		special_ops[special_ops_key] = MessageSender;

		var keyobj = $("attachfilekey");
		var d = new Date();
		
		var attachfilekey = d.getTime();
		keyobj.value = attachfilekey;

		var fobj = $("uploaderForm");
		fobj.submit();
		// This does the upload without heavy programming.
		//			This makes it look like the upload was done with heavy programming.
		//
		
		var url = "uploadAttachment.php";

		var lpos = attachValue.lastIndexOf("/");
		if ( lpos == -1 ) {
			lpos = attachValue.lastIndexOf("\\");
		}
		if ( lpos > 0 ) {
			attachValue = attachValue.slice(lpos+1);
		}

		var parameters = "attachfilekey=" + attachfilekey;
		parameters += "&doupload=0";
		parameters += "&sess=" + g_classydex_session_id;
		parameters += "&uploaderFile=" + attachValue;
	//
		makePOSTRequest(url, parameters)
	}
	//
}



function addemail() {
	//
	var srcobj = $("newemail");
	var dstobj = $("emailEntryFormList");
	//
	var vv = dstobj.value;
	if ( vv.length > 0 ) {
		vv += "," + srcobj.value;
	} else {
		vv = srcobj.value;
	}
	//
	dstobj.value = vv;	
	$("emaillist").innerHTML = remove_returns(vv);
	//
	$("message_subject").focus();
}


function changeemail(chngstate) {

	if ( chngstate == 1 ) {
		var dstobj = $("emailEntryFormList");
		var vv = dstobj.value;
		$("emaillist").innerHTML = remove_returns(vv);
	}

	$("message_subject").focus();
}



function selectFriend(obj) {
	var x = obj.innerHTML;
	var c = x.charAt(0);
	if ( ( c == '+' ) || ( c == '-' ) ) {
		x = x.substr(2,x.length);
	}
	obj.innerHTML = x;

	var memberId = obj.innerHTML;
	if ( groupListSelections.hasOwnProperty(memberId) ) {
		var state = groupListSelections[memberId];
		if ( state ) {
			groupListSelections[memberId] = false;
			obj.style.backgroundColor = "transparent";
			obj.style.color = "black";
		} else {
			obj.style.backgroundColor = "#EFEFEF";
			obj.style.color = "purple";
			groupListSelections[memberId] = true;
		}
	} else {
		obj.style.backgroundColor = "#EFEFEF";
		obj.style.color = "purple";
		groupListSelections[memberId] = true;
	}
}




function selectEditFriend(obj,i) {
	var editField = $("member_name");
	editField.value = obj.innerHTML;
	currentFriendIndex = i;
}



function selectAllFriends() {
	//
	if ( g_current_group_object != null ) {
		////
		var friends_array = g_current_group_object.members;
	
		allFriendsSelected = true;
		//
		var n = friends_array.length;
		var i = 0;
		
		for ( i = 0; i < n; i++ ) {
			var tdID = "friendTo" + i;
			var obj = $(tdID);
			var memberId = obj.innerHTML;
			obj.style.backgroundColor = "#EFEFEF";
			obj.style.color = "purple"
			groupListSelections[memberId] = true;
		}
		
		var recip;
		for ( recip in groupListSelections ) {
			groupListSelections[recip] = true;
		}
		
		var obj = $("mailGroupListSpan");
		prevStyle = obj.style.border;
	//
	}
}

function selectNoneFriends() {
	//
	if ( g_current_group_object != null ) {
		////
		var friends_array = g_current_group_object.members;
	
		allFriendsSelected = false;
		//
		var n = friends_array.length;
		var i = 0;
		
		for ( i = 0; i < n; i++ ) {
			var tdID = "friendTo" + i;
			var obj = $(tdID);
			var memberId = obj.innerHTML;
			obj.style.backgroundColor = "transparent";
			obj.style.color = "black"
			groupListSelections[memberId] = false;
		}
		
	
		var recip;
		for ( recip in groupListSelections ) {
			groupListSelections[recip] = false;
		}
		
		var obj = $("mailGroupListSpan");
		prevStyle = obj.style.border;
	//
	}
}



var currentFriendIndex = -1;


function AddMember() {
	if ( g_current_group_object != null ) {
		////
		var friends_array = g_current_group_object.members;
		var editField = $("member_name");
		var targetTxt = editField.value;

		if ( targetTxt == "empty" ) return;

		var n = friends_array.length;
		for ( i = 0; i < n; i++ ) {
			txt = friends_array[i];
			if ( targetTxt == txt ) {
				alert( targetTxt + " is already a member.");
				return;
			}
			if ( txt == "empty" ) {
				friends_array[i] = targetTxt;
				break;
			}
		}

		if ( !(i < n) ) {
			friends_array.push(targetTxt);
		}
		updateGroupDisplay();

		var divname = "mailGroupEditorDiv";
		var divobj = $(divname);

		storeGroupEdit();
	}
}



function DeleteMember() {
	if ( g_current_group_object != null ) {
		////
		var friends_array = g_current_group_object.members;
		if ( currentFriendIndex >= 0 ) {
			friends_array.splice(currentFriendIndex,1);
			updateGroupDisplay();
			currentFriendIndex = -1;
		}
	}
}





function updateGroupDisplay() {
	generate_mailGroupEditorListSpan();
	generate_mailGroupListSpan();
}


function ChangeMember() {
	if ( g_current_group_object != null ) {
		////
		var friends_array = g_current_group_object.members;
		if ( currentFriendIndex >= 0 ) {
			var editField = $("member_name");
			var changedTxt = editField.value;
			if ( changedTxt.length > 0 ) {
				friends_array[currentFriendIndex] = changedTxt;
				updateGroupDisplay();
			}
		}
	}
}

function storeGroupEdit() {
	if ( g_current_group_object != null ) {
		////
		var friends_array = g_current_group_object.members;
		var n = friends_array.length;
		var i;
		var frlist = "";
		for ( i = 0; i < n; i++ ) {
			frlist += friends_array[i];
			if ( i < (n-1) ) frlist += ",";
		}

		spanID = "statusMsg";
		var obj = $("statusMsg");
		obj.innerHTML = "Storing group Edit";

		var urlNparameters = "putGroup.php";
		urlNparameters += "?sess=" + g_classydex_session_id + "&mailgroup=" + g_current_group_object.index;
		urlNparameters += "&memberlist=" + frlist;
		//
		makeDocRequest(urlNparameters);

		var divname = "mailGroupEditorDiv";
		divobj = $(divname);
		divobj.style.visibility = "hidden";
		
		if ( g_current_group_object.index != 1 ) {
			currentFriendIndex = 10;
			memberToGroup("Everyone");
			currentFriendIndex = -1;
		}
	}
}

//=======================================


var g_current_selected_msgSource = "M";
var g_current_selected_msgAttach = "NONE";
var g_current_selected_message = -1;
var g_current_selected_msg_sender = "";
var g_current_selected_msg_sender_id = "";
var g_current_selected_subject = "";


var g_current_selected_sent_msgSource = "M";
var g_current_selected_sent_msgAttach = "NONE";
var g_current_selected_sent_message = -1;
var g_current_selected_sent_msg_sender = "";
var g_current_selected_sent_msg_sender_id = "";
var g_current_selected_sent_subject = "";


var g_current_selected_Deleted_msgSource = "M";
var g_current_selected_Deleted_msgAttach = "NONE";
var g_current_selected_Deleted_message = -1;
var g_current_selected_Deleted_msg_sender = "";
var g_current_selected_Deleted_msg_sender_id = "";
var g_current_selected_Deleted_subject = "";




function find_index_in_array(an_array,int_val) {

	var n = an_array.length;
	for ( var i = 0; i < n; i++ ) {
		if ( an_array[i] == int_val ) return(i);
	}
	return(-1);
}




function selectMessages(objsource,i) {
/*
{ tag: '$messageTag', time: decodeURI('$messageTime'), attachment: '$attachment', sender_name: '$username', sender_id: $senderID, subject: decodeURI($messageSubject) }
*/
	if ( g_current_group_object != null ) {
		var subjectlines = g_current_group_object.in_mail_ids;
		var msgobj = g_current_group_object.mail_in_descr[i];
		////
		//
		var obj = $("mailGroupReaderSenderSpan");
		obj.innerHTML = msgobj.sender_name;
		g_current_selected_msg_sender = msgobj.sender_name;
	
		////
		obj = $("mailGroupReaderDateSpan");
		obj.innerHTML = msgobj.time;
	
		g_current_selected_msg_sender_id = msgobj.sender_id;
	
		////
		obj = $("mailGroupReaderSubjectSpan");
		obj.innerHTML = msgobj.subject;

		clear_message_selection(0);
		g_current_selected_subject = obj.innerHTML;
		
		///////////////////////////////
		obj = $("mailGroupReaderAttachmentSpan");
	
	
		////
		var m_attach = msgobj.attachment;
		
		var pp = m_attach.indexOf("NONE");
		if ( pp >= 0 ) {
			m_attach = m_attach.substr(pp,4);
		}
	
		if ( m_attach != "NONE" ) {
			var href =  decodeURI(m_attach);
			var fname = href.slice(href.lastIndexOf("/"));
			//
			var attachAnchor = 'Attachment Included: <a class="attachClass" href="';
			attachAnchor += href;
			attachAnchor += '" title="';
			attachAnchor += href;
			attachAnchor += '" >';
			attachAnchor += fname;
			attachAnchor += '</a>';
			////
			obj.innerHTML = attachAnchor;
		} else {
			obj.innerHTML = "";
		}
	
		///////////////////////////////
		
		var msgID = subjectlines[i];
		g_current_selected_message = msgID;
		
		spanID = "mailGroupReaderMessageSpan";
		var nowtime = g_date_holder.getTime();
		var urlNparameters = "getMessageBody.php";
		urlNparameters += "?sess=" + g_classydex_session_id + "&MID=" + g_current_selected_message + "&when=" + nowtime;

		makeDocRequest(urlNparameters);
	}
}



function selectSentMessages(objsource,i) {
/*
{ tag: '$messageTag', time: decodeURI('$messageTime'), attachment: '$attachment', users: [$username_list], user_ids: [$recipients], subject: decodeURI($messageSubject) }
*/
	if ( g_current_group_object != null ) {
		//
		var sent_subjectlines = g_current_group_object.out_mail_ids;
		var msgobj = g_current_group_object.mail_out_descr[i];
		////
		//
		var obj = $("sent_mailGroupReaderReceiversSpan");
		obj.innerHTML = msgobj.users;
		g_current_selected_sent_msg_sender = msgobj.sender_name;
		////
		obj = $("sent_mailGroupReaderDateSpan");
		obj.innerHTML = msgobj.time;
	
		g_current_selected_sent_msg_sender_id = msgobj.sender_id;
		////
		obj = $("sent_mailGroupReaderSubjectSpan");
		obj.innerHTML = msgobj.subject;
	
		clear_message_selection(1);
		g_current_selected_sent_subject = obj.innerHTML;
		///////////////////////////////
		obj = $("sent_mailGroupReaderAttachmentSpan");
		////
		var m_attach = msgobj.attachment;
		
		var pp = m_attach.indexOf("NONE");
		if ( pp >= 0 ) {
			m_attach = m_attach.substr(pp,4);
		}
	
		if ( m_attach != "NONE" ) {
			var href =  decodeURI(m_attach);
			var fname = href.slice(href.lastIndexOf("/"));
			//
			var attachAnchor = 'Attachment Included: <a class="attachClass" href="';
			attachAnchor += href;
			attachAnchor += '" title="';
			attachAnchor += href;
			attachAnchor += '" >';
			attachAnchor += fname;
			attachAnchor += '</a>';
			////
			obj.innerHTML = attachAnchor;
		} else {
			obj.innerHTML = "";
		}
	
		///////////////////////////////
		var msgID = sent_subjectlines[i];
		g_current_selected_sent_message = msgID;
		
		spanID = "sent_mailGroupReaderMessageSpan";
		var nowtime = g_date_holder.getTime();
		var urlNparameters = "getMessageBody.php";
		urlNparameters += "?sess=" + g_classydex_session_id + "&MID=" + g_current_selected_sent_message + "&when=" + nowtime;

		makeDocRequest(urlNparameters);
	}
}




function selectDeleteMessages(objsource,i) {
/*
{ tag: '$messageTag', time: decodeURI('$messageTime'), attachment: '$attachment', users: [$username_list], user_ids: [$recipients], subject: decodeURI($messageSubject) }
*/
	if ( g_current_group_object != null ) {
		//
		var Deleted_subjectlines = g_current_group_object.deleted_mail_ids;
		var msgobj = g_current_group_object.mail_deleted_descr[i];
		////
		//
		var obj = $("Deleted_mailGroupReaderReceiversSpan");
		obj.innerHTML = msgobj.users;
		g_current_selected_Deleted_msg_sender = msgobj.sender_name;
		////
		obj = $("Deleted_mailGroupReaderDateSpan");
		obj.innerHTML = msgobj.time;
	
		clear_message_selection(1);
		g_current_selected_Deleted_msg_sender_id = msgobj.sender_id;
		////
		obj = $("Deleted_mailGroupReaderSubjectSpan");
		obj.innerHTML = msgobj.subject;
	
		g_current_selected_Deleted_subject = obj.innerHTML;
		///////////////////////////////
		obj = $("Deleted_mailGroupReaderAttachmentSpan");
		////
		var m_attach = msgobj.attachment;

		var pp = m_attach.indexOf("NONE");
		if ( pp >= 0 ) {
			m_attach = m_attach.substr(pp,4);
		}
	
		if ( m_attach != "NONE" ) {
			var href =  decodeURI(m_attach);
			var fname = href.slice(href.lastIndexOf("/"));
			//
			var attachAnchor = 'Attachment Included: <a class="attachClass" href="';
			attachAnchor += href;
			attachAnchor += '" title="';
			attachAnchor += href;
			attachAnchor += '" >';
			attachAnchor += fname;
			attachAnchor += '</a>';
			////
			obj.innerHTML = attachAnchor;
		} else {
			obj.innerHTML = "";
		}
	
		///////////////////////////////
		var msgID = Deleted_subjectlines[i];
		g_current_selected_Deleted_message = msgID;

		spanID = "Deleted_mailGroupReaderMessageSpan";
		var nowtime = g_date_holder.getTime();
		var urlNparameters = "getMessageBody.php";
		urlNparameters += "?sess=" + g_classydex_session_id + "&MID=" + g_current_selected_Deleted_message + "&when=" + nowtime;

		makeDocRequest(urlNparameters);
	}
}









function killMessage() {
	var urlNparameters = "deleteMessage.php";
	var group = g_current_group_object;
	urlNparameters += "?sess=" + g_classydex_session_id + "&MID=" + g_current_selected_message + "&mailgroup=" + group.name;

	g_allow_groupLabel = false;
	deletingMessageState = true;

	spanID = "statusMsg";
	makeDocRequest(urlNparameters);	
}


function killSentMessage() {
	var urlNparameters = "deleteSentMessage.php";
	urlNparameters += "?sess=" + g_classydex_session_id + "&MID=" + g_current_selected_sent_message;

	g_allow_groupLabel = false;
	deletingMessageState = true;

	spanID = "statusMsg";

	var group = g_current_group_object;
	group.out_mail_ids = null;
	group.mail_out_descr = null;
	special_ops_key = "update_sent_messages";
	special_ops[special_ops_key] = fetch_group_cascade;

	makeDocRequest(urlNparameters);
}



/// ==============================

function line_breaks(output) {
	while ( output.indexOf("<br") > -1 ) {
		output = output.replace("<br>","\n");
	}
	return(output);
}

/// ==============================

var g_mtype = 0;

function clear_message_selection(mtype) {
	g_mtype = mtype;
	if ( mtype != 0 ) g_current_selected_subject = "";
	if ( mtype != 1 ) g_current_selected_sent_subject = "";
	if ( mtype != 2 ) g_current_selected_Deleted_subject = "";
}

function message_copy_subject() {
	if ( g_mtype == 0 ) return(g_current_selected_subject);
	if ( g_mtype == 1 ) return(g_current_selected_sent_subject);
	if ( g_mtype == 2 ) return(g_current_selected_Deleted_subject);
}

function message_copy_body() {
	var m_src_id = "mailGroupReaderMessageSpan";
	if ( g_mtype == 1 ) m_src_id = "sent_mailGroupReaderMessageSpan";
	else if ( g_mtype == 2 ) m_src_id = "Deleted_mailGroupReaderMessageSpan";

	var obj = $(m_src_id);
	var output = obj.innerHTML;
	output = line_breaks(output);

	return(output);
}


function messageToGroup(targetName) {

	if ( ( g_current_selected_subject.length == 0 ) && ( g_current_selected_sent_subject.length == 0 ) && ( g_current_selected_Deleted_subject.length == 0 ) ) {
		alert("No message selectd");
		return;
	}

	var sendSubject = message_copy_subject();
	var messageBody = message_copy_body();

	/// Write the current e-mail being read into the e-mail editor view...
	obj = $("message_text");
	obj.value = messageBody;
	
	obj = $("message_subject");
	obj.value = sendSubject;

	spanID = "statusMsg";  // Get the group the message is supposed to go to. So that clicking send makes sense...
	targetName = targetName.substring(4);
	targetName = targetName.substring(0,targetName.indexOf("&gt;"));
	set_current_group(targetName);

}


function memberToGroup(targetName) {
	//
	if ( currentFriendIndex > -1 ) {

		var editField = $("member_name");
		var memname = editField.value;

		spanID = "statusMsg";


		targetName = targetName.substring(4);
		targetName = targetName.substring(0,targetName.indexOf("&gt;"));
		var gnum = find_group_number(targetName);

		var urlNparameters = "addToGroup.php";
		urlNparameters += "?sess=" + g_classydex_session_id + "&mailgroup=" + gnum;
		urlNparameters += "&member=" + memname;
		urlNparameters += "&grouplabel=" + targetName;
		//
		makeDocRequest(urlNparameters);

	} else {
		alert("No member has been selected.");
	} 
}





///////////   FILE ATTATCH....

function fileAttachUploading() {
	var obj = $("uploaderDisplay");
	var vstate = obj.style.visibility;
	
	var controller = $("zipattachControl");
	
	if ( vstate != "visible" ) {
		obj.style.visibility = "visible";
		controller.innerHTML = "Don't Attach";
		controller.style.border = "orange 2px solid";
	} else {
		obj.style.visibility = "hidden";
		controller.innerHTML = "Attach Zip File";
		controller.style.border =  "darkgreen 2px solid";
		g_attachment = "";
	}
}


function closeUploading() {
	var obj = $("uploaderDisplay");
	obj.style.visibility = "hidden";
	var controller = $("zipattachControl");
	controller.innerHTML = "Attach Zip File";
	controller.style.border =  "darkgreen 2px solid";
	g_attachment = "";  // Assume the same attachment will not be sent.
}


/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////

//// RENDERING

function generate_mailGroupReaderSpan() {
	var n;
	var i;
	var spanTxt = "";
	
	if ( g_current_group_object  != null ) {
		spanTxt += '<table  width="100%" cellspacing="1" cellpadding="0" border="0" >\n';

		var subjectlines = g_current_group_object.in_mail_ids;
		var message_subject_array = g_current_group_object.mail_in_descr;

		i = 0;
		n = subjectlines.length;
		for ( i = 0; i < n; i++ ) {
			spanTxt += '<tr>';
			spanTxt += '<td style="cursor:pointer;padding-left:16;border:2px solid lightblue;" onmouseOver="rollover(this);" onmouseOut="rollout(this);" onClick="selectMessages(this,';
			spanTxt += i;
			spanTxt += ');">';
		//
/*
{ tag: '$messageTag', time: decodeURI('$messageTime'), attachment: '$attachment', sender_name: '$username', sender_id: $senderID, subject: decodeURI($messageSubject) }
*/
		//
			var msgobj = message_subject_array[i];
			spanTxt += msgobj.tag + "|" + msgobj.time + "|" + msgobj.sender_name + "|" + msgobj.subject;
			spanTxt += '</td></tr>\n';
	
		}
		spanTxt += '</table>';
	
		var obj = $('mailGroupReaderMsgsSpan');
		obj.innerHTML = spanTxt;
	}
}



function generate_sent_mailGroupReaderSpan() {
	var n;
	var i;
	var spanTxt = "";


	if ( g_current_group_object  != null ) {
		var subjectlines = g_current_group_object.out_mail_ids;
		var message_subject_array = g_current_group_object.mail_out_descr;

		
		spanTxt += '<table  width="100%" cellspacing="1" cellpadding="0" border="0" >\n';
		
		i = 0;
		n = subjectlines.length;
		for ( i = 0; i < n; i++ ) {
			spanTxt += '<tr>';
			spanTxt += '<td style="cursor:pointer;padding-left:16;border:2px solid lightblue;" onmouseOver="rollover(this);" onmouseOut="rollout(this);" onClick="selectSentMessages(this,';
			spanTxt += i;
			spanTxt += ');">';
		//
/*
{ tag: '$messageTag', time: decodeURI('$messageTime'), attachment: '$attachment', users: [$username_list], user_ids: [$recipients], subject: decodeURI($messageSubject) }
*/
		//
			var msgobj = message_subject_array[i];
			spanTxt += msgobj.tag + "|" + msgobj.time + "|" + msgobj.subject;
			spanTxt += '</td></tr>\n';
		}
		spanTxt += '</table>';
	
		var obj = $('mailGroupReaderSentMsgsSpan');
		obj.innerHTML = spanTxt;
	}
}




function generate_delete_mailGroupReaderSpan() {
	var n;
	var i;
	var spanTxt = "";


	if ( g_current_group_object  != null ) {
		var subjectlines = g_current_group_object.deleted_mail_ids;
		var message_subject_array = g_current_group_object.mail_deleted_descr;

		
		spanTxt += '<table  width="100%" cellspacing="1" cellpadding="0" border="0" >\n';
		
		i = 0;
		n = subjectlines.length;
		for ( i = 0; i < n; i++ ) {
			spanTxt += '<tr>';
			spanTxt += '<td style="cursor:pointer;padding-left:16;border:2px solid lightblue;" onmouseOver="rollover(this);" onmouseOut="rollout(this);" onClick="selectDeleteMessages(this,';
			spanTxt += i;
			spanTxt += ');">';
		//
/*
{ tag: '$messageTag', time: decodeURI('$messageTime'), attachment: '$attachment', users: [$username_list], user_ids: [$recipients], subject: decodeURI($messageSubject) }
*/
		//
			var msgobj = message_subject_array[i];
			spanTxt += msgobj.tag + "|" + msgobj.time + "|" + msgobj.subject;
			spanTxt += '</td></tr>\n';
		}
		spanTxt += '</table>';
	
		var obj = $('mailGroupReaderDeletedMsgsSpan');
		obj.innerHTML = spanTxt;
	}
}



function generate_mailGroupEditorListSpan() {
	if ( g_current_group_object != null ) {
		var friends_array = g_current_group_object.members;
		var n = friends_array.length;
		var i;
		var spanTxt = "";
		
		spanTxt += '<table  width="100%" cellspacing="1" cellpadding="0" border="0" >\n';
		for ( i = 0; i < n; i++ ) {
			spanTxt += '<tr>';
			spanTxt += '<td style="cursor:pointer;padding-left:16;border:2px solid lightblue;" onmouseOver="rollover(this);" onmouseOut="rollout(this);" onClick="selectEditFriend(this,';
			spanTxt += i;
			spanTxt += ');">';
			spanTxt += friends_array[i];
			spanTxt += '</td></tr>\n';
		}
		spanTxt += '</table>';
		
		var obj = $("mailGroupEditorListSpan");
		obj.innerHTML = spanTxt;
	}
}


function generate_mailGroupListSpan() {	
	if ( g_current_group_object != null ) {
		var friends_array = g_current_group_object.members;
		var n = friends_array.length;
		var i;
		var spanTxt = "";
		
		spanTxt += '<table  width="100%" cellspacing="1" cellpadding="0" border="0" style="min-width:100%" >\n';
		for ( i = 0; i < n; i++ ) {
			spanTxt += '<tr>';
			spanTxt += '<td id="' + "friendTo" + i;
			spanTxt += '" style="cursor:pointer;padding-left:16;border:2px solid lightblue;color:black;nowrap;" onmouseOver="msgsend_rollover(this);" onmouseOut="msgsend_rollout(this);" onClick="selectFriend(this,';
			spanTxt += i;
			spanTxt += ');">';
			spanTxt += friends_array[i];
			spanTxt += '</td></tr>\n';
		}
		spanTxt += '</table>';
		
		var obj = $("mailGroupListSpan");
		obj.innerHTML = spanTxt;
	}
}



/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////




function fetch_received_group_mail(group) {
	var nowtime = g_date_holder.getTime();
	var group_label = group.name;
	var urlNparameters = "fetchMessages.php?sess=" + g_classydex_session_id + "&grouplabel=" + group_label + "&when=" + nowtime;
	makeDocEvalRequest(urlNparameters);
}



function fetch_sent_group_mail(group) {
	var nowtime = g_date_holder.getTime();
	var  group_label = group.name;
	var urlNparameters = "fetchSentMessages.php?sess=" + g_classydex_session_id + "&grouplabel=" + group_label + "&when=" + nowtime;
	makeDocEvalRequest(urlNparameters);
}


function fetch_deleted_group_mail() {
	var group = g_current_group_object;
	var nowtime = g_date_holder.getTime();
	var  group_label = group.name;
	var urlNparameters = "fetchDeletedMessages.php?sess=" + g_classydex_session_id + "&grouplabel=" + group_label + "&when=" + nowtime;
	makeDocEvalRequest(urlNparameters);
}



function fetch_mail_group(group) {
	var nowtime = g_date_holder.getTime();
	var group_num = group.index;
	var urlNparameters = "fetchGroup.php?sess=" + g_classydex_session_id + "&mailgroup=" + group_num + "&when=" + nowtime;
	makeDocEvalRequest(urlNparameters);
}



function getPOP3Messages() {
	//
	alert("This feature is currently blocked at this time. It will be available after we do some testing.");
	return;
	//
	var group = g_current_group_object;
	group.in_mail_ids = null;
	group.mail_in_descr = null;
	special_ops_key = "pop3mailmessages";
	special_ops[special_ops_key] = fetch_group_cascade;
	//
	var nowtime = g_date_holder.getTime();
	var urlNparameters = "fetchPOP3EMail.php?sess=" + g_classydex_session_id + "&when=" + nowtime;
	makeDocEvalRequest(urlNparameters);
}


function sendMessagesToZipFile() {
	//
	alert("This feature is currently blocked at this time. It will be available after we do some testing.");
	return;
	//
	var group = g_current_group_object;
	var urlNparameters = "bundleMessagesToZip.php?sess=" + g_classydex_session_id + "&mailgroup=" + group.index + "&when=" + nowtime;
	spanID = "statusMsg";
	makeDocRequest(urlNparameters);
}



function blockMember() {
	//
	var member = g_current_selected_msg_sender_id;
	//
	spanID = "statusMsg";
	//
	var group = g_current_group_object;
	var urlNparameters = "blockMember.php";
	urlNparameters += "?sess=" + g_classydex_session_id + "&mailgroup=" + group.name + "&wbc="  + member + "&when=" + nowtime;
	makeDocRequest(urlNparameters);

	currentFriendIndex = find_index_in_array(group.member_ids,member);
	DeleteMember();
}


/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////





function display_array(aa) {
	var n = aa.length;
alert(n);
	var ss = "";
	var sep = "";
	for ( var i = 0; i < n; i++ ) {
		ss += sep + aa[i]; sep = "\n";
	}
alert(aa)
}

function display_arrays(m1,m2) {
	display_array(m1);
	display_array(m2);
}

/////////////////////////////////////////////////////////////////


var g_group_array = [];

function group_representation(gname) {
	this.name = gname;
	this.members = null;
	this.member_ids = null;
	this.mail_in_descr = null;
	this.in_mail_ids = null;
	this.mail_out_descr = null;
	this.out_mail_ids = null;
	this.mail_deleted_descr = null;
	this.deleted_mail_ids = null;
	this.index = 0;
}



function add_group_to_db(group) {
	save_groups();
}


function fetch_group_cascade() {
	var group = g_current_group_object;
	if ( group != null ) {
		if ( ( group.mail_in_descr == null ) || ( group.mail_in_descr.length == 0 ) ) {
			fetch_received_group_mail(group);
		} else if  ( ( group.mail_out_descr == null ) || ( group.mail_out_descr.length == 0 ) ) {
			fetch_sent_group_mail(group);
		} else if ( ( group.members == null ) || ( group.members.length == 0 ) ) {
			fetch_mail_group(group);
		}
	}
}

function fetch_group_data_from_db(group) {
	if ( group == null ) return;
	////
	g_current_group_object = group;
	////
	if ( ( group.mail_in_descr != null ) && ( group.mail_in_descr.length > 0 ) ) {
		generate_mailGroupReaderSpan();
	} else {
		fetch_group_cascade();
	}
	if  ( ( group.mail_out_descr != null ) && ( group.mail_out_descr.length > 0 ) ) {
		generate_sent_mailGroupReaderSpan();
	} else {
		fetch_group_cascade();
	}
	if ( ( group.members != null ) && ( group.members.length > 0 ) ) {
		updateGroupDisplay();
	} else {
		fetch_group_cascade();
	}

}


function save_groups() {
	var groupUpdateURL = "groupUpdate.php?sess=" + g_classydex_session_id + "&recordID=" + g_group_rec_id;
	var n = g_group_array.length;
	for ( var i = 2; i <= n; i++ ) {
		var group = g_group_array[i-1];
		groupUpdateURL += "&group" + i + "=" + group.name;
	}
	spanID = "statusMsg";

	makeDocRequest(groupUpdateURL);
}


/////////////////////////////////////////////////////////////////



function add_group_to_array(gname,ii) {
	var group = new group_representation(gname);
	g_group_array[ii-1] = group;
	group.index = ii;
	return(group);
}


function group_name(indx) {
	var group_obj = g_group_array[indx-1];
	return(group_obj.name);
}


function find_group_in_array(gname) {
	var n = g_group_array.length;
	for ( var i = 0; i < n; i++ ) {
		var group = g_group_array[i];
		if ( group.name == gname ) {
			group.index = (i+1);
			return(group);
		}
	}
	return(g_group_array[0]);
}


function find_group_number(gname) {
	var group = find_group_in_array(gname);
	return(group.index);
}


var g_application_group_menu_count = 7;

function set_menu_group(indx) {
	var groupname = group_name(indx);

	for ( var i = 0; i < g_application_group_menu_count; i++ ) {
		var spanid = "mail_menu_span_" + (i+1);
		var obj = $(spanid);
		if ( obj.value ) {
			obj.value = indx;
		} else {
			obj.innerHTML = groupname;
		}
	}

}


function add_group(gname,ii) {
	var group = add_group_to_array(gname,ii);
	add_group_to_db(group,ii);
}


function set_current_group(gname) {
	var group = find_group_in_array(gname);
	var indx = group.index;
	set_menu_group(indx);
	fetch_group_data_from_db(group);
}



function group_action(objsrc,ii) {
	var abc = objsrc.innerHTML;

	if ( abc.indexOf("¤") > 0 ) {
		if ( confirm("Would you like to name this group?") ) {
			var tmp = prompt("Enter a name for this group");
			if ( tmp != null ) {
				alert("Creating group: " + tmp);
				objsrc.innerHTML = "&lt;" + tmp + "&gt;";
				add_group(tmp,ii);
				set_current_group(tmp);
			} else alert("Operation Cancled");
		}
	} else {
		$("spCurrentGroup").innerHTML = abc;
		abc = abc.substring(4);
		abc = abc.substring(0,abc.indexOf("&gt;"));
		set_current_group(abc);
	}

}

function init_status_reporting() {
	special_ops_key = "mailstatus";
	special_ops[special_ops_key] = animate_report;
}



function message_eraser() {
	var ans = confirm("Erasing All Messages Marked for Deletion.");
	if ( ans ) {
		spanID = "statusMsg";
		var group = g_current_group_object;
		var nowtime = g_date_holder.getTime();
		var urlNparameters = "deleteMarkedMessages.php?sess=" + g_classydex_session_id  + "&grouplabel=" + group.name + "&when=" + nowtime;
		makeDocRequest(urlNparameters);
	}
}



function obj_change_group_name(prevobj,newobj) {

	var prevname = prevobj.innerHTML;
	if ( prevname == "Everyone" ) {
		alert("You cannot change the name of group 'Everyone'");
	} else {
		var newname = newobj.value;
		if ( newname.length  > 0 ) {
			var ans = confirm("Change group name " + prevname + " to " + newname + "?");
			storeGroupEdit();
		} else {
			alert("Please supply a value.");
		}
	}
}



var g_content_rw_state = "R";

var g_ct_access_list = {};


function object_from_array(arkeys,ival) {
	var obj = new Object();
	var n = arkeys.length;
	for ( i = 0; i < n; i++ ) {
		obj[arkeys[i]] = ival;
	}

	return(obj);
}

var g_ct_access_vocname = "";
var g_ct_access_voc_id = 0;
function access_limit_tree_selections(container,aclist,RW) {
	if ( aclist != null ) {
		g_ct_access_list[container] = object_from_array(aclist.split(","),RW);
	} else {
		g_ct_access_list[container] = null;
	}

 	pick_vocabulary(g_ct_access_vocname,g_ct_access_voc_id,container);
}

function filtered_taxo_pick(vocname,vocid,container,RW) {
//
	g_ct_access_vocname = vocname;
	g_ct_access_voc_id = vocid;

	var provider = role_ops + "accesslimits.php?sess=" + g_classydex_session_id + "&serviceid=" + g_s_i;
	provider += "&vid=" + vocid;
	provider += "&RW=" + RW;
	provider += "&container=" + container;
	provider += "&accounttype=" + g_account_type;

	makeDocEvalRequest( provider );
}


function promote_current_group() {
	var provider = role_ops + "account_info.php?sess=" + g_classydex_session_id + "&serviceid=" + g_s_i;
	makeDocEvalRequest(provider);
}





