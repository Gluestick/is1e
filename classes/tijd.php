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
		if ($tijd != "0000-00-00") {
			$datum = new DateTime($tijd);
			return $datum->format($format);
		} else {
			return null;
		}
	}
	
	/**
	 * Deze functie controleert dat als een correct nederlands format is meegegeven
	 * Of de datum die meegegeven is klopt.
	 * HYPERDELUXE!
	 * @param string $datum
	 * @return bool
	 */
	public static function checkCorrectieDatum($datum) {
		if (!empty($datum)) {
			if (strstr($datum, "-")) {
				if (preg_match("/^[0-9]{1,2}[-]{1}[0-9]{1,2}[-]{1}[0-9]{2,4}$/", $datum)) {
					$deel = explode("-", $datum);
					if ($deel[0] >= 1 && $deel[0] <= 31 && $deel[1] >= 1 && $deel[1] <= 12 && $deel[2] >= 1900 && $deel[2] <= 2020) {
						return checkdate($deel[1], $deel[0], $deel[2]);
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
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