// $Id: dhtml_menu.js,v 1.7 2006/12/27 22:52:48 merlinofchaos Exp $



var g_menutreelist = {};
var g_expansionlist = [[{index:3,state:1,subs:null},{index:10,state:1,subs:[{index:1,state:1,subs:null}]}],[{index:0,state:1,subs:[{index:1,state:1,subs:null}]}]];

function serialize_dhtml_object(obj) {
	var str = "";
	str += "{index:" + obj.index;
	//
	str += ",state:" + obj.state;
	str += ",subs:";
	
	if ( obj.subs == null ) { str += "null"; }
	else  { str += serialize_dhtml_object_list(obj.subs); }

	str += "}";
	return(str);
}

function serialize_dhtml_object_list(objectarray) {
	var n = objectarray.length;
	var str = "";
	str += "[";
	//
	//
	for ( var i = 0; i < n; i++ ) {
		var obj = objectarray[i];
		str += serialize_dhtml_object(obj);
		if ( i < (n-1) ) str += ",";
	}
	str += "]";
/*
*/
	return(str);
}

function serialize_dhtml_array() {
	var n = g_expansionlist.length;
	var str = "";

	str += "[";
	//
	for ( var i = 0; i < n; i++ ) {
		var objarray = g_expansionlist[i];
		str += serialize_dhtml_object_list(objarray);
		if ( i < (n-1) ) str += ",";
	}
	//
	str += "]";

	return("dhtml_menu=" + str);
}

function expand_elements(n,expl, pnode) {
	for ( var i = 0; i < n; i++ ) {
		var info = expl[i];
		var j = info.index;
		var node = pnode.children[j];
		if ( info.state == 1 ) node.expand();
		
		if ( info.subs != null ) {
			expand_elements(info.subs.length, info.subs, node);
		}
	}
};


function indexer(i,st) {
	this.index = i;
	this.subs = null;
	this.state = st;
}


function dhtml_record_child_expansion(children) {
	////
	var exparray = new Array();
	var n = children.length;
	for ( var i = 0; i < n; i++ ) {
		var node = children[i];
		if ( node.children.length > 0 ) {
			var obj = new indexer(i,node.state);
			obj.subs = dhtml_record_child_expansion(node.children);
			exparray.push(obj);
		}	
	}
	if ( exparray.length == 0 ) return(null);
/*
*/	
	return(exparray);
}


function remove_dhtml_cookie(str) {
	var search = "dhtml_menu=";
	var offset = str.indexOf(search);
	if ( offset >= 0 ) {
		var front = str.substring(0,offset);
		var strback = str.substring(offset);
		offset = strback.indexOf(";");
		if ( offset > 0 ) {
			strback = str.substring(offset);
		}	
		str = front + strback;
	}
	return(str);
}


function dhtml_save_tree_state() {
	//
	var l = 0;
	for ( var tp in g_menutreelist ) {
		////
		var t = g_menutreelist[tp];
		var children = t.tree.children;
		var exparray = dhtml_record_child_expansion(children);
		g_expansionlist[l] = exparray;

		l++;
	}

	var this_cookie = serialize_dhtml_array();
	document.cookie = this_cookie + ";path=/" ;

}


function init_dhtml_tree() {
	////
	//
	var l = 0;
	for ( var tp in g_menutreelist ) {

		var t = g_menutreelist[tp];
		////
		var n = g_expansionlist[l].length;
		var expl = g_expansionlist[l];

		if ( n > 0 ) {
			t.tree.expand();
			expand_elements(n, expl, t.tree);
		}

		t.mapwalk("assign_expansion_auditor",dhtml_save_tree_state);
		t.mapwalk("assign_collapse_auditor",dhtml_save_tree_state);

		l++;
	}

	/// Assume blockbar loadded...  NOT really the best spot for this...
	blockbar_onload();

}


function addmenutree(divname) {
	var t1 = g_menutreelist[divname];
	if ( t1 == null ) {
		try {
			var t = new OAT.Tree({imagePath:"/drupal/../sharedimages/",imagePrefix:"menu",ext:"png",
								allowDrag:0,onClick:"select",onDblClick:"toggle",onlyOneOpened:false });
		} catch(e) {
			alert(e.message);
		}

		g_menutreelist[divname] = t;
		t.assign(divname,true);
	}
}



