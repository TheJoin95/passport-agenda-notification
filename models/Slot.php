<?php

Class Slot
{
	public $availabilities = [];

	public function __construct(Array $availabilities = [])
	{
		$this->availabilities = $availabilities;
	}

	public function getAvailabilities() {
		return $this->availabilities;
	}
}

?>