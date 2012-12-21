<?php

	$serviceid = $_POST['serviceid'];


	function single_approval_row($approval) {
		$output = "";

		$output .= "<td class='approvalUser check' >";
		$output .= "<input name='accepteduser' type='checkbox' on value='$approval->uid,$approval->id'>";
		$output .= "</td>";

		$output .= "<td class='approvalUser' onclick='approve_user_for_acctype($approval->uname,$approval->uid,$approval->id,$approval->name)'>";
		$output .= $approval->uname; // Account user name
		$output .= "</td>";
		
		$output .= "<td class='approvalUser' onclick='approve_user_for_acctype($approval->uname,$approval->uid,$approval->id,$approval->name)'>";
		$output .= $approval->name; // Account name
		$output .= "</td>";

		$output .= "<td class='approvalPrice'>";
		$output .= $approval->price;
		$output .= "</td>";

		$output .= "<td class='approvalReasons'>";
		$output .= $approval->POSTDATA;
		$output .= "</td>";

		return($output);
	}


	$description = urlencode($description);
	$needs_form = $needs_form == "on" ? 1 : 0;

	$qq = "select u.name as uname, ac.id, ac.name, aus.uid, aus.POSTDATA, aus.price from accounttypes ac INNER JOIN authspecials aus INNER JOIN users u ON ( (aus.account_type_id = ac.id) AND ( u.id = aus.uid ) ) where ( ac.serviceid = '$serviceid' ) AND (aus.needs_approval = 1) ORDER BY ac.typename";
	$approval_list = db_query_objec_list($qq);

	$output = "";
	foreach ( $approval_list as $approval ) {
		$output = "<tr>";
		$output .= single_approval_row($approval);
		$output = "</tr>\n";
	}

?>

<form method="POST" action="approveAccountTypeApps.php" >
<table class="userApprovalTable">
<?php echo $output; ?>
</table>
<input type="hidden" name="serviceid"  value="<? echo $serviceid; ?>" >
</form>
