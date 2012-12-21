 
////
var currentDip = null;
////
function drupal_fetch(drupalurl) {
	spanID = "drupalcontent";
	var urlNparams = '../' + drupalurl;
	makeDocRequest(urlNparams);
}


function drupalContentUp(response) {
	var refobj = $("worldpeaceAnchor");
	var obj = $("drupalcontent");
	
	obj.style.top = (refobj.offsetTop - 15) + "px";
	obj.style.left = (refobj.offsetLeft) + "px";
	obj.style.width = (refobj.offsetWidth) + "px";
	// obj.style.height = (refobj.offsetHeight) + "px";
	//
	obj.style.visibility = "visible";
}


function initialize_community_software() {
	spanID = "cominitializer";
	var urlNparams = "initialize.php";
	makeDocRequest(urlNparams);
}




var nextclick = "";
var urltitle = "";


function doregisteredaction() {
	var url = nextclick;

	self.open(url,urltitle);
	//drupal_fetch(url);
}


function dohiding() {
    $hide('drupalcontent');
}



function clickAwareDiv(url) {

	nextclick = url;

	var refobj = $('communityClick');
	var obj = $('actionFramer');

	var ll = refobj.offsetLeft;
	var ww = refobj.offsetWidth;
	var tt = refobj.offsetTop;
	var hh = refobj.offsetHeight;
	
	obj.style.top = (tt - 1) + "px";
	obj.style.left = (ll - 1) + "px";

	obj.style.width = (ww - 1)  + "px";
	obj.style.height = (hh - 1) + "px";
	
	obj.style.visibility = "visible";
}



