<?php

global $db_connection;
include"../admin_header_lite.php";

if ( isset($_POST['accpublisher']) ) {

	$seriviceid = $_POST['serviceid'];
	$UU = "UPDATE accounttypes SET published = 0 where serviceid = '$seriviceid'";

	db_query_exe($UU);

	if ( isset($_POST['acclist']) ) {
		$list = $_POST['acclist'];
		if ( is_array($list) ) {
			$aclisttxt = implode(",",$list);
		} else {
			$aclisttxt = $list;
		}

		$UU = "UPDATE accounttypes SET published = 1 where id in ($aclisttxt)";
		db_query_exe($UU);
	}

	$g_business_focus = $_POST['bfocus'];
	$cc = urlencode( "( ac.published = 1 )" );
	$url = "http://$webhost/hosted/accounttype/accounts.php?bfocus=$g_business_focus&pushbuttons=true&condition=$cc"; /// Filter these out...
	$form = file_get_contents($url);

	$form = urlencode($form);
	$UU = "UPDATE serivcesource set uses_account_types = 1, published_accounts='$form'";
	db_query_exe($UU);

///g_vocname + " to " + g_vocname_new
/*
	for ( $j = 1; $j <= 2; $j++ ) {
		if ( isset($_POST["menu_name_list$j"]) ) {
			$menulist = $_POST["menu_name_list$j"];
			$aclist = explode(",",$aclisttxt);
			foreach ( $aclist as $acctype ) {
				$menuname = $menulist[$acctype];
				$menuid = db_quey_value("SELECT id FROM vocabulary where name = '$menuname'");
				if ( $menuid > 0 ) {
					$newname = $menuname . "_" . $g_business_focus . "_" . $acctype . "_$j" ;
					$postTarget = "../taxonomy/cloneTaxoTree.php?based_on_taxonomy=$menuid&taxoname=$newname";
					file_get_contents($url);
				}
			}
		}
	}
*/
} 

echo urldecode($form);
?>
