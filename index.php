<?php

require_once(dirname(__FILE__) . '/environment/config.inc.php');
require_once(dirname(__FILE__) . '/controllers/Auth.php');
require_once(dirname(__FILE__) . '/controllers/Dashboard.php');
require_once(dirname(__FILE__) . '/controllers/Availability.php');

require_once(dirname(__FILE__) . '/models/Credential.php');
require_once(dirname(__FILE__) . '/models/Province.php');
require_once(dirname(__FILE__) . '/models/Slot.php');

require_once(dirname(__FILE__) . '/utils/Request.php');

$passportAuth = new Auth(BASE_URL.ENDPOINT['login'], 443);
$isLoggedIn = $passportAuth->authenticate(new Credential('xxxxx', 'yyyyy'));

if($isLoggedIn)
{
	$dashboard = new Dashboard(BASE_URL.ENDPOINT['dashboard'], 443);
	$province = $dashboard->getProvince();

	if(empty($province))
		throw new Exception("Check your login", 1);
}
else
{
	throw new Exception("Bad login", 1);
}

$availabilityRequest = new Availability(BASE_URL.ENDPOINT['availability_list'], 443);
$availabilities = $availabilityRequest->getFromProvinceCode($province[0]);

if(empty($availabilities))
{
	echo "Non ci sono disponibilità\n";
}else{
	print_r($availabilities);
	// sendPush or sendEmail
}

?>