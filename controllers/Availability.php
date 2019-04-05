<?php

Class Availability
{

	private $endpoint;
	private $port;

	// GestioneDisponibilitaAction.do?codop=getDisponibilitaCittadino&amp;previous=false&amp;data=05-04-2019
	private $pagination_string = "/GestioneDisponibilitaAction.do?codop=getDisponibilitaCittadino&previous=@PREVIOUS@&data=@DATA@";
	private $regexp_list = '/headers="(\w+)">|href="([A-Za-z.?=&;0-9-]+)"|>([\sA-Za-z]+)<\/a>|([\w+,\s\/\d-]+)<|>(\d+)<\/td>/';

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

		file_put_contents('./availability.html', $response);

		if(preg_match('/\d+\/\d+\/\d+/', $response, $match) === 1)
			$availability_date = $match[0];

		if(!empty($availability_list))
		{
			// 0 => field, 1 => link disponibilità, 2 => sede name, 3 => address, 4 => n. civico
			if(preg_match_all($this->regexp_list, str_replace(array("\n","\r", "\t"), '', $response), $matches))
			{
				for($i = 0; $i < count($matches); $i++)
				{
					$availabilities[] = array(
						'link' => $matches[$i][1],
						'office' => array(
							'name' => $matches[$i][2],
							'address' => $matches[$i][3] . ' ' . $matches[$i][4]
						)
					);
				}
			}
		}

		// recuperare le strutture con link relativo e tot disponibilità

		return $availabilities;
	}

	public function getFromProvinceCode(Province $province)
	{
		$r = new Request();

		$r->setOpt(CURLOPT_URL, $this->endpoint);
		$r->setOpt(CURLOPT_PORT, $this->port);
		$r->setRequestHeaders(array('Cookie' => "JSESSIONID={$_SESSION['jid']}"));
		/*$r->setOpt(CURLOPT_POSTFIELDS, array(
				'provincia' => $province->getCode(),
				'codop' => 'getDisponibilitaCittadino',
				'x' => 17,
				'y' => 17
			)
		);*/
		$r->exec();

		$response = $r->getResponse();
		var_dump($response); die();

		$availabilities = $this->getAvailabilities($response);

		return (new Slot($availabilities))->getAvailabilities();
	}
}

?>