<?php

Class Province
{
	public $code;
	public $name;

	public function __construct(String $code = '', String $name = '')
	{
		$this->setCode($code);
		$this->setName($name);
	}

	public function setCode(String $code)
	{
		$this->code = $code;
	}

	public function setName(String $name)
	{
		$this->name = $name;
	}

	public function getCode()
	{
		return $this->code;
	}

	public function getName()
	{
		return $this->name;
	}
}

?>