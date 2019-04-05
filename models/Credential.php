<?php

Class Credential
{
	public $tax_code;
	public $password;

	public function __construct(String $tax_code, String $pwd)
	{
		$this->tax_code = $tax_code;
		$this->password = $pwd;
	}

	public function getUsername()
	{
		return $this->tax_code;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function getRequestData()
	{
		return [
			'codiceFiscale' => $this->tax_code,
			'password' => $this->password
		];
	}
}

?>