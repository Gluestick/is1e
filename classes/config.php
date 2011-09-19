<?php

/**
 * In deze class worden benodigde gegevens geladen om te gebruiken in het project
 *
 * @author Hans-Jurgen
 */
class config {
	public static $csspad;
	
	private static $instantie;
	
    private $hostname;
    private $database;
    private $gebruikersnaam;
    private $wachtwoord;

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
		self::$csspad = $_SERVER["DOCUMENT_ROOT"]."/project/css";
		$this->hostname = "localhost";
		$this->database = "zf-tutorial";
		$this->gebruikersnaam = "root";
		$this->wachtwoord = "";
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