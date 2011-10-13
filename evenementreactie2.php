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
			database::getInstantie();

			$id = $_POST["evenementid"];
			$naam = $_POST["naam"];
			$tekstvak = $_POST["tekstvak"];
			$tijdstip = date("Y-m-d");

			if (($naam) && ($tekstvak)) {
				$query1 = "INSERT INTO reactie (evenementid,afzender, inhoud, tijdstip) 
			VALUES('$id','$naam', '$tekstvak', '$tijdstip')";

				mysql_query($query1);
			}
			?>
			<table>
				<tr>
					<td>Naam </td>
					<td>
						<?php
						if ($naam != "") {
							echo $naam;
						} else {
							echo "Naam is verplicht!";
						}
						?>
					</td>
				</tr>
				<tr>
					<td>Datum </td>
					<td><?php echo date("d/m/Y"); ?></td>
				</tr>
				<tr>
					<td>Bericht </td>
					<td>
						<?php
						if ($tekstvak != "") {
							echo specialetekens::vervangTekensInTekst($tekstvak);
						} else {
							echo "Bericht is verplicht!";
						}
						?>
					</td>
				</tr>
			</table>
			<a href="evenementreactie.php?id=1"/> Ga terug</a>
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