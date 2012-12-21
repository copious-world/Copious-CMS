/*
 *  $Id: preferences.js,v 1.9 2007/05/18 12:03:38 source Exp $
 *
 *  This file is part of the OpenLink Software Ajax Toolkit (OAT) project.
 *
 *  Copyright (C) 2005-2007 OpenLink Software
 *
 *  See LICENSE file for details.
 */
OAT.Preferences = {
	showAjax:1, /* show Ajax window even if not explicitly requested by application? */
	useCursors:1, /* scrollable cursors */
	windowTypeOverride:0, /* do not guess window type */
	xsltPath:"/xslt/",
	imagePath:"/images/",
	version:"18.5.2007",
	httpError:1, /* show http errors */
	allowDefaultResize:1,
	allowDefaultDrag:1
}
OAT.Loader.featureLoaded("preferences");
