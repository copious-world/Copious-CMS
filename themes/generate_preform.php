<?php

/// --------------->


$content_type = $_GET['content_type'];
$classifiers = $_GET['classifiers'];

$classifiers_symbol = str_replace(",","_",$classifiers_symbol);
$articulation = "FORMGEN_" . $content_type . $classifiers_symbol;



$text = $_GET['text_with_symbols'];
$symbollist = $_GET['symbols'];

$symbollist = urldecode($symbollist);
$symbollist = json_decode($symbollist);


// Just fetch the default TinyMCE settings from this list.
$default_tinymce_settings = file_get_contents("default_tiny_mce.txt");



$outout = array();
$output["quickedits"] = "";
$output["html"] = urldecode($text);;
$output["custom_oats"] = ""

$replacers = array();

$n_optionals = 0;
foreach( $symbollist as $symbol ) {

	$symbol_print = $symbol->name;
	$replacers[$symbol_print] = "";

	$replacers[$symbol_print] = "";

$prepend =<<<EOEXPLAINSTART
<div style="sys_preform_instructions">
EOEXPLAINSTART

	if ( $symbol->optional_display ) {
		$n_optionals++;
		
$prepend =<<<EOSELECTOR
<input type="checkbox" id="preform_checkbox_sel_$n_optionals" name="display[$symbol_print]" @checked_$n_optionals  value=" " >

EOSELECTOR;

		$replacers[$symbol_print] .= $prepend;
	}

	$replacers[$symbol_print] .= $symbol->instructions;

$replacers[$symbol_print] .=<<<EOEXPLAINEND 
</div>

EOEXPLAINEND;


	$replacer_type  = $symbol->replacer_type;
	switch ( $replacer_type ) {
		case "WYZYTEXT": {
	
$object_text =<<<EOFOBJTEXT
<div class="sys_preform_textarea_container"  style="overflow:auto" >
<textarea id="$symbol_print" name="$symbol_print" style="width:100%;">
@$symbol_print
</textarea>
</div>
EOFOBJTEXT;
	
	
			break;
		}
		case "INPLACE": {
	
$single_edit =<<<EOFQEDIT
		OAT.QuickEdit.assign("$varname",OAT.QuickEdit.STRING,[]);

EOFQEDIT;
	$output["quickedits"] .= $single_edit;
	
	$specific_style = $symbol->wyzzy_editor_style; // Read from the style tag set in the editor.\
	$tag = $symbol->user_supplied_tag;
	
$object_text =<<<EOFOBJTEXT
<$tag id="$varname" style="$specific_style">
@$varname
</$tag> 
EOFOBJTEXT;
	
			break;
		}
		case "ROAR_PLACEMENT": {
			$output["custom_oats"] .= "\n";
			$output["custom_oats"] .= $symbol->java_script;  /// Details predetermined in client and calling service..
			$output["custom_oats"] .= "\n";
	
			$object_texts = $symbol->instance_html;
	
			break;
		}

	}

	$replacers[$symbol_print] .= $object_text;

}



/// Form the final text to be returned as a preform... (To be used as a generator for themed forms.)

foreach ( $replacers as $symbolkey => $symbolvalue ) {
	$output["html"] = str_replace($symbolkey,$symbolvalue,$output["html"]);
}




?>

<script language="javascript" >

INFOGROUP.<?php echo $articulation; ?>_form = {
	needs:["quickedit"],
	wind: null,
	save_width: 0,
	app_action: null,
	cb:function() {
<?php echo $output["quickedits"]; ?>
	}
}


<?php echo $output["custom_oats"]; ?>


g_theme_tinyMCE_settings = 
{
	mode : "exact",
	elements : "thm_topic1_1",
<?php echo $default_tinymce_settings; ?>
	convert_on_click : true,
	relat2ive_urls : false,
	rem2ove_script_host : false
}


n_optional_view_sections = <?php echo $n_optionals; ?>;

</script>
<!-- required for text areas using tinyMCE -->
<input id="element_entries" name="element_entries" type="hidden" value="thm_topic1_1">
<input id="theme_dir" name="theme_dir" type="hidden" value="basic">
@area_display_states

<?php echo $output["html"]; ?>
