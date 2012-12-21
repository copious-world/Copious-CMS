


var g_fetch_form_elements = null;
var g_field_details_info = null;

var g_currentSelected = null;
var g_existing_components = null;
var g_default_component = null;
var g_field_details_table = null;
var g_field_details_info = null;



function object_clone(obj) {
	var newobj = null;
	if ( obj.constructor == "Array" ) {
		newobj = obj.copy();
		var n = newobj.length;
		for ( var i = 0; i < n; i++ ) {
			newobj[i] = object_clone(obj);
		}
		return(newobj);
	} else if ( obj.constructor == "String" ) {
		return(obj.substring(0));
	} else if ( ( obj.constructor == "Number" ) || ( obj.constructor == "Boolean" ) || ( obj.constructor == "Function" ) ) {
		return(obj);
	} else {
		newpobj = new Object();
		for ( j in obj ) {
			newpobj[j] = obj[i]
		}
		return(newpobj);
	}
	return(null);
}


function get_max_delta(aname) {
	var maxdelta = -1;
	var paname = aname.substr(0,aname.lastIndexOf("_"));

	for ( var cname in g_existing_components ) {
		var pname = cname.substr(0,cname.lastIndexOf("_"));
		if ( paname == pname ) {
		var delta = g_existing_components[cname].delta;
			if ( maxdelta < delta ) maxdelta = delta;
		}
	}
	return(maxdelta);
}


function oat_form_populate_from(tdsrc,aname,delta) {

	if ( g_default_component == null ) {
		g_default_component = new Object();
		g_default_component.pname = $('edit-name').value;
		g_default_component.delta = $('edit-clone-index').value;
		g_default_component.java_script = $('edit-javascript').value;
		g_default_component.element = $('edit-codepart').value;
		g_default_component.datasource = $('edit-datasource').value;
		g_default_component.data_source_parameters = $('edit-data-source-parameters').value;
	}

	if ( tdsrc.className != "oatlist_selected" ) {
		if ( g_currentSelected != null ) {
			g_currentSelected.className = "oatlist";
		}
		tdsrc.className = "oatlist_selected";
		g_currentSelected = tdsrc;

		var cname = aname;
		var obj = g_existing_components[cname];
		if ( obj == null ) return;

		var pname = cname.substr(0,cname.lastIndexOf("_"));
		$('edit-name').value = pname;
		$('edit-clone-index').value = get_max_delta(cname) + 1;
		$('edit-javascript').value = decodeURIComponent(obj.java_script);
		$('edit-codepart').value = decodeURIComponent(decodeURIComponent(obj.element));
		$('edit-datasource').value = obj.datasource;
		$('edit-data-source-parameters').value = decodeURIComponent(decodeURIComponent(obj.data_source_parameters));

		// populated the component.
	} else {
		tdsrc.className = "oatlist";
		
		if ( g_default_component == null ) return;

		$('edit-name').value = g_default_component.pname;
		$('edit-clone-index').value = g_default_component.delta;
		$('edit-javascript').value = g_default_component.java_script;
		$('edit-codepart').value = g_default_component.element;
		$('edit-datasource').value = g_default_component.datasource;
		$('edit-data-source-parameters').value = g_default_component.data_source_parameters;

	}
}


var g_prev_selected = null;

function rolled_oat_toggle_select(obj) {
	////
	var cname = obj.className;

	var cname_parts = cname.split(" ",2);
	cname = cname_parts[0];
	var endparts = cname_parts[1];
	////
	var p = cname.indexOf("_selected");
	if ( p > 0 ) {
		cname = cname.substring(0,p);
	} else {
		if ( g_prev_selected != null ) g_prev_selected.className = cname + " " + endparts;
		g_prev_selected = obj;
		cname += "_selected";
	}
	obj.className = cname + " " + endparts;
	////
}





function check_for_oat_component_existence(aname,delta) {
	var mdelta = get_max_delta(aname);
	if ( delta <= mdelta) return(true);
	return(false);
}



function check_form_values(aform) {

	var namer = $('edit-name');
	var v = "";
	if ( namer != null ) {
		v = namer.value;
		if ( v == 'my component name' ) {
			alert("You need to supply your own oat component name");
			return(false);
		}
	}

	var vjs = "";
	var jsscript = $('edit-javascript');
	if ( jsscript != null ) {
		vjs = jsscript.value;
		if ( v.length < 4 ) {
			alert("The JSCOMPONENT has to be defined for OAT components to be created.");
			return(false);
		}
	}

	if ( ( v.length > 0 ) && ( vjs.length > 0 ) ) {
		while ( v.indexOf(" ") > 0 ) {
			v = v.replace(" ","_");
		}
		v = (v + "_" + $('edit-clone-index').value);
		namer.value = v;

		if ( check_for_oat_component_existence( v, $('edit-clone-index').value) ) {
			alert("There is already a component by this name and this component is not a clone of it.");
			return(false);
		}

		vjs = vjs.replace("%name",v);
		vjs = vjs.replace("%divname",v + "_div");

		jsscript.value = encodeURIComponent(vjs);

		var obj = $('edit-codepart');
		obj.value = encodeURIComponent(obj.value);

		obj = $('edit-data-source-parameters');
		obj.value = encodeURIComponent(obj.value);

		obj = $('edit-valsource');
		obj.value = encodeURIComponent(obj.value);

		obj = $('edit-valparameters');
		obj.value = encodeURIComponent(obj.value);

	}

	return(true);
}





function check_form_values_lib(aform) {

	var obj = $('edit-codepart');
	obj.value = encodeURIComponent(obj.value);

	obj = $('edit-infopart');
	obj.value = encodeURIComponent(obj.value);

}



var g_operation_option = null;


function setDeleter(op) {
	g_operation_option = op;
}

function confirm_delete() {
	if ( ( g_operation_option != null ) && ( g_operation_option == "Delete" ) ) {
		return(confirm("Are you sure you want to delete these? This operation cannot be undone."));
	} else {
		return(true);
	}
}



function rolled_oats_attach(attach_me,to_this) {
	//OAT.Dom.unlink(attach_me);
	OAT.Dom.append(to_this,attach_me);
	OAT.Dom.show(attach_me);
}





////////////
////////////    The following are called by the content applications..
////////////
var g_remoteEvals = null;
var g_remotedformObject = null;



// This is the final call back to the system.
// If the remote evaluations have all succeeded, then the form will be processed and submitted.
//
function end_of_remote_evaluations() {
	////
	if ( g_remotedformObject != null ) {
		rolled_oats_prepare_storage_format('edit-body');
		g_remotedformObject.submit();
	}
	////
}


//
//	stopping_failure...
//	This routine may be called in order to halt further checking when 
//	a particular component fails. This routine is called by the compnent...
//
//
function stopping_failure(message) {
	alert(message);
	g_remotedformObject = null;
	OAT.AJAX.abortAll();
}



function check_value_types_and_limits() {

	if ( g_remotedformObject == null ) {
		g_remotedformObject = formobj;
		remoteEvals = new Array();

		for ( obname in ENTRYFORMGROUP ) {
			var obj = ENTRYFORMGROUP[obname];
			if ( obj.remote_validation ) {
				remoteEvals.push(obj);
			} else {
				if ( (obj.check_limit != null) && !obj.check_limits(obj.element) ) {
					g_remotedformObject = null;
					return(false);
				}
			}
		}

		if ( remoteEvals.length > 0 ) {
	
			OAT.AJAX.endRef = end_of_remote_evaluations;
	
			var n = remoteEvals.length;
			for ( var i = 0; i < n; i++ ) {
				var remoter = remoteEvals[i];
				if ( remoter.method == "GET" ) {
					OAT.AJAX.GET(remoter.validation_source, true, remoter.check_limits, remoter.validator_parameters);
				} else {
					OAT.AJAX.POST(remoter.validation_source, true, remoter.check_limits, remoter.validator_parameters);
				}
			}
	
			return(false);
		}
	
		return(true);
	}

	g_remotedformObject = null;
	return(false);

} 





var g_special_app_calls = new Array();

function rolled_oats_prepare_storage_format(data_storage_field) {
	////
	var fieldsets = "";
	var sep = "";

	var apptype = $("edit-oatapptype");
	if ( apptype != null ) {
		apptype = apptype.value;
	} else {
		apptype = "custom";
	}

	for ( obname in ENTRYFORMGROUP ) {
		var obj = ENTRYFORMGROUP[obname];

		if ( ( obj != null ) && (  obj.data_representation != null ) ) {
			str = obj.data_representation(obj.element); // Get an array of strings or a single string.
			if ( str != "nothing" ) {
				fieldsets += sep + "\n" + obname + ":\t";
				sep = ",";
				var j = (str.indexOf(",]")-1);  // Just in case a badly formatted array is returned..
				if ( j > 0 ) {
					str = str.slice(0,j);
					str += "] ";
				}
				var j = (str.indexOf(", ]")-1);
				if ( j > 0 ) {
					str = str.slice(0,j);
					str += "] ";
				}
				fieldsets += str + "\t\n";
			}
		}
	}

	// The standard elements may not have a specific check available. But, the values are saved.
	if ( ( g_fetch_form_elements != null ) && ( g_fetch_form_elements.length > 0 ) ) {
		for ( obname in g_fetch_form_elements ) {
			var fobj = $(obname);
			if ( fobj != null ) {
				////
				if ( fobj.value != "nothing" ) {
					var ftype = fobj.type;
					if ( ( ftype == "checkbox" ) || ( ftype == "radio" ) ) {
						str = (( fobj.checked ) ? "true" : "false" );
					} else {
						str = rolled_oat_quoted(fobj.value);
					}
					////
					obname = obname.substring(("edit-".length));
					fieldsets += sep + "\n" + obname + ":\t";
					sep = ",";
	
					var j = (str.indexOf(",]")-1);
					if ( j > 0 ) {
						str = str.slice(0,j);
						str += "] ";
					}
					var j = (str.indexOf(", ]")-1);
					if ( j > 0 ) {
						str = str.slice(0,j);
						str += "] ";
					}
					fieldsets += str + "\t\n";
				}
			}
		}
	}

	if ( g_special_app_calls != null ) {
		var nn = g_special_app_calls.length;
		for ( var idx = 0; idx < nn; idx++ ) {
			var obj = g_special_app_calls[idx];
				////
			if ( obj.path == "from" ) {
				obname = obj.container;
				fobj = $(obj.container);
				////
				if ( fobj != null ) {
					var ftype = fobj.type;
					if ( ( ftype == "checkbox" ) || ( ftype == "radio" ) ) {
						str = (( fobj.checked ) ? "true" : "false" );
					} else {
						str = rolled_oat_quoted(fobj.value);
					}
					////
					if ( obname.indexOf("edit-") == 0 ) {
						obname = obname.substring(("edit-".length));
					}
					obname = obname.replace('-','_');
					fieldsets += sep + "\n" + obname + ":\t";
					sep = ",";
		
					var j = (str.indexOf(",]")-1);
					if ( j > 0 ) {
						str = str.slice(0,j);
						str += "] ";
					}
					var j = (str.indexOf(", ]")-1);
					if ( j > 0 ) {
						str = str.slice(0,j);
						str += "] ";
					}
					fieldsets += str + "\t\n";
					////
				}
			} else {
				fobj = $(obj.container);
				if ( fobj != null ) {
					var data = obj.gendata(fobj.type);
					fobj.value = data;
				}
			}
		}
	}

	$(data_storage_field).value = encodeURIComponent(fieldsets);

	return(true);
}



function rolled_oats_validity_and_format(formobj) {
	if ( check_value_types_and_limits(formobj) ) {
		rolled_oats_prepare_storage_format('edit-body');
		return(true);
	}
	return(false);
}


function extract_span(str,idx,quotes) {
	var pos = 0;
	var isanchor = false;
	if ( idx == 1 ) {
		pos = str.indexOf("</span>");
		if ( pos < 0 ) {
			pos = str.indexOf("</a>");
			str = str.substring(0,pos);
			isanchor = true;
		} else {
			str = str.substring(0,pos);
		}
	} else {
		pos = str.lastIndexOf("</span>");
		str = str.substring(0,pos);
	}

	var savestr = str;
	pos = str.lastIndexOf(">");
	////
/*
	if ( isanchor ) {
		savestr = str.substring(3,pos);
	}
*/

	str = str.substring(pos+1);
/*
	if ( isanchor ) {
		str += ", description: " + savestr;
	}
*/
	if ( ( quotes != null ) && ( quotes == false ) ) return(str);

	return( '\"' + str + '\" ' );
}


function is_one_of(label,tchecked) {
	var n = tchecked.length;
	for ( var i = 0; i < n; i++ ) {
		var key = tchecked[i];
		if ( label.indexOf(key) > 0 ) {
			label = extract_span(label,1,false);
			if ( label == key ) return(true);
		}
	}
	return(false);
}


function parent_included(node) {
	if ( ( node.parent == node.root.tree ) || ( !(node.parent) ) ) {
		return(true);
	} else {
		if ( node.parent.checkbox.checked ) return(true);
	}
	return(false);
}


function recheck_tree_using(data_src,a_tree) {
	var obj = $(data_src);
	if ( obj != null ) {
		var treespec = obj.value;
		if ( ( treespec.length > 0 ) && ( treespec != "empty" ) ) {
			treespec = decodeURIComponent(treespec);
			var data_objects = "";

			treespec = "data_objects = { " + treespec + " }";
			eval(treespec);

			if ( data_objects.tree != null ) {
				var tchecked = data_objects.tree;
	
				var n = tchecked.length;
				if ( n > 0 ) {
					a_tree.walk("select");
					n = a_tree.selectedNodes.length;
					for ( var i = 0; i < n; i++ ) {
						var node = a_tree.selectedNodes[i];
						var label = node.getLabel();
						if ( parent_included(node) && is_one_of(label,tchecked) ) {
							node.checkAll();
						}
					}
					a_tree.walk("updateNOI");
				}
			}
		} 
	}
}


function rolled_oat_quoted(qval) {
	return('"' + qval + '"');
}



function rolled_oat_set_edit_values(data_src,dest,data_key,is_check) {
	var obj = $(data_src);
	if ( obj != null ) {
		var dataspec = obj.value;
		////
		if ( ( dataspec.length > 0 ) && ( dataspec != "empty" ) ) {
			dataspec = decodeURIComponent(dataspec);
			var data_objects = "";
	
			dataspec = "data_objects = { " + dataspec + " }";
			eval(dataspec);
			if ( data_objects.hasOwnProperty(data_key) ) {
				var datastr = data_objects[data_key];
				if ( is_check == null ) {
					$(dest).value = datastr;
				} else {
					var ischecked = eval(datastr);
					$(dest).checked = ischecked; 
					if ( ischecked ) {
						$(dest).__checked = "1";
					} else {
						$(dest).__checked = "0";
					}
				}
			}
		}
		////
	}
}


function get_value_of(str_in,is_checked) {
	var datastr = "";
	var obj = $(str_in);
	if ( obj != null ) {
		if ( is_checked == null ) {
			datastr = obj.value;
		} else {
			datastr = "false";
			if ( obj.checked ) {
				datastr = "true";
			}
		}
	}
	return(datastr);
}


var g_activeFieldTag_prevclick = null;
var g_activeFieldTag_prevborder = null;

function select_panel_for_content(clickedobj,targetTitle) {
	//
	if ( g_activeFieldTag_prevclick != clickedobj ) {
		//
		if ( g_activeFieldTag_prevclick != null ) {
			g_activeFieldTag_prevclick.style.border = g_activeFieldTag_prevborder;
		}
		//
		g_activeFieldTag_prevborder = clickedobj.style.border;
		g_activeFieldTag_prevclick = clickedobj;
		//
		clickedobj.style.border = "solid 2px orange";

		$(targetTitle).checked = true;
	}
}



function default_initializer() {
	////
}


