<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

$pagina->setTitel("Vriendengroep");
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
			if (isset($_GET["id"])) {
				$sql = "SELECT * FROM groep WHERE eigenaar = ".mysql_real_escape_string($_GET["id"]);
				$resultaat_van_server = mysql_query($sql);
				if (mysql_num_rows($resultaat_van_server) > 0) {
					echo "<table style=\"text-align:left;\">";
					while ($array = mysql_fetch_assoc($resultaat_van_server)) {
						$query = "SELECT * FROM groeplid INNER JOIN student ON student.studentid = groeplid.studentid WHERE groepid = ".$array["groepid"];
						$resultaat = mysql_query($query);
						echo "<tr><td valign=\"middle\" rowspan=\"".(mysql_num_rows($resultaat) + 1)."\">".$array["naam"]."</td></tr>";
						while ($rij = mysql_fetch_assoc($resultaat)) {
							echo "<tr><td><a href=\"raadplegenprofiel.php?id=".$rij["studentid"]."\">".$rij["voornaam"]." ".$rij["achternaam"]."</a></td></tr>";
						}
					}
					echo "</table>";
				} else {
					echo "U heeft nog geen groepen aangemaakt";
				}
			} else {
				echo "Geen gegevens beschikbaar";
			}
			?>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();
?>