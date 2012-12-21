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
	<td class="businessName"  onclick="set_business('$name');loginopener();" >$name</td><td class="businessURL"><span style="font-weight:bold;color:gray;" >$srvurl</span></td>
</tr>
EOBOBJ;
	} else {
$txt =<<<EOBOBJ
<tr>
	<td class="businessName" onclick="set_business('$name');loginopener();" >$name</td><td class="businessURL"><a href="http://$srvurl" target="_target" >$srvurl</a></td>
</tr>
EOBOBJ;
	}
	
	$output .= $txt;
	$output .= "\n";
}

?>
<script language="javascript" >
function set_business(bname) {
	gServiceBase = bname;
}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
	<td class="businessName" style="background-color:#F7F7FA;border-bottom:solid 1px navy">Business Names</td><td class="businessURL" style="background-color:#F7F7FA;border-bottom:solid 1px navy" >URL</td>
</tr>
<?php echo $output; ?>
</table>
