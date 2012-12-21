
var g_table_resize_schedule = new Array();
var g_table_resize_count = new Array();


// NOTE: Find a way to get rid of this...
function fixup_refresh_setting() {
	var refresher = $('edit-refresh');
	if ( refresher != null ) {
		if ( refresher.value == 0 ) refresher.value = '';
	}
}



function afterload_single_table_adjust(series,elcount) {

	var mastertable = $("tableid" + series);
	var srctable = $("tablesrcid" + series);
	var tw = srctable.offsetWidth;
	mastertable.style.width = tw + "px";
	mastertable.style.border = "1px solid gold";
	mastertable.style.backgroundColor = "#EAEAE0";
	mastertable.style.visibility = "inherit";

	for ( var i = 0; i < elcount; i++ ) {
		var objdst = $("a" + series + "_" + i);
		OAT.Dom.hide(objdst);
	}
	
	for ( var i = 0; i < elcount; i++ ) {
		var objdst = $("a" + series + "_" + i);
		var objsrc = $("b" + series + "_" + i);
		
		var w = OAT.Dom.getWH(objsrc);
		w = w[0];

		objdst.style.fontWeight = "bold";

		objdst.style.width = w + "px";
		
	}
	for ( var i = 0; i < elcount; i++ ) {
		var objdst = $("a" + series + "_" + i);
		OAT.Dom.show(objdst);
		objdst.style.visibility = "inherit";
	}
	
}

function afterload_table_adjust() {
	var n = g_table_resize_schedule.length;
	for ( var i = 0; i < n; i++ ) {
		var ser = g_table_resize_schedule[i];
		var elN = g_table_resize_count[i];
	 	afterload_single_table_adjust(ser,elN);
	}
}

function peacenames_tableadjust(series,elcount) {
	g_table_resize_schedule.push(series);
	g_table_resize_count.push(elcount);
}




var JSCOMPONENT = {};
var OATCOMPONENT = {};


function fieldSet_toggleVizState(elementname) {
	var obj = $(elementname);
	var styleclass = obj.className;
	if ( styleclass == "fset_open" ) {
		styleclass =  "fset_closed";
		for ( var node in obj.childNodes ) {
			OAT.Dom.hide(node);
		}
	} else {
		styleclass =  "fset_open";
		for ( var node in obj.childNodes ) {
			OAT.Dom.show(node);
		}
	}
	obj.className = styleclass;
}



function drupal_init() {
	var obname;
////
	for ( obname in JSCOMPONENT ) {
		var obj = JSCOMPONENT[obname];
		if (!obj.drawn ) {
			if (obj.cb) {
				OAT.Loader.loadFeatures(obj.needs,(function(job){
						var qobj = job;
						return(function(){qobj.cb();qobj.drawn=true;});
					})(obj),obname
				);
			} else { obj.drawn = true; }
		} /* if not yet included & drawn */
	}
////
	for ( obname in OATCOMPONENT ) {
		var obj = OATCOMPONENT[obname];
		if (!obj.drawn ) {
			if (obj.cb) {
				OAT.Loader.loadFeatures(obj.needs,(function(job){
						var qobj = job;
						return(function(){qobj.element = qobj.cb();qobj.drawn=true;});
					})(obj)
				);
			} else { obj.drawn = true; }
		} /* if not yet included & drawn */
	}
////
	OAT.Loader.loadFeatures(['tree'],(function(obj){
			return( function(){ init_dhtml_tree(); } );
	})(null));

	afterload_table_adjust();

	fixup_refresh_setting();// This is a stopgap
}



init_list_all["drupal_init"] = drupal_init;
