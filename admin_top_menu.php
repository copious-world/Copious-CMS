<?php

if ( isset($g_caller_salt) ) {

	if ( !isset($ommit_accounttype) ) {
?>
<td  style="text-align:center;width:15%">
	<a href="/hosted/accounttype/inuse.php?sess=<?php echo $sess; ?>&appdir=<?php echo $appdir; ?>&busdir=<?php echo $bus_appdir; ?>" class="buttonLike" style="text-decoration:none;color:darkgreen" target="BUSINESS_ACCOUNTS" >Accounts</a>
</td>
<?php
	}
?>
<?php
	if ( !isset($ommit_businesses) ) {
?>
<td  style="text-align:center;width:15%">
	<a href="/hosted/businesses/inuse.php?sess=<?php echo $sess; ?>&appdir=<?php echo $appdir; ?>&busdir=<?php echo $bus_appdir; ?>" class="buttonLike" style="text-decoration:none;color:darkgreen" target="BUSINESS_BUSINESS" >Businesses</a>
</td>
<?php
	}
?>
<?php
	if ( isset($include_themes) ) {
?>
<td  style="text-align:center;width:15%">
	<a href="/hosted/themes/inuse.php?sess=<?php echo $sess; ?>&appdir=<?php echo $appdir; ?>&busdir=<?php echo $bus_appdir; ?>" class="buttonLike" style="text-decoration:none;color:darkgreen" target="BUSINESS_THEMES" >Themes</a>
</td>
<?php
	}
?>
<td  style="text-align:center;width:15%">
	<a href="/hosted/taxonomy/inuse.php?sess=<?php echo $sess; ?>&appdir=taxonomy&busdir=<?php echo $bus_appdir; ?>" class="buttonLike" style="text-decoration:none;color:darkgreen" target="BUSINESS_TAXONOMY" >Taxonomy</a>
</td>
<?php
}
?>
