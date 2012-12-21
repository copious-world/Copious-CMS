/*
 *  $Id: dereference.js,v 1.4 2007/07/31 09:16:04 source Exp $
 *
 *  This file is part of the OpenLink Software Ajax Toolkit (OAT) project.
 *
 *  Copyright (C) 2005-2007 OpenLink Software
 *
 *  See LICENSE file for details.
 */
/*
	OAT.Dereference.go(url, callback, optObj)
*/

OAT.Dereference = {
	go:function(url,callback,optObj) {
		if (url.match(/^http/i)) { /* Virtuoso proxy: */
			var r = url.match(/^http:\/\/([^@]+@)?(.*)/);
			var user = (r[1] ? r[1].substring(0,r[1].length-1) : false);
			
			var encoded = encodeURIComponent("http://"+r[2]);
			encoded = "/proxy?url="+encoded+"&force=rdf";
			if (user) { encoded += "&login="+encodeURIComponent(user); }
		} else {
			var encoded = url;
		}
		OAT.AJAX.GET(encoded,false,callback,optObj);
	}
}
OAT.Loader.featureLoaded("dereference");
