


var clickAware_originalStyleClass = "MemberClick";

function styledescr(servicerep,url) {
	var classname = descrStyle[url];
	servicerep.className = classname;
}

function restoreViz() {
	var servicerep = $(gFlasher);
	servicerep.className = clickAware_originalStyleClass;
}

function urldescr(url) {
	return(descrlist[url]);
}


function clickAware(ll,tt,ww,hh,url) {

	var refobj = $(gImageMapNav);
	var obj = $(actionFramer);

	var imgObj = $(gImageMapNavImgHolder);

	var l = refobj.offsetLeft;
	var t = refobj.offsetTop;
	
	var w = imgObj.width;
	var h = imgObj.height;
	
	var refw = refobj.offsetWidth;
	var refh = refobj.offsetHeight;
	
	var diffw = Math.floor((refw - w)/2);
	var diffh = Math.floor((refh - h)/2);
	
	obj.style.top = (refobj.offsetTop + tt + diffh - 1) + "px";
	obj.style.left = (refobj.offsetLeft + ll + diffw - 1) + "px";

	obj.style.width = (ww-1)  + "px";
	obj.style.height = hh  + "px";
	
	obj.style.visibility = "visible";

	var servicerep = $(gServiceDescriber);

	servicerep.innerHTML = urldescr(url);

	styledescr($(gFlasher),url);
//
	nextclick = linklist[url];
	urltitle = url;

}

