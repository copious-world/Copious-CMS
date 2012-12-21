


function findPosX(obj) {
	var curleft = 0;
	////
	if ( obj.offsetParent ) {
		while ( obj.offsetParent ) {
			curleft += obj.offsetLeft
			obj = obj.offsetParent;
		}
	} else if ( obj.x ) {
		curleft += obj.x;
	}
	////
	return curleft;
}

function findPosY(obj) {
	var curtop = 0;
	//
	if ( obj.offsetParent ) {
		while ( obj.offsetParent ) {
			curtop += obj.offsetTop
			obj = obj.offsetParent;
		}
	} else if ( obj.y ) {
		curtop += obj.y;
	}
	return curtop;
}

/////////////////////////////////////////////////////////////
// Extended Tooltip Javascript:
// copyright 9th August 2002, 3rd July 2005
// by Stephen Chapman, Felgall Pty Ltd
//
// Paul G: Modified, it was no choice: z-index in IE does not work with form's selection elements,
// so if they are under my mapped image, then tooltip's text is behind Selection elements
// Had to show tooltips always at the same position related to my image, where
// there are no Selection elements on the way
var DH = 0;var an = 0;var al = 0;var ai = 0;if (document.getElementById) {ai = 1; DH = 1;}else {if (document.all) {al = 1; DH = 1;} else { browserVersion = parseInt(navigator.appVersion); if ((navigator.appName.indexOf('Netscape') != -1) && (browserVersion == 4)) {an = 1; DH = 1;}}} function fd(oi, wS) {if (ai) return wS ? document.getElementById(oi).style:document.getElementById(oi); if (al) return wS ? document.all[oi].style: document.all[oi]; if (an) return document.layers[oi];}

function pw() {return window.innerWidth != null? window.innerWidth: document.body.clientWidth != null? document.body.clientWidth:null;}
function mouseX(evt) {if (evt.pageX) return evt.pageX; else if (evt.clientX)return evt.clientX + (document.documentElement.scrollLeft ?  document.documentElement.scrollLeft : document.body.scrollLeft); else return null;}
function mouseY(evt) {if (evt.pageY) return evt.pageY; else if (evt.clientY)return evt.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop); else return null;}
function popUp(evt,oi,elID, t,l) {
        if (KbdVariant == '888') return; 
        var myObj=document.getElementById(elID);
        var toppos = findPosY(myObj)+ (t);
        var leftpos = findPosX(myObj)+ (l);
        
        if (DH) {var wp = pw(); ds = fd(oi,1); dm = fd(oi,0); st = ds.visibility; if (dm.offsetWidth) ew = dm.offsetWidth; else if (dm.clip.width) ew = dm.clip.width; if (st == "visible" || st == "show") { ds.visibility = "hidden"; } else {tv = toppos + 20; lv = leftpos - (ew/4); if (lv < 2) lv = 2; else if (lv + ew > wp) lv -= ew/2; if (!an) {lv += 'px';tv += 'px';} ds.left = lv; ds.top = tv; ds.visibility = "visible";}}
        // if (DH) {var wp = pw(); ds = fd(oi,1); dm = fd(oi,0); st = ds.visibility; if (dm.offsetWidth) ew = dm.offsetWidth; else if (dm.clip.width) ew = dm.clip.width; if (st == "visible" || st == "show") { ds.visibility = "hidden"; } else {tv = mouseY(evt) + 20; lv = mouseX(evt) - (ew/4); if (lv < 2) lv = 2; else if (lv + ew > wp) lv -= ew/2; if (!an) {lv += 'px';tv += 'px';} ds.left = lv; ds.top = tv; ds.visibility = "visible";}}
}
/////////////////////////////////////////////////////////////


function copy_clip(myText){
// based on example at http://www.webdeveloper.com/forum/showpost.php?p=344728&postcount=10
	if (window.clipboardData)
           window.clipboardData.setData("Text", myText);
	else if (window.netscape){
		netscape.security.PrivilegeManager.enablePrivilege  ('UniversalXPConnect');

		var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard  );
		if (!clip) return false;

		var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
		if (!trans) return false;

		trans.addDataFlavor('text/unicode');

		var str = new Object();
		var len = new Object();

		var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);   
		var copytext=myText;   
		str.data=copytext;   
		trans.setTransferData("text/unicode",str,copytext.length*2);   
		var clipid=Components.interfaces.nsIClipboard;

		if (!clip) return false;   
		clip.setData(trans,null,clipid.kGlobalClipboard);

	}

	return false;
}



function PasteIE()
{
     var range = txtControl.createTextRange(); 
     range.execCommand("Paste"); 
}
function CopyIE()
{
     var range = txtControl.createTextRange(); 
     range.execCommand("Copy"); 
}
function ClearIE()
{
     var range = txtControl.createTextRange(); 
     range.execCommand("Delete"); 
}


