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
			<a href="evenement.php?id=<?php echo $id; ?>"/> Ga terug</a>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>



<?php
echo $pagina->getVereisteHTMLafsluiting();
?>