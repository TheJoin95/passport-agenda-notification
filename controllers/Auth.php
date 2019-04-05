<?php

Class Auth
{
	private $endpoint;
	private $port;

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

	public function authenticate(Credential $credential)
	{
		$r = new Request();
		$r->setOpt(CURLOPT_URL, $this->endpoint);
		$r->setOpt(CURLOPT_PORT, $this->port);
		$r->setOpt(CURLOPT_POSTFIELDS, array(
				'codiceFiscale' => $credential->getUsername(),
				'codop' => 'logCittadino',
				'password' => $credential->getPassword()
			)
		);
		$r->exec();

		return $this->isSignedIn($r->getResponse(), $r->getResponseCookie());
	}

	private function isSignedIn($html, $headers)
	{
		$signedIn = (preg_match('/errorLoginCittadino/', $html) === 0);
		$this->setSession($headers['JSESSIONID']);

		return $signedIn;
	}

	private function setSession($id)
	{
		$_SESSION['jid'] = urlencode($id);
	}

}

?>