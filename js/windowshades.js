

var currentDip = null;
var maxDivZ = 0;

var g_monthoffset = 0;


function showsection(secname) {
	//
	var obj = document.getElementById(secname);
	if ( currentDip != null ) {
		currentDip.style.visibility = "hidden";
	}
	
	var whereobj = document.getElementById("sectionplacer");
	
	if ( secname == "topic3" ) {
		getNames();
/*	} else if ( secname == "topic2" ) {
	
		obj.style.top = "35%";
		obj.style.left = "42%";
		obj.style.visibility = "visible";
*/
	} else {

		whereobj.innerHTML = obj.innerHTML;
	
	}
}



function postName() {
	var obj = document.getElementById("peacename");
	var vv = obj.value;

	if ( vv.length > 0 ) {
		spanID = "sectionplacer";
		var urlNparameters = "enterpeacename.php?peacename=" + vv;
		makeDocRequest(urlNparameters)
	} else {
		alert("Please enter a name");
	}
	
}

function getNames() {
	spanID = "sectionplacer";
	var urlNparameters = "getpeacenames.php";
	makeDocRequest(urlNparameters)
}


function echoText(entryfield,destfield) {

	var ef_obj = document.getElementById(entryfield);
	var o_obj = document.getElementById(destfield);
	//
	//
	var efText = ef_obj.value;

	var n = efText.length;
	//

	//
	var oText = "";
	if ( n >= 4 ) {

		var txtArray = efText.split(' ');
		//
		if ( txtArray.length > 0 ) {
			var aN = txtArray.length;
			for ( var i = 0; i < aN; i++ ) {
				var nwtxt = txtArray[i];
				if ( nwtxt.length == 4 ) {
					nwtxt = "0x" + nwtxt;
					var kk = String.fromCharCode(Number(nwtxt));
					oText += kk;
				}
			}
		}
	}
	
	o_obj.innerHTML = oText;
}



var savebnum = 0;

var g_current_obj = null;
var g_timeout_id = 0;
		
function hidecurrentObj() {
	if ( g_current_obj != null ) {
		g_current_obj.style.visibility = "hidden";
		g_current_obj = null;
		g_timeout_id = 0;
		if ( savebnum > 0 ) resetbutton(savebnum);
	}
}



function jigglebutton(bnum) {

	if ( g_timeout_id = 0 ) {
		clearTimeout(g_timeout_id);
	}
	///g_timeout_id = setTimeout("hidecurrentObj()",20000);

	if ( bnum != savebnum ) {
		if ( savebnum > 0 ) resetbutton(savebnum);
	}
	
	savebnum = bnum;
 
	var bname = "govbutton" + bnum;
	var boj = document.getElementById(bname);
	
	boj.style.backgroundColor = "lightyellow";
	
	var x = boj.offsetLeft;
	var y = boj.offsetTop;
	
	bname = "links" + bnum;
	boj = document.getElementById(bname);
	
	x += 20;
	y += 7;

	boj.style.left = x + "px";
	boj.style.top = y + "px";
	
	boj.style.visibility = "visible";
	boj.style.zIndex = 400 + bnum;
	
	g_current_obj = boj;
		
}

function resetbutton(bnum) {
	var bname = "govbutton" + bnum;
	var boj = document.getElementById(bname);
	
	boj.style.backgroundColor = "#EFFFEE";

	bname = "links" + bnum;
	boj = document.getElementById(bname);
	boj.style.visibility = "hidden";
	
	savebnum = 0;

}


var movedDivs = new Object();
var saveSection = "";


function setmoved(dname) {
	movedDivs[dname] = true;
}

function unmoved(dname) {
	movedDivs[dname] = false;
}

function ismoved(dname) {
	if ( movedDivs.hasOwnProperty(dname) ) {
		return(movedDivs[dname]);
	}
	return(false);
}


function hideDivAndParts(dname) {
	hideDiv(dname);
	$hide(dname + "-sub");
}

function showDivAndParts(dname) {
	$show(dname);
	$show(dname + "-sub");
}

function resetSelection(prevName) {
	if ( saveSection.length > 0 ) {
		if ( !ismoved(prevName) ) hideDivAndParts(prevName);
	}
}





function selectbutton(bnum,bchoice) {
	//
	resetSelection(saveSection);
	//
	var bname = "topic" + bnum;
	bname += "_" + bchoice;

	saveSection = bname;

	var boj = document.getElementById(bname);
	var targetdiv = document.getElementById("urlselections");	
	
	var x = targetdiv.offsetLeft;
	var y = targetdiv.offsetTop;
	
	x += 8;
	y += 4;

	boj.style.left = x + "px";
	boj.style.top = y + "px";
	
	boj.style.visibility = "visible";
	showDivAndParts(bname);
	
	var zz = 100 + bnum;
	boj.style.zIndex = zz;
	
	if ( zz > maxDivZ ) {
		maxDivZ = zz;
	} else {
		maxDivZ += 1;
		boj.style.zIndex = maxDivZ;
	}

	unshadewindow(bname);
	unmoved(bname);

}



var savediv = "";
var saveX = 0;
var saveY = 0;
var justmoving = false;

function savexy(evt) {
	var x = evt.clientX;
	var y = evt.clientY;

	saveX = x;
	saveY = y;
}


function hideDiv(dname) {
	var boj = document.getElementById(dname);
	boj.style.visibility = "hidden";

	justmoving = false;
	saveX = 0;
	saveY = 0;
}

var delaydiv = "";

function premove(dname,evt) {

	justmoving = false;

	savediv = dname;
	delaydiv = dname;

	var x = evt.clientX;
	var y = evt.clientY;

	saveX = x;
	saveY = y;
	
	var zz = $(dname).style.zIndex;
	if ( zz <= maxDivZ ) {
		maxDivZ += 2;
		$(dname).style.zIndex = maxDivZ;
	}
}


function stopmover() {
	savediv = "";
	justmoving = false;
	saveX = 0;
	saveY = 0;
}

function movecaptured(evt) {
	if ( ( delaydiv == savediv ) && ( savediv.length > 0 ) ) {
		divmover(delaydiv,evt);
	}
}


function divmover(dname,evt) {

	if ( savediv == dname ) {
		setmoved(dname);
		//
		var x = evt.clientX;
		var y = evt.clientY;
		
		mouseadjust(dname,x,y);
	}
	///
}


function mouseadjust(dname,x,y) {
	justmoving = true;
	var obj = document.getElementById(dname);
	var px = obj.offsetLeft;
	var py = obj.offsetTop;
	
	var x_diff = saveX - x;
	var y_diff = saveY - y;
	
	obj.style.left = (px - x_diff) + "px";
	obj.style.top = (py - y_diff) + "px";

	saveX = x;
	saveY = y;
}


function togglewindowshade(divtype,formfit) {

	var shader = $(divtype);
	var h = 0;
	
	if ( shader.hasOwnProperty("prevH") ) {
		h = shader.prevH;
	} else {
		h = shader.offsetHeight;
		shader["prevH"] = h;
		shader["shaded"] = false;
	}
	
	var fh = formfit.offsetHeight;
	
	if ( !(shader.shaded) ) {  // contract
		shader.style.height = fh + "px";
		shader.prevH = h;
		shader.shaded = true;
		$hide(divtype + "-sub");
	} else {	// expand
		shader.style.height = h + "px";		
		shader.shaded = false;
		$show(divtype + "-sub");
	}
	
	return(true);
}


function unshadewindow(divtype) {

	var shader = $(divtype);
	
	if ( shader.hasOwnProperty("prevH") ) {
		h = shader.prevH;
		shader.style.height = h + "px";		
		shader.shaded = false;
		$show(divtype + "-sub");
	}
}


var timeoutReady = false;
function cancelTimeout(evt) {
	timeoutReady = false;
	evt.stopPropagation();
	return(true);
}

function timerstopmover() {
	if ( timeoutReady ) {
		stopmover();
	} else {
		timeoutReady = true;
	}
}


var save_select_day = null;
var resetColorOddness = 0;

function reset_selected_day() {
	if ( save_select_day != null ) {
		save_select_day.style.color = "darkgreen";

		var bColor = '#FFEAEF';
		if ( resetColorOddness == 0 ) {
			bColor = '#FFEAEF';
		} else bColor = '#CAEAE0';
		save_select_day.style.backgroundColor = bColor;
	}
	save_select_day = null;
	
/*
	var dayschedgDisp = document.getElementById("eventReport");
	dayschedgDisp.style.visibility = "hidden";
*/

}

var saveCurMonthDate = null;


/////       DEBUG TEST TEST

var gLB = -1;
var gUB = 1;

function setOffsetRange(lb,ub) {
	gLB = lb;
	gUB = ub;
}


var gNextRefreshIndex = 0;

function initializeCalander(monthOffset) {
	var curmonth = 0;
	
	if ( monthOffset != 0 ) {
		g_monthoffset += monthOffset;
		reset_selected_day();
	} else g_monthoffset = 0;

	if ( ( g_monthoffset > gUB ) || ( g_monthoffset < gLB ) ) {
		gNextRefreshIndex = ( g_monthoffset < gLB ) ? -1 : 1;
		refreshEvents();
		return;
	}

	for ( var i = 0; i < 42; i++ ) {
		var dayname = "d" + (i + 1);
		var dobj = $(dayname);
		dobj.innerHTML = "~";
	}

	var ddate = new Date();
	var monthobj = $("monthspan");
	
	var mmm = ddate.getMonth();
	mmm += g_monthoffset;
	ddate.setMonth(mmm);
	monthobj.innerHTML = ddate.toDateString();
	
	
	ddate.setDate(1);
	mmm = ddate.getMonth();
	var firstDay = ddate.getDay();
	
	for ( var j = 1; j <= 42; j++ ) {
		i = j + firstDay;
		if ( i > 42 ) break;
		ddate.setDate(j);
		var testM = ddate.getMonth();
		if ( testM > mmm ) break;
		if ( ( mmm == 11 ) && ( testM == 0 ) ) {
		 break;
		}
//
		var dayname = "d" + i;
		var daycontainer = "c" + i;
//
		var dobj = $(dayname);
		var containerObj = $(daycontainer);
//
		dobj.innerHTML = j;
		if ( has_event(j,mmm) ) {
			dobj.innerHTML += " E";
			containerObj.style.border = "2px solid orange";
		} else {
			containerObj.style.border = "none";
			containerObj.style.borderLeft = "1px solid gold";
			containerObj.style.borderRight = "1px solid red";
		}
//
	}

	ddate.setMonth(mmm);
	saveCurMonthDate = ddate;
}




function populate_schedule(day,month) {
	var txtobj = document.getElementById("mockup");
	var txt = txtobj.innerHTML;
	
	var targetobj = document.getElementById("schedule_list");
	targetobj.innerHTML = txt;
}

function depopulate_schedule() {
	var txtobj = document.getElementById("noeeventmsgs");
	var txt = txtobj.innerHTML;
	
	var targetobj = document.getElementById("schedule_list");
	targetobj.innerHTML = txt;
}






// eventReport
function calanderAction(dnum,srcobj) {
	//
	hide_event_popper();
	//
	if ( save_select_day != srcobj ) {
		//
		reset_selected_day();
		save_select_day = srcobj;
		//
		var oddness = Math.floor((dnum-1)/7) % 2;
		resetColorOddness = oddness;
// 		//
		var tstText = save_select_day.innerHTML;
		if ( tstText.indexOf("~") == -1 ) {
			//
			save_select_day.style.color = "gold";
			save_select_day.style.backgroundColor = "darkgreen";
			//
/*
			var dayschedgDisp = $("eventReport");
			
			var seldate = "";
			
			var dateOfSel = $("eventday");
			var daySpan = "d" + dnum;
			daySpan = $(daySpan);
			
			seldate = daySpan.innerHTML;
			saveCurMonthDate.setDate(seldate);
			dateOfSel.innerHTML = saveCurMonthDate.toDateString();
			
			if ( seldate.indexOf("E") > 0 ) {
				populate_schedule(seldate,saveCurMonthDate.getMonth());
			} else {
				depopulate_schedule();
			}
			
			dayschedgDisp.style.visibility = "visible";
			dayschedgDisp.style.top = "50%";
*/
		}
		///
	} else {
		reset_selected_day();
	}
}


var timeOutWaiting = -1;
function hide_event_popper() {
	OAT.Dom.hide(INFOGROUP.eventttitlesW.wind.div);

}

function popup_events(seldate) {
		var eventpop = $("eventttitles");
		eventpop.style.top = (30 + g_squeeze*30) + "%";
		eventpop.style.visibility = "visible";
		timeOutWaiting = setTimeout("hide_event_popper();",10000);
}


var saveRollOver = -1;

function calanderRollOver(dnum,srcobj) {

	if ( dnum == saveRollOver ) {
		if ( timeOutWaiting > -1 ) {
			clearTimeout(timeOutWaiting);
			timeOutWaiting = -1;
		}
		hide_event_popper();
	}
	saveRollOver = dnum;

	var daySpan = "d" + dnum;
	daySpan = $(daySpan);
	
	var seldate = daySpan.innerHTML;
	var eventPos = seldate.indexOf("E");

	if ( eventPos > 0 ) {
		var tmp = seldate.split(" ");
		seldate = tmp[0];
		popup_events(seldate);
	}

}


function showHelp(refobj) {
	var helper = $('helpdiv');
	$showAt(helper,refobj)
}



var gDayObjects = null;

function has_event(j,mmm) {
	mmm++;
	if ( mmm < 10 ) mmm = "0" + mmm;
	if ( j < 10 ) j = "0" + j;
	var daykey = "k" + mmm + "_" + j;

	if ( gDayObjects != null ) {
		if ( gDayObjects.hasOwnProperty(daykey) ) {
			return(true);
		}
	}

	return(false);
}


function describeMe(daykey,evi) {
	if ( gDayObjects != null ) {
		if ( gDayObjects.hasOwnProperty(daykey) ) {
			var htmltxt = gDayObjects[daykey].describeEvent[evi];
			$("eventdescriber").innerHTML = htmltxt;
			INFOGROUP.eventdescriberW.wind.div.style.top = ($("urlselections").offsetTop - 16) + "px";
			INFOGROUP.eventdescriberW.wind.div.style.zIndex = OAT.Dom.maxZ(INFOGROUP.eventdescriberW.wind.div.style.zIndex);
			OAT.Dom.show(INFOGROUP.eventdescriberW.wind.div);
		}
	}	
}


function eventDescription(seldate) {

	if ( gDayObjects != null ) {

		var mm = saveCurMonthDate.getMonth();

		mm++;
		if ( mm < 10 ) mm = "0" + mm;
		if ( seldate < 10 ) j = "0" + seldate;
		var daykey = "k" + mm + "_" + seldate;

		try {
			var htmltxt = gDayObjects[daykey].txt;
			return(htmltxt);
		} catch ( e ) {
		} 

	} else {
		var ev = "	<table width=\"100%\" align=\"center\" class=\"windowShade\" style=\"background-color:green;\" ID=\"Table80\">";
			ev += "	<tr>";
			ev += "		<td align=\"center\" width=\"5%\">&nbsp;</td>";
			ev += "		<td width=\"95%\" align=\"center\">Smart Cars</td>";
			ev += "	</tr>";
			ev += "</table>";
	
			ev = "<div>" + seldate + "</div>" + ev;
			return(ev);
	}
}


function winShade_dateTitle(seldate) {
	var dayDate = new Date(saveCurMonthDate.toString());
	dayDate.setDate(seldate);
	return(dayDate.toDateString());
}


function setEventDays(dayObjects) {
	gDayObjects = dayObjects;
}


function refreshEvents() {
	// Refresh (AJAX) events with the event service.
	var ddate = new Date();
	//
	var request = "http://" + gHostbase + "copious-events/eventService.php?clientmonth=";
	request += encodeURI(ddate.getTime());
	request += "&monthOffset=" + g_monthoffset;
	////
	makeDocEvalRequest(request);
}


function calanderResponseHandler() {
	initializeCalander(gNextRefreshIndex);
}



