
<?php
/**
 * @author: Kay van Bree, Kajel Bhikhoe
 * @description: 
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Eventplaza");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();

$id = $_POST["evenementid"];

?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>
			<input type="hidden" name ="evenementid" value = "<?php echo $id ?>"/>
			<?php

			database::getInstantie();

			$studentenid = $_POST['studentenid'];

			$evenementid = $id; // stap 3  tijdelijk ;D
			$today = date("Y-m-d");
			$test = "1111-11-11";
//oke, dus we hebben de gegevens die wij nodig hebben opgehaald, nu moeten we de query schrijven om iets in de database te gooien.
//wil je dit doen;D? Ja, maar k maak wel gebruik van de presentatie :$ Ken t nog niet zo ksgoed.. isgoed;d
			$query1 = "INSERT INTO aanmelding (studentId, evenementId, aanmeldingsdatum) 
VALUES('$studentenid' , '$evenementid', '$today')";

			mysql_query($query1);

////je gebruikt '$_POST[name]' om de 'value' van een verstuurd form op te halen
//wat dus tussen de '' van $_POST[''] moet komen, is de NAME waarvan je de waarde wilt hebbben.
// Waarom je dus name gebruikt, stel je dat je meerdere waardes verstuurd via een form, dan moet je wel weten welke welke is.
// dus name wordt gebruikt om naar te verijen, ik laat het wel zien.
			?>
			Student is aan het evenenement toegevoegd <br/><a href ="evenement.php?id=<?php echo $evenementid; ?>"/> Ga terug</a>

		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>



<?php
echo $pagina->getVereisteHTMLafsluiting();

//	database::getInstantie();
//
//	$sql = "SELECT * FROM `student`;";
//	$resultaat_van_server = mysql_query($sql);
//	while($array = mysql_fetch_array($resultaat_van_server)) {
//		echo $array["voornaam"]."<br />";
//	}
?>