/*
 *  $Id: panelbar.js,v 1.6 2007/05/18 12:03:38 source Exp $
 *
 *  This file is part of the OpenLink Software Ajax Toolkit (OAT) project.
 *
 *  Copyright (C) 2005-2007 OpenLink Software
 *
 *  See LICENSE file for details.
 */
/*
	var pb = new OAT.Panelbar(div,fadeDelay) ( 0 == no fade )
	pb.addPanel(clickerDiv,contentDiv)
	pb.go(0);
	
	CSS: .panelbar, .panelbar_option, .panelbar_option_selected, .panelbar_option_upper, .panelbar_option_lower, .panelbar_content
*/

OAT.Panelbar = function(div,delay,panelops) {
	var obj = this;
	this.div = $(div);
	OAT.Dom.addClass(this.div,"panelbar");
	this.selectedIndex = -1;
	this.panels = [];
	this.delay = delay;
	this.panel_limit = true;
	this.class_prefix = "panelbar_";
	if ( panelops != null ) {
		if ( panelops.panel_limit != null ) {
			this.panel_limit = panelops.panel_limit;
		}
		if ( panelops.class_prefix != null ) this.class_prefix = panelops.class_prefix;
	}

	this.go = function(index) {
		for (var i=0;i<obj.panels.length;i++) {
			obj.panels[i].clicker.className = this.class_prefix + "option " +
								(i <= index ? (this.class_prefix + "option_upper") : (this.class_prefix + "option_lower") );
			if ( !( obj.panels[i].opened ) || this.panel_limit ) { OAT.Dom.hide(obj.panels[i].content); }
			if (obj.delay && this.panel_limit) { OAT.Style.opacity(obj.panels[i].content,0); }
		}
		if ( !( obj.panels[index].opened ) || this.panel_limit ) {
			obj.panels[index].clicker.className += " " + this.class_prefix + "option_selected";
			OAT.Dom.show(obj.panels[index].content);
			obj.panels[index].opened = true;
		} else {
			obj.panels[index].opened = false;
			OAT.Dom.hide(obj.panels[index].content);
		}
		if (obj.delay && this.panel_limit) {
			var a = new OAT.AnimationOpacity(obj.panels[index].content,{delay:obj.delay,opacity:1});
			a.start();
		}
		if ( this.panel_limit ) obj.selectedIndex = index;
	}
	
	this.addPanel = function(clickerDiv,contentDiv) {
		var clicker_elm = $(clickerDiv);
		var content_elm = $(contentDiv);
		clicker_elm.className = this.class_prefix + "option";
		content_elm.className = this.class_prefix + "content";
		var callback = function(event) {
			var index = -1;
			for (var i=0;i<obj.panels.length;i++) if (obj.panels[i].clicker == clicker_elm) { index = i; }
			if (index == obj.selectedIndex) { return; }
			obj.go(index);
		}
		OAT.Dom.attach(clicker_elm,"click",callback);
		this.panels.push({ clicker: clicker_elm, content: content_elm, opened: true});
		this.div.appendChild(clicker_elm);
		this.div.appendChild(content_elm);
		this.go(this.panels.length-1);
	}
	
	
}
OAT.Loader.featureLoaded("panelbar");
