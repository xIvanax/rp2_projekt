<?php

class Hotel
{
	protected $grad, $id_hotela, $ime, $udaljenost_od_centra;

	function __construct($grad, $id_hotela, $ime, $udaljenost_od_centra)
	{
		$this->grad = $grad;
		$this->id_hotela = $id_hotela;
		$this->ime = $ime;
		$this->udaljenost_od_centra = $udaljenost_od_centra;
	}

	function __get( $prop ) { return $this->$prop; }
	function __set( $prop, $val ) { $this->$prop = $val; return $this; }
}

?>
