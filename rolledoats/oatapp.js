// Most of this has to do with the editing of the content type.


function comp_name_display(compname) {

	var dispname = compname.replace("_1d0t3_",".");
	return(dispname);

}



var g_drag_source_components = null;

function delete_this_line(obj) {
	if ( confirm("Delete this field, " + obj.innerHTML + "?") ) {
		var cnm = obj.innerHTML;
		var p = obj.parentNode;
		OAT.Dom.unlink(obj);
		var str = p.innerHTML;

		str = str.replace("<br><br>","<br>");
		p.innerHTML = str;

		while ( (p != null) && !p.hasOwnProperty('tnode') ) {
			p = p.parentNode;
		}
		if ( p != null ) {
			var tnode = p.tnode;
			var list = tnode.oat_fields;
			if ( list.hasOwnProperty(cnm) ) {
				tnode.oat_fields = removePropety(list,cnm);
				list = null;
				remove_field_from_details_grid(cnm,tnode);
			}
		}
	}
}


function add_component_to_node(compname,tnode) {

	if ( !tnode.hasOwnProperty('oat_fields') )  {
		tnode['oat_fields'] = new Object();
	}

	var oats = tnode.oat_fields;
	if ( oats.hasOwnProperty(compname) ) {
		return;
	}

	var lister = tnode.getLabel();

	if ( lister.indexOf("&lt;root") > 0 ) {
		if ( lister.indexOf( "</div>") < 0 ) {
			lister += '<br><div style="border:solid navy 1px;font-weight:bold;color:darkred;background-color:#FEFEDD" >';
			lister += '<span style="background-color:white;border:1px solid navy;color:black;font-weight:plain;font-size:0.75em">Fields Included:</span><br>';
			lister += '</div>';
		}
	}

	var displaycomp = comp_name_display(compname);
	var tmp = "<span style='cursor:pointer;border-bottom:1px solid navy;' onclick='delete_this_line(this)' >" + displaycomp + "</span><br>";
	lister = lister.replace("</div>",tmp + "</div>");
	tnode.setLabel(lister);

	oats[compname] = tnode._label;
	tnode._label['tnode'] = tnode;

}



var g_existing_field_names = {};

function get_name_for_field(compname) {

	var keepgoing = true;
	while ( keepgoing ) {
		var fname = prompt("Enter a name for this field:");

		var n = fname.length - 2;

		if ( n > 0 ) {
			var j =  fname.indexOf(".")
			if ( j > 0 ) {
				var fname_array = fname.split(".");
				fname = fname_array[0] + "_1d0t3_"; // as unlikely as possible...
				fname += fname_array[1];
			}
		}

		var okform = eval("/^[a-z]+[a-z0-9_]{" + n + ",24}$/i.test(fname)");

		if ( (fname.length > 0) && okform ) {
			if ( g_existing_field_names.hasOwnProperty(fname) ) {
				keepgoing = confirm("This name is taken. Would you like to another name?");
			} else {
				g_existing_field_names[fname] = compname;
				return(fname + ":" + compname);
			}
		} else {
			keepgoing = confirm("This name cannot be used as a field. Would you like to another name?");
		} 
	}

	return("");
}


function add_component(compname) {

	var fieldname = get_name_for_field(compname);
	if ( fieldname.length == 0 ) return;

	var tree = OATCOMPONENT.tree.element;

	var n = tree.checkedNOI.length;
	for ( var i = 0; i < n; i++ ) {
		var tnode = tree.checkedNOI[i];
		add_component_to_node(fieldname,tnode);
		add_to_field_details_grid(fieldname,tnode);
	}
}

var g_vocabulary_id = 3;
var g_stored_grid_backup = null;

function store_grid_just_because(grid) {
	g_stored_grid_backup = grid;
}


function add_to_field_details_grid(fieldname,tnode) {
	var term = tnode.getLabel();
	term = extract_span(term,1,false);

	// get DB info and create a field
	// OATCOMPONENT.field_details_0.element.createRow(dataarray);
	// var grid = OATCOMPONENT.field_details_0.element;
	try {
		var parts = fieldname.split(":");
	
		var fieldname = parts[0];
		var oatname = parts[1];

		var dataarray = [oatname,fieldname, term,
			"<span class=\"littlebutton\" onclick=\"edit_parameters(" + g_vocabulary_id + ",'" + oatname + "','" + fieldname + "','" + term + "')\" >override</span>",
			"<span class=\"littlebutton\" onclick=\"edit_parameters(" + g_vocabulary_id + ",'" + oatname + "','" + fieldname + "','" + term + "')\" >edit</span>"
		];

		var griddata = get_initial_field_details();
		griddata.push(dataarray);

		g_stored_grid_backup.createRow(dataarray);
		g_stored_grid_backup.sort(2,OAT.GridData.SORT_ASC);

	} catch (e) {
		alert(e.message);
	}

}


var g_field_details_to_delete = new Array();


/*
alert( t_oatname + "== " + oatname + " && " + fieldname + "== " + t_fieldname + " && " + term  + "== " + t_term );
*/



function remove_field_from_details_grid(cnm,tnode) {
	var parts = cnm.split(":");
	var fieldname = parts[0];
	var oatname = parts[1];

	var term = tnode.getLabel();
	term = extract_span(term,1,false);

	var rows = g_stored_grid_backup.rows;
	var n = rows.length;

	for ( var i = 0; i < n; i++ ) {
		var row = rows[i];
		var t_oatname = row.cells[0].value.innerHTML;
		var t_fieldname = row.cells[1].value.innerHTML;
		var t_term = row.cells[2].value.innerHTML;

		if ( (t_oatname == oatname) && (fieldname == t_fieldname) && (term == t_term) ) {
			//
			var griddata = get_initial_field_details();
			var m = griddata.length;
			for ( var j = 0; j < m; j++ ) {
				var row = griddata[j];
				var t_oatname = row[0];
				var t_fieldname = row[1];
				var t_term = row[2];

				if ( (t_oatname == oatname) && (fieldname == t_fieldname) && (term == t_term) ) {
					griddata.splice(j,1);
					break;
				}
			}
			var fielddetail = fieldname + "_" + term;
			g_field_details_info[fielddetail] = null;

			g_field_details_to_delete.push(fielddetail);

			reset_initial_field_details(griddata);

			g_stored_grid_backup.clearData();
			n = griddata.length;
			for ( var k = 0; k < n; k++ ) {
				var datarow = griddata[k];
				g_stored_grid_backup.createRow(datarow);
			}

			g_stored_grid_backup.sort(2,OAT.GridData.SORT_ASC);
			//
			break;
		}
	}


}




function array_of_oat_fields( tnode ) {
	var listput = "[";

	if ( tnode.hasOwnProperty('oat_fields') ) {
		var sep = "";
		for ( pp in tnode.oat_fields ) {
			listput += sep + " " + '\"' + pp + '\"';
			sep = ",";
		}
	}
	listput += "]";
	return(listput);
}




function extract_data(a_tree) {

	var output = "";
	a_tree.walk("select");
	n = a_tree.selectedNodes.length;
	var sep = "";
	for ( var i = 0; i < n; i++ ) {
		var node = a_tree.selectedNodes[i];
		var label = node.getLabel();
		var termfield = extract_span(label,1,false);

		if ( termfield == "&lt;root&gt;" ) {
			termfield = "tree_root";
		}
		output += ( sep + " " + termfield + ": " + array_of_oat_fields( node ) );
		sep = ",";
	}

	return(output);
}




function reload_tree_values_using(data_src,a_tree) {
	var obj = $(data_src);
	if ( obj != null ) {
		var treespec = obj.value;
		if ( ( treespec.length > 0 ) && ( treespec != "empty" ) ) {
			treespec = decodeURIComponent(treespec);
			treespec = eliminate_plus(treespec);
			var data_objects = "";

			treespec = "data_objects = " + treespec;
			eval(treespec);

			a_tree.walk("select");
			n = a_tree.selectedNodes.length;

			if ( n > 0 ) {
				for ( var i = 0; i < n; i++ ) {
					var tnode = a_tree.selectedNodes[i];
					var label = tnode.getLabel();

					var termfield = extract_span(label,1,false);
					if ( termfield == "&lt;root&gt;" ) {
						termfield = "tree_root";
					}
					if ( data_objects.hasOwnProperty(termfield) ) {
						var elarray = data_objects[termfield];
						var m = elarray.length;
						for ( var j = 0; j < m; j++ ) {
							compname = elarray[j];
							add_component_to_node(compname,tnode);
						}
					}
				}
			}
		}
	}
}












/////////==============================================================
/////////==============================================================

var g_details_mode = "";
var g_current_field = null;


function edit_parameters(vid,field_type_id,field_name,term) {
	var obj = $("details_id_field");
	if ( obj != null ) {
		obj.innerHTML = field_name + " : " + term;
	}

	var params = field_name + "_" + term;
	g_current_field = params;
	
	if ( g_field_details_info.hasOwnProperty(params) ) {
		var details = g_field_details_info[params];
		var obj = $("oat_field_details");
		if ( obj != null ) {
			obj.value = details.parameters;
		}
	}

	g_details_mode = "params";

}


function edit_substitutions(vid,field_type_id,field_name,term) {
	var obj = $("details_id_field");
	if ( obj != null ) {
		obj.innerHTML = field_name + " : " + term;
	}
	var params = field_name + "_" + term;
	g_current_field = params;
	
	if ( g_field_details_info.hasOwnProperty(params) ) {
		var details = g_field_details_info[params];
		var obj = $("oat_field_details");
		if ( obj != null ) {
			obj.value = details.substitutions;
		}
	}
	g_details_mode = "subst";
}




function clean_dollar_symbol(str) {
	var n = str.length;
	var output = "";
	var cprev = "";
	for ( var i = 0; i < n; i++ ) {
		var c = str[i];
		if ( ( c == "$" ) && ( cprev != "\\" ) ) {
			output += "\\";
		}
		output += c;
		cprev = c;
	}

	return(output);
}




function localstore_field_data() {
	if ( g_current_field != null ) {
		if ( g_field_details_info.hasOwnProperty(g_current_field) ) {
			var details = g_field_details_info[g_current_field];
			var obj = $("oat_field_details");
			if ( obj != null ) {
				if ( g_details_mode == "subst" ) {
					var str = obj.value;
					details.substitutions = clean_dollar_symbol(str);
				} else {
					var str = obj.value;
					details.parameters = clean_dollar_symbol(str);
				} 
			}
		}
	}
}



function oat_details_to_deep_string() {
// Grid Data is an array of application data.
	var str = "array(";

	var sep = "";
	for ( fielddetail in g_field_details_info ) {
		var detail = g_field_details_info[fielddetail];
		if ( detail != null ) {
			str += sep + "\n " + fielddetail + " => array(\n";
			str += "\t\tparameters => \"" + detail.parameters + "\",";
			str += "\t\tsubstitutions => \"" + detail.substitutions + "\" ";
			str += ")";
			sep = ",";
		}
	}
	str += ");";

	return(str);
}




function clear_edit_fields() {

	var obj = $("oat_field_details");
	if ( obj != null ) {
		obj.value = "";
	}

}


function get_initial_field_details() {
	////
	if ( g_field_details_table != null ) {
		g_initial_field_state = object_clone(g_field_details_info);
		return(g_field_details_table);
	}
	return('["a","b","c","d","e"]');
}


function reset_initial_field_details(griddata) {
	g_field_details_table = griddata;
}





var prevClick = null;

function checkboxAction(clicker,actor,act_id) {
	var obj = clicker;
	var cc = obj.style.color;

	if ( prevClick != null ) {
		prevClick.style.color = "darkred";
	}

	if ( obj == prevClick ) { prevClick = null; }
	else { prevClick = obj; }

	if ( cc != "navy" ) {
		obj.style.color = "navy";
	} else {
		obj.style.color = "darkred";
	}

	var t = OATCOMPONENT.tree.element;

	if ( ( prevClick != null ) && ( act_id >= 0 ) ) {
		var pobj = $("click_is_parent");
		pobj.innerHTML = actor;
		//$(""show_taxo_childen"").innerHTML = actdata.innerHTML;
		$("parent-taxonomy").value = act_id;
	}
}


function content_click_to_taxo(clicker,termname,vid,tid) {
	var fldname = "edit-taxonomy-tags-" + vid;
	var taxoterms = $(fldname);

	if ( taxoterms != null ) {
		var current_terms = taxoterms.value;

		var ii = current_terms.indexOf(termname);
		if ( ii > -1 ) {
			if ( (ii == 0 ) || ( ( current_terms[ii-1] != ' ' )  && ( current_terms[ii-1] != ',') ) ) {
				var nl = ii + termname.length;
				if (nl < current_terms.length ) {
					if ( ( current_terms[nl+1] == "," ) || ( current_terms[nl+1] == " " ) ) {	
						checkboxAction(clicker,termname,tid);
						return;
					}
				}
			}
		}

		if ( current_terms.length > 0 ) current_terms += ",";
		current_terms += termname;

		taxoterms.value = current_terms;

		checkboxAction(clicker,termname,tid);
	}
}



