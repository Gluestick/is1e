<?php
/**
 * @author: Daniel
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

$studentid = mysql_real_escape_string($_GET["id"]);

$sql = "SELECT studentnr, voornaam, achternaam, adres, postcode, woonplaats, geslacht, geboortedatum, emailadres, profielfoto
		FROM student S JOIN user U ON S.studentid = U.studentid
		WHERE S.studentid = '$studentid' LIMIT 1;";

$resultaat_van_server = mysql_query($sql);
$array = mysql_fetch_array($resultaat_van_server);

$naam = "";
if (mysql_num_rows($resultaat_van_server) > 0) {
	$naam = "van " . $array["voornaam"] . " " . $array["achternaam"];
}

$pagina->setTitel("Studenten profiel " . $naam);
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>
			<a href="wijzigprofiel.php?id=<?php echo $studentid; ?>"> wijzig </a>

			<table style="text-align:left;">
				<tr>
					<th>
						Profielfoto
					</th>
					<td>
						<?php if (!empty($array["profielfoto"])) { ?>
							<img src="data:image/png;base64,<?php echo $array["profielfoto"]; ?>" alt="avatar" title="avatar" />
						<?php } else { ?>
							Geen profielfoto.
						<?php } ?>
					</td>
				</tr>
				<tr>
					<th>  Studentnummer  </th>
					<td> <?php echo $array["studentnr"]; ?> </td>
				</tr>
				<tr>
					<th>  Voornaam  </th>
					<td> <?php echo $array["voornaam"]; ?></td>
				</tr>
				<tr>
					<th>  Achternaam  </th>
					<td><?php echo $array["achternaam"]; ?></td>
				</tr>
				<tr>
					<th>  Adres  </th>
					<td><?php echo $array["adres"]; ?></td>
				</tr>
				<tr>
					<th>  Postcode  </th>
					<td><?php echo $array["postcode"]; ?></td> 
				</tr>
				<tr>
					<th>  Woonplaats </th>
					<td><?php echo $array["woonplaats"]; ?></td>
				</tr>
				<tr>
					<th>  Geslacht  </th>
					<td><?php echo $array["geslacht"]; ?></td>
				</tr>
				<tr>
					<th>  Geboortedatum   </th> 
					<td><?php echo $array["geboortedatum"]; ?></td>
				</tr>
				<tr>
					<th>  E-mail   </th> 
					<td><?php echo $array["emailadres"]; ?></td>
				</tr>

			</table> 
			</br>


			Mijn berichten ( <a href="plaatsenprofielbericht.php?id=<?php echo $studentid; ?>"> toevoegen </a>)



			<?php
			database::getInstantie();
			$id = mysql_real_escape_string($_GET["id"]);
			$query = "SELECT * FROM profielbericht WHERE studentid = " . $studentid . ";";
			$resultaat_van_server = mysql_query($query);

			echo "<table style=\"text-align:left;\">";
			while ($row = mysql_fetch_array($resultaat_van_server)) {
				echo "<tr><th>datum</th><td> " . $row["datum"] . "</td></tr> ";
				echo "<tr><th>onderwerp</th><td>" . $row["onderwerp"] . "</td></tr> ";
				echo "<tr><th>bericht</th><td>" . specialetekens::vervangTekensInTekst($row["inhoud"]) . "</td></tr> ";
			}
			echo "</table>";
			?>



			<b>Evenementen</b> </br>

			Bezocht: 



<?php
$sql = "SELECT * FROM aanmelding INNER JOIN evenement ON evenement.evenementid = aanmelding.evenementid WHERE studentid = " . $studentid . " ;";
$resultaat_van_server = mysql_query($sql);



echo" evenementen bezocht";
echo"<table style=\"text-align:left;\">";
while ($row = mysql_fetch_array($resultaat_van_server)) {
	if ($row["begindatum"] <= date("Y-m-d")) {
		echo "<tr><th>naam</th><td><a href=\"evenement.php?id=" . $row["evenementid"] . "\">" . $row["naam"] . "</a></td></tr> ";
		echo "<tr><th>begindatum</th><td>" . tijd::formatteerTijd($row["begindatum"], "d-m-Y") . "</td></tr> ";
		echo "<tr><th>vereniging</th><td>" . $row["organiserendeverenigingid"] . "</td></tr> ";
		echo "<tr><th>categorie</th><td>" . $row["categorieid"] . "</td></tr> ";
	}
}
echo"</table> ";
echo"evenementen nog te bezoeken";
echo"<table style=\"text-align:left;\">";
$sql = "SELECT * FROM aanmelding INNER JOIN evenement ON evenement.evenementid = aanmelding.evenementid WHERE studentid = " . $studentid . " ;";
$resultaat_van_server = mysql_query($sql);
while ($row = mysql_fetch_array($resultaat_van_server)) {
	if ($row["begindatum"] > date("Y-m-d")) {
		echo "<tr><th>naam</th><td><a href=\"evenementen.php\">" . $row["naam"] . "</a></td></tr> ";
		echo "<tr><th>begindatum</th><td>" . tijd::formatteerTijd($row["begindatum"], "d-m-Y") . "</td></tr> ";
		echo "<tr><th>vereniging</th><td>" . $row["organiserendeverenigingid"] . "</td></tr> ";
		echo "<tr><th>categorie</th><td>" . $row["categorieid"] . "</td></tr> ";
	}
}
echo"</table> ";

$sql = "SELECT * FROM groep WHERE eigenaar = ".mysql_real_escape_string($_GET["id"]);
$resultaat_van_server = mysql_query($sql);
if (mysql_num_rows($resultaat_van_server) > 0) {
	echo "<table style=\"text-align:left;\">";
	echo "<tr><th>Groepen die u heeft aangemaakt:</th></tr>";
	while ($array = mysql_fetch_assoc($resultaat_van_server)) {
		echo "<tr><td valign=\"middle\"><a href=\"vriendengroep.php?groepid=".$array["groepid"]."\">".$array["naam"]."</a></td></tr>";
	}
	echo "</table>";
} else {
	echo "U heeft nog geen groepen aangemaakt";
}

?>
		</div>
	</div>
			<?php echo $pagina->getFooter(); ?>
</div>



<?php
echo $pagina->getVereisteHTMLafsluiting();