<?php

/**
 * In deze class worden benodigde gegevens geladen om te gebruiken in het project
 *
 * @author Hans-Jurgen
 */
class config {
	public static $csspad = "/project/css/";
	public static $jspad = "/project/js/";
	
	private static $instantie;
	
    private $hostname = "localhost";
    private $database = "project";
    private $gebruikersnaam = "root";
    private $wachtwoord = "usbw";

	/**
	 *
	 * @return config
	 */
	public static function getInstantie()
	{
		if (!self::$instantie) {
			self::$instantie = new self();
		}
		return self::$instantie;
	}
	
	public function __construct()
	{
		
	}
    
    public function getHostName() {
		return $this->hostname;
	}
	
	public function getDatabase() {
		return $this->database;
	}
	
	public function getGebruikersnaam() {
		return $this->gebruikersnaam;
	}
	
	public function getWachtwoord() {
		return $this->wachtwoord;
	}
	
	public function getCssPad() {
		return $this->csspad;
	}
}

?>