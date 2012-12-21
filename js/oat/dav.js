/*
 *  $Id: dav.js,v 1.10 2007/05/18 12:03:38 source Exp $
 *
 *  This file is part of the OpenLink Software Ajax Toolkit (OAT) project.
 *
 *  Copyright (C) 2005-2007 OpenLink Software
 *
 *  See LICENSE file for details.
 */
/*
	OAT.WebDav.init(optObj)
	OAT.WebDav.openDialog(optObj)
	OAT.WebDav.saveDialog(optObj)
*/

OAT.WebDav = {
	cache:{}, /* visited directories and their content */
	window:false, /* window object */
	dom:{}, /* shortcuts to various dom elements: path, file, ext, ok, cancel */
	options: { /* defaults */
		user:'',
		pass:'',
		path:'/DAV/', /* where are we now */
		file:'', /* preselected filename */
		extension:false, /* preselected extension */
		pathFallback:'/DAV/', /* what to offer when dirchange fails */
		width:760,
		height:450,
		imagePath:'/DAV/JS/images/',
		imageExt:'png',
		confirmOverwrite:true,
		isDav:true,
		extensionFilters:[], /* ['id','ext','my extension description','content type'],... */
		callback:function(path,file,content){}, /* what to do after selection */
		dataCallback:function(file,extID){return "";} /* data provider for saving. when false, nothing is saved */
	},
	displayMode:0, /* details / icons */
	mode:0, /* open / save */
	
/* basic api */
	
	openDialog:function(optObj) { /* open in browse file mode */
		this.dom.ok.value = "Open";
		this.mode = 0;
		this.commonDialog(optObj);
		OAT.Dom.hide("dav_permissions");
	},
	
	saveDialog:function(optObj) { /* open in save file mode */
		this.dom.ok.value = "Save";
		this.mode = 1;
		this.commonDialog(optObj);
		
		var state = [1,1,0,1,0,0,1,0,0];
		this.dom.perms[2].disabled = true;
		this.dom.perms[5].disabled = true;
		this.dom.perms[8].disabled = true;
		for (var i=0;i<9;i++) {
			this.dom.perms[i].checked = (state[i] == 1);
		}
	},
	
/* standard methods */

	openDirectory:function(newDir,treeOnly) { /* try to open a path */
		var dir = newDir;
		if (dir.substring(newDir.length-1) != "/") { dir += "/"; } /* add trailing slash */
		
		var error = function(xhr) {
			var p = prompt("Cannot change directory to "+dir+".\n Please specify other directory.",OAT.WebDav.options.pathFallback);
			if (!p) { return; }
			OAT.WebDav.openDirectory(p);
		} /* error callback */
		
		var callback = function() {
			if (treeOnly) { return; }
			OAT.WebDav.options.path = dir;
			OAT.WebDav.redraw();
		}
		if (dir in this.cache) {
			callback();
		} else {
			this.requestDirectory(dir,callback,error);
		}
	},
	
	useFile:function(_path,_file) { /* finish */	
		if (_path || _file) {
			var p = _path;
			var f = _file;
		} else {
			var p = this.options.path;
			var f = this.dom.file.value;
		}

		var item = this.fileExists(f);
		if (item && item.dir) {
			this.openDirectory(p+f);
			return;
		}
		
		if (this.mode == 0) { /* open */
			var path = p + f;
			var error = function(xhr) {
				var desc = OAT.WebDav.genericError(xhr,path);
				alert('Error while trying to open file.\n'+desc);
			}
			var url = path + '?'+ new Date().getMilliseconds();
			var o = {
				auth:OAT.AJAX.AUTH_BASIC,
				user:this.options.user,
				password:this.options.pass,
				type:OAT.AJAX.TYPE_TEXT,
				onerror:error
			}
			var response = function(data) {
				OAT.Dom.hide(OAT.WebDav.window.div);
				if (OAT.WebDav.options.callback) { OAT.WebDav.options.callback(p,f,data); }
			}
			OAT.AJAX.GET(url,false,response,o);
		}
		
		if (this.mode == 1) { /* save */
			var id = false;
			if (this.options.isDav) {
				var ext = this.options.extensionFilters[this.dom.ext.selectedIndex];
				if (!(f.match(/\./)) && ext[1] != "*") { f += "."+ext[1]; } /* add extension */

				/* does the file exist? */
				var c = true;
				if (this.options.confirmOverwrite && this.fileExists(f)) {
					var c = confirm('Do you want to replace existing file?');
				}
				if (!c) { return; }
				id = ext[0];
			}
			
			/* ready to save */
			var response = function() {
				if (OAT.WebDav.options.isDav) { OAT.WebDav.updatePermissions(p+f); }
				OAT.Dom.hide(OAT.WebDav.window.div);
				if (OAT.WebDav.options.callback) { OAT.WebDav.options.callback(p,f); }
			}

			if (!this.options.dataCallback) {
				response();
				return; 
			}
			var data = this.options.dataCallback(f,id);
			var error = function(xhr) {
				var desc = OAT.WebDav.genericError(xhr,p+f);
				alert('Error while trying to save file.\n'+desc);
			}
			var o = {
				auth:OAT.AJAX.AUTH_BASIC,
				user:this.options.user,
				password:this.options.pass,
				type:OAT.AJAX.TYPE_TEXT,
				onerror:error
			}
			var r = f.match(/\.([^\.]+)$/); /* content type */
			if (r) { /* has extension */
				var ext = r[1];
				for (var i=0;i<this.options.extensionFilters.length;i++) {
					var filter = this.options.extensionFilters[i];
					if (filter[1] == ext && filter.length == 4) { o.headers = {"Content-Type":filter[3]}; }
				}
			}
			OAT.AJAX.PUT(p+f,data,response,o);
		} /* save */
	},

	createDirectory:function(newDir) { /* create new directory */
		if (this.fileExists(newDir)) {
			alert("An item with name '"+newDir+"' already exists!");
			return;
		}
		var url = this.options.path+newDir;
		var error = function(xhr) {
			var desc = OAT.WebDav.genericError(xhr,newDir);
			alert('Error while creating new directory.\n'+desc);
		}
		var o = {
			auth:OAT.AJAX.AUTH_BASIC,
			user:OAT.WebDav.options.user,
			password:OAT.WebDav.options.pass,
			type:OAT.AJAX.TYPE_TEXT,
			onerror:error
		}
		var callback = function() {
			delete OAT.WebDav.cache[OAT.WebDav.options.path];
			OAT.WebDav.openDirectory(OAT.WebDav.options.path); /* refresh current */
		}
		OAT.AJAX.MKCOL(url,null,callback,o);
	},

	init:function(optObj) { /* to be called once. draw window etc */
		this.applyOptions(optObj);
		if (OAT.Preferences.windowTypeOverride == 2 || OAT.Browser.isMac) {
			this.options.width += 16;
		}
		/* create window */
		var wopts = {
			min:0,
			max:0,
			close:1,
			width:this.options.width,
			height:this.options.height,
			imagePath:this.options.imagePath,
			title:"WebDAV Browser"
		}
		this.window = new OAT.Window(wopts);
		var div = this.window.div;
		var content = OAT.Dom.create("div",{paddingLeft:"2px",paddingRight:"5px"});
		
		this.window.content.appendChild(content);
		div.style.zIndex = 1001;
		div.id = "dav_browser";
		this.window.onclose = function() { OAT.Dom.hide(div); }
		OAT.Dom.hide(div);
		document.body.appendChild(div);
		/* create toolbar */
		var toolbarDiv = OAT.Dom.create("div");
		var toolbar = new OAT.Toolbar(toolbarDiv);
		toolbar.addIcon(0,this.options.imagePath+"Dav_new_folder.gif","Create New Folder",function() {
			var nd = prompt('Create new folder','New Folder');
			if (!nd) { return; }
			OAT.WebDav.createDirectory(nd);
		});
		toolbar.addSeparator();
		toolbar.addIcon(0,this.options.imagePath+"Dav_view_details.gif","Details",function(){
			OAT.WebDav.displayMode = 0;
			OAT.WebDav.redraw();
		});
		toolbar.addIcon(0,this.options.imagePath+"Dav_view_icons.gif","Icons",function(){
			OAT.WebDav.displayMode = 1;
			OAT.WebDav.redraw();
		});
		toolbar.addSeparator();
		toolbar.addIcon(0,this.options.imagePath+"Dav_up.gif","Up one level",function(){
			var nd = OAT.WebDav.options.path.match(/^(.*\/)[^\/]+\//);
			OAT.WebDav.openDirectory(nd[1]);
		});


		/* path */
		var path = OAT.Dom.create('div');
		path.id = "dav_path";
		var input = OAT.Dom.create("input");
		input.size = 60;
		input.type = "text";
		this.dom.path = input;
		var go = OAT.Dom.create("img",{verticalAlign:"middle",cursor:"pointer"});
		go.src = this.options.imagePath+"Dav_go.gif";
		this.dom.go = go;
		OAT.Dom.append([path,OAT.Dom.text('Location: '),input,go]);
		/* main part */
		var h1 = (this.options.height-165)+"px";
		var h2 = (this.options.height-167)+"px";
		var main = OAT.Dom.create('div',{height:h1,position:"relative"});
		main.id = 'dav_main';

		var main_tree = OAT.Dom.create('div',{overflow:"auto",height:h2});
		var main_splitter = OAT.Dom.create('div',{height:"100%"});
		var main_right = OAT.Dom.create('div',{height:"100%",overflow:"auto"});
		var main_content = OAT.Dom.create('div',{height:"100%"});
		main_tree.id = 'dav_tree';
		main_splitter.id = 'dav_splitter';
		main_right.id = 'dav_right';
		main_content.id = 'dav_right_content';
		OAT.Dom.append([main,main_tree,main_splitter,main_right],[main_right,main_content]);

		/* resizing */
		var restrict = function(x,y) { return (x < 25); }
		OAT.Drag.create(main_splitter,main_splitter,{type:OAT.Drag.TYPE_X,restrictionFunction:restrict});
		OAT.Drag.create(main_splitter,main_right,{type:OAT.Drag.TYPE_X}); 
		OAT.Resize.create(main_splitter,main_tree,OAT.Resize.TYPE_X,restrict);
		OAT.Resize.create(main_splitter,main_right,-OAT.Resize.TYPE_X,restrict);
		OAT.Resize.create(main_splitter,main_content,-OAT.Resize.TYPE_X,restrict);
		OAT.Resize.create(this.window.resize,main,OAT.Resize.TYPE_Y);
		OAT.Resize.create(this.window.resize,main_tree,OAT.Resize.TYPE_Y);
		OAT.Resize.create(this.window.resize,main_right,OAT.Resize.TYPE_X);
		OAT.Resize.create(this.window.resize,main_content,OAT.Resize.TYPE_X);
		
		if (OAT.Browser.isIE && document.compatMode == "BackCompat") {
			main_right.style.height = h1;
			OAT.Resize.create(this.window.resize,main_right,OAT.Resize.TYPE_Y);
		}
		
		this.window.resize.style.cursor = "nw-resize";
		this.dom.content = main_content;

		/* bottom part */
		var bottom = OAT.Dom.create('div');
		bottom.id = "dav_bottom";

		this.dom.ok = OAT.Dom.button('OK');
		this.dom.cancel = OAT.Dom.button('Cancel');
		
		this.dom.file = OAT.Dom.create("input");
		this.dom.file.type = "text";
		this.dom.ext = OAT.Dom.create("select");
		
		var label_1 = OAT.Dom.text("File name: ");
		var label_2 = OAT.Dom.text("File type: ");

		var line_1 = OAT.Dom.create("div");
		var line_2 = OAT.Dom.create("div");

		OAT.Dom.append([line_1,label_1,this.dom.file,this.dom.ok]);
		OAT.Dom.append([line_2,label_2,this.dom.ext,this.dom.cancel]);
		
		/* permissions */
		this.initPermissions(bottom);
		OAT.Dom.append([bottom,line_1,line_2]);
		OAT.Dom.append([content,toolbarDiv,path,main,bottom]);
		
		/* tree */
		this.tree = new OAT.Tree({onClick:false,ascendSelection:false});
		var ul = OAT.Dom.create("ul",{whiteSpace:"nowrap"});
		main_tree.appendChild(ul);
		this.tree.assign(ul,true);
		this.treeSyncDir("/DAV/","/DAV");

		this.attachEvents();
	},
	
	initPermissions:function(parentDiv) { /* draw the permissions table */
		var x = '<table id="dav_permissions"><tbody>'+
				'<tr><td colspan="3">Owner</td><td colspan="3">Group</td><td colspan="3">Others</td></tr>'+
				'<tr><td>R</td><td>W</td><td>X</td><td>R</td><td>W</td><td>X</td><td>R</td><td>W</td><td>X</td></tr>'+
				'<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>'+
				'</tbody></table>';
		var d = OAT.Dom.create("div",{cssFloat:"left",styleFloat:"left"});
		d.innerHTML = x;
		var row = d.getElementsByTagName("tr")[2];
		var tds = row.getElementsByTagName("td");
		this.dom.perms = [];
		for (var i=0;i<tds.length;i++) {
			var td = tds[i];
			var ch = OAT.Dom.create("input");
			this.dom.perms.push(ch);
			ch.type="checkbox";
			td.appendChild(ch);
		}
		parentDiv.appendChild(d);
	},
	
	requestDirectory:function(directory,callback,error) { /* send ajax request */
		/* send a request */
		var data = "";
		data += '<?xml version="1.0" encoding="utf-8" ?>' +
				'<propfind xmlns="DAV:"><prop>' +
				'	<creationdate/><getlastmodified/><href/>' +
				'	<resourcetype/><getcontentlength/><getcontenttype/>' +
				'	<virtpermissions xmlns="http://www.openlinksw.com/virtuoso/webdav/1.0/"/>' + 
				'	<virtowneruid xmlns="http://www.openlinksw.com/virtuoso/webdav/1.0/"/>' + 
				'	<virtownergid xmlns="http://www.openlinksw.com/virtuoso/webdav/1.0/"/>' + 
				' </prop></propfind>';
		var o = {
			headers:{Depth:1},
			auth:OAT.AJAX.AUTH_BASIC,
			user:OAT.WebDav.options.user,
			password:OAT.WebDav.options.pass,
			type:OAT.AJAX.TYPE_XML,
			onerror:error
		}
		
		var ref = function(data) {
			OAT.WebDav.parse(directory,data); /* add to cache */
			OAT.WebDav.treeSyncDir(directory); /* sync with tree */
			if (OAT.Browser.isIE) {
				var x = $("dav_bottom");
				var p = x.parentNode;
				OAT.Dom.unlink(x);
				p.appendChild(x);
			}
			callback();
		}
		OAT.AJAX.PROPFIND(escape(directory),data,ref,o);	
	},
	
	parse:function(directory,xml) { /* parse dav response: update tree, add data to cache */
		var items = [];
		var data = xml.documentElement;
		for (var i=0;i<data.childNodes.length;i++) {
			var node = data.childNodes[i];
			if (node.nodeType != 1) { continue; }
			var item = OAT.WebDav.parseNode(node);
			if (item.fullName != directory) { items.push(item); }
		}
		
		var arr = [];
		for (var i=0;i<items.length;i++){
			var item = items[i];
			if (item.dir) { 
				arr.push(item); 
				this.treeSyncDir(item.fullName);
			} /* dirs first */
		}
		for (var i=0;i<items.length;i++){
			var item = items[i];
			if (!item.dir) { arr.push(item); } /* files next */
		}
		OAT.WebDav.cache[directory] = arr; /* add to cache */
	},
	
	redraw:function() { /* redraw view */
		/* this.options.path MUST be in this.cache in this phase */
		this.dom.path.value = this.options.path;
		this.treeOpenCurrent();
		var list = this.cache[this.options.path];

		OAT.Dom.clear(this.dom.content);
		function attachClick(elm,item,arr) {
			OAT.Dom.attach(elm,"click",function() {
				OAT.WebDav.dom.file.value = item.name;
				if (!arr) { return; }
				for (var i=0;i<arr.length;i++) {
					var e = arr[i];
					OAT.Dom.removeClass(e,"dav_item_selected");
				}
				OAT.Dom.addClass(elm,"dav_item_selected");
			});
		}
		function attachDblClick(elm,item) {
			OAT.Dom.attach(elm,"dblclick",function() {
				if (item.dir) {
					OAT.WebDav.openDirectory(OAT.WebDav.options.path+item.name);
				} else {
					OAT.WebDav.useFile();
				}
			});
		}
		
		if (this.displayMode == 0) { /* details */
			var content = this.dom.content;
			var g = new OAT.Grid(content,0);
			g.imagePath = this.options.imagePath;
			var header = ["Name",{value:"Size",align:OAT.GridData.ALIGN_RIGHT},"Modified","Type","Owner","Group","Perms"];
			g.createHeader(header);
			var numRows = -1;
			var mask = "rwxrwxrwx";
			
			for (var i=0;i<list.length;i++) {
				var item = list[i];
				if (!item.dir && !this.checkExtension(item.name)) { continue; }
				var ico_type = (item.dir ? 'node-collapsed' : 'leaf');
				var ico = this.imagePathHtml(ico_type) + "&nbsp;" + item.name;
				var date = new Date(item.modificationDate);
				var p = "";
				for (var j=0;j<9;j++) {
					p += (item.permissions.charAt(j) == "1" ? mask.charAt(j) : "-");
				}
				var row = [
					ico,
					{value:item.length,align:OAT.GridData.ALIGN_RIGHT},
					date.format("Y-m-d H:i"),
					item.type,
					item.uid,
					item.gid,
					p
				]
				g.createRow(row);
				numRows++;
				attachClick(g.rows[numRows].html,item);
				attachDblClick(g.rows[numRows].html,item);
			}
		}
		
		if (this.displayMode == 1) { /* icons */
			var content = this.dom.content;
			var cubez = [];
			for (var i=0;i<list.length;i++) {
				var item = list[i];
				if (!item.dir && !this.checkExtension(item.name)) { continue; }
				var ico_type = (item.dir ? 'folder' : 'file');
				var src = this.options.imagePath+"Dav_"+ico_type+"."+this.options.imageExt;
				var srcB = this.options.imagePath+"Blank.gif";
				var ico = OAT.Dom.image(src,srcB,32,32);
				var cube = OAT.Dom.create('div',{},"dav_item");
				OAT.Dom.append([cube,ico,OAT.Dom.create("br"),OAT.Dom.text(item.name)],[content,cube]);
				content.appendChild(cube);
				attachClick(cube,item,cubez);
				attachDblClick(cube,item);
				cubez.push(cube);
			}
		}
	},
	
/* supplementary routines */
	
	treeOpenCurrent:function() { /* open & expand current path */
		var p = this.options.path;
		var parts = p.split("/");
		if (parts[0] == "") { parts.shift(); }
		if (parts[parts.length-1] == "") { parts.pop(); }
		
		var ptr = 0;
		var node = this.tree.tree;
		var currentPath = "/";

		while (ptr < parts.length) { /* walk through whole path */
			currentPath += parts[ptr] + "/";
			var index = -1;
			for (var i=0;i<node.children.length;i++) { /* find child */
				var child = node.children[i];
				if (child.path == currentPath) { index = i; }
			}
			ptr++; 
			node = node.children[index];
			node.expand(true);
		}
		node.toggleSelect({ctrlKey:false});
	},

	treeSyncDir:function(path) { /* sync tree structure with this directory */
		var parts = path.split("/");
		if (parts[0] == "") { parts.shift(); }
		if (parts[parts.length-1] == "") { parts.pop(); }
		
		var ptr = 0;
		var node = this.tree.tree;
		var currentPath = "/";
		
		function attach(node,path) {
			OAT.Dom.attach(node._gdElm,"click",function(){
				OAT.WebDav.openDirectory(path);
			});
		}
		
		while (ptr < parts.length) { /* walk through whole path */
			currentPath += parts[ptr] + "/";
			var index = -1;
			for (var i=0;i<node.children.length;i++) { /* find child */
				var child = node.children[i];
				if (child.path == currentPath) { index = i; }
			}
			if (index == -1) { /* if not yet in tree -> append */
				var label = parts[ptr];
				var newNode = node.createChild(parts[ptr],true);
				index = node.children.length-1;
				newNode.path = currentPath;
				newNode.collapse();
				attach(newNode,currentPath);   
			}
			ptr++; 
			node = node.children[index];
		}
		this.tree.walk("sync");
	},

	checkExtension:function(f) {
		var active = this.options.extensionFilters[this.dom.ext.selectedIndex];
		var ext = active[1];
		if (ext == "*") { return true;}
		var r = f.match(/\.([^\.]+)$/);
		if (r && r.length == 2 && r[1].toLowerCase() == ext) { return true; }
		return false;
	},

	fileExists:function(f) { /* does the file exist in current directory? */
		var list = this.cache[this.options.path];
		if (!list) { return false; }
		for (var i=0;i<list.length;i++) {
			var item = list[i];
			if (item.name == f) { return item; }
		}
		return false;
	},

	genericError:function(xhr,url) { /* generic error code explanation */
		var status = xhr.getStatus();
		var text = xhr.getResponseText();
		var msg = "";
		if (status == 404) {
			msg = 'HTTP/'+status+': Not found. The requested URL '+url+' was not found on this server.';
		} else if (status == 401){
			msg = 'HTTP/'+status+': Forbidden. You have no access to URL '+url+'.';
		}else{
			msg = 'HTTP/'+status+': '+text+'.';
		}
		return msg;
	},
	
	attachEvents:function() { /* attach events to dom nodes */
		OAT.Dom.attach(this.dom.path,"keypress",function(event) {
			if (event.keyCode != 13) { return; }
			var p = OAT.WebDav.dom.path.value;
			OAT.WebDav.openDirectory(p);
		});
		OAT.Dom.attach(this.dom.go,"click",function(event) {
			var p = OAT.WebDav.dom.path.value;
			OAT.WebDav.openDirectory(p);
		});
		OAT.Dom.attach(this.dom.file,"keypress",function(event) {
			if (event.keyCode != 13) { return; }
			OAT.WebDav.useFile();
		});
		OAT.Dom.attach(this.dom.ok,"click",function(event) {
			if (!OAT.WebDav.dom.file.value) { return; }
			OAT.WebDav.useFile();
		});
		OAT.Dom.attach(this.dom.cancel,"click",function(event) {
			OAT.Dom.hide(OAT.WebDav.window.div);
		});
		OAT.Dom.attach(this.dom.ext,"change",function(event) {
			OAT.WebDav.redraw();
		});
		
		OAT.MSG.attach(this.tree,OAT.MSG.TREE_EXPAND,function(tree,msg,node) {
			var path = node.path;
			OAT.WebDav.openDirectory(path,true);
		});
	},

	parseNode:function(node) { /* parse one response node */
		var result = {
			length:"",
			type:"",
			dir:false,
			creationDate:"",
			modificationDate:"",
			name:"",
			fullName:"",
			permissions:"",
			uid:"",
			gid:""
		};
		var propstat = OAT.Xml.getElementsByLocalName(node,"propstat")[0]; /* first propstat contains http/200 */
		var prop = OAT.Xml.getElementsByLocalName(propstat,"prop")[0]; /* this contains successfull properties */
		
		/* dir */
		var col = OAT.Xml.getElementsByLocalName(prop,"collection");
		if (col.length) { result.dir = true; }
		
		/* name */
		var href = OAT.Xml.getElementsByLocalName(node,"href")[0];
		result.fullName = OAT.Xml.textValue(href);
		result.fullName = unescape(result.fullName);
		result.name = result.fullName.match(/([^\/]+)\/?$/)[1];

		/* dates */
		var tmp = OAT.Xml.getElementsByLocalName(prop,"creationdate"); 
		if (tmp.length) { result.creationDate = OAT.Xml.textValue(tmp[0]); }
		var tmp = OAT.Xml.getElementsByLocalName(prop,"getlastmodified"); 
		if (tmp.length) { result.modificationDate = OAT.Xml.textValue(tmp[0]); }
		
		/* perms, uid, gid */
		var tmp = OAT.Xml.getElementsByLocalName(prop,"virtpermissions"); 
		if (tmp.length) { result.permissions = OAT.Xml.textValue(tmp[0]); }
		var tmp = OAT.Xml.getElementsByLocalName(prop,"virtowneruid"); 
		if (tmp.length) { result.uid = OAT.Xml.textValue(tmp[0]); }
		var tmp = OAT.Xml.getElementsByLocalName(prop,"virtownergid"); 
		if (tmp.length) { result.gid = OAT.Xml.textValue(tmp[0]); }

		/* type & length */
		var tmp = OAT.Xml.getElementsByLocalName(prop,"getcontenttype"); 
		if (tmp.length) { result.type = OAT.Xml.textValue(tmp[0]); }
		var tmp = OAT.Xml.getElementsByLocalName(prop,"getcontentlength"); 
		if (tmp.length) { result.length = parseInt(OAT.Xml.textValue(tmp[0])).toSize(); }
		
		return result;
	},
	
	applyOptions:function(optObj) { /* inherit options */
		for (var p in optObj) { this.options[p] = optObj[p]; }
	},
	
	commonDialog:function(optObj) { /* common phase for both dialog types */
		this.applyOptions(optObj);
		var allContained = false;
		for (var i=0;i<this.options.extensionFilters.length;i++) {
			var filter = this.options.extensionFilters[i];
			if (filter[1] == "*") { allContained = true; }
		}
		if (!allContained) { /* add *.* filter */
			var f = ["*","*","All files"];
			this.options.extensionFilters.push(f);
		}
		
		if (!this.options.isDav) { /* siiiimple mode */
			var info = "Please choose a file name.";
			var f = [];
			for (var i=0;i<this.options.extensionFilters.length;i++) {
				var filter = this.options.extensionFilters[i];
				if (filter[1] != "*") { f.push("*."+filter[1]); }
			}
			if (f.length) { info += "\nAvailable extensions: "+f.join(", "); }
			var file = prompt(info,this.options.path+this.options.file);
			if (!file) { return; }
			var r = file.match(/^(.*)([^\/]+)$/);
			this.useFile(r[1],r[2]);
			return;
		}
		
		OAT.Dom.show(this.window.div);
		OAT.Dom.center(this.window.div,1,1);
		OAT.Dom.show("dav_permissions");
		this.dom.file.value = this.options.file; /* preselected file name */
		
		OAT.Dom.clear(this.dom.ext); /* extension select */
		this.dom.ext.style.width = "";
		var index = 0;
		for (var i=0;i<this.options.extensionFilters.length;i++) {
			var f = this.options.extensionFilters[i];
			var label = f[2] + " (*." + f[1] + ")";
			OAT.Dom.option(label,f[0],this.dom.ext);
			if (f[0] == this.options.extension) { index = i; }
		}
		this.dom.ext.selectedIndex = index;
		var w = OAT.Dom.getWH(this.dom.ext)[0]+2;
		this.dom.ext.style.width = (w+4)+"px";
		this.dom.file.style.width = w+"px";
		
		this.dom.ok.style.width = "";
		this.dom.cancel.style.width = "";
		var w1 = OAT.Dom.getWH(this.dom.ok)[0];
		var w2 = OAT.Dom.getWH(this.dom.cancel)[0];
		var w = Math.max(w1,w2)+2;
		this.dom.ok.style.width = w+"px";
		this.dom.cancel.style.width = w+"px";

		if (this.options.path in this.cache) {
			delete this.cache[this.options.path];
		}
		this.openDirectory(this.options.path);
		
	},

	imagePathHtml:function(name) { /* get html code for image */
		var style = "width:16px;height:16px;";
		var path = this.options.imagePath+"Tree_"+name+"."+this.options.imageExt;
		if (OAT.Browser.isIE && this.options.imageExt.toLowerCase() == "png") {
			style += "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+path+"', sizingMethod='crop')";
			path = this.options.imagePath+"Blank.gif";
		}
		return '<img src="'+path+'" style="'+style+'" />';
	},

	updatePermissions:function(url) {
		var newPermissions = "";
		for (var i=0;i<this.dom.perms.length;i++) {
			var ch = this.dom.perms[i];
			newPermissions += (ch.checked ? "1" : "0");
		}
		var data = "";
		data += '<?xml version="1.0" encoding="utf-8" ?>' +
				'<propfind xmlns="DAV:"><prop>' +
				'	<virtpermissions xmlns="http://www.openlinksw.com/virtuoso/webdav/1.0/"/>' + 
				' </prop></propfind>';
		var o = {
			headers:{Depth:1},
			auth:OAT.AJAX.AUTH_BASIC,
			user:OAT.WebDav.options.user,
			password:OAT.WebDav.options.pass,
			type:OAT.AJAX.TYPE_XML
		}
		var ref = function(xmlDoc) {
			/* extract existing, apply new */
			var pnode = OAT.Xml.getElementsByLocalName(xmlDoc.documentElement,"virtpermissions")[0];
			var perms = OAT.Xml.textValue(pnode);
			var end = perms.substring(perms.length-2);
			newPermissions += end;
			var patch = "";
			patch += '<?xml version="1.0" encoding="utf-8" ?>' + 
					'<D:propertyupdate xmlns:D="DAV:"><D:set><D:prop>'+
					'<virtpermissions xmlns="http://www.openlinksw.com/virtuoso/webdav/1.0/">'+newPermissions+'</virtpermissions>' +
					'</D:prop></D:set></D:propertyupdate>';
			OAT.AJAX.PROPPATCH(escape(url),patch,function(){},o);
		}
		OAT.AJAX.PROPFIND(escape(url),data,ref,o);	
	},
	
/* backward compatibility */	

	open:function(opts) {
		var o = {};
		if ("user" in opts) { o.user = opts.user; }
		if ("pass" in opts) { o.pass = opts.pass; }
		if ("pathDefault" in opts) { o.path = opts.pathDefault; }
		if ("imagePath" in opts) { o.imagePath = opts.imagePath; }
		if ("imageExt" in opts) { o.imageExt = opts.imageExt; }
		if ("dontDisplayWarning" in opts) { o.confirmOverwrite = !opts.dontDisplayWarning; }
		if ("onConfirmClick" in opts) { o.callback = opts.onConfirmClick; }
		if ("filetypes" in opts) {
			var f = [];
			for (var i=0;i<opts.filetypes.length;i++) {
				var ft = opts.filetypes[i];
				var filter = [ft.ext,ft.ext,ft.label];
				f.push(filter);
			}
			o.extensionFilters = f;
		}
		
		if (opts.mode == 'open_dialog' || opts.mode == 'browser') {
			OAT.WebDav.openDialog(o);
		} else {
			o.dataCallback = o.callback;
			o.callback = opts.afterSave;
			OAT.WebDav.saveDialog(o);
		}
	},

	getFileName:function(user,pass,path,oEF,button,callback) {
		var o = {
			user:user,
			pass:pass,
			path:path,
			callback:callback
		}
		OAT.WebDav.openDialog(o);
	},
	
	getFile:function(user,pass,path,oEF,button,callback) {
		var o = {
			user:user,
			pass:pass,
			path:path,
			callback:callback
		}
		OAT.WebDav.openDialog(o);
	},
	
	saveFile:function(user,pass,path,content,ui,callback) {
		var dataCallback = function() {
			return content;
		}
		var o = {
			user:user,
			pass:pass,
			path:path,
			confirmOverwrite:(ui == false),
			dataCallback:dataCallback,
			callback:callback
		}
		OAT.WebDav.saveDialog(o);
	}
}

OAT.Dav = { /* legacy backwards compatibility! */

	getFile:function(dir,file) { /* no dav prompt */
		var ld = (dir ? dir : ".");
		var lf = (file ? ld+"/"+file : ld+"/");
		return prompt("Choose a file name",lf);
	},

	getNewFile:function(dir,file,filters) { /* no dav prompt */
		var ld = (dir ? dir : ".");
		var str = (file ? dir+"/"+file : dir+"/");
		return prompt("Choose a file name",str);
	}
}

OAT.Loader.featureLoaded("dav");
