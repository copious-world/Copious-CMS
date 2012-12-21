<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<style type="text/css" media="screen"><!--

		#q1 {
			border: 1px gray solid;
			width:500px;
			text-align: justify;
			padding:10px;
			visibility: visible;
			top: 0px;
			left: 0px;
		}

		.qpart {
			border: 1px gray solid;
			width:500px;
			text-align: justify;
			padding:10px;
			visibility: hidden;
			position: absolute;
			top: 0px;
			left: 0px;
		}

 --></style>

<?php

	$db_connect = 0;
	$db_connection = 0;
	$db_select = 0;
	
	if ( isset($_GET['servicedir']) ) {
		$servicedir = $_GET['servicedir'];
		require_once($servicedir . "/" . 'servicename.php');
	} else {
		require_once "../servicename.php";
	}
	require_once('params_current.php');
	require_once('../database.php');

	//	//
	$nu_symbolname = $_POST['nu_symbolname'];
	//
	$nu_firstname = $_POST['nu_firstname'];
	$nu_lastname = $_POST['nu_lastname'];
	$nu_postal = $_POST['nu_postal'];
	//
	$nu_city = $_POST['nu_city'];
	$nu_state = $_POST['nu_state'];
	$nu_country = $_POST['nu_country'];
	$nu_zcode = $_POST['nu_zcode'];

	$nu_phone_country_code = $_POST['nu_phone_country_code'];
	$nu_phone_area_code = $_POST['nu_phone_area_code'];
	$nu_phone_primary = $_POST['nu_phone_primary'];
	$nu_phone_secondary = $_POST['nu_phone_secondary'];

	$nu_email = $_POST['nu_email'];


?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $SERVICE; ?> new user step 2</title>
</head>
<script language="javascript" src="../docjax.js"></script>
<script language="javascript" type="text/javascript" src="../browserid.js"></script>
<script language="javascript" type="text/javascript" src="../jsresources.js"></script>
<script language="javascript" >

var spanID = "";
//////////////
/////
function secondary_http_request_response(spanID,result) {
	var fobj = $("userdata");
	fobj.submit();
}

function clear_server_parameters() {}

var nq = <?php echo $nq; ?>;
var nr = <?php echo $qrowlist; ?>;

	function processQ(qdivnum) {
		var qdiv = "q" + qdivnum;
		var qobj = $(qdiv);
		////
		var qdivnext = "q" + (qdivnum + 1);
		var qobjnext = $(qdivnext);
		//
		//
		$hide(qdiv);
		if ( qobjnext != null ) {
			$(qdivnext).style.top = $("q1").offsetTop + "px";
			$(qdivnext).style.left = $("q1").offsetLeft + "px";
			$show(qdivnext);
			$(qdivnext + "r1").focus();
		} else {
			//
			var url = "storequestionaire.php?";
			//
			url += "nu_symbolname=" + "<?php echo $nu_symbolname; ?>";
			url += "&nu_firstname=" + "<?php echo $nu_firstname; ?>";
			url += "&nu_lastname=" + "<?php echo $nu_lastname; ?>";

			for ( var i = 0; i < nq; i++ ) {
				var n = nr[i];
				for ( var j = 0; j < n; j++ ) {
					var dname = "q" + (i+1) + "r" + (j+1);
					var ans = $(dname).value;
					url += "&" + dname + "=" + ans;
				}
			}

			makeDocRequest(url);
		}
		//
	}

</script>
<body>
<!-- Biz Stuff  -->
<table border="0" cellspacing="0" width="100%" ID="Table1">
<tbody><tr>
<td bgcolor="darkgreen" height="1" width="100%">
</td>
</tr></tbody></table>
<table border="0" cellspacing="0" width="100%" ID="Table2">
<tbody><tr>
<td bgcolor="#fcf8d5"" height="1" width="100%">
</td>
</tr></tbody></table>
<br>
<blockquote style="background-color: rgb(254,244,254) ">
<font style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
Step 2. For 
</font>
&nbsp;&nbsp;&nbsp;
<span style="background-color:#fcfcc5;color: rgb(20, 50, 100); text-transform:capitalize;text-decoration: none; font-weight: bold; font-size : 24" >
<?php echo $SERVICE; ?>.
</span>
&nbsp;&nbsp;&nbsp;
<font style="color: rgb(20, 50, 150); text-decoration: none; font-weight: bold; font-size : 18" >
Please select a new user name and password.
</font>

</blockquote>
<!-- Biz Stuff  -->
<br>
<!-- Biz Stuff  -->
<table border="0" cellspacing="0" width="100%" ID="Table3">
<tbody><tr>
<td bgcolor="darkgreen" height="1" width="100%">
</td>
</tr></tbody></table>
<table border="0" cellspacing="0" width="100%" ID="Table4">
<tbody><tr>
<td bgcolor="#fcf8d5"" height="1" width="100%">
</td>
</tr></tbody>
</table>
		<!-- Completion  -->
		<div align="center" >
		
			<div id="q1" >
				<form name="fq1" ID="fq1" action="javascript:processQ(1);" >
				Question 1:<br><input type="text" id="q1r1" NAME="q1r1" >
				<input type="submit" value="enter">
				</form>
			</div>

			<div id="q2" class="qpart" >
				<form name="fq2" ID="fq2" action="javascript:processQ(2);" >
				Question 2:<br><input type="text" id="q2r1" NAME="q2r1" value=""  >
				<input type="submit" value="enter">
				</form>
			</div>


			<div id="Completion" class="qpart" >
					<form name="userdata" ID="userdata" action="../makeaccount_userdata.php" method="POST" >	
						<input type="hidden" NAME="nu_symbolname" value="<?php echo $nu_symbolname; ?>"  > 
						<input type="hidden" NAME="nu_firstname" value="<?php echo $nu_firstname; ?>" > 
						<input type="hidden" NAME="nu_lastname" value="<?php echo $nu_lastname; ?>"  > 
						<input type="hidden" NAME="nu_postal" value="<?php echo $nu_postal; ?>"  > 
						<input type="hidden" NAME="nu_city" value="<?php echo $nu_city; ?>"  > 
						<input type="hidden" NAME="nu_state" value="<?php echo $nu_state; ?>"  > 
						<input type="hidden" NAME="nu_country" value="<?php echo $nu_country; ?>" > 
						<input type="hidden" NAME="nu_zcode" value="<?php echo $nu_country; ?>"  > 
						<input type="hidden" NAME="nu_phone_country_code" value="<?php echo $nu_phone_country_code; ?>" > 
						<input type="hidden" NAME="nu_phone_area_code" value="<?php echo $nu_phone_area_code; ?>" > 
						<input type="hidden" NAME="nu_phone_primary" value="<?php echo $nu_phone_primary; ?>" > 
						<input type="hidden" NAME="nu_phone_secondary" value="<?php echo $nu_phone_secondary; ?>" > 
						<input type="hidden" NAME="nu_email" value="<?php echo $nu_email; ?>" > 
					</form>
			</div>
			
<br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		</div>

<table border="0" cellspacing="0" width="100%" ID="Table8">
<tbody><tr>
<td bgcolor="darkgreen" height="1" width="100%">
</td>
</tr></tbody></table>
<table border="0" cellspacing="0" width="100%" ID="Table9">
<tbody><tr>
<td bgcolor="#fcf8d5"" height="1" width="100%">
</td>
</tr></tbody></table>

<font size="1">Copious Systems  2006</font><br>

</body>
</html>

