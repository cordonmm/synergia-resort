<?php 
class Carpeta extends Eloquent {	
	
	/**
	 * Devuelve el url 
	 *
	 * @return string
	 */
	public function nombre()
	{
		return $this->nombre;
	}
	
	/**
	 * Get the Entradas de la url.
	 *
	 * @return Array(string)
	 */
	public function urls()
	{
		return $this->hasMany("Url");
	}

	

}
?>