 <?php


	$servicelist = array();
	
	$service = new service();
	$service->label = "classydex";
	$service->href = $saddr . "classydex/";
	$service->description = "classydex: the classy classified index or the Green Ecommerce Marketplace";
	
	$servicelist[] = $service;
	$service = new service();
	$service->label = "copious";
	$service->href = $saddr . "../copious/";
	$service->description = "Copious Systems: On the Net, Off the Grid, Safe and Secure";

	$servicelist[] = $service;
	$service = new service();
	$service->label = "Club Global Warming";
	$service->href = $saddr . "clubglobalwarming/";
	$service->description = "Club Global Warming: Take Care of Our Home";

	$servicelist[] = $service;
	$service = new service();
	$service->label = "Globe";
	$service->href = $saddr . "globetraining/login.php";
	$service->description = "Training for Trade all over the Globe";


	$servicelist[] = $service;
	$service = new service();
	$service->label = "Copious Mail";
	$service->href = $saddr . "/mail/";
	$service->description = "Copious Mail: As much as you need not more than you need.";

	$servicelist[] = $service;
	$service = new service();
	$service->label = "Peacenames";
	$service->href = $saddr . "peacenames/";
	$service->description = "Names for Peace.";

	$servicelist[] = $service;


?>
