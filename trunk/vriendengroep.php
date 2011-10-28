<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

$naam = "";
$error = "";
if (isset($_GET["groepid"])) {
	$sql = "SELECT * FROM groep INNER JOIN student ON eigenaar = studentid WHERE groepid = ".mysql_real_escape_string($_GET["groepid"]." LIMIT 1;");
	$resultaat_van_server = mysql_query($sql);
	if (mysql_num_rows($resultaat_van_server) > 0) {
		$array = mysql_fetch_assoc($resultaat_van_server);
		$naam = " ".$array["naam"]." van ".$array["voornaam"]." ".$array["achternaam"];
	}
}

if (isset($_POST["afmelden"])) {
	if (isset($_POST["student"]) && !empty($_POST["student"]) && is_array($_POST["student"])) {
		foreach ($_POST["student"] as $key => $val) {
			$query = "DELETE FROM groeplid WHERE studentid = ".mysql_real_escape_string($val)." AND groepid = ".mysql_real_escape_string($_GET["groepid"]).";";
			mysql_query($query);
		}
	} else {
		$error .= "<li>Er ging iets fout.</li>";
	}
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
			if ($error != "") {
				echo $error;
			}
			
			if (isset($_GET["groepid"]) && isset($array)) {
				$query = "SELECT * FROM groeplid INNER JOIN student ON student.studentid = groeplid.studentid WHERE groepid = ".$array["groepid"];
				$resultaat = mysql_query($query);
				if (mysql_num_rows($resultaat) > 0) {
					echo "<form action=\"vriendengroep.php?groepid=".$_GET["groepid"]."\" method=\"post\">";
					echo "<table style=\"text-align:left;\">";
					echo "<tr><th colspan=\"5\">Leden:</th></tr>";
					echo "<tr><th></th><th>Studentennummer</th><th>Naam</th><th>Geslacht</th><th>Geboortedatum</th></tr>";
						while ($rij = mysql_fetch_assoc($resultaat)) {
							echo "<tr><td><input type=\"checkbox\" name=\"student[]\" value=\"".$rij["studentid"]."\" /></td><td>".$rij["studentnr"]."</td><td><a href=\"raadplegenprofiel.php?id=".$rij["studentid"]."\">".$rij["voornaam"]." ".$rij["achternaam"]."</a></td><td>".$rij["geslacht"]."</td><td>".tijd::formatteerTijd($rij["geboortedatum"], "d-m-Y")."</td></tr>";
						}
					echo "<tr><td colspan=\"5\" style=\"text-align:right;\"><input type=\"submit\" name=\"afmelden\" value=\"Afmelden voor deze groep\" /></td></tr></table></form>";
				} else {
					echo "Er zijn nog geen vrienden aan deze groep gekoppeld.";
				}
			} else {
				echo "Geen resultaten beschikbaar.";
			}
			if (isset($array)) {
				echo "<br /><a href=\"aanmeldengroep.php?id=".$_GET["id"]."&groepid=".$array["groepid"]."\">Voor groep aanmelden</a>";
			}
			?>
			<br /><br /><a href="raadplegenprofiel.php?id=<?php echo $_GET["id"]; ?>">Terug</a>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();
?>