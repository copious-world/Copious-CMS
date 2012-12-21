
function echo(str) {
	alert(str);
}


function merge_objects(value_holder,value_source) {

	if ( value_holder == null ) {
		value_holder = new Object();
	}

	for ( ky in value_source ) {
		value_holder[ky] = value_source[ky];
	}
	return(value_holder);
}


////
function removePropety(list,cnm) {
	var nlist = new Object();
	for ( cc in list ) {
		if ( cc != cnm ) {
			nlist[cc] = list[cc];
			list[cc] = null;
		}
	}
	return(nlist);
}

/////
function stringify(obj,quotes) {
	var str = "";

	var realsep = ",";
	if ( quotes ) realsep = ", \"";

	if ( obj.constructor == "Array" ) {
		str += "[";
		var n = obj.length;
		var sep = "";
		for ( var i = 0; i < n; i++ ) {
			txt = stringify(obj[i]);
			str += sep + txt;
			sep = ",";
		}
		str += "]";
	} else if ( obj.constructor == "String" ) {
		str = obj;
	} else if ( ( obj.constructor == "Number" ) || ( obj.constructor == "Boolean" ) || ( obj.constructor == "Function" ) ) {
		str = "" + obj;
	} else if ( ( typeof(obj) == "object" ) || ( obj.constructor == "Object" ) ) {
		var objsep = ":";
		if ( quotes ) objsep = "\" :";
		str += "{";
		if ( quotes ) str += "\"";
		var sep = "";
		for ( j in obj ) {
			var txt = j + objsep + stringify(obj[j]);
			str += sep + txt;
			sep = realsep;
		}
		str += "}";
	} else {
		str = "" + obj;
	} 

	return(str);
}


function $(objName) {
	var divObj = document.getElementById(objName);
	return(divObj);
}


function removespace(str) {
	var ostr = "";
	var sp = ' ';
	var tb = '\t';
	var rt = '\n';
	var lf = '\r';
	var n = str.length;
	for ( var i = 0; i < n; i++ ) {
		var c = str.charAt(i);
		if ( ( sp == c ) || ( tb == c ) || ( rt == c ) || ( lf == c ) ) continue;
		ostr += c;
	}
	return(ostr);
}


function fileBase(filestr) {
	var i = filestr.lastIndexOf("/");
	if ( i < 0 ) {
		i = filestr.lastIndexOf("\\");
	}
	
	return(filestr.slice(i+1));
}

function showPart(inputObj) {
	inputObj.style.visibility = "visible";
}

function hidePart(inputObj) {
	inputObj.style.visibility = "hidden";
}


function $show(objName,data) {
	var divObj = $(objName);
	if ( divObj != null ) {
		showPart(divObj);
		if ( data != null ) {
			divObj.innerHTML = data;
		}
	}
	return(divObj);
}

function $hide(objName) {
	var divObj = $(objName);
	if ( divObj != null ) hidePart(divObj);
	return(divObj);
}

function $obj_show(obj) {
	obj.style.visibility = "visible";
}

function $obj_hide(obj) {
	obj.style.visibility = "hidden";
}

function toggleVisPart(inputObj) {
	var viz = inputObj.style.visibility;
	if ( viz != "visible" ) {
		inputObj.style.visibility = "visible";
	} else {
		inputObj.style.visibility = "hidden";
	}
}


function eliminate_plus(treespec) {
	var n = treespec.length;
	var output = "";
	for ( var i = 0; i < n; i++ ) {
		var c = treespec.charAt(i);
		if ( c == "+" ) {
			c = " ";
		}
		output += c;
	}
	return(output);
}



function $showAt(obj,refob) {

	var y = refob.offsetTop;
	var x = refob.offsetLeft;
	
	obj.style.top = y + "px";
	obj.style.left = x + "px";
	
	$obj_show(obj);
}


var g_prev_distance = 0;

function divdistance(x,y,t,l,t2,l2) {
	var cx = l + (l-l2)/2;
	var cy = t + (t - t2)/2;
	var dx = (x - cx);
	dx = dx*dx;
	var dy = (y - cy);
	dy = dy*dy;
	var d = Math.sqrt(dx + dy);

	
	return(d)
}


function iswithin(x,y,dname) {
	var dobj = $(dname);
	//------------------------------
	var t = dobj.offsetTop;
	var l = dobj.offsetLeft;
	var t2 = t + dobj.offsetHeight;
	var l2 = l + dobj.offsetWidth;

//alert(t + ", " + l + ", " + t2 + ", " + l2 + "  " + x + ":" + y);
	if ( ( x > l ) && ( x < l2 ) ) {
		if ( ( y > t ) && ( y < t2 ) ) {
			return(true);
		}
	}
	//------------------------------
	return(false);
}

