<?php

global $form_type;

if ( !isset($form_type) ) {
	$form_type = "creator";
}

$actype = $acc->name;

$QQ = "SELECT id,name,vid FROM content_types WHERE LOCATE('$actype,',accounttypes) > 0";
$acytpelist = db_query_object($QQ);

$output = "";
foreach ( $acytpelist AS $content ) {

$outlist =<<<EOFENTRY
<tr>
<td class="sys_td buttonLike" onclick="fetch_content_type_classifier('$content->name',$content->vid);" >
<span class="buttonLike" >$content->name</span>
</td>
</tr>

EOFENTRY;

$output .= $outlist;

}

?>

<form method="GET" action="<?php echo $form_type; ?>_form.php" onnsumbit="open_submitter_window(this)" target="<?php echo $form_type; ?>_submitter_iframe" >
<input type="hidden" name="sess" value="<?php echo $sess; ?>" >
<input type="hidden" name="busapp" value="<?php echo $busapp_dir; ?>" >
<input type="hidden" name="content_type_name" value="<?php echo $content->name; ?>" >
<input type="hidden" name="content_type_id" value="<?php echo $content->id; ?>" >
<input type="hidden" name="form_table" value="<?php echo $form_type; ?>_forms" >

<table class='sys_table' >
<tr>
<td width="50%" >
<table class='sys_table'>
<?php echo $output; ?>
</table>
<td>
<td width="50%" >
<div class="sys_describe" >
When the tree appears click on the leaf that classifies the object you are intending to create.
</div>
<div id="content_type_tree" >
select type here
</div>
</td>
</tr>
</table>
</form>
