<?php

Class Availability
{
	public $availabilities = [];

	public function __construct(Array $availabilities = [])
	{
		$this->availabilities = $availabilities;
	}

	public static function getAvailabilities($body) {
		return $this->availabilities;
	}
}

?>