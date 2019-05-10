<?php

/**
* @Request
* @description
* This class is a wrapper to use the curl lib
* 
*/

class Request {
	private $ch;
	private $response;
	private $response_html;
	private $headers;

	private $default_opt = [
		CURLOPT_VERBOSE => 0,
		CURLOPT_HEADER => 1,
		CURLOPT_SSLVERSION => 3,
		// CURLOPT_POST => 0,
		CURLOPT_SSL_VERIFYPEER => 1,
		CURLOPT_RETURNTRANSFER => 1,
	];

	public function __construct(Array $opt = [])
	{
		$this->ch = curl_init(); 
		$this->setDefaultOpt($opt);
	}

	/**
	* Run the request
	*/
	public function exec()
	{
		$this->response = curl_exec($this->ch);
		$this->setRequestInfo();
	}

	/**
	* Get and Set the request info of curl
	*/
	private function setRequestInfo()
	{
		$this->headers = substr($this->response, 0, curl_getinfo($this->ch, CURLINFO_HEADER_SIZE));
		$this->httpCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
	}

	/**
	* Get the cookie from the response of the curl request
	*/
	public function getResponseCookie()
	{
		preg_match_all('/^Set-Cookie:\s*([^ \r\n;]*)/mi', $this->response, $matches);
		$cookies = array();
		foreach($matches[1] as $item) {
		    parse_str($item, $cookie);
		    $cookies = array_merge($cookies, $cookie);
		}

		return $cookies;
	}

	/**
	* Set the request headers
	*/
	public function setRequestHeaders(Array $headers)
	{
		$formattedHeaders = array();
		foreach($headers as $key => $value)
		{
			$formattedHeaders[] = $key.": ".$value;
		}

		$this->setOpt(CURLOPT_HTTPHEADER, $formattedHeaders);
	}

	// Set the option for the curl
	public function setOpt($opt, $value)
	{
		curl_setopt($this->ch, $opt, $value);
	}

	// Set the default option for the curl
	private function setDefaultOpt(Array $options)
	{
		$options = empty($options) ? $this->default_opt : $options;
		foreach($options as $opt => $value)
		{
			$this->setOpt($opt, $value);
		}
	}

	public function getHttpCode()
	{
		return $this->httpCode;
	}

	public function getHeaders()
	{
		return $this->headers;
	}

	public function getResponse() 
	{
		return $this->response;
	}

	public function getResponseHTML()
	{
		return $this->response_html;
	}

	// Parse the response to a DOMDocument
	public function setResponseHTML()
	{
		$this->response_html = new DOMDocument();
		$this->response_html->loadHTML($this->response);
	}
}

?>