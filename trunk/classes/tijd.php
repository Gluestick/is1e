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
	
	public static function formatteerTijd($tijd, $format) {
		$datum = new DateTime($tijd);
		return $datum->format($format);
	}
}

?>