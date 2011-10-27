<?php
/**
 * @author: Daniel
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

$studentid = mysql_real_escape_string($_GET["id"]);

$sql = "SELECT studentid, U.user_id as user_id, studentnr, voornaam, achternaam, adres, postcode, woonplaats, geslacht, geboortedatum, email, profielfoto
		FROM student S JOIN user U ON S.userid = U.user_id
		WHERE S.studentid = '$studentid' LIMIT 1;";

$resultaat_van_server = mysql_query($sql);
$array = mysql_fetch_array($resultaat_van_server);

$studentid = $array['studentid'];
$userid = $array['user_id'];

$naam = "";
if (mysql_num_rows($resultaat_van_server) > 0) {
	$naam = $array["voornaam"] . " " . $array["achternaam"];
}

$pagina->setTitel($naam);
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?>&nbsp;
			<?php if(isset($_SESSION['user_id']) && $userid == $_SESSION['user_id']){ ?>
				<a href="wijzigprofiel.php?id=<?php echo $studentid; ?>"> wijzig </a>
			<?php } ?>
			</h1>

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
					<td><?php echo tijd::formatteerTijd($array["geboortedatum"], "d-m-Y"); ?></td>
				</tr>
				<tr>
					<th>  E-mail   </th> 
					<td><?php echo $array["email"]; ?></td>
				</tr>

			</table> 
			<br />
			Mijn berichten ( <a href="plaatsenprofielbericht.php?id=<?php echo $studentid; ?>"> toevoegen </a>)
			<?php
			database::getInstantie();
			$id = mysql_real_escape_string($_GET["id"]);
			$query = "SELECT * FROM profielbericht WHERE studentid = ".$studentid.";";
			$resultaat_van_server = mysql_query($query);

			echo "<table style=\"text-align:left;\">";
			
			$teller = 0;
			
			while ($row = mysql_fetch_array($resultaat_van_server)) {
				
				$teller++;
				
				if(is_int($teller/2))
				{
					$color = "red";
				}
				else
				{
					$color = "blue";
				}
				
				echo "<tr style='background-color:".$color."'><th>datum</th><td> ".tijd::formatteerTijd($row["datum"], "d-m-Y")."</td></tr> ";
				echo "<tr><th>onderwerp</th><td>" . $row["onderwerp"] . "</td></tr> ";
				echo "<tr><th>bericht</th><td>" . specialetekens::vervangTekensInTekst($row["inhoud"]) . "</td></tr> ";
			}
			echo"</table>";
			echo"<br/>";
			
			
			$sql1 ="SELECT l.verenigingid, v.naam ,l.studentid
					FROM lidmaatschap AS l
					JOIN vereniging AS v
					ON v.verenigingid = l.verenigingid
					WHERE l.studentid =" .$studentid.";";
					$resultaat1 = mysql_query($sql1) ;
			if (mysql_num_rows($resultaat1) > 0) {
			
			echo"<table> ";
			echo"</br>";
				
			echo"<tr><td> is lid van </td></tr>";
				
			while( $row= mysql_fetch_array($resultaat1)) {
				echo"<tr><td>vereniging</td><td><a href=\"raadplegenvereniging.php?id=".$row["verenigingid"]." \">" .$row["naam"]." </a></td></tr> ";
			}
			echo"</table>";
			} else {
					echo"student is nog geen lid van een vereniging";
					echo"<br/>";
				}
			
			?>
			<br />
			<?php
			$sql1 = "SELECT aanmelding.evenementid, evenement.begindatum, evenement.naam AS evenementnaam, vereniging.naam AS verenigingnaam, categorie.naam AS categorienaam FROM aanmelding 
					INNER JOIN evenement ON evenement.evenementid = aanmelding.evenementid 
					INNER JOIN vereniging ON vereniging.verenigingid = evenement.organiserendeverenigingid
					INNER JOIN categorie ON evenement.categorieid = categorie.categorieid
					WHERE studentid = ".$studentid."
					AND evenement.begindatum <= CURDATE();";
			$resultaat_van_server1 = mysql_query($sql1);
			
			$sql2 = "SELECT aanmelding.evenementid, evenement.begindatum, evenement.naam AS evenementnaam, vereniging.naam AS verenigingnaam, categorie.naam AS categorienaam FROM aanmelding 
					INNER JOIN evenement ON evenement.evenementid = aanmelding.evenementid 
					INNER JOIN vereniging ON vereniging.verenigingid = evenement.organiserendeverenigingid
					INNER JOIN categorie ON evenement.categorieid = categorie.categorieid
					WHERE studentid = " . $studentid . "
					AND evenement.begindatum > CURDATE();";
			$resultaat_van_server2 = mysql_query($sql2);
			
			if ((mysql_num_rows($resultaat_van_server1) > 0) || (mysql_num_rows($resultaat_van_server2) > 0)) {
				echo "<b>Evenementen</b><br />";
				if (mysql_num_rows($resultaat_van_server1) > 0) {
					echo"Evenementen bezocht:";
					echo"<table style=\"text-align:left;\">";
					while ($row = mysql_fetch_array($resultaat_van_server1)) {
						echo "<tr><th>naam</th><td><a href=\"evenement.php?id=" . $row["evenementid"] . "\">" . $row["evenementnaam"] . "</a></td></tr> ";
						echo "<tr><th>begindatum</th><td>" . tijd::formatteerTijd($row["begindatum"], "d-m-Y") . "</td></tr> ";
						echo "<tr><th>vereniging</th><td>" . $row["verenigingnaam"] . "</td></tr> ";
						echo "<tr><th>categorie</th><td>" . $row["categorienaam"] . "</td></tr> ";
					}
					echo"</table> ";
				}
				
				if (mysql_num_rows($resultaat_van_server2) > 0) {
					echo"<br />Evenementen nog te bezoeken:";
					echo"<table style=\"text-align:left;\">";

					while ($row = mysql_fetch_array($resultaat_van_server2)) {
						echo "<tr><th>naam</th><td><a href=\"evenement.php?id=" . $row["evenementid"] . "\">" . $row["evenementnaam"] . "</a></td></tr> ";
						echo "<tr><th>begindatum</th><td>" . tijd::formatteerTijd($row["begindatum"], "d-m-Y") . "</td></tr> ";
						echo "<tr><th>vereniging</th><td>" . $row["verenigingnaam"] . "</td></tr> ";
						echo "<tr><th>categorie</th><td>" . $row["categorienaam"] . "</td></tr> ";
					}
					echo"</table> ";
				}
			}
			else{
				 echo"student heeft zich nog niet aangemeld voor een evenement";
			}
			echo "<br />";
			if(isMember()){
				$sql = "SELECT * FROM groep WHERE eigenaar = ".mysql_real_escape_string($_GET["id"]);
				$resultaat_van_server = mysql_query($sql);
				if (mysql_num_rows($resultaat_van_server) > 0) {
					echo "<table style=\"text-align:left;\">";
					echo "<tr><th>Groepen:</th></tr>";
					while ($array = mysql_fetch_assoc($resultaat_van_server)) {
						echo "<tr><td valign=\"middle\"><a href=\"vriendengroep.php?groepid=".$array["groepid"]."\">".$array["naam"]."</a></td><td>"; if (isset($_SESSION['user_id']) && $userid == $_SESSION['user_id']) { echo "<a href=\"wijziggroep.php?id=".$_GET["id"]."&groepid=".$array["groepid"]."\">Wijzig</a>"; } echo "</td><td>"; if (isset($_SESSION['user_id']) && $userid == $_SESSION['user_id']) { echo "<a href=\"verwijdergroep.php?id=".$_GET["id"]."&groepid=".$array["groepid"]."\">Verwijder</a>"; } echo "</td></tr>";
					}
					echo "</table><br /><br />
						<a href=\"groeptoevoegen.php?id=".$_GET["id"]."\">Groep toevoegen</a>";
				}
			}

			?>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();