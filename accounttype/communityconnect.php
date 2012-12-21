<?php

	$hostaddr =  $_SERVER['SERVER_ADDR']; //"63.147.61.144";

	$userid = $_GET["diddle"];
	$sid = $_GET["sid"];
	$appdir = $_GET["appdir"];
	$browser = $_GET["browser"];

	$servicedir = $appdir;
	$appdir = "../$appdir";
	require_once("../servicename.php");
	require_once("../database.php");
	require_once("../identity.php");
	require_once("../copiousauth/userdata.php");
	require_once("../process_account_type.php");

	$statemsg = fetch_user_auth_state($userid,$SERVICE);

if ( !isset($statemsg) || strlen($statemsg) == 0 ) {

	if ( $browser == "IE" ) {

$aa = <<<LINKER
		<table border="0px" cellspacing="1px" cellpadding="2px" width="100%" ID="Table6">
			<tbody>
				<tr>
<form method="GET" action="http://$webhost/drupal?q=user/$userid&sess=$sid" target="FEATUREWIN1" >
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;" width="25%">
	<input type="submit" class="toolpanel" style="cursor:pointer;background-color:#FFFFEF;border: none;text-align:center;" value="View Profile" >
					</td>
</form>
<form method="GET" action="http://$webhost/drupal?sess=$sid&q=node/add/blog" target="FEATUREWIN2" >
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;" width="25%">
	<input type="submit" class="toolpanel" style="cursor:pointer;background-color:#FFFFEF;border: none;text-align:center;" value="Add to Blog" >
					</td>
</form>
<form method="GET" action="http://$webhost/drupal?sess=$sid&q=node/add/event" target="FEATUREWIN3" >
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;" width="25%">
	<input type="submit" class="toolpanel" style="cursor:pointer;background-color:#FFFFEF;border: none;text-align:center;" value="Events" >
					</td>
</form>
<form method="GET" action="http://$webhost/hosted/mail/commandcenter.php?diddle=$userid&sid=$sid&servicedir=$servicedir" target="FEATUREWIN4" >
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;" width="25%">
	<input type="submit" class="toolpanel" style="cursor:pointer;background-color:#FFFFEF;border: none;text-align:center;" value="Mail Center" >
					</td>
</form>
				</tr>
				<tr>
<form method="GET" action="http://$webhost/drupal?sess=$sid&q=profile" target="FEATUREWIN5" >
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;" width="25%">
	<input type="submit" class="toolpanel" style="cursor:pointer;background-color:#FFFFEF;border: none;text-align:center;" value="User Profiles" >
					</td>
</form>
<form method="GET" action="http://$webhost/drupal?sess=$sid&q=tracker" target="FEATUREWIN6" >
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;" width="25%">
	<input type="submit" class="toolpanel" style="cursor:pointer;background-color:#FFFFEF;border: none;text-align:center;" value="Recent Posts" >
					</td>
</form>
<form method="GET" action="http://$webhost/drupal?sess=$sid&q=forum" target="FEATUREWIN7" >
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;" width="25%">
	<input type="submit" class="toolpanel" style="cursor:pointer;background-color:#FFFFEF;border: none;text-align:center;" value="Member Forums" >
					</td>
</form>
<form method="GET" action="http://$webhost/drupal?sess=$sid&q=poll" target="FEATUREWIN8" >
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;" width="25%">
	<input type="submit" class="toolpanel" style="cursor:pointer;background-color:#FFFFEF;border: none;text-align:center;" value="Polling Place" >
					</td>
</form>
				</tr>
			</tbody>
		</table>
LINKER;

	} else {

$aa = <<<LINKER
<style type="text/css">
	.toolpanel {
		color: darkgreen;
		cursor:pointer;
	}
</style>
		<table border="0px" cellspacing="1px" cellpadding="2px" width="100%" ID="Table6">
			<tbody>
				<tr>
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;" width="25%">
 							<span class="toolpanel" style="cursor:pointer" onclick="javascript:wopener('http://$webhost/hosted/usersown/profiles.php?sess=$sid&focus=individuals',1)">View Profiles</span>
					</td>
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;"  width="25%">
							<span class="toolpanel" style="cursor:pointer" onclick="wopener('http://$webhost/hosted/usersown?sess=$sid',5)" >Editing Tools</span>
					</td>
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;"  width="25%">
							<span class="toolpanel" style="cursor:pointer" onclick="javascript:wopener('http://$webhost/events/month.php?sess=$sid',3)">Events</span>
					</td>
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;"  width="25%">
							<span class="toolpanel" style="cursor:pointer" onclick="javascript:wopener('http://$webhost/hosted/mail/index.php?sess=$sid',4)">Mail Center</span>
					</td>
				</tr>
				<tr>
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;"  width="25%">
							<span class="toolpanel" style="cursor:pointer" onclick="javascript:wopener('http://$webhost/hosted/usersown/profiles.php?sess=$sid&focus=groups',6)")">View Groups</span>
					</td>
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;"  width="25%">
							<span class="toolpanel" style="cursor:pointer" onclick="wopener('http://$webhost/hosted/usersown/?sess=$sid&focus=tracker',2)" >Recent Posts</span>
					</td>
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;"  width="25%">
							<span class="toolpanel" style="cursor:pointer" onclick="wopener('http://$webhost/hosted/forums/index.php?sess=$sid',7)" >Forums</span>
					</td>
					<td class="controlpanel" style="background-color:#FFFFEF;border: solid 1px darkgreen;text-align:center;"  width="25%">
							<span class="toolpanel" style="cursor:pointer" onclick="wopener('http://$webhost/hosted/polls?sess=$sid',8)" >Polling Place</span>
					</td>
				</tr>
			</tbody>
		</table>
LINKER;
	}

	$statemsg = urlencode($aa);
	$statemsg = str_replace("+"," ",$statemsg);
?>

$(spanID).innerHTML = decodeURIComponent("<?php echo $statemsg; ?>");

<?php
} else {
	$statemsg = urlencode($statemsg);
	$statemsg = str_replace("+"," ",$statemsg);
?>

$(spanID).innerHTML = decodeURIComponent("<?php echo $statemsg; ?>");

<?php
}
?>
