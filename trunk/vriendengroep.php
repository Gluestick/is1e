<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */

if (!isMember()) {
	header("location:index.php");
}
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
				$query1 = "SELECT * FROM groeplid INNER JOIN student ON student.studentid = groeplid.studentid WHERE groepid = ".$array["groepid"]." AND groeplid.lid = 1";
				$resultaat1 = mysql_query($query1);
				if ($resultaat1) {
					if (mysql_num_rows($resultaat1) > 0) {
						echo "<form action=\"vriendengroep.php?groepid=".$_GET["groepid"]."\" method=\"post\">";
						echo "<table style=\"text-align:left;\">";
						if (isset($_SESSION["user_id"]) && $_GET["id"] == $_SESSION["studentid"]) {
							echo "<tr><th colspan=\"5\">Leden:</th></tr>";
							echo "<tr><th></th><th>Studentennummer</th><th>Naam</th><th>Geslacht</th><th>Geboortedatum</th></tr>";
						} else {
							echo "<tr><th colspan=\"4\">Leden:</th></tr>";
							echo "<tr><th>Studentennummer</th><th>Naam</th><th>Geslacht</th><th>Geboortedatum</th></tr>";
						}
						while ($rij = mysql_fetch_assoc($resultaat1)) {
							echo "<tr>";
							if (isset($_SESSION["user_id"]) && $_GET["id"] == $_SESSION["studentid"]) {
								echo "<td><input type=\"checkbox\" name=\"student[]\" value=\"".$rij["studentid"]."\" /></td>";
							}
							echo "<td>".$rij["studentnr"]."</td><td><a href=\"raadplegenprofiel.php?id=".$rij["studentid"]."\">".$rij["voornaam"]." ".$rij["achternaam"]."</a></td><td>".$rij["geslacht"]."</td><td>".tijd::formatteerTijd($rij["geboortedatum"], "d-m-Y")."</td></tr>";
						}
						if (isset($_SESSION["user_id"]) && $_GET["id"] == $_SESSION["studentid"]) {
							echo "<tr><td colspan=\"5\" style=\"text-align:right;\"><input type=\"submit\" name=\"afmelden\" value=\"Afmelden voor deze groep\" /></td></tr>";
						}
						echo "</table></form>";
					} else {
						echo "Er zijn nog geen vrienden die die u heeft uitgenodigd/de uitnodiging hebben geaccepteerd.";
					}
				} else {
					echo "Er zijn nog geen vrienden die die u heeft uitgenodigd/de uitnodiging hebben geaccepteerd.";
				}
				
				$query2 = "SELECT * FROM groeplid INNER JOIN student ON student.studentid = groeplid.studentid WHERE groepid = ".$array["groepid"]." AND groeplid.lid = 0";
				$resultaat2 = mysql_query($query2);
				if ($resultaat2) {
					if (mysql_num_rows($resultaat2) > 0) {
						echo "<br /><br /><br /><form action=\"vriendengroep.php?groepid=".$_GET["groepid"]."\" method=\"post\">";
						echo "<table style=\"text-align:left;\">";
						echo "<tr><th colspan=\"4\">Uitgenodigde studenten:</th></tr>";
						echo "<tr><th>Studentennummer</th><th>Naam</th><th>Geslacht</th><th>Geboortedatum</th></tr>";
							while ($rij2 = mysql_fetch_assoc($resultaat2)) {
								echo "<tr><td>".$rij2["studentnr"]."</td><td><a href=\"raadplegenprofiel.php?id=".$rij2["studentid"]."\">".$rij2["voornaam"]." ".$rij2["achternaam"]."</a></td><td>".$rij2["geslacht"]."</td><td>".tijd::formatteerTijd($rij2["geboortedatum"], "d-m-Y")."</td></tr>";
							}
						echo "<tr><td colspan=\"4\" style=\"text-align:right;\"></td></tr></table></form>";
					} else {
						echo "<br /><br />Er zijn geen studenten uitgenodigd voor deze groep.";
					}
				} else {
					echo "<br /><br />Er zijn geen studenten uitgenodigd voor deze groep.";
				}
			} else {
				echo "Geen resultaten beschikbaar.";
			}
			?>
			<br /><br /><a href="raadplegenprofiel.php?id=<?php echo $_GET["id"]; ?>">Terug</a>
			<div style="clear:both;"></div>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();
?>