<?php
/**
 * @author: Kay van Bree, Kajel Bhikhoe
 * @description: 
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Eventplaza");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>

<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>

			<?php
			$naam = $_POST["naam"];
			$bdatum = $_POST["bdatum"];
			$edatum = $_POST["edatum"];
			$tekstvak = $_POST["tekstvak"];
			$categorie = $_POST["categorie"];
			$vereniging = $_POST["vereniging"];
			$evenement = $_POST["evenementid"];
			
			database::getInstantie();

			if (isset($_POST["aanmelden"])) {
				$aanmelden = $_POST["aanmelden"];
				$query1 = "UPDATE evenement 
				SET categorieid='$categorie', naam='$naam', omschrijving='$tekstvak', begindatum='$bdatum', einddatum='$edatum', isaanmeldingverplicht='$aanmelden', organiserendeverenigingid='$vereniging' 
				where evenementid='$evenement';";

				mysql_query($query1);
			} else {

				$query2 = "UPDATE evenement
				SET categorieid='$categorie', naam='$naam', omschrijving='$tekstvak', begindatum='$bdatum', einddatum='$edatum', isaanmeldingverplicht='Nee', organiserendeverenigingid='$vereniging' 
				where evenementid='$evenement';";

				mysql_query($query2);
			}
			
			if (isset($_POST["aanmelden"])) {
				$aanmelden = $_POST["aanmelden"];
				$query3 = "UPDATE evenement 
				SET categorieid='$categorie', naam='$naam', omschrijving='$tekstvak', begindatum='$bdatum', einddatum='$edatum', isaanmeldingverplicht='$aanmelden', evenementid='$evenement' 
				where organiserendeverenigingid='$vereniging';";

				mysql_query($query3);
			} else {

				$query4 = "UPDATE evenement
				SET categorieid='$categorie', naam='$naam', omschrijving='$tekstvak', begindatum='$bdatum', einddatum='$edatum', isaanmeldingverplicht='Nee', evenementid='$evenement' 
				where organiserendeverenigingid='$vereniging';";

				mysql_query($query4);
			}
			?>
			<a href ="http://localhost:8080/project/evenementenlijst.php">Update gelukt ga terug</a>
		</div>
	</div>
<?php echo $pagina->getFooter(); ?>
</div>



<?php
echo $pagina->getVereisteHTMLafsluiting();
?>