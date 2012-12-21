// 



var g_sec_userid = 0;
var g_sec_sessionid = 0;

var passwordAuth;
// // 
// // // 
var user_login_state_action = null;
// // // 


var g_phpservicedir = "";
function setServiceDir(phpservicedir) {
	g_phpservicedir = phpservicedir;
}

function accountFeaturesAction() {
	//
	var urlNparams = "myaccountinfo.php?sess=" + g_sec_sessionid + "&servicedir=" + phpservicedir + "&browser=" + Br;
	if ( Br == "IE" ) {
		urlNparams = homevars.basic + urlNparams;
	} else {
		urlNparams = "/hosted/" + urlNparams;
	}
	try {

		if ( Br == "IE" ) {
			var win = window.open(urlNparams, "AccountInfo", "width=800,height=600");
		} else {
			var win = window.open(urlNparams, "AccountInfo", "width=800,height=600,scrollbars");
		}
	} catch ( e ) {
		alert(e.message);
	}
}



function fetchLoginParams(uname) {
	//
	spanID = "sectionplacer";
	if ( g_sec_lang != 1 ) {
		if ( Br == "IE" ) {
			uname = encodeURI(uname);
		}
	}
	var urlNparameters = "copiousauth/loginParamsEval.php?username=" + uname  + "&browser=" + Br;
	//
	makeDocEvalRequest(urlNparameters);
	//
}


function showform(buttonImg) {
////
	var imgObj = $(buttonImg);
	var src = imgObj.src;
	//
	src = fileBase(src);
	//
	$hide("multiLangPass");
	$hide("authUserName");

	if ( src == "buttonDown.jpg" ) {
		imgObj.src = "./img/buttonUp.jpg";
		
		var uiObj = $("username");
		uiObj.value = "";
	} else {
		imgObj.src = "./img/buttonDown.jpg";
	}
	
	var inputObj = $("multiLangInput");
	inputObj.style.left = (imgObj.offsetLeft + 2*imgObj.offsetWidth)  + "px";
	inputObj.style.top = (imgObj.offsetTop + Math.round(imgObj.offsetHeight/6)) + "px";
	
	toggleVisPart(inputObj);
////

}




function loginPasswordOrError(response) {
	//
	if ( response != "INV" ) {
		//	
		var imgObj =  $("buttonImgSignUp");
		var inputObj = $("multiLangPass");
		//
		var ll = (imgObj.offsetLeft + 2*imgObj.offsetWidth);
		inputObj.style.left = ll  + "px";
		inputObj.style.top = (imgObj.offsetTop + Math.round(imgObj.offsetHeight/6)) + "px";
		
		var obj =  $("SIGNINDIV");
		var refw = $("multiLangInput").offsetWidth;
		var maxW = obj.offsetWidth - ll;
		
		var w = 0;
		
		if ( maxW > 180 ) maxW = 180;
		// inputObj.style.width =  (refw + maxW) + "px";
		inputObj.style.width = "70%";
		//
		$show("authUserName",response);
		$show("multiLangPass",null);
		//
		$("PN_password").focus();
		//
		fetchLoginParams(response);
	} else {
		$hide("authUserName");
		$hide("multiLangPass");
	}
	//
	handleMLO_response = null;
}


function logoutAction() {
	//
	$hide("succesfulLogin");
	$show("SIGNINDIV",null);
	//
	var urlNparams = "copiousauth/logout.php?uid=" + g_sec_userid + "&sess=" + g_sec_sessionid; + "&browser=" + Br;
	makeDocRequest(urlNparams);
	//
	set_user_id(0);		// g_sec_userid
	set_session_id(0);	// g_sec_sessionid
	//
	if ( user_login_state_action != null ) {
		user_login_state_action(false);
	}
}

function accountFeatureParams(phpservicedir) {

	var urlNparams = "myaccountinfo.php?sess=" + g_sec_sessionid + "&servicedir=" + phpservicedir + "&browser=" + Br;
	if ( Br == "IE" ) {
		urlNparams = homevars.basic + urlNparams;
	} else {
		urlNparams = "./" + urlNparams;
	}

	return(urlNparams);
}


function divswitchOnSignIn(abc) {
	//
	$hide("SIGNINDIV");
	
	var obj =  $("SIGNINDIV");
	var destobj = $("signedInDone");
	
	destobj.innerHTML = abc;
	destobj.style.width = "60%";
	//
	destobj = $("succesfulLogin");
	destobj.style.top = obj.offsetTop + "px";
	destobj.style.height = obj.offsetHeight  + "px";
	destobj.style.width = obj.offsetWidth + "px";

	$show("succesfulLogin",null);
	handleMLO_response = null;
	if ( user_login_state_action != null ) {
		user_login_state_action(true);
	}
}

function reloadLogout() {
	if ( ( g_sec_userid > 0 ) && ( g_sec_sessionid > 0 ) ) {
		logoutAction();
	}
}

var store_user_name = "";

function loginAuth() {

	var passObj = $("multiLangPass");
	//
	var uiObj = $("username");
	var uidVal = uiObj.value;
	
	var viz = passObj.style.visibility;
	if ( viz == "visible" ) {
		uidVal = store_user_name;
	} else {
		store_user_name = uidVal;
	}

	if ( uidVal.length == 0 ) {
		alert("A user name is required.");
		return;
	}
	
	if ( textOK(uidVal) ) {
	
		if ( viz == "visible" ) {
			//
			passObj.style.visibility = "hidden";
			$hide("authUserName");
			//
			handleMLO_response = divswitchOnSignIn;
			//
			//
			passwordAuth();
			//
		} else {
			//
			showform("buttonImgSignUp");
			
			spanID = "authUserName";
			handleMLO_response = loginPasswordOrError;
			//
			if ( g_sec_lang != 1 ) {
				if ( Br == "IE" ) {
					uidVal = encodeURI(uidVal);
				}
			}
			//
			var urlNparams = homevars.secure + "copiousauth/username.php?username=" + uidVal + "&browser=" + Br;
			makeDocRequest(urlNparams);
		}
		
	} else {
		alert("The user id must be alphabet letters or digits, no spaces.");
	}


}



function startsearch(strCmdSrch) {
}

