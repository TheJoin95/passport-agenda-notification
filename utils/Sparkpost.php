<?php

Class Sparkpost
{

	private $api_key;
	private $base_path = 'https://api.eu.sparkpost.com/api/v1';

	private $endpoint = ['email' => '/transmissions'];
	private $port = 443;

	public function __construct(String $api_key)
	{
		$this->api_key = $api_key;
	}

	private function buildEndpointPath($endpoint)
	{
		return $this->base_path . $endpoint;
	}

	public function sendEmail($to, $subject, $text, $options=array('smtp' => false))
	{

		$r = new Request();

		$r->setOpt(CURLOPT_URL, $this->buildEndpointPath($this->endpoint['email']));
		$r->setOpt(CURLOPT_PORT, $this->port);
		$r->setRequestHeaders(array('Authorization' => $this->api_key, 'Content-Type' => 'application/json'));
		$r->setOpt(CURLOPT_POSTFIELDS, json_encode(
			array(
				'options' => array('sandbox' => true),
					'content' => array(
						'from' => 'sandbox@sparkpostbox.com',
						'subject' => $subject,
						'text' => $text
					),
					'recipients' => array(
						array('address' => $to)
					)
				)
			)
		);
	}
}

?>