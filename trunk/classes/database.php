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

		$this->verbinding = mysql_connect($config->getHostName(), $config->getGebruikersnaam(), $config->getWachtwoord());
		if (!$this->verbinding) {
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db($config->getDatabase(), $this->verbinding);
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
}

?>
