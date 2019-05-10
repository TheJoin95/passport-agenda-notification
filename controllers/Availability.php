<?php

/**
* @Availability
* 
* @description
* This class manage to retrieve the availabilities by office and by day
* 
*/

Class Availability
{

	private $endpoint;
	private $port;

	// Pattern to manage the weird pagination
	private $pagination_string = "/GestioneDisponibilitaAction.do?codop=getDisponibilitaCittadino&previous=@PREVIOUS@&data=@DATA@";
	
	// Don't touch this... taaara rara tu ta taao.. (you) Can't touch this
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

	/**
	* @getAvailabilities
	* @param String - the html response of the avaiability request
	* @return Array - The availabilities array (empty if there are no availabilities)
	*/
	private function getAvailabilities (String $response)
	{
		$availabilities = array();
		$availability_date = date('Y-m-d');

		if(preg_match('/(\d+\/\d+\/\d+)|(\d+\-\d+\-\d+)/', $response, $match) === 1)
			$availability_date = $match[0];

		if(!empty($match))
		{
			// 0 => availability link, 1 => office name, 2 => address, 3 => n. availability
			if(preg_match_all($this->regexp_list, str_replace(array("\n","\r", "\t"), '', $response), $matches))
			{
				$tmpArray = array();
				$matchGroup = 0;
				for($i = 1; $i < count($matches); $i++)
				{
					if($i % 4 == 0)
					{
						$tmpArray[] = $matches[$i][$matchGroup];
						$availabilities[] = array(
							'link' => $tmpArray[0],
							'date' => $availability_date,
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

	/**
	* @getFromProvinceCode
	* @param Province - the Province object that is mandatory to make the requests
	* @return Array - availabilities
	*/
	public function getFromProvinceCode(Province $province)
	{
		$r = new Request();

		$r->setOpt(CURLOPT_URL, $this->endpoint);
		$r->setOpt(CURLOPT_PORT, $this->port);
		$r->setRequestHeaders(array('Cookie' => "JSESSIONID={$_SESSION['jid']}"));
		$r->exec();

		$response = $r->getResponse();

		$availabilities = $this->getAvailabilities($response);

		return (new Slot($availabilities))->getAvailabilities();
	}
}

?>