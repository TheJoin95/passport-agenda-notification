<?php

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


	public function getProvince()
	{
		$result = array();
		preg_match_all('/<option value="(\w+)">(.+)<\/option>/', $this->index_page, $matches);
		if(!empty($matches[1][0])) {
			// new Province($matches[1][0], $matches[2][0]);
			$result = array(
				$matches[1][0] => $matches[2][0]
			);
		}

		return $result;
	}
}

?>