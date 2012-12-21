/*
 *  $Id: bootstrap.js,v 1.3 2007/05/21 07:10:18 source Exp $
 *
 *  This file is part of the OpenLink Software Ajax Toolkit (OAT) project.
 *
 *  Copyright (C) 2005-2007 OpenLink Software
 *
 *  See LICENSE file for details.
 */

/* handles dynamic library loading */

OAT.Loader.Dependencies = { /* dependency tree */
	ajax:"crypto",
	ajax2:"xml",
	soap:"ajax2",
	xmla:["soap","xml","connection"],
	roundwin:["drag","resize","simplefx"],
	rectwin:["drag","resize"],
	mswin:["drag","resize"],
	macwin:["drag","resize","simplefx"],
	window:["roundwin","rectwin","mswin","macwin"],
	ghostdrag:"animation",
	quickedit:"instant",
	grid:"instant",
	combolist:"instant",
	formobject:["drag","resize","datasource","tab"],
	tab:"layers",
	color:"drag",
	combobutton:"instant",
	pivot:["ghostdrag","statistics","instant","barchart"],
	combobox:"instant",
	menu:"animation",
	panelbar:"animation",
	dock:["animation","ghostdrag"],
	calendar:"drag",
	graph:"canvas",
	dav:["grid","tree","toolbar","ajax2","xml","window"],
	dialog:["window","dimmer"],
	datasource:["jsobj","json","xml","connection","dstransport","ajax2"],
	gmaps:["gapi","map"],
	ymaps:"map",
	simplefx:"animation",
	msapi:["map","layers"],
	ws:["xml","soap","ajax2","schema","connection"],
	schema:["xml"],
	timeline:["slider","tlscale","resize"],
	piechart:"svg",
	graphsvg:["svg","graphsidebar","rdf","dereference"],
	rdf:"xml",
	anchor:["window","rectwin"],
	map:["window","rectwin"],
	openlayers:["map","layers","roundwin"],
	svgsparql:["svg","ghostdrag","geometry"],
	linechart:"svg",
	sparkline:"linechart",
	webclip:"webclipbinding",
	declarative:"json",
	tree:"ghostdrag",
	rdfbrowser:["rdf","tree","dereference","anchor","rdftabs","tab","dav"],
	graphsidebar:"tree",
	form:["ajax2","dialog","datasource","formobject","crypto"],
	rssreader:"xml"
}

OAT.Loader.Files = { /* only those whose names differ */
	gmaps:"customGoogleLoader.js",
	ymaps:"customYahooLoader.js",
	openlayers:"OpenLayers.js",
	gapi:"gmapapi.js"
}

OAT.LoaderTMP = { /* second part of loader */
	dimmer:false,
	loadedLibs:[], /* libraries ready to be used */
	loadingLibs:[], /* libraries marked for inclusion */
	loadCallbacks:[], /* features & callbacks to be executed */
	
	loadFeatures:function(features,callback,marker) { /* load all these features and execute callback */
		var allNames = OAT.Loader.makeDep(features); /* dependencies */
		/* distinct values */
		var distinct = {};
		for (var i=0;i<allNames.length;i++) if (!(allNames[i] in distinct)) { distinct[allNames[i]] = 1; }
		var loadList = []; /* list of libraries needed to include */
		for (var name in distinct) { 
			var index = OAT.Loader.loadedLibs.find(name); /* detect whether lib was already included */
			if (index == -1) { loadList.push(name);	}
		}
		if (loadList.length && OAT.Dimmer && !OAT.Loader.dimmer && document.body) {
			OAT.Loader.dimmer = 1;
			document.body.appendChild(OAT.Loader.dimmerElm);
			OAT.Dimmer.show(OAT.Loader.dimmerElm);
			OAT.Dom.center(OAT.Loader.dimmerElm,1,1);
		}

		OAT.Loader.loadCallbacks.push([loadList,callback,marker]); /* all needed, not yet loaded, libs */

		var cpy = [];
		for (var i=0;i<loadList.length;i++) { cpy.push(loadList[i]); }
		for (var i=0;i<cpy.length;i++) { 
			var name = cpy[i];
			var index = OAT.Loader.loadingLibs.find(name);
			if (index == -1) { 
				var fileName = name+".js";
				if (name in OAT.Loader.Files) { fileName = OAT.Loader.Files[name]; }
				OAT.Loader.include(fileName); 
			} /* include only if not in loadingLibs list */
		}

		OAT.Loader.checkLoading();
	},
	
	featureLoaded:function(name) { /* called by libraries when they are loaded */
		OAT.Loader.loadedLibs.push(name); /* add to list of loaded */
		var index = OAT.Loader.loadingLibs.find(name); 
		OAT.Loader.loadingLibs.splice(index,1); /* remove from list of being loaded */
		for (var i=0;i<OAT.Loader.loadCallbacks.length;i++) {
			var list = OAT.Loader.loadCallbacks[i][0];
			var index = list.find(name);
			if (index != -1) { list.splice(index,1); }
		}
		OAT.Loader.checkLoading();
	},
	
	checkLoading:function() { /* check list of loaded libs against TODO list with callbacks */
		var done = []; /* indexes */
		var toExecute = [];
		var acallback = null;
		var marker = null;

////var testmarker = null;

		var n = OAT.Loader.loadCallbacks.length;
		for (var i=0;i<n;i++) { /* check all lists for completion */
			var list = OAT.Loader.loadCallbacks[i][0];
			marker =  OAT.Loader.loadCallbacks[i][2];
/*
if ( testmarker == "panel_edit" ) {
alert(n + " = " + i + " = " + marker + " = Execute: " + toExecute.length + " = " + acallback );
}
*/
			if (!list.length) { /* nothing to be loaded -> execute and mark for removal */
				acallback = OAT.Loader.loadCallbacks[i][1];
				toExecute.push(acallback);
				done.push(i);
/*if ( ( marker != null ) && (marker == "panel_edit") ) {
testmarker = marker;
alert(n + " = " + i + " = " + marker + " = Execute: " + toExecute.length + " = " + acallback );
}*/
			}
		}
/*if ( ( acallback != null ) && (testmarker == "panel_edit") ) {
alert(testmarker + " = " + toExecute.length );
}*/
		/* remove all executed */
		for (var i=done.length-1;i>=0;i--) {
			var index = done[i];
			OAT.Loader.loadCallbacks.splice(index,1);
		}
		if (!OAT.Loader.loadCallbacks.length && OAT.Loader.dimmer) { 
			OAT.Loader.dimmer = 0; 
			if (OAT.Loader.dimmerElm == OAT.Dimmer.elm) { OAT.Dimmer.hide(); }
		}


		for (var i=0;i<toExecute.length;i++) { 
			if ( ( toExecute[i] != null ) &&  ( toExecute[i] != false ) ) {
/*if ( ( acallback != null ) && (testmarker == "panel_edit") ) {
alert(testmarker + " = " + toExecute.length );

panel_edit_init();

}*/
				toExecute[i]();
			}
		}
	},
	
	startInit:function() { /* check if everything is ready */
		/* to be called when all initial libs are loaded. waits until 'onload' occurs and then continues */
		var ref = function() {
			if (!OAT.Loader.loadOccurred) { 
				setTimeout(ref,200);
				return;
			}	
			
			if (typeof(window._init) == "function") { window._init(); } /* if _init is specified, execute */
			if (OAT.Declarative) { OAT.Declarative.execute(); } /* declarative markup */
			OAT.MSG.send(OAT,OAT.MSG.OAT_LOAD,{});
			if (typeof(window.init) == "function") { window.init(); } /* pass control to userspace */
		}

		if (OAT.Loader.loadedLibs.find("window") != -1) {
			var obj = {
				1:"mswin",
				2:"macwin",
				3:"roundwin",
				4:"rectwin"
			}
			var name = obj[OAT.WindowType()];
			OAT.Loader.loadFeatures(name,ref);
		} else { ref(); } /* no window needed, let's wait for onload */
	},

	makeDep:function(features) {
		/* create list of needed libs for this featureset */
		var arr = (typeof(features) == "object" ? features : [features]);
		var result = [];
		for (var i=0;i<arr.length;i++) {
			var f = arr[i];
			if (f != "dom") { result.push(f); } /* historical remains */
			if (f in OAT.Loader.Dependencies) { /* if has dependencies */
				var value = OAT.Loader.Dependencies[f];
				var v = (typeof(value) == "object" ? value : [value]);
				for (var j=0;j<v.length;j++) {
					result.append(OAT.Loader.makeDep(v[j]));
				}
			}
		}
		return result;
	},
	
	start:function() {
		/* create dimmer element */
		OAT.Loader.dimmerElm = OAT.Dom.create("div",{border:"2px solid #000",padding:"1em",position:"absolute",backgroundColor:"#fff"});
		OAT.Loader.dimmerElm.innerHTML = "OAT Components loading...";
		/* initial set of libraries */
		var fl = (window.featureList ? window.featureList : []);
		fl.push("preferences");
		/* go */
		OAT.Loader.loadFeatures(fl,OAT.Loader.startInit);
	}
}
for (var p in OAT.LoaderTMP) { OAT.Loader[p] = OAT.LoaderTMP[p]; } /* mix to OAT.Loader  */
OAT.Loader.start();
