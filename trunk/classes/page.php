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
		<img src=\"images/header.png\" />
		<div id=\"login\">
			<h4>Inloggen:</h4>
			<form action=" . $_SERVER["PHP_SELF"] . " method=\"post\">
				<input type=\"text\" name=\"gebruiker\" class=\"text\" /><br />
				<input type=\"password\" name=\"password\" class=\"pass\" />
				<input type=\"submit\" name=\"submit\" value=\"Ga!\" class=\"submit\" />
			</form><br />
			<div>Geen account? <a href=\"#\">Registreer!</a></div>
		</div>
	</div>";
	}

	public function getMenu()
	{
		return "<div id=\"menu\">
		<ul id=\"nav\">
			<li class=\"single\">
				<a href=\"index.php\">Home</a>
			</li>
			<li>
				<a href=\"student.php\" class=\"drop\">Studenten</a>
				<div class=\"dropdown\">
					<div><a href=\"#\">Studentenlijst<p>Een lijst van alle studenten</p></a></div>
					<div><a href=\"#\">Profiel<p>Wijzig je profiel</p></a></div>
					<div><a href=\"#\">Registreren<p>Geen account? Schrijf je in</p></a></div>
				</div>
			</li>
			<li>
				<a href=\"vereniging.php\" class=\"drop\">Verenigingen</a>
				<div class=\"dropdown\">
					<div><a href=\"#\">Verenigingenlijst<p>Een lijst van alle verenigingen</p></a></div>
					<div><a href=\"#\">Registreren<p>Registreer je vereniging</p></a></div>
				</div>
			</li>
			<li>
				<a href=\"evenement.php\" class=\"drop\">Evenementen</a>
				<div class=\"dropdown\">
					<div><a href=\"#\">Evenementenlijst<p>Een lijst van alle evenementen</p></a></div>
					<div><a href=\"#\">Toevoegen<p>Voeg een evenement toe</p></a></div>
				</div>
			</li>
			<li>
				<a href=\"beheer.php\" class=\"drop\">Beheer</a>
				<div class=\"dropdown\">
					<div><a href=\"#\">Categorieen<p>Beheer categorieen</p></a></div>
					<div><a href=\"#\">Managements-rapport<p>Vraag rapporten op</p></a></div>
				</div>
			</li>
			<div class=\"align_right\">
				<form>
					<fieldset class=\"search\">
					<input type=\"text\" name=\"zoek\" class=\"box\" />
					<input type=\"submit\" name=\"submit\" value=\"O-\" class=\"btn\" />
					</fieldset>
				</form>
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