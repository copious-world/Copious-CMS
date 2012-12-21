<?php
	
	$index_name = "Copious Classifieds";
	$mymail = "rleddy@svn.net";
	
	$default_price = "$50.00";
	$agent_price = "$40.00";
	
/*
	$default_price = "$0.50";
	$agent_price = "$0.40";
*/



	// DEPLOYMENT CONFIG

	$processor_server = "www.paypal.com";
	$store_server = "www.copious-systems.com";
	$payservice = "https://www.paypal.com/cgi-bin/webscr";
	$port = 80;
	$post_URL = "/cgi-bin/webscr";
	$service_business_identifier = "rleddy@svn.net";
	$post_URL_dir = "/classifieds/docclassifiedserver/manager/jobs";
/*
*/

/*	// SANDBOX CONFIG

	$processor_server = "www.sandbox.paypal.com";
	$store_server = "www.copious-systems.com";
	$payservice = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	$port = 80;
	$post_URL = "/cgi-bin/webscr";
	$service_business_identifier = "info@copious-systems.com";
	$post_URL_dir = "/classifieds/docclassifiedserver/manager/jobs";


*/

/*

// TEST CONFIG
	$processor_server = "localhost";
	$store_server = "localhost";
	$payservice = "https://www.sandbox.paypal.com/cgi-bin/webscr";
	$port = 8080;
	$post_URL = "/docclassifiedserver/manager/jobs/testtrans.php";
	$service_business_identifier = "rleddy@svn.net";
	$post_URL_dir = "/docclassifiedserver/manager/jobs";

*/


	$webdirectory = "http://$store_server:$port$post_URL_dir";


?>
