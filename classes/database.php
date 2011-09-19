<?php

/**
 * Met behulp van deze class word de verbinding met de database geregeld.
 *
 * @author Hans-Jurgen
 */
class database
{
	private static $instantie;
	
	private $verbinding;
	
	public function __construct()
	{
		$config = config::getInstantie();
		
		try {
			$this->verbinding = new PDO("mysql:host=".$config->getHostName().";dbname=".$config->getDatabase(),
					$config->getGebruikersnaam(),
					$config->getWachtwoord());
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	/**
	 *
	 * @return database
	 */
	public static function getInstantie()
	{
		if (!self::$instantie) {
			self::$instantie = new self();
		}
		return self::$instantie;
	}
	
	public function getVerbinding()
	{
		return $this->verbinding;
	}
}

?>
