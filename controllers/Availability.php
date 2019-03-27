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

	public function getFromProvinceCode(Province $province)
	{
		$r = new Request();

		$r->setOpt(CURLOPT_URL, $this->endpoint);
		$r->setOpt(CURLOPT_PORT, $this->port);
		$r->setOpt(CURLOPT_POSTFIELDS, array(
				'provincia' => $province->getCode(),
				'codop' => 'getDisponibilitaCittadino',
				'x' => 17,
				'y' => 17
			)
		);
		$r->exec();

		$response = $r->getResponse();
		// preg_match_all('/pattern/', $response, $matches);
		return new Availability($matches[1][0]);
	}
}

?>