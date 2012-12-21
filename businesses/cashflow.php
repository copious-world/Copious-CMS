<?php



	function cash_sources($label,$n) {
		$numlist = array();
		for ( $i = 0; $i < $n; $i++ ) {
			$numlist[$i] = 0;
		}
		return($numlist);
	}

	function expenditures($label,$n) {
		$numlist = array();
		if ( $label == "Office Space" ) {
			for ( $i = 0; $i < $n; $i++ ) {
				$numlist[$i] = 250.00;
			}
		} else if ( $label == "Equipment Lease" ) {
			for ( $i = 0; $i < $n; $i++ ) {
				$numlist[$i] = 0;
			}
			$numlist[0] = 5000.00;
		} else if ( $label == "Insurance" ) {
			for ( $i = 0; $i < $n; $i++ ) {
				$numlist[$i] = 250;
			}
		} else if ( $label == "Communication" ) {
			for ( $i = 0; $i < $n; $i++ ) {
				$numlist[$i] = 250;
			}
		} else if ( $label == "Trial Outsource" ) {
			$total = 0.0;
			for ( $i = 0; $i < $n; $i++ ) {
				$numlist[$i] = ($i+1)*350.00;
				$total += $numlist[$i];
			}
			$numlist[$i] = "total: " . $total;
		} else if ( $label == "Salary BIT" ) {
			for ( $i = 0; $i < $n; $i++ ) {
				$numlist[$i] = 7950;
			}
		} else {
			for ( $i = 0; $i < $n; $i++ ) {
				$numlist[$i] = rand(0,150);
			}
		}
		return($numlist);
	}


	$projectlength = 6;

	$numbers = array();
	$numbers['startingcash'] = array();


	$n = $projectlength + 1;
	$numbers['startingcash'][0] = 76500;

	$cashin_label = array("Cash Sales","Cash Received");
	$cashout_label = array("Office Space","Equipment Lease","Insurance","Communication","Salary BIT","General Services","Trial Outsource");
	foreach ( $cashin_label as $label ) {
		$numbers[$label] = cash_sources($label,$n);
	}
	foreach ( $cashout_label as $label ) {
		$numbers[$label] = expenditures($label,$n);
	}

	$totalcashflow = 0.0;

	for ( $i = 0; $i < $n; $i++ ) {
		$startingcache = $numbers['startingcash'][$i];
		$total = 0;
		foreach ( $cashin_label as $label ) {
			$total += $numbers[$label][$i];
		}
		$totalcashin = $total;
		$numbers['totalcashin'][$i] = $totalcashin;

		$total = 0;
		foreach ( $cashout_label as $label ) {
			$total += $numbers[$label][$i];
		}
		$totalcashout = $total;
		$numbers['totalcashout'][$i] = $totalcashout;
		$EOM = $startingcache + $totalcashin - $totalcashout;
		$numbers['eombalance'][$i] = $EOM;
		$numbers['startingcash'][$i+1] = $EOM;
		$numbers['cashflow'][$i] = $EOM - $startingcache;
		$totalcashflow += $numbers['cashflow'][$i];
	}



?>
<style type="text/css" >
.monthlabel {
	font-weight:bold;
	width:5%;
	border: 1px solid grey;
	text-align:center;
	background-color:lightgray;
	padding:3px;
}

.startingcash {
	font-weight:bolder;
	font-family:courier;
	width:5%;
	border: 1px solid darkgreen;
	text-align:right;
	background-color:white;
	color: green;
	padding:4px;
}

.cashflow {
	font-weight:bolder;
	font-family:courier;
	width:5%;
	border: 1px solid darkgreen;
	text-align:right;
	background-color:#FFFFF3;
	color: green;
	padding:4px;
}

.keyIem {
	font-weight:656;
	border: 1px solid navy;
	text-align:right;
	width:15%;
	background-color:#FFFFF9;
	text-align:right;
	padding:3px;
	color:darkred;
}

.sectionLabel {
	text-align:center;
	width:15%;
	background-color:#FFFFF3;
}


</style>

<table id="cashflow" style="width:100%;margin:2px;color:navy" cellspacing="0" >
<tr>
<td class="monthlabel" style="width:15%" >month</td>
<td class="monthlabel">0</td>
<td class="monthlabel">1</td>
<td class="monthlabel">2</td>
<td class="monthlabel">3</td>
<td class="monthlabel">4</td>
<td class="monthlabel">5</td>
<td class="monthlabel">6</td>
<td class="monthlabel">7</td>
<td class="monthlabel">8</td>
<td class="monthlabel">9</td>
<td class="monthlabel">10</td>
<td class="monthlabel">11</td>
<td class="monthlabel">12</td>
</tr>

<tr><td class="startingcash" >Starting Cash</td>
<?php	for ( $i = 0; $i < 13; $i++ ) { 	?>
				<td class="startingcash"><?php echo $numbers['startingcash'][$i]; ?></td>
<?php } ?> </tr>
<tr><td class="monthlabel sectionLabel" >Cash In</td>
<?php	for ( $i = 0; $i < 13; $i++ ) { 	?>
				<td class="monthlabel">&nbsp;</td>
<?php } ?> </tr>


<?php	foreach ( $cashin_label as $label ) {  /// Labels: CASH IN
?>
<tr><td class="keyIem" ><?php echo $label; ?></td>
<?php	for ( $i = 0; $i < 13; $i++ ) { 	?>
				<td class="cashflow"><?php echo $numbers[$label][$i]; ?></td>
<?php } ?>
</tr>
<?php } ?>


<tr><td class="cashflow " style="text-align:right;width:15%;background-color:#FFFFF3" >Total Cash In</td>
<?php	for ( $i = 0; $i < 13; $i++ ) { 	?>
				<td class="cashflow"><?php echo $numbers['totalcashin'][$i]; ?></td>
<?php } ?> </tr>


<tr><td class="monthlabel sectionLabel">Cash Out</td>
<?php	for ( $i = 0; $i < 13; $i++ ) { 	?>
				<td class="monthlabel">&nbsp;</td>
<?php } ?> </tr>


<?php	foreach ( $cashout_label as $label ) {  /// Labels: CASH OUT
?>

<tr><td class="keyIem" ><?php echo $label; ?></td>

<?php	for ( $i = 0; $i < 13; $i++ ) { 	?>
				<td class="cashflow"><?php echo $numbers[$label][$i]; ?></td>
<?php } ?>

</tr>
<?php } ?>


<tr><td class="cashflow" style="text-align:right;width:15%;background-color:#FFFFF3" >Total Cash Out</td>
<?php	for ( $i = 0; $i < 13; $i++ ) { 	?>
				<td class="cashflow"><?php echo $numbers['totalcashout'][$i]; ?></td>
<?php } ?> </tr>


<tr><td class="monthlabel" style="text-align:right;width:15%;background-color:#FFFFF3" >----</td>
<?php	for ( $i = 0; $i < 13; $i++ ) { 	?>
				<td class="monthlabel">&nbsp;</td>
<?php } ?> </tr>


<tr><td class="cashflow" style="text-align:right;width:15%;background-color:#FFFFF3" >EOM Balance</td>
<?php	for ( $i = 0; $i < 13; $i++ ) { 	?>
				<td class="cashflow"><?php echo $numbers['eombalance'][$i]; ?></td>
<?php } ?> </tr>
<tr><td class="cashflow sectionLabel" >Cash Flow</td>
<?php	for ( $i = 0; $i < 13; $i++ ) { 	?>
				<td class="cashflow "><?php echo $numbers['cashflow'][$i]; ?></td>
<?php } ?> </tr>

<tr><td class="cashflow sectionLabel" >Total Cash Flow</td>
<?php	for ( $i = 0; $i < 13; $i++ ) {
			$txt = "&nbsp;";
			if ( $i == $n ) { $txt = $totalcashflow; }
			 	?>
				<td class="cashflow "><?php echo $txt; ?></td>
<?php } ?> </tr>

</table>
