/*
 *  $Id: instant.js,v 1.3 2007/05/18 12:03:38 source Exp $
 *
 *  This file is part of the OpenLink Software Ajax Toolkit (OAT) project.
 *
 *  Copyright (C) 2005-2007 OpenLink Software
 *
 *  See LICENSE file for details.
 */
/*
	OAT.Instant.assign(something,callback)
*/

OAT.Instant = {
	element:false,
	
	assign:function(something,callback) {
		/* assigned -> hide it, show when elm._Instant_show() is called */
		var elm = $(something);
		elm._Instant_show = function() {
			if (!OAT.Instant.element) { /* show only when hidden */
				OAT.Instant.element = elm;
				OAT.Dom.show(elm);
				OAT.Dom.attach(document,"mousedown",OAT.Instant.check);
			}
		}
		elm._Instant_hide = function() {
			OAT.Dom.hide(this);
			OAT.Instant.element = false;
			OAT.Dom.detach(document,"mousedown",OAT.Instant.check);
		}
		elm._Instant_hide();
		elm._Instant_callback = function(){};
		if (callback) { elm._Instant_callback = callback; }
	},
	
	check:function(event) {
		/* element shown, checking where user clicked */
		var node = OAT.Dom.source(event);
		/* walk up from the clicker. if we find instant element, then user clicked on it -> do nothing */
		window.nodes = [];
		do {
			window.nodes.push(node);
			if (node == OAT.Instant.element) { return; }
			node = node.parentNode;
		} while (node != document.body && node != document);
		if (OAT.Instant.element) {
			OAT.Instant.element._Instant_callback();
			OAT.Instant.element._Instant_hide();
		}
	}
}
OAT.Loader.featureLoaded("instant");
