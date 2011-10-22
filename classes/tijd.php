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
	
	/**
	 * Deze functie vervangt bijv. monday door maandag en
	 * august door augustus
	 * @param string $datum
	 * @return string
	 */
	public static function vervangEngelsDoorNederlands($datum) {
		$dagenNL = array("maandag","dinsdag","woensdag","donderdag","vrijdag","zaterdag","zondag");
		$dagenEN = array("monday","tuesday","wednesday","thursday","friday","saturday","sunday");
		$maandenNL = array("januari","februari","maart","april","mei","juni","juli","augustus","september","oktober","november","december");
		$maandenEN = array("januari","februari","march","april","may","june","july","august","september","october","november","december");
		
		$tekst = str_ireplace($dagenEN, $dagenNL, $datum);
		$tekst = str_ireplace($maandenEN, $maandenNL, $tekst);
		
		return $tekst;
	}
}

?>