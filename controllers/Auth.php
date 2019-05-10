<?php

/**
*
* @Auth
*
* @Description
* This class manage the auth and the session of the application
* 
*/

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

	/**
	* @authenticate
	* @param Credential - username and password
	* @return bool - true stand for signed in
	*/
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

	/**
	* @isSignedIn
	* @param html - string - html response of the signin request
	* @param headers - array - the response headers of the request
	* @return bool
	*/
	private function isSignedIn($html, $headers)
	{
		$signedIn = (preg_match('/errorLoginCittadino/', $html) === 0);
		$this->setSession($headers['JSESSIONID']);

		return $signedIn;
	}

	/**
	* @setSession
	* @param $id - string - session id
	* @return void
	*/
	private function setSession($id)
	{
		$_SESSION['jid'] = urlencode($id);
	}

}

?>