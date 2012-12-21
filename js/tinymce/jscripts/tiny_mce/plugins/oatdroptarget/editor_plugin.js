/**
 * $Id: editor_plugin_src.js 201 2007-02-12 15:56:56Z spocke $
 *
 * @author Richard Leddy @ Copious Systems
 * @copyright Copyright � 2004-2007, Copious Systems, All rights reserved.
 */

/* Import plugin specific language pack */
tinyMCE.importPluginLanguagePack('oatdroptarget');

var TinyMCE_InsertOatDropTargetPlugin = {

	next_id: 0,

	find_next_drop_id : function(inst) {
					var b = inst.getBody();
					///
					var i = 0;
					while ( i < 10 ) {
						var pos = b.innerHTML.indexOf('oat_drop_container' + i);
						if ( pos <= 0 ) { break; }
						i++;
					}
					return(i);
				},

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
			case "oattarget":
				return tinyMCE.getButtonHTML(cn, 'lang_oat_target_desc', '{$pluginurl}/images/droptarget.gif', 'mceInsertOATTarget');
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
				return("");
			}

			var next_id = TinyMCE_InsertOatDropTargetPlugin.next_id;


			if ( next_id == 0 ) {
				var inst = tinyMCE.getInstanceById(editor_id);
				next_id = TinyMCE_InsertOatDropTargetPlugin.find_next_drop_id(inst);
			}

			TinyMCE_InsertOatDropTargetPlugin.next_id = next_id + 1;

			var imgurl = (tinyMCE.baseURL + '/plugins/oatdroptarget/images/target.gif');
			var txt = "<a id='oat_drop_container" + next_id + "' ><img src='" + imgurl + "' title='needs drop definition'></a>";

			return(txt);
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

tinyMCE.addPlugin("oatdroptarget", TinyMCE_InsertOatDropTargetPlugin);



