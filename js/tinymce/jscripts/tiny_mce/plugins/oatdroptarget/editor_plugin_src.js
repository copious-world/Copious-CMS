/**
 * $Id: editor_plugin_src.js 201 2007-02-12 15:56:56Z spocke $
 *
 * @author Richard Leddy @ Copious Systems
 * @copyright Copyright � 2004-2007, Copious Systems, All rights reserved.
 */

/* Import plugin specific language pack */
tinyMCE.importPluginLanguagePack('oatdroptarget');

var TinyMCE_InsertDateTimePlugin = {
	getInfo : function() {
		return {
			longname : 'Insert OAT drop target',
			author : 'Copious Systems',
			authorurl : 'http://www.opensource-copious.com',
			infourl : 'http://www.opensource-copious.com',
			version : tinyMCE.majorVersion + "." + tinyMCE.minorVersion
		};
	},

	/**
	 * Returns the HTML contents of the insertdate, inserttime controls.
	 */
	getControlHTML : function(cn) {
		switch (cn) {
			case "insertoattarget":
				return tinyMCE.getButtonHTML(cn, 'lang_insertdate_desc', '{$pluginurl}/images/droptarget.gif', 'mceInsertOATTarget');
		}

		return "";
	},

	/**
	 * Executes the mceInsertDate command.
	 */
	execCommand : function(editor_id, element, command, user_interface, value) {
		/* Adds zeros infront of value */
		
		function add_drop_target() {
			if ( OAT == null ) {
				alert("The OAT library needs to be included for this Plugin to Work");
			} else {
				alert("HOORAY");
			}
		}

		// Handle commands
		switch (command) {
			case "mceInsertOATTarget":
				tinyMCE.execInstanceCommand(editor_id, 'mceInsertContent', false, add_drop_target());
				return true;
		}

		// Pass to next handler in chain
		return false;
	}
};

tinyMCE.addPlugin("oatdroptarget", TinyMCE_InsertDateTimePlugin);
