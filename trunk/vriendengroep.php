<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

$naam = "";
if (isset($_GET["groepid"])) {
	$sql = "SELECT * FROM groep INNER JOIN student ON eigenaar = studentid WHERE groepid = ".mysql_real_escape_string($_GET["groepid"]." LIMIT 1;");
	$resultaat_van_server = mysql_query($sql);
	if (mysql_num_rows($resultaat_van_server) > 0) {
		$array = mysql_fetch_assoc($resultaat_van_server);
	}
	$naam = " ".$array["naam"]." van ".$array["voornaam"]." ".$array["achternaam"];
}

$pagina->setTitel("Vriendengroep".$naam);
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
			if (isset($_GET["groepid"])) {
				echo "<table style=\"text-align:left;\">";
				echo "<tr><th colspan=\"4\">Leden:</th></tr>";
				echo "<tr><th>Studentennummer</th><th>Naam</th><th>Geslacht</th><th>Geboortedatum</th></tr>";

					$query = "SELECT * FROM groeplid INNER JOIN student ON student.studentid = groeplid.studentid WHERE groepid = ".$array["groepid"];
					$resultaat = mysql_query($query);
					while ($rij = mysql_fetch_assoc($resultaat)) {
						echo "<tr><td>".$rij["studentnr"]."</td><td><a href=\"raadplegenprofiel.php?id=".$rij["studentid"]."\">".$rij["voornaam"]." ".$rij["achternaam"]."</a></td><td>".$rij["geslacht"]."</td><td>".tijd::formatteerTijd($rij["geboortedatum"], "d-m-Y")."</td></tr>";
					}
				echo "</table>";
				echo "<a href=\"aanmeldengroep.php?groepid=".$array["groepid"]."\">Voor groep aanmelden</a>";
			} else {
				echo "Geen resultaten beschikbaar.";
			}
			?>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();
?>