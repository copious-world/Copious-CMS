<?php

//Included file... uses environment of includer


	global $content_type_display_kind;
	global $button_class;

	if ( !isset($button_class) ) {
		$button_class = "buttonLike";
	}

	global $cts_call_count;

	if ( !isset($cts_call_count) ) {
		$cts_call_count = 0;
	}
	$cts_call_count++;

	global $type_list;
	$type_list = null;

	global $vocabrenderop;
	if ( !isset($vocabrenderop) ) {
		$vocabrenderop = "pick_vocabulary";
	}
	global $RW;
	if ( !isset($RW) ) {
		$RW = "";
	}

	global $content_focus;
	if ( !isset($content_focus) ) {
		$content_focus = NULL;
	}



	function get_content_types($showdefault,$entity,$content_focus = NULL) {
		global $type_list;

		switch_db_connection("taxonomy");

		$typelist = array();
		if ( $showdefault ) {
			$typelist['empty'] = '--select a content type--';
		}

		$QQ = "SELECT name,vid FROM content_type WHERE ( entity_symbol = '$entity' )";
		if ( $content_focus != NULL ) {
			$QQ .= " AND ( name = '$content_focus' )";
		}

		$tlist = db_query_object_list($QQ);
		$ttile_list = array();
		foreach ( $tlist as $ctype ) {
			$ttile_list[$ctype->name] = ucfirst($ctype->name);
		}

		$typelist = array_merge($typelist,$ttile_list);

		switch_db_connection("copious");
		$type_list = $tlist;

		return($typelist);
	}
	$typeid = 6;

	$content_types = get_content_types(($content_type_display_kind == "options"),$bus_appdir,$content_focus);
///
	switch ( $content_type_display_kind ) {
		case "options": {
			$lister = "<option value='@type'>@display_type</option>\n";
			break;
		}
		case "pushbutton": {
			$lister = "<tr><td class='sys_td'><input id='content_type_button_@i' type='submit' value='@type' class='$button_class' ></td></tr>\n";
			break;
		}
	}

	$output = "";
	$i = 0;
	foreach ( $content_types as $typename => $displaystr ) {
		$txt = str_replace("@type",$typename,$lister);
		$txt = str_replace("@display_type",$displaystr,$txt);
		$i++;
		$txt = str_replace("@i",$cts_call_count . "_" . $i,$txt);
		$output .= $txt;
	}

	echo $output;

	unset($button_class);

	$followons = array("pushbutton");

	if ( ( $i > 0 ) && ( in_array($content_type_display_kind,$followons ) ) ) {

		$n = $i;
?>
<script language="javascript" >

INFOGROUP.content_type_buttons<?php echo $cts_call_count ;?> = {
	needs:["window"],
	wind: null,
	save_width: 0,
	dontOpen: false,
	app_action: null,
	cb:function() {
<?php
		$i = 0;
		foreach ( $type_list as $typeobj ) {
			$i++;
			$typename = $typeobj->name;
			$typeid = $typeobj->vid;
?>
		OAT.Dom.attach($("<?php echo "content_type_button_" . $cts_call_count . "_" . $i ;?>"),
			"click", function() {
<?php
				if ( !isset($pick_action) ) {
?>
				<?php echo $vocabrenderop ;?>("<?php echo $typename ;?>","<?php echo $typeid ;?>","<?php echo "content_type_area$cts_call_count"; ;?>","<?php echo $RW ;?>");
<?php
				} else {
$pick_action = str_replace("@content_type_id",$typeid,$pick_action);
$pick_action = str_replace("@content_type",$typename,$pick_action);

$output =<<<EOPICKACTION
					$pick_action;
EOPICKACTION;
					echo $output;
				}
?>
			});
<?php
		}
?>
	}
};

</script>

<?php
	} else {
?>

	<span class="consideration" >You will need to assign some taxonomies to content types before access rules can be made. </span>

<?php
	}
?>
