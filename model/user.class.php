<?php

class User
{
	protected $email, $has_registered, $id_usera, $registration_sequence, $username, $password_hash, $datum_odlaska, $datum_dolaska;

	function __construct($email, $has_registered, $id_usera, $registration_sequence, $username, $password_hash, $datum_odlaska, $datum_dolaska)
	{
		$this->email = $email;
		$this->has_registered = $has_registered;
		$this->id_usera = $id_usera;
		$this->registration_sequence = $registration_sequence;
		$this->username = $username;
		$this->password_hash = $password_hash;
		$this->datum_odlaska = $datum_odlaska;
		$this->datum_dolaska = $datum_dolaska;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
