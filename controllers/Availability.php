<?php

Class Availability
{
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

	public function getFromProvinceCode($province)
	{

		$xpath = new DOMXpath($doc);
		$element = $xpath->query('//*[@id="provincia"]');
		var_dump($element);
	}
}

?>