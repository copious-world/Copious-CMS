

var Netscape, MSIE, Opera, Unknown, NN1, NN2, Ffox=false;
var Win, Mac, Other;
var NetscapeVer, MSIEVer, OperaVer, NetscapeOK, AlertMsg;

var Br = "1";

// detect browser
var g_navobj = navigator.userAgent;
var g_Browser;
var g_uAgentName

Netscape = ( navigator.appName == "Netscape" );
	if ( Netscape ) g_Browser = "NETSCAPE";
MSIE = ( navigator.appName == "Microsoft Internet Explorer" );
	if ( MSIE ) g_Browser = "MICROSOFTIE";
Opera = ( navigator.userAgent.indexOf("Opera") > -1 );
	if ( Opera ) g_Browser = "OPERA";

Unknown = !(Netscape || MSIE || Opera);

NetscapeOK = false;

// detect platform

Win = navigator.userAgent.indexOf("Win") > -1;
	if ( Win ) g_uAgentName = "NETSCAPE";
//
Mac = navigator.userAgent.indexOf("Mac") > -1;
	if ( Mac ) g_uAgentName = "MACINTOSH";
//
Linux = navigator.userAgent.indexOf("LINUX") > -1;
	if ( Linux ) g_uAgentName = "LINUX";

Other = !(Win || Mac || Linux);


function extractOperaVersion(navobj) {
	var strOperaPos;

	//
	strOperaPos = navobj.indexOf("Opera/"); // "Opera " or "Opera/"
	var overs = "";
	if (strOperaPos == -1) overs = navobj.substr(navobj.indexOf("Opera ")+("Opera ").length, 4);
	else overs = navobj.substr(strOperaPos + ("Opera/").length, 4);    
	//
	overs = parseFloat(overs);
	return(overs);
}

function browserSensing(navobj) {
	switch ( g_Browser ) {
		case "NETSCAPE": {
			//
			NetscapeVer = parseFloat(navigator.appVersion);
			if ( NetscapeVer > 4 ) { 
				//			        
				if ( navobj.indexOf("Netscape/") != -1 ) {
					NN1 = navobj.substr(navobj.indexOf("Netscape/")+9);
					NN1 = parseFloat(NN1);
				}
				NN1 = navobj.substr( navobj.indexOf("rv:") + 3 );
				NN1 = parseFloat(NN1); 

				if (NN1 >= "1.3") NetscapeOK = true;
			}
			if ( NetscapeOK ) {
				Br="NN";    
				if (navobj.indexOf("Firefox") != -1) Ffox = true;
			}
			break;
		}
		case "MICROSOFTIE": {
			////
			navobj = navigator.userAgent;
			//
			MSIEVer = navobj.substr( navobj.indexOf("MSIE ") + ("MSIE ").length, 4 );
			MSIEVer = parseFloat(MSIEVer); 
			// converts it into a floatint point number

			if( Opera ) {
				OperaVer = extractOperaVersion(navobj);
				//
			} else Br = "IE";
			
			break;
		}
		case "OPERA": {
			navobj = navigator.userAgent;
			OperaVer = extractOperaVersion(navobj);
			break;
		}
	}

	       
	if ( Opera ) {
		if (OperaVer >= 8) Br = "NN"; // Opera 8 works as Mozilla
	}

}



/////////////////////////////////////////////

browserSensing(g_navobj);

/////////////////////////////////////////////s


var basiclocus = self.location;

basiclocus = new String(basiclocus.toString());


if ( basiclocus.indexOf(".php?") > 0 ) {
	basiclocus = basiclocus.substring(0,basiclocus.lastIndexOf("/")+1);
}


if ( basiclocus.substring(0,5) == "https" ) {
	securelocus = basiclocus;
	basiclocus = "http" + basiclocus.slice(5);
} else {
	securelocus = "https" + basiclocus.slice(4);
}

var homevars = { secure: securelocus, basic: basiclocus };

