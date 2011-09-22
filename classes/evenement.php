<?php

class evenement
{

	private $web_database;
	private $evenementId;
	private $categorieId;
	private $naam;
	private $omschrijving;
	private $begindatum;
	private $einddatum;
	private $isAanmeldingVerplicht;
	private $organiserendeVerenigingId;

	public function __construct()
	{
		$this->web_database = web_database::getInstance();
	}

	public function LoadFromDB($id)
	{
		$evenementen = mysql_fetch_assoc(mysql_query("SELECT * FROM `evenement` WHERE evenementId = '" . $id . "';"));

		if ($evenementen) {
			$this->evenementId = $evenementen["evenementId"];
			$this->categorieId = $evenementen["categorieId"];
			$this->naam = $evenementen["naam"];
			$this->omschrijving = $evenementen["omschrijving"];
			$this->begindatum = $evenementen["begindatum"];
			$this->einddatum = $evenementen["einddatum"];
			$this->isAanmeldingVerplicht = $evenementen["isAanmeldingVerplicht"];
			$this->organiserendeVerenigingId = $evenementen["organiserendeVerenigingId"];
			
			return true;
		}
		return false;
	}

	public function Save()
	{
		if (!is_numeric($this->id)) {
			$insert_id = mysql_query(
					"INSERT INTO `evenement` 
						(
							categorieId,
							naam, 
							omschrijving, 
							begindatum, 
							einddatum, 
							isAanmeldingVerplicht
						) VALUES
						('" . $this->title . "', 
						'" . $this->content . "', 
						'" . $this->archive . "',
						'" . $this->datestamp . "',
						'" . $this->author->getID() . "');");
			$this->id = $insert_id;
			return true;
		} else {
			$sql = "UPDATE `evenement` 
					SET
					title = '" . $this->title . "' , 
					content = '" . $this->content . "' , 
					archive = '" . $this->archive . "' WHERE 
					news_id = '" . $this->id . "' LIMIT 1;";
			$affected_rows = mysql_query($sql);
			return $affected_rows;
		}
	}

	public function Delete()
	{
		if (is_numeric($this->id)) {
			$rows = mysql_query("DELETE FROM `evenement` WHERE evenementId = '".$this->evenementId."' LIMIT 1;");
			if ($rows == "1") {
				return true;
			}
		}
		return false;
	}

}
?>