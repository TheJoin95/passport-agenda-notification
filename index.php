<?php

require_once(dirname(__FILE__) . '/enviroment/config.inc.php');
require_once(dirname(__FILE__) . '/controllers/Auth.php');
require_once(dirname(__FILE__) . '/controllers/Dashboard.php');
require_once(dirname(__FILE__) . '/controllers/Availability.php');

require_once(dirname(__FILE__) . '/models/Credential.php');

require_once(dirname(__FILE__) . '/utils/Request.php');

$dataLogin = array(
	'codiceFiscale' => '',
	'codop' => 'logCittadino',
	'password' => ''
);

$dataSearch = array(
	'provincia' => 'FI',
	'x' => 17,
	'y' => 17
);

$passportAuth = new Auth(BASE_URL.ENDPOINT['login'], 443);
$result = $passportAuth->authenticate(new Credential('xxxxx', 'yyyy'));

$dashboard = new Dashboard(BASE_URL.ENDPOINT['dashboard'], 443);
$province = $dashboard->getProvince();

if(empty($province))
	throw new Exception("Check your login", 1);
	
die("da fare");
$availability_list = (new Availability())->getFromProvinceCode($province[0]);

// 'Set-Cookie' => "JSESSIONID={$_SESSION['jid']}"

var_dump($result);
die("fine");

$r = new Request();
$r->setOpt(CURLOPT_URL, BASE_URL.ENDPOINT['login']);
$r->setOpt(CURLOPT_PORT, 443);

$ch = curl_init(); 
curl_setopt($ch, CURLOPT_URL,  BASE_URL.ENDPOINT['login']); 
curl_setopt($ch, CURLOPT_PORT , 443); 
curl_setopt($ch, CURLOPT_VERBOSE, 0); 
curl_setopt($ch, CURLOPT_HEADER, 1); 
curl_setopt($ch, CURLOPT_SSLVERSION, 3); 
curl_setopt($ch, CURLOPT_POST, 1); 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $dataLogin); 
# curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml","SOAPAction: \"/soap/action/query\"", "Content-length: ".strlen($data))); 

$response = curl_exec($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);

#var_dump(curl_getinfo($ch));
var_dump($header);
echo $response;

// xPath => se html title contiene errorLoginCittadino => 400
// se no ok


?>