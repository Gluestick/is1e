<?php

/**
 * Met deze class kan een pagina volledig gebouwt worden.
 * De namen van de functies spreken voor zichzelf.
 * En hun doel ook.
 *
 * @author Hans-Jurgen Bakkenes
 */
class pagina
{

	/**
	 * Hieronder staan de properties van de class gedefinieërd.
	 * Properties zijn variabelen die in de class/via de class gebruikt kunnen worden.
	 * 
	 * Voor de properties staat een beveiligingsniveau.
	 * Deze kan bestaan uit: private, protected en public.
	 * ALLE properties met bovenstaande beveiligingsniveau's, kunnen binnen dezelfde class gebruikt worden.
	 * 
	 * Public: Properties die beveiligingsniveau public hebben kunnen worden aangeroepen buiten de class
	 * door bijvoorbeeld te typen: $pagina = new pagina(); $pagina->titel;
	 * Hier werd de propertie titel aangeroepen nadat de class geinstantieërd werd.
	 * 
	 * Protected: Properties die beveiligingsniveau protected hebben kunnen alleen door andere classes gebruikt worden.
	 * Hier is in deze applicatie geen sprake van.
	 * 
	 * Private: Properties die beveiligingsniveau private hebben kunnen alleen binnen dezelfde class gebruikt worden.
	 */
	private static $instantie;
	private $csspad;
	public $titel;
	public $meta_beschrijving;
	public $meta_sleutelwoorden;
	public $javascript;
	public $css;

	/**
	 * Deze functie word aangeroepen als de class word geinstantieerd.
	 */
	public function __construct()
	{
		
	}

	/**
	 * Geeft singleton terug van de class. 
	 * Met de singleton word gecontroleerd of een class reeds geinstantieerd is.
	 * 
	 * Het instantièren van een class is het plaatsen van een class in een variabele.
	 * Deze variabele word dan een object van class ... genoemd.
	 * 
	 * Met behulp van -> kunnen functies uit de class worden aangeroepen.
	 * @return pagina
	 */
	public static function getInstantie()
	{
		if (!self::$instantie) {
			self::$instantie = new self();
		}
		return self::$instantie;
	}

	/**
	 * Deze functie maakt voor jullie automatisch de javascript include op de pagina.
	 * De minimaal vereiste variabele is de source.
	 * Plaats javascript bestanden altijd in de daarvoor bestemde map.
	 * @param string $src
	 * @param string $type
	 */
	public function setJavascript($src, $type = "text/javascript")
	{
		$this->javascript .= "<script type=\"" . $type . "\" src=\"" . $src . "\"></script>";
	}

	/**
	 * Deze functie maakt voor jullie automatisch de css include op de pagina.
	 * De minimaal vereiste variabele is de source.
	 * Plaats css bestanden altijd in de daarvoor bestemde map.
	 * 
	 * Hoe werkt het:
	 * 
	 * 
	 * @param string $src
	 * @param string $type
	 * @param string $rel
	 */
	public function setCss($src, $type = "text/css", $rel = "stylesheet")
	{
		$this->css .= "<link rel=\"" . $rel . "\" href=\"" . config::$csspad . $src . "\" type=\"" . $type . "\" />";
	}

	public function setTitel($titel)
	{
		$this->titel = $titel;
	}

	public function getTitel()
	{
		return $this->titel;
	}

	public function setMetaKeyword($keyword)
	{
		$this->meta_sleutelwoorden .= $keyword;
	}

	public function setMetaDescription($description)
	{
		$this->meta_beschrijving .= $description;
	}

	public function getVereisteHTML()
	{
		return "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
				<html lang=\"en-US\" xml:lang=\"en-US\" xmlns=\"http://www.w3.org/1999/xhtml\"> 
				<head>
				<title>" . $this->titel . "</title>
				<link rel=\"shortcut icon\" href=\"/favicon.ico\" type=\"image/x-icon\" />
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
				<meta name=\"description\" content=\"" . $this->meta_beschrijving . "\" />
				<meta name=\"keywords\" content=\"" . $this->meta_sleutelwoorden . "\" />
				" . $this->css . "
				" . $this->javascript . "
				</head>
				<body>";
	}

	public function render_noscript()
	{
		echo '<noscript><center><p class="noscript">Your browser does not support JavaScript!/doesn\'t have javascript enabled</p></center></noscript>';
	}

	public function getHeader()
	{
		return "<div id=\"header\">
		<img src=\"images/header.png\" alt=\"henk!\" />
	</div>";
	}

	public function getMenu()
	{
		return "<div id=\"menu\">
		<ul id=\"nav\">
			<li class=\"single\">
				<a href=\"index.php\" class=\"button\">Home</a>
			</li>
			<li>
				<a href=\"student.php\" class=\"drop\" class=\"button\">Studenten</a>
				<div class=\"dropdown\">
					<div><a href=\"#\" class=\"button\">Studentenlijst<br /><font>Een lijst van alle studenten</font></a></div>
					<div><a href=\"#\" class=\"button\">Profiel<br /><font>Wijzig je profiel</font></a></div>
					<div><a href=\"#\" class=\"button\">Registreren<br /><font>Geen account? Schrijf je in</font></a></div>
				</div>
			</li>
			<li>
				<a href=\"vereniging.php\" class=\"drop\" class=\"button\">Verenigingen</a>
				<div class=\"dropdown\">
					<div><a href=\"#\" class=\"button\">Verenigingenlijst<br /><font>Een lijst van alle verenigingen</font></a></div>
					<div><a href=\"#\" class=\"button\">Registreren<br /><font>Registreer je vereniging</font></a></div>
				</div>
			</li>
			<li>
				<a href=\"evenement.php\" class=\"drop\" class=\"button\">Evenementen</a>
				<div class=\"dropdown\">
					<div><a href=\"evenementenlijst.php\" class=\"button\">Evenementenlijst<br /><font>Een lijst van alle evenementen</font></a></div>
					<div><a href=\"#\" class=\"button\">Toevoegen<br /><font>Voeg een evenement toe</font></a></div>
				</div>
			</li>
			<li>
				<a href=\"beheer.php\" class=\"drop\" class=\"button\">Beheer</a>
				<div class=\"dropdown\">
					<div><a href=\"#\" class=\"button\">Categorieen<br /><font>Beheer categorieen</font></a></div>
					<div><a href=\"rapport.php\" class=\"button\">Managements-rapport<br /><font>Vraag rapporten op</font></a></div>
				</div>
			</li>
			<li class=\"align_right\">
				<a href=\"#\" class=\"drop\">Inloggen</a>
					<div id=\"login\" class=\"dropdown\">
					<h4>Inloggen:</h4>
					<form action=\"" . $_SERVER["PHP_SELF"] . "\" method=\"post\">
						<input type=\"text\" name=\"gebruiker\" class=\"text\" /><br />
						<input type=\"password\" name=\"password\" class=\"pass\" />
						<input type=\"submit\" name=\"submit\" value=\"Ga!\" class=\"submit\" />
					</form><br /><br />
					Geen account? <a href=\"#\" class=\"login\">Registreer!</a></div>
				<div>
			</li>
		</div>
		</ul>
		</div>";
	}

	public function getFooter()
	{
		return "<div id=\"footer\">
				<p><a href=\"#\">eventplaza</a> is ontworpen door <a href=\"#\">is1e gfy</a>, in opdracht van <a href=\"#\">zoen</a></p>
			</div>";
	}

	public function getVereisteHTMLafsluiting()
	{
		return "</body></html>";
	}

}