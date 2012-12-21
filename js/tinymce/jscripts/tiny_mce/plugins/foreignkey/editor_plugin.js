/**
 * $Id: editor_plugin_src.js 201 2007-02-12 15:56:56Z spocke $
 *
 * @author Copious Systems
 * @copyright Copyright � 2004-2008, Copious Systems, All rights reserved.
 */

/* Import plugin specific language pack */
tinyMCE.importPluginLanguagePack('foreignkey');

var TinyMCE_KeyboardVariantPlugin = {
	getInfo : function() {
		return {
			longname : 'Foreign Keyboards',
			author : 'Copious Systems',
			authorurl : 'http://www.opensource-copious.org',
			infourl : 'http://www.opensource-copious.org/downloads/TinyMCE/foreignkeys',
			version : tinyMCE.majorVersion + "." + tinyMCE.minorVersion
		};
	},

	getControlHTML : function(cn) {
		switch (cn) {
			case "foreignkeys":

				var keyboardLanguages = "<option value='fkb_default'>--Foreign Keybords--</option>";
				var langList = g_all_languages_keyboards;
				for ( lang in langList ) {
					var array_name = langList[lang];
					keyboardLanguages += "<option value='" + array_name + "'>" + lang + "</option>";
				}

				return '<select id="{$editor_id}_styleSelect" name="{$editor_id}_foreignKeys" onfocus="tinyMCE.addSelectAccessibility(event,this,window);" onchange="tinyMCE.execInstanceCommand(\'{$editor_id}\',\'mceSetKeyBoardVariant\',false,this.options[this.selectedIndex].value);" class="mceSelectList">' + keyboardLanguages + '</select>';
		}

		return "";
	},

	execCommand : function(editor_id, element, command, user_interface, value) {
		var e, inst;

		// Handle commands
		switch (command) {

			case "mceSetKeyBoardVariant": {
				///   BUG... ALL TINY MCE == inst = tinyMCE.getInstanceById(editor_id);
				///
				if ( value == 'fkb_default' ) {
					tinyMCE.setKeyTransformer(false);
				} else if ( value == 'fkb_English' ) {
					tinyMCE.setKeyTransformer(false);
				}  else {
					var kb_array = eval(value);
					tinyMCE.setKeyTransformer(kb_array);
				}
				return true;
			}

		}

		// Pass to next handler in chain
		return false;
	},

	handleNodeChange : function(editor_id, node, undo_index, undo_levels, visual_aid, any_selection) {
	},

	// Private plugin specific methods
};

tinyMCE.addPlugin("foreignkey", TinyMCE_KeyboardVariantPlugin);
