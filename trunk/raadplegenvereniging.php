<?php
/**
 * @author: Joep Kemperman
 * @description: 
 */
if (!empty($_GET["id"])) {
	database::getInstantie();
	$verenigingid = $_GET["id"];
	$sql = "SELECT * FROM vereniging WHERE verenigingid=$verenigingid";
	$resultaat_van_server = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($resultaat_van_server);
} else {
	$row["naam"] = "Vereniging";
}
$pagina = pagina::getInstantie();
$pagina->setTitel($row["naam"]);
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1><?php if(isAdmin()){?><p><a href="wijzigvereniging.php?id=<?php if (isset($verenigingid)){ print $verenigingid; }?>">Wijzig vereniging</a><?php }?>
			<?php
			if (isset($_POST["aanmelden"])) {
				$getdatum = getdate();
				$datum = $getdatum["year"] . "-" . $getdatum["mon"] . "-" . $getdatum["mday"];
				$sql = "INSERT INTO lidmaatschap VALUES(" . mysql_real_escape_string($_POST["studentid"]) . ", " . mysql_real_escape_string($_POST["id"]) . ", '$datum')";
				$result = mysql_query($sql);
				if ($result != true) {
					print"Student niet aan vereniging toegevoegd. Misschien ben je al lid?";
				}
			}
			if (!empty($_GET["id"])) {
				$aantal_leden = mysql_num_rows(mysql_query("SELECT * FROM lidmaatschap WHERE verenigingid='{$_GET["id"]}'"));
				$sql = "SELECT * FROM student JOIN lidmaatschap ON student.studentid=lidmaatschap.studentid WHERE verenigingid='$verenigingid' AND lidmaatschap.studentid IS NOT NULL";
				$resultaat_van_server = mysql_query($sql) or die(mysql_error());
				?>
				<table>
					<tr>
						<th align="left">Leden</th>
					</tr>
					<?php
					while ($array = mysql_fetch_array($resultaat_van_server)) {
						print "<tr><td><a href=\"raadplegenprofiel.php?id=" . $array["studentid"] . "\">" . $array["voornaam"] . " " . $array["achternaam"] . "</a></td></tr>";
					}
					?>
				</table><br/>
				<table>
					<tr>
						<th colspan="2">Evenementen</th>
					</tr>
					<tr>
						<th>Naam</th>
						<th>Begindatum</th>
					</tr>
					<?php
					$sql = "SELECT * FROM evenement WHERE organiserendeverenigingid=$verenigingid";
					$resultaat_van_server = mysql_query($sql) or die(mysql_error());
					$format = "d-m-Y";
					while ($array = mysql_fetch_array($resultaat_van_server)) {
						$begindatum = tijd::formatteerTijd($array["begindatum"], $format);
						print"<tr><td><a href=\"evenement.php?id=" . $array["evenementid"] . "\">" . $array["naam"] . "</a></td><td>" . $begindatum . "</td></tr>";
					}
					?>
				</table><br/>
				<?php
				$sql = "SELECT * FROM vereniging WHERE verenigingid=$verenigingid";
				$resultaat_van_server = mysql_query($sql) or die(mysql_error());
				$row = mysql_fetch_assoc($resultaat_van_server);
				?>
				<table>
					<tr>
						<th colspan="2">Info over vereniging</th>
					</tr>
					<tr>
						<td>Adres</td>
						<td><?php print $row["adres"]; ?></td>
					</tr>
					<tr>
						<td>Postcode</td>
						<td><?php print $row["postcode"]; ?></td>
					</tr>
					<tr>
						<td>Plaats</td>
						<td><?php print $row["plaats"]; ?></td>
					</tr>
					<tr>
						<td>Aantal Leden</td>
						<td><?php print $aantal_leden; ?></td>
					</tr>
					<tr>
						<td>KVK</td>
						<td><?php print $row["kvk"]; ?></td>
					</tr>
					<tr>
						<td>Contactpersoon</td>
						<td><?php print $row["contactpersoon"]; ?></td>
					</tr>
					<tr>
						<td>Telefoonnummer</td>
						<td><?php print $row["telefoonnr"]; ?></td>
					</tr>
					<tr>
						<td>E-mail adres</td>
						<td><?php print "<a href=\"mailto:" . $row["emailadres"] . "\">" . $row["emailadres"] . "</a>"; ?></td>
					</tr>
				</table>
				<form action="<?php print $_SERVER["PHP_SELF"] . "?id=" . $_GET["id"]; ?>" method="post">
					<input type="hidden" name="id" value="<?php print $_GET["id"]; ?>" />
					<select name="studentid">
						<?php
						$sql = "SELECT * FROM student ORDER BY voornaam";
						$resultaat_van_server = mysql_query($sql) or die(mysql_error());

						while ($array = mysql_fetch_array($resultaat_van_server)) {
							print "<option value=\"" . $array["studentid"] . "\">" . $array["voornaam"] . " " . $array["achternaam"] . "</option>";
						}
						print "</select><input type=\"submit\" name=\"aanmelden\" value=\"Aanmelden\" />";
						?>
				</form>
			</div>
		</div>
		<?php
	} else {
		print "<h3>Oops!</h3>Er is iets fout gegaan! Klik <a href='index.php'>hier</a> om terug naar de hoofdpagina te gaan.";
	}
	?>
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