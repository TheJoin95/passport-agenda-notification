<?php

/**
* @Dashboard
* @description 
* This class manage the first page after the login.
* This class is where the province is setted.
* 
*/

Class Dashboard
{
	public $index_page;

	public function __construct(String $endpoint, String $port)
	{
		$this->setEndpoint($endpoint);
		$this->setPort($port);

		$r = new Request();
		$r->setOpt(CURLOPT_URL, $this->endpoint);
		$r->setOpt(CURLOPT_PORT, $this->port);
		$r->setRequestHeaders(array('Cookie' => "JSESSIONID={$_SESSION['jid']}"));
		$r->exec();

		$this->index_page = $r->getResponse();
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
	 * @getProvince
	 * @description - Get from the index_page property the province values
	 * @return Array of Province
	*/
	public function getProvince()
	{
		$result = array();
		preg_match_all('/<option value="(\w+)">(.+)<\/option>/', $this->index_page, $matches);
		if(!empty($matches[1][0])) {
			$result[] = new Province($matches[1][0], $matches[2][0]);
		}

		return $result;
	}
}

?>