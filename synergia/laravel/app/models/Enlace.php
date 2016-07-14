<?php
class Enlace extends Eloquent {

	public $timestamps = false;
	/**
	 * Devuelve el nombre
	 *
	 * @return string*/
	
	public function nombre()
	{
		return $this->nombre;
	}
	
	/**
	 * Devuelve el url 
	 *
	 * @return string*/
	
	public function url()
	{
		return $this->url;
	}
	/**
	 * Devuelve el tipo de la url
	 * 
	 * @return string
	 */
	public function tipo()
	{
		return $this->tipo;
	}
	
	public function local()
	{
		return $this->local;
	}
	
	
	/**
	 * Get the Entradas de la url.
	 *
	 * @return Array(string)
	 */
	public function entradas()
	{
		$entradas = Array();
		foreach ($this->belongsToMany('Entrada','enlaces_entradas') as $entrada){
			array_push($entradas, Url::to($entrada));
		}
		return $entradas;
	}

	

}