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
			<h1><?php echo $pagina->getTitel();
		if (isAdmin()) { ?>&nbsp;<a href="wijzigvereniging.php?id=<?php
				if (isset($verenigingid)) {
					print $verenigingid;
				}
			?>">Wijzig</a><?php } ?></h1>
				<?php
				if (isset($_POST["aanmelden"]) && !empty($_GET["id"]) && isset($_SESSION["login"]) && isset($_SESSION["studentid"])) {
					$today = getdate();
					$date = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
					$aanmelden = mysql_query("INSERT INTO lidmaatschap VALUES ('{$_SESSION["studentid"]}', '{$_GET["id"]}', '$date')");
					if ($aanmelden == true) {
						print "Succesvol aangemeld!<br/><br/>";
					} else {
						print "Kan niet worden aangemeld.<br/><br/>";
					}
				}
				elseif (isset($_POST["afmelden"]) && !empty($_GET["id"]) && isset($_SESSION["login"]) && isset($_SESSION["studentid"])) {
					$today = getdate();
					$date = $today["year"] . "-" . $today["mon"] . "-" . $today["mday"];
					$afmelden = mysql_query("DELETE FROM lidmaatschap WHERE studentid = {$_SESSION["studentid"]} AND verenigingid = {$_GET["id"]}");
					if ($afmelden == true) {
						print "Succesvol afgemeld!<br/><br/>";
					} else {
						print "Kan niet worden afgemeld.<br/><br/>";
					}
				}
				if (!empty($_GET["id"])) {
					$aantal_leden = mysql_num_rows(mysql_query("SELECT * FROM lidmaatschap WHERE verenigingid='{$_GET["id"]}'"));
					$sql = "SELECT * FROM student JOIN lidmaatschap ON student.studentid=lidmaatschap.studentid WHERE verenigingid='$verenigingid' AND lidmaatschap.studentid IS NOT NULL";
					$resultaat_van_server = mysql_query($sql) or die(mysql_error());
					?>
				<table><tr>
						<th>Leden</th>
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
						<td><?php $ding = mysql_fetch_assoc(mysql_query("SELECT username, email FROM user JOIN vereniging ON vereniging.userid = user.user_id WHERE vereniging.verenigingid = '".$_GET['id']."';"));
						print $ding['username']; ?></td>
					</tr>
					<tr>
						<td>Telefoonnummer</td>
						<td><?php print $row["telefoonnr"]; ?></td>
					</tr>
					<tr>
						<td>E-mail adres</td>
						<td><?php print "<a href=\"mailto:" . $ding["email"] . "\">" . $ding["email"] . "</a>"; ?></td>
					</tr>
				</table>
				<form action="<?php print $_SERVER["PHP_SELF"] . "?id=" . $_GET["id"]; ?>" method="post">
					<input type="hidden" name="id" value="<?php print $_GET["id"]; ?>" />
	<?php if (isStudent() && mysql_num_rows(mysql_query("SELECT * FROM lidmaatschap WHERE studentid = {$_SESSION["studentid"]} AND verenigingid = {$_GET["id"]}")) == 0) { ?><input type="submit" name="aanmelden" value="Aanmelden" /><?php } 
	elseif (isStudent() && mysql_num_rows(mysql_query("SELECT * FROM lidmaatschap WHERE studentid = {$_SESSION["studentid"]} AND verenigingid = {$_GET["id"]}")) >= 1) { ?><input type="submit" name="afmelden" value="Afmelden" /><?php } ?>
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