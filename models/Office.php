<?php

Class Office
{
	public $name;
	public $address;

	public function __construct(String $name = '', String $address = '')
	{
		$this->name = $name;
		$this->address = $address;
	}
}

?>