<?php

Class Availability
{

	private $endpoint = ENDPOINT['availability_list'];
	private $port = 443;

	public function __construct(String $endpoint, String $port)
	{
		$this->setEndpoint($endpoint);
		$this->setPort($port);
	}

	public function setEndpoint(String $endpoint)
	{
		$this->endpoint = $endpoint;
	}

	public function setPort(String $port)
	{
		$this->port = $port;
	}

	private function getAvailabilities (String $response)
	{
		$availabilities = array();
		$availability_date = date('Y-m-d');

		if(preg_match('/\d+\/\d+\/\d+/', $response, $match) === 1)
			$availability_date = $match[0];

		// recuperare le strutture con link relativo e tot disponibilità

		return $availabilities;
	}

	public function getFromProvinceCode(Province $province)
	{
		$r = new Request();

		$r->setOpt(CURLOPT_URL, $this->endpoint);
		$r->setOpt(CURLOPT_PORT, $this->port);
		$r->setRequestHeaders(array('Cookie' => "JSESSIONID={$_SESSION['jid']}"));
		$r->setOpt(CURLOPT_POSTFIELDS, array(
				'provincia' => $province->getCode(),
				'codop' => 'getDisponibilitaCittadino',
				'x' => 17,
				'y' => 17
			)
		);
		$r->exec();

		$response = $r->getResponse();

		$availabilities = $this->getAvailabilities($response);

		return (new Availability($availabilities))->getAvailabilities();
	}
}

?>