<?php

class tijd {
	/**
	 *
	 * @return tijd
	 */
	public static function getInstantie()
	{
		if (!self::$instantie) {
			self::$instantie = new self();
		}
		return self::$instantie;
	}
	
	/**
	 * Deze functie formatteerd elke correcte php datum tijd 
	 * waarde naar het format wat je mee stuurt aan de functie
	 * @param string $tijd
	 * @param string $format
	 * @return string 
	 */
	public static function formatteerTijd($tijd, $format) {
		$datum = new DateTime($tijd);
		return $datum->format($format);
	}
}

?>