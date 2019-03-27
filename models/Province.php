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

	public setCode(String $code)
	{
		$this->code = $code;
	}

	public setName(String $name)
	{
		$this->name = $name;
	}

	public getCode()
	{
		return $this->code;
	}

	public getName()
	{
		return $this->name;
	}
}

?>