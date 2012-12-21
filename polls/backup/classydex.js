var last_server_parameter = "";
var dateforIE = new Date();

function windowHeight() {
	if ( window.innerHeight ) {
		return(window.innerHeight);
	}
	if ( document.body.clientHeight ) {
		return(document.body.clientHeight);
	}
	return(null);
}

function windowWidth() {
	if ( window.innerWidth ) {
		return(window.innerWidth);
	}
	if ( document.body.clientWidth ) {
		return(document.body.clientWidth);
	}
	return(null);
}


function sendClassifiedsCommand(alink) {
	var dexhost = gHostbase + "classydex";
	///dexhost = "www.copious-systems.com/classifieds";
	var alink = "http://" + dexhost + alink;
	alink += "&seq=" + dateforIE.getTime();
	makeDocRequest( alink );
}





function doctablesize() {
	var doctable = document.getElementById("docfacetable");
	var docdisplay = document.getElementById("outerWrapper");
	var doccontents = document.getElementById("contents");
	
	var h = Math.floor(windowHeight() - doctable.offsetTop);
	//  Need to leave room for TOC.....
	
	var ll = windowWidth()*(0.15);
	ll = Math.max(ll,100);
	var w = Math.floor( ( windowWidth() - ll )*0.92);
	//
	docdisplay.style.height = (h-4) + "px";
	docdisplay.style.width = (w-4) + "px";
	
	////
	var docContentsdisplay = document.getElementById("outerContentsWrapper");
	docContentsdisplay.style.height = (h-20) + "px";
	docContentsdisplay.style.width = (ll) + "px";
	//
}

function user_contentclick() {
	doctablesize();
}


var savecolor;

function rollover(obj) {
	savecolor = obj.style.borderColor;
	obj.style.borderColor = "darkgreen";
}

function rollout(obj) {
	obj.style.borderColor = savecolor;
}


var saveHTML = "";
var storeduseraction = "";

function buttonResponse(useraction) {
	var call_locus = admin_locus;
	storeduseraction = useraction;
	if ( last_server_parameter.length > 0 ) {
		//
		saveHTML = document.getElementById("docpages").innerHTML;
		//
		call_locus += useraction;
		call_locus += "&section=";
		call_locus += last_server_parameter;
		call_locus += "&seq=" + dateforIE.getTime();
		sendClassifiedsCommand(call_locus);
		//
	} else {
		alert("No section selected");
	}
}




function process_classified_index(evt,sectionnum) {
/*
	var appendseq = "";

	if (  Br != "IE" ) evt.stopPropagation();
	else {
		appendseq = Math.rand(6);
	}
	try {
		var dexhost = gHostbase + "classydex";
		///dexhost = "www.copious-systems.com/classifieds";
		var alink = server_locus + sectionnum + "&startNumber=0";
		alink += "&seq=" + dateforIE.getTime();
		//sendClassifiedsCommand( alink );
		store_section( sectionnum );
	} catch ( e ) {
		alert(e.message);
	}
*/
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




///////////////
////////////////
/////////////////

function prevquery() {
	var contactDiv = document.getElementById("contactDiv");
	if ( contactDiv.style.visibility == "visible" ) {
		closeContact();
	} else {
		if ( saveHTML && ( saveHTML.length > 0 ) ) {
			var adPage = document.getElementById("docpages");
			adPage.innerHTML = saveHTML;
			saveHTML = "";
		} else {
		
			if ( storeduseraction.length == 0 ) storeduseraction = "selection";
		
			if ( section_selection ) {
				remember_start -= 100;
				if ( remember_start < 0 ) {
					remember_start = 0;
				}

				if ( storeduseraction != "focus" ) {
					var link = server_locus + last_server_parameter;
					link += "&startNumber=" + remember_start
					sendClassifiedsCommand(link);
				} else {
					searchentry(remember_start);
				}

			}
		}
	}
}




function nextquery() {
	var contactDiv = document.getElementById("contactDiv");
	if ( contactDiv.style.visibility == "visible" ) {
		closeContact();
	} else {
		if ( saveHTML && ( saveHTML.length > 0 ) ) {
			var adPage = document.getElementById("docpages");
			adPage.innerHTML = saveHTML;
			saveHTML = "";
		} else {
			if ( section_selection ) {
				remember_start += 100;

				if ( storeduseraction != "focus" ) {
					var link = server_locus + last_server_parameter;
					link += "&startNumber=" + remember_start
					sendClassifiedsCommand(link);
				} else {
					searchentry(remember_start);
				}

			}
		}
	}
}


function searchentry(nn) { 
	////
	var obj = document.getElementById("classisearchterm");
	var searchterm = obj.value;
			////

	var slen = searchterm.length;

	if ( slen > 0 ) {
		//
		var call_locus = focus_locus;
		storeduseraction = "focus";


		if ( last_server_parameter.length > 0 ) {
			//
			saveHTML = document.getElementById("docpages").innerHTML;
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



var save_responder_element = "docpages";
var saverefobj;
var saveClick_X = 0;
var saveClick_Y = 0;
var savedReportId = 0;

function showDetails(detailid,refobj,evt) {
	closeContact();
	//(evt,refobj,im_name)
	savedReportId = detailid;
	var alink = server_details_locus  + detailid;
	saverefobj = refobj;
	//
	saveClick_X = evt.clientX;
	saveClick_Y = evt.clientY;
	//
	spanID = "singleItemEntrySpan";
	alink += "&seq=" + dateforIE.getTime();
	sendClassifiedsCommand(alink);
	//
}




function secondary_http_request_response(objname) {
	spanID = save_responder_element;
	
	if ( objname == "singleItemEntrySpan" ) {
		var divobj = document.getElementById("singleItemEntry");
		var spanobj = document.getElementById("singleItemEntrySpan");

		if ( spanobj.innerHTML.length > 0 ) {
			divobj.style.zIndex = 1500;
			//
			var posobj =  document.getElementById("outerWrapper");

			divobj.style.left = saveClick_X + 'px';
			divobj.style.top = saveClick_Y + 'px';
/*	
*/
			divobj.style.width = (posobj.offsetWidth - saveClick_X - 10);
			//
			//
			divobj.style.visibility = "visible";

		// Position.
		} else {
			//divobj.style.visibility = "hidden";
		}

//		document.getElementById("docpages").innerHTML = divobj.innerHTML;
	}
}



function hideDiv(divname) {
	var divobj = document.getElementById("singleItemEntry");
	divobj.style.visibility = "hidden";
}

function resetSection(objname) {
	var divobj = document.getElementById("customsadddetail");
	divobj.style.visibility = "hidden";
}



function managerAction(reactor) {
	//manager_locus
}


function runPlacer() {
//
	var getstr = "?";

	var vname = "contact_number";
	var target_obj = document.getElementById(vname);
	var vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("A phone number is required");
		return;
	}
	
	var shipping_data = "";
	vname = "shipping_origination_country";
	target_obj = document.getElementById(vname);
	vdata = target_obj.value;
		
	if ( vdata.length == 0 ) {
		alert("Please enter a country.");
		return;
	}
	shipping_data += vdata + ",";
	
	vname = "shipping_origination_state";
	target_obj = document.getElementById(vname);
	vdata = target_obj.value;
		
	if ( vdata.length == 0 ) {
		alert("Please enter a state or region abreviation.");
		return;
	}
	shipping_data += vdata + ",";
	
	vname = "shipping_origination_zcode";
	target_obj = document.getElementById(vname);
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
	target_obj = document.getElementById(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";

	vname = "add_title";
	target_obj = document.getElementById(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("A title must be displayed");
		return;
	}

	vname = "brief_description";
	target_obj = document.getElementById(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("Some description is required");
		return;
	}

	vname = "offered_price";
	target_obj = document.getElementById(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("Put 0.00 if the price is for discussion and state that it is to be discussed in the description.");
		return;
	}

	vname = "email_address";
	target_obj = document.getElementById(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata;
	
	if ( vdata.length == 0 ) {
		alert("The e-mail address is required for your identification and processing.");
		return;
	}
	

	var url = manager_locus + "placeadd.php" + getstr + "&section=" + last_server_parameter;
	
	url += "&seq=" + dateforIE.getTime();
	sendClassifiedsCommand(url);

	return(true);
}

/*

alert(manager_locus + "jobs/jobs_placeadd.php" + "  ========  ");
alert("  ========  " + getstr);

*/


function runPlacerJobs() {
//
	var getstr = "";

	var vname = "contact_number";
	var target_obj = document.getElementById(vname);
	var vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";

	if ( vdata.length == 0 ) {
		alert("A phone number is required");
		return;
	}

	vname = "member_agent";
	target_obj = document.getElementById(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";

	var shipping_data = "";
	vname = "shipping_origination";
	target_obj = document.getElementById(vname);
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
	target_obj = document.getElementById(vname);
	vdata = encodeURI( target_obj.value );
	getstr += vname + "=" + vdata + "&";

	vname = "add_title";
	target_obj = document.getElementById(vname);
	vdata = encodeURI( target_obj.value );
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("A title must be displayed");
		return;
	}


	vname = "brief_description";
	target_obj = document.getElementById(vname);
	vdata = encodeURI( target_obj.value );
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("Some description is required");
		return;
	}

	vname = "offered_price";
	target_obj = document.getElementById(vname);
	vdata = target_obj.value;
	getstr += vname + "=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("Put 0.00 if the price is for discussion and state that it is to be discussed in the description.");
		return;
	}

	vname = "email_address";
	target_obj = document.getElementById(vname);
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
	parameters += "&seq=" + dateforIE.getTime();
	makePOSTRequest(url, parameters);
	////
	return(true);
}



	
	function getMemberAgent() {
		var obj = document.getElementById("agentMail");
		var txt = obj.value;
		if ( txt.length > 0 ) {
			agentSelectionResponse();
		} else {
			alert("Please enter an e-mail address for the agent.");
		}
	}
	
	function fetch_agent_setup() {
		var obj = document.getElementById("agent_form");
		var amounttoggle = "";
		if ( obj.style.visibility == "visible" ) {
			obj.style.visibility = "hidden";
			amounttoggle = "$50.00";
			var agentobj = document.getElementById("member_agent");
			agentobj.value = '';
		} else {
			obj.style.visibility = "visible";
			amounttoggle = "$40.00";
		}
		
		obj = document.getElementById("alteramount");
		obj.innerHTML = amounttoggle;
	}
	
	function agentSelectionResponse() {
	
		var obj = document.getElementById("agentMail");
		var txt = obj.value;

		var agentobj = document.getElementById("member_agent");
		agentobj.value = txt;
	
		obj = document.getElementById("agent_accessible");
		obj.style.visibility = "hidden";
		
	}
	


////
function makeContact(detailid) {
	hideDiv("test");
	var contactDiv = document.getElementById("contactDiv");
	//
	contactDiv.style.zIndex = 200;
	//
	var posobj =  document.getElementById("outerWrapper");
	var xx = posobj.offsetLeft
	var yy = posobj.offsetTop;
	contactDiv.style.left = xx + 'px'
	contactDiv.style.top = yy + 'px';
	contactDiv.style.width = (posobj.offsetWidth - xx - 10);
	
	
	var spanTitleId = "listertitle" + detailid;
	var spTitleObj = document.getElementById(spanTitleId);
	var tmptitle = spTitleObj.innerHTML;
	
	spTitleObj = document.getElementById("contactDivTitle");
	spTitleObj.innerHTML = tmptitle;
	//
	contactDiv.style.visibility = "visible";
}

function sendClassiContact() {
//
	var getstr = "?";
	
	getstr += "reportid=" + savedReportId + "&";
	
	var vname = "contact_number2";
	var target_obj = document.getElementById(vname);
	var vdata = target_obj.value;
	getstr += "sender_phone=" + vdata + "&";
	
	if ( vdata.length == 0 ) {
		alert("A phone number is required");
		return;
	}

	vname = "contact_comments";
	target_obj = document.getElementById(vname);
	vdata = target_obj.value;
	getstr += "sender_message=" + vdata + "&";
		
	if ( vdata.length == 0 ) {
		alert("There is no message.");
		return;
	}

	vname = "contact_email_address";
	target_obj = document.getElementById(vname);
	vdata = target_obj.value;
	getstr += "sender_email=" + vdata + "&";

	if ( vdata.length == 0 ) {
		alert("An email is required.");
		return;
	}

	
	var url = manager_locus + "adresponse.php" + getstr + last_server_parameter;
	url += "&seq=" + dateforIE.getTime();
	//
	closeContact();
	sendClassifiedsCommand(url);
}

//
//
function closeContact() {
	var contactDiv = document.getElementById("contactDiv");
	contactDiv.style.visibility = "hidden";
}


//=========================================================================
//
//
