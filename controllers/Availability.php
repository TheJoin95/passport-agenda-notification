<?php

Class Availability
{

	private $endpoint;
	private $port;

	// GestioneDisponibilitaAction.do?codop=getDisponibilitaCittadino&amp;previous=false&amp;data=05-04-2019
	private $pagination_string = "/GestioneDisponibilitaAction.do?codop=getDisponibilitaCittadino&previous=@PREVIOUS@&data=@DATA@";
	// private $regexp_list = '/headers="(\w+)">|href="([A-Za-z.?=&;0-9-]+)"|>([\sA-Za-z]+)<\/a>|([\w+,\s\/\d-]+)<|>(\d+)<\/td>/';
	private $regexp_list = '/headers="descrizione"><ahref="([A-Za-z.?=&;0-9-]+)"|title="Disponibilita">([\sA-Za-z]+)<\/a>| headers="indirizzo">([\w+,\s\/\d-]+)<|>(\d+)<\/td>/';

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

		file_put_contents('./availability.html', str_replace(array("\n","\r", "\t"), '', $response));

		if(preg_match('/(\d+\/\d+\/\d+)|(\d+\-\d+\-\d+)/', $response, $match) === 1)
			$availability_date = $match[0];

		if(!empty($match))
		{
			// 0 => field, 1 => link disponibilità, 2 => sede name, 3 => address, 4 => n. civico
			if(preg_match_all($this->regexp_list, str_replace(array("\n","\r", "\t"), '', $response), $matches))
			{
				$tmpArray = array();
				$matchGroup = 0;
				for($i = 1; $i < count($matches); $i++)
				{
					if($i % 4 == 0)
					{
						$availabilities[] = array(
							'link' => $tmpArray[0],
							'availability' => $tmpArray[3],
							'office' => array(
								'name' => $tmpArray[1],
								'address' => $tmpArray[2]
							)
						);
						$matchGroup = 0;
						$tmpArray = array();
					}
					else
					{
						$tmpArray[] = $matches[$i][$matchGroup];
						$matchGroup++;
					}
				}
			}
		}

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

		$availabilities = $this->getAvailabilities($response);

		return (new Slot($availabilities))->getAvailabilities();
	}
}

?>