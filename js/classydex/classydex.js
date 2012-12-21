

function replace_returns(msgtxt) {
	var jtxt = msgtxt;
	
	while ( jtxt == msgtxt ) {
		jtxt = msgtxt.replace("\n","<br>");
		if ( jtxt != msgtxt ) msgtxt = jtxt;
		else return(jtxt);
	}
	//
	
	return(jtxt);
}

function remove_returns(msgtxt) {
	var jtxt = msgtxt;
	
	while ( jtxt == msgtxt ) {
		jtxt = msgtxt.replace("\n","");
		if ( jtxt != msgtxt ) msgtxt = jtxt;
		else return(jtxt);
	}
	//
	
	return(jtxt);
}




function remove_spaces(str) {
	var ostr = "";
	var sp = ' ';
	var n = str.length;
	for ( var i = 0; i < n; i++ ) {
		var c = str.charAt(i);
		if ( sp == c ) continue;
		ostr += c;
	}
	return(ostr);
}

function tabtrim(str) {
	var ostr = "";
	var sp = '\t';
	var n = str.length;
	for ( var i = 0; i < n; i++ ) {
		var c = str.charAt(i);
		if ( sp == c ) continue;
		ostr += c;
	}
	return(ostr);
}

var g_space_rg = new RegExp('[\n\t ]+','g');
function strim(str) {
	var ostr = "";

	str = str.replace(g_space_rg,' ');
	var oarray = str.split(" ");
	var n = oarray.length;
	sep = "";
	for ( var i = 0; i < n; i++ ) {
		if ( oarray[i] == ' ' ) continue;
		if ( oarray[i].length == 0 ) continue;
		ostr += sep + oarray[i];
		sep = " ";
	}

	return(ostr);	
}


var timerspan = "timestr";
var datespan = "datestr";

var saveHTML = "";
var storeduseraction = "";

////////////////////////////////////////////

var last_server_parameter = "";
var dateforIE = new Date();


function in_array(arrayvar,sect) {
	for ( var i = 0; i < arrayvar.length; i++ ) {
		if ( arrayvar[i] == sect ) {
			return(true);
		}
	}
	return(false);
}

////////////////////////////////////////////

var g_extra_task = false;

function local_update_clock() {
	//
	var D = new Date();
	
	var Dstr = D.toLocaleDateString();
	var Tstr = D.toLocaleTimeString();
	
	var obj =null;
	
	obj = $(timerspan);
	obj.innerHTML = Tstr;
	//
	obj = $(datespan);
	obj.innerHTML = Dstr;
	if ( g_extra_task ) {
		g_extra_task = false;
	}
}



// Wait for an index... 
// Start requesting service when the clock updates...
function start_waiting_index() {
	g_extra_task = true;
}


function sendClassifiedsCommand(alink) {
	var dexhost = gHostbase + "classydex";

	var alink = "http://" + dexhost + alink;
	alink += "&seq=" + dateforIE.getTime();
	makeDocRequest( alink );
}



function getPosterForm() {
	var call_locus = admin_locus;

	if ( last_server_parameter.length > 0 ) {
		//
		saveHTML = $("docpages").innerHTML;
		//
		call_locus += 'postad';
		call_locus += "&section=";
		call_locus += last_server_parameter;

		sendClassifiedsCommand(call_locus);
		//
	}

}


function retrieve_classified_index(sectionnums) {

	try {
		var dexhost = gHostbase + "classydex";
		var alink = server_locus + sectionnums + "&startNumber=0";

		spanID = "searchResults";

		sendClassifiedsCommand( alink );
		//// store_section( sectionnum );  Has to do with prev and next...
	} catch ( e ) {
		alert(e.message);
	}

}



function searchentry(nn) { 
	////
	var obj = $("classisearchterm");
	var searchterm = obj.value;
			////

	var slen = searchterm.length;

	if ( slen > 0 ) {
		//
		var call_locus = focus_locus;
		storeduseraction = "focus";


		if ( last_server_parameter.length > 0 ) {
			//
			saveHTML = $("docpages").innerHTML;
			//
			call_locus += last_server_parameter;
			call_locus += "&searchterm=";
			call_locus += searchterm;
			call_locus += "&startNumber=" + nn;

			sendClassifiedsCommand(call_locus);
			//
		} else {
			alert("No section selected");
		}
		//
	}

}



function save_poster_section(sect) {
	last_server_parameter = sect;
}



var salvage_server_param_for_nextprev = "";

function clear_server_parameters() {
	last_server_parameter = "";
}



var remember_start = 0;
var section_selection = false;



function store_section(serverparams) {
	last_server_parameter = serverparams;
	remember_start = 0;
	section_selection = true;
	salvage_server_param_for_nextprev = last_server_parameter;
	storeduseraction = "selection";
}


var special_ops = {};
var special_ops_key = "";

function secondary_http_request_response(whichspan,result) {
	spanID = save_responder_element;

	if ( whichspan == "singleItemEntrySpan" ) {
		var spanobj = $("singleItemEntrySpan");


		if ( spanobj.innerHTML.length > 0 ) {

			var posobj = INFOGROUP.topic1_5W.wind.div;
			var tl = OAT.Dom.position(posobj);
			var wh = OAT.Dom.getWH(posobj);

			var w = Math.floor(wh[0]/2);

			INFOGROUP.singleItemDetail.wind.div.style.top = (tl[1] + 16) + "px";
			INFOGROUP.singleItemDetail.wind.div.style.left = (tl[0] + 16) + "px";
			////
			INFOGROUP.singleItemDetail.wind.div.style.width = w + "px";
			INFOGROUP.singleItemDetail.wind.move.style.width = w + "px";
			$("singleItemEntry").style.width = w + "px";
			spanobj.style.width = w + "px";
			INFOGROUP.singleItemDetail.wind.content.style.width = (w - 30) + "px";
			////
			INFOGROUP.singleItemDetail.wind.div.style.height = (wh[1] - 5) + "px";
			INFOGROUP.singleItemDetail.wind.content.style.height = (wh[1] - 30) + "px";
			$("singleItemEntry").style.height = (wh[1] - 17) + "px";
			spanobj.style.height = (wh[1] - 19) + "px";
			spanobj.childNodes[1].style.height = (wh[1] - 20) + "px";


			INFOGROUP.singleItemDetail.wind.content.childNodes[0].className = "topicclass-viz";

			INFOGROUP.singleItemDetail.wind.div.style.zIndex = OAT.Dom.maxZ(INFOGROUP.topic1_5W.wind.div.style.zIndex);
			OAT.Dom.show(INFOGROUP.singleItemDetail.wind.div);
			OAT.Dom.show(INFOGROUP.singleItemDetail.wind.div.childNodes);
			OAT.Dom.show(spanobj);
			OAT.Dom.show($("singleItemEntry"));
			OAT.Dom.show(spanobj.childNodes[1]);
	//
		}
	} else if ( whichspan == "menutree_1" ) {
		tree_render(whichspan);
		menu_fetch_next();
	} else if ( whichspan == "menutree_2" ) {
		tree_render(whichspan);
	} else {
		if ( special_ops_key.length ) {
			var f = special_ops[special_ops_key];
			if ( f ) f(result);
			special_ops_key = "";
		}
	}


}



/////////////////////////////////////////////////////////////////////////////
// First form submit....
/////////////////////////////////////////////////////////////////////////////

function runPlacer() {
//
	var getstr = "?";

	var vname = "contact_number";
	var target_obj = $(vname);
	var vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("A phone number is required");
		return;
	}
	
	var shipping_data = "";
	vname = "shipping_origination_country";
	target_obj = $(vname);
	vdata = target_obj.value;
		
	if ( vdata.length == 0 ) {
		alert("Please enter a country.");
		return;
	}
	shipping_data += vdata + ",";
	
	vname = "shipping_origination_state";
	target_obj = $(vname);
	vdata = target_obj.value;
		
	if ( vdata.length == 0 ) {
		alert("Please enter a state or region abreviation.");
		return;
	}
	shipping_data += vdata + ",";
	
	vname = "shipping_origination_zcode";
	target_obj = $(vname);
	vdata = target_obj.value;
		
	if ( vdata.length == 0 ) {
		alert("A least a postal code is required.");
		return;
	}
	shipping_data += vdata;
	////
	///
	//
	getstr += "shipping_origination=" + shipping_data + "&";

	vname = "full_description";
	target_obj = $(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";

	vname = "add_title";
	target_obj = $(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("A title must be displayed");
		return;
	}

	vname = "brief_description";
	target_obj = $(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("Some description is required");
		return;
	}

	vname = "offered_price";
	target_obj = $(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("Put 0.00 if the price is for discussion and state that it is to be discussed in the description.");
		return;
	}

	vname = "email_address";
	target_obj = $(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata;
	
	if ( vdata.length == 0 ) {
		alert("The e-mail address is required for your identification and processing.");
		return;
	}
	

	var url = manager_locus + "placeadd.php" + getstr + "&section=" + last_server_parameter;
	
	sendClassifiedsCommand(url);

	return(true);
}



function runPlacerJobs() {
//
	var getstr = "";

	var vname = "contact_number";
	var target_obj = $(vname);
	var vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";

	if ( vdata.length == 0 ) {
		alert("A phone number is required");
		return;
	}

	vname = "member_agent";
	target_obj = $(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";

	var shipping_data = "";
	vname = "shipping_origination";
	target_obj = $(vname);
	vdata = encodeURI( target_obj.value );
		
	if ( vdata.length == 0 ) {
		alert("Please enter information about the job location.");
		return;
	}
	shipping_data += vdata + ",";

	///
	//
	getstr += "shipping_origination=" + shipping_data + "&";

	vname = "full_description";
	target_obj = $(vname);
	vdata = encodeURI( target_obj.value );
	getstr += vname + "=" + vdata + "&";

	vname = "add_title";
	target_obj = $(vname);
	vdata = encodeURI( target_obj.value );
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("A title must be displayed");
		return;
	}


	vname = "brief_description";
	target_obj = $(vname);
	vdata = encodeURI( target_obj.value );
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("Some description is required");
		return;
	}

	vname = "offered_price";
	target_obj = $(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("Put 0.00 if the price is for discussion and state that it is to be discussed in the description.");
		return;
	}

	vname = "email_address";
	target_obj = $(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata;
	
	if ( vdata.length == 0 ) {
		alert("The e-mail address is required for your identification and processing.");
		return;
	}

	var url = manager_locus + "jobs/jobs_placeadd.php";
	var parameters = getstr + "&section=" + last_server_parameter;

	//
	///
	makePOSTRequest(url, parameters);
	////
	return(true);
}





var saverefobj;
var saveClick_X = 0;
var saveClick_Y = 0;
var savedReportId = 0;

function showDetails(detailid,refobj,evt) {
	closeContact();
	//(evt,refobj,im_name)
	savedReportId = detailid;
	var alink = server_details_locus + detailid;
	saverefobj = refobj;
	//
	saveClick_X = evt.clientX;
	saveClick_Y = evt.clientY;
	//
	spanID = "singleItemEntrySpan";
	sendClassifiedsCommand(alink);
	//
}

function closeContact() {


}

function getMemberAgent() {
	var obj = $("agentMail");
	var txt = obj.value;
	if ( txt.length > 0 ) {
		agentSelectionResponse();
	} else {
		alert("Please enter an e-mail address for the agent.");
	}
}

function fetch_agent_setup() {
	var obj = $("agent_form");
	var amounttoggle = "";
	if ( obj.style.visibility == "visible" ) {
		obj.style.visibility = "hidden";
		amounttoggle = "$50.00";
		var agentobj = $("member_agent");
		agentobj.value = '';
	} else {
		obj.style.visibility = "visible";
		amounttoggle = "$40.00";
	}
	
	obj = $("alteramount");
	obj.innerHTML = amounttoggle;
}

function agentSelectionResponse() {

	var obj = $("agentMail");
	var txt = obj.value;

	var agentobj = $("member_agent");
	agentobj.value = txt;

	obj = $("agent_accessible");
	obj.style.visibility = "hidden";
	
}



function getMemberAgent() {
	var obj = $("agentMail");
	var txt = obj.value;
	if ( txt.length > 0 ) {
		agentSelectionResponse();
	} else {
		alert("Please enter an e-mail address for the agent.");
	}
}

function fetch_agent_setup() {
	var obj = $("agent_form");
	var amounttoggle = "";
	if ( obj.style.visibility == "visible" ) {
		obj.style.visibility = "hidden";
		amounttoggle = "$50.00";
		var agentobj = $("member_agent");
		agentobj.value = '';
	} else {
		obj.style.visibility = "visible";
		amounttoggle = "$40.00";
	}
	
	obj = $("alteramount");
	obj.innerHTML = amounttoggle;
}

function agentSelectionResponse() {

	var obj = $("agentMail");
	var txt = obj.value;

	var agentobj = $("member_agent");
	agentobj.value = txt;

	obj = $("agent_accessible");
	obj.style.visibility = "hidden";
	
}



////
function makeContact(detailid) {

	//
	//
	var spanobj = $("contactDiv");

	var posobj = INFOGROUP.topic1_5W.wind.div;
	var tl = OAT.Dom.position(posobj);
	var wh = OAT.Dom.getWH(posobj);

	var w = Math.floor(3*wh[0]/4);

	INFOGROUP.contactForm.wind.div.style.top = (tl[1] + 16) + "px";
	INFOGROUP.contactForm.wind.div.style.left = (tl[0] + 16) + "px";
	////
	INFOGROUP.contactForm.wind.div.style.width = w + "px";
	INFOGROUP.contactForm.wind.move.style.width = w + "px";
	spanobj.style.width = w + "px";
	INFOGROUP.contactForm.wind.content.style.width = (w - 30) + "px";
	////
	INFOGROUP.contactForm.wind.div.style.height = (300 - 5) + "px";
	INFOGROUP.contactForm.wind.content.style.height = (300 - 30) + "px";
	spanobj.style.height = (300 - 19) + "px";
	spanobj.childNodes[1].style.height = (190) + "px";


	INFOGROUP.contactForm.wind.content.childNodes[0].className = "topicclass-viz";

	INFOGROUP.contactForm.wind.div.style.zIndex = OAT.Dom.maxZ(INFOGROUP.topic1_5W.wind.div.style.zIndex);
	OAT.Dom.show(INFOGROUP.contactForm.wind.div);
	OAT.Dom.show(INFOGROUP.contactForm.wind.div.childNodes);
	OAT.Dom.show(spanobj);
	OAT.Dom.show(spanobj.childNodes[1]);
	//
}

function sendClassiContact() {
//
	var getstr = "?";
	
	getstr += "reportid=" + savedReportId + "&";
	
	var vname = "contact_number2";
	var target_obj = $(vname);
	var vdata = target_obj.value;
	getstr += "sender_phone=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("A phone number is required");
		return;
	}

	vname = "contact_comments";
	target_obj = $(vname);
	vdata = target_obj.value;
	getstr += "sender_message=" + vdata + "&";
		
	if ( vdata.length == 0 ) {
		alert("There is no message.");
		return;
	}

	vname = "contact_email_address";
	target_obj = $(vname);
	vdata = target_obj.value;
	getstr += "sender_email=" + vdata + "&";

	if ( vdata.length == 0 ) {
		alert("An email is required.");
		return;
	}

	var url = manager_locus + "adresponse.php" + getstr + last_server_parameter;
	//
	closeContact();
	sendClassifiedsCommand(url);
}

/*
//
*/

function content_rendering_data(dataobj) {

	var txt = decodeURIComponent(dataobj.js);

	clear_late_components();

	eval(txt);

	txt = decodeURIComponent(dataobj.xsource);
	$(spanID).innerHTML = txt;

	var filelist = decodeURIComponent(dataobj.js_files);

	filelist = eval(filelist);
	var n = filelist.length;
	var i = 0;
	for ( ; i < n; i++ ) {
		var file = filelist[i];
		OAT.Loader.include(file);
	}

	late_info_window_init();
}





function check_form_and_send(frm_obj,form_data_obj) {
	var prefix = form_data_obj.prefix;
	var elArray = form_data_obj.elements;

	var n = elArray.length;
	for ( var i = 0; i < n; i++ ) {
		var chkObj = elArray[i];
		if ( chkObj.required ) {
			var elID = prefix + "-" + chkObj.id;
			var v = $(elID).value;
			v = strim(v);
			if ( v.length == 0 ) {
				alert(chkObj.id + " requires a value");
				return(false);
			}
		}
	}

	return(true);
}





function linkReactor(path) {
	var urlNparameters = publication_locus + "?sess=" + g_classydex_session_id + "&publication=" + path; // + "&when=" + nowtime;
	makeDocEvalRequest(urlNparameters);
}

function render_fetch_data(rendobj) {
	var js = rendobj.js;
	var filelist = rendobj.js_files;
	var xsource = rendobj.xsource;
	for ( key in xsource ) {
		var divid = "page_" + key;
		var divobj = $(divid);
		var txt = xsource[key];
		divobj.innerHTML = txt;
	}
}

