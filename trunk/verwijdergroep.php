<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
isHimSelf($_GET["id"]);
$pagina = pagina::getInstantie();
database::getInstantie();

$naam = "";
$error = "";
if (isset($_GET["groepid"])) {
	$sql = "SELECT * FROM groep INNER JOIN student ON eigenaar = studentid WHERE groepid = ".mysql_real_escape_string($_GET["groepid"]." LIMIT 1;");
	$resultaat_van_server = mysql_query($sql);
	if (mysql_num_rows($resultaat_van_server) > 0) {
		$array = mysql_fetch_assoc($resultaat_van_server);
		$naam = " ".$array["naam"];
	}
}

if (isset($_POST["verwijder"])) {
	$query = "DELETE FROM groeplid WHERE groeplid.groepid = ".$_GET["groepid"].";";
	mysql_query($query);
	$query = "DELETE FROM groep WHERE groep.groepid = ".$_GET["groepid"].";";
	mysql_query($query);
}

$pagina->setTitel("Verwijder vriendengroep".$naam);
$pagina->setCss("style.css");
$pagina->setJavascriptCode("
	function bevestig() {
		var answer = confirm('Weet u zeker dat u deze groep wilt verwijderen?');
		if (answer) {
			return true;
		} else {
			return false;
		}
	}
");

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
			} else if (isset($_POST["verwijder"]) && $error == "") {
				header("location:raadplegenprofiel.php?id=".$_POST["eigenaar"]);
			}
			
			if (isset($_GET["groepid"]) && isset($array)) {
				$query = "SELECT * FROM groeplid INNER JOIN student ON student.studentid = groeplid.studentid WHERE groeplid.groepid = ".$array["groepid"].";";
				$resultaat = mysql_query($query);
				if (mysql_num_rows($resultaat) > 0) {
					echo "<form action=\"verwijdergroep.php?groepid=".$_GET["groepid"]."\" method=\"post\">";
					echo "<table style=\"text-align:left;\">";
					echo "<tr><th colspan=\"4\">Groep ".$array["naam"]." met leden:</th></tr>";
					echo "<tr><th>Studentennummer</th><th>Naam</th><th>Geslacht</th><th>Geboortedatum</th></tr>";
						while ($rij = mysql_fetch_assoc($resultaat)) {
							echo "<tr><td>".$rij["studentnr"]."</td><td><a href=\"raadplegenprofiel.php?id=".$rij["studentid"]."\">".$rij["voornaam"]." ".$rij["achternaam"]."</a></td><td>".$rij["geslacht"]."</td><td>".tijd::formatteerTijd($rij["geboortedatum"], "d-m-Y")."</td></tr>";
						}
					echo "<tr><td colspan=\"4\" style=\"text-align:right;\"><input type=\"hidden\" name=\"eigenaar\" value=\"".$array["eigenaar"]."\" /><input type=\"submit\" name=\"verwijder\" value=\"Verwijder groep\" onclick=\"return bevestig();\" /></td></tr></table></form>";
				} else {
					echo "Er zijn nog geen vrienden aan deze groep gekoppeld.";
				}
			} else {
				echo "Geen resultaten beschikbaar.";
			}
			?>
			<br /><a href="raadplegenprofiel.php?id=<?php echo $_GET["id"]; ?>">Terug</a>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();
?>