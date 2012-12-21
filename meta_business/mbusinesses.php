<?php


include '../servicename.php';

try {
	include '../database.php';
} catch (Exception $e) {
	echo 'Caught exception: ' .  $e->getMessage();
}
/*
*/
global $db_connection;


$QQ = "select * from serivcesource";
$bobjects = db_query_object_list($QQ);


$output = "";
foreach ( $bobjects as $bobj ) {
	$srvurl = $bobj->serviceurl;
	$name = $bobj->servicename;
	if ( $srvurl == "TBD" ) {
$txt =<<<EOBOBJ
<tr>
	<td class="businessName"  onclick="set_business('$name');loginopener();" >$name</td><td class="businessURL"><span style="font-weight:bold;color:gray;" >$srvurl</span></td><td style="width:10%" ><input type="checkbox" name="DELETES[$name]" ></td>
</tr>
EOBOBJ;
	} else {
$txt =<<<EOBOBJ
<tr>
	<td class="businessName" onclick="set_business('$name');loginopener();" >$name</td><td class="businessURL"><a href="http://$srvurl" target="_target" >$srvurl</a></td><td style="width:10%" ><input type="checkbox" name="DELETES[$name]" ></td>
</tr>
EOBOBJ;
	}

	$output .= $txt;
	$output .= "\n";
}

?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
	<td class="businessName businessHeader" >Business Names</td><td class="businessURL businessHeader" >URL</td><td class="businessURL businessHeader" style="width:10%" >Delete</td>
</tr>
<?php echo $output; ?>
</table>
