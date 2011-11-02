<?php
/**
 * @author: Daniel
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

if (!isset($_GET["id"]) || empty($_GET["id"]) || !intval($_GET["id"])) {
	header("location:index.php");
}

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

$pagina->setJavascript("jquery.js");
$pagina->setJavascript("jquery.colorbox-min.js");
$pagina->setJavascriptCode("
	$(document).ready(function() {
		$(\".invite\").click(function(){
			var vriendengroep = '';
			var verwijder = false;
			if ($(\"#vriendengroep span:first-child\").length != 0) {
				vriendengroep = $(\"#vriendengroep span:first-child\").attr('class');
				verwijder = true;
			} else {
				vriendengroep = $(\"#vriendengroep select\").val();
			}
		
			$.post('uitnodiging.php', { studentid: ".$_GET["id"].", groepid: vriendengroep }, function(data) {
				alert(data);
			}).complete(function() {
				if (verwijder) {
					$(\"#vriendengroep\").remove();
				}
			});
		});
		$(\".accept\").click(function(){
			$.colorbox({href:\"accepteren.php\"});
				$(document).bind('cbox_complete', function(){
					$(\"#inline_content .accept, #inline_content .ignore\").click(function(){
					var index = $(this).parent().parent().parent().parent();
					var actie = $(this).html();
					$.post('uitnodiging.php', { studentid: ".$_GET["id"].", groepid: index.attr('class'), action: actie }, function(data) {
					}).complete(function() {
						if ($(\"#inline_content table\						var aantal = $(\"#teaccepteren\").html().match(/\\((.*?)\\)/);
							var number = aantal[1];
							var newnumber = number - 1;
							$(\"#teaccepteren\").html($(\"#teaccepteren\").html().replace(number, newnumber));
						} else {
							$.colorbox.close();
							$(\"#teaccepteren\").remove();
						}
					});
				});
			});
			
		});
	});
");

$pagina->setTitel($naam);
$pagina->setCss("style.css");
$pagina->setCss("colorbox.css");

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
			<?php
			if (isset($userid) && !empty($userid) && intval($userid) && isset($_SESSION["studentid"]) && isset($_SESSION['user_id']) && $userid != $_SESSION['user_id']) {
				$query = "SELECT * FROM groep WHERE eigenaar = ".$_SESSION["studentid"]." AND groepid NOT IN (SELECT groepid FROM groeplid WHERE studentid = ".  mysql_real_escape_string($_GET["id"]).");";
				$resultaat = mysql_query($query);
				if ($resultaat && mysql_num_rows($resultaat) > 0) {
			?>
			<div style="float:right;" id="vriendengroep">
				Uitnodigen voor vriendengroep: 
				<?php if (mysql_num_rows($resultaat) > 1) { ?>
				<select>
					<?php
					while ($groep = mysql_fetch_assoc($resultaat)) {
						echo "<option value=\"".$groep["groepid"]."\">".$groep["naam"]."</option>";
					}
					?>
				</select>
				<?php } else { 
					$groep = mysql_fetch_assoc($resultaat);
					echo "<span class=\"".$groep["groepid"]."\">".$groep["naam"]."</span>";
				} ?>
				<span class="invite" style="color:blue;text-decoration:underline;cursor:pointer;">Uitnodigen</span>
			</div>
			<?php
				}
			}
			?>
			
			<?php
			if (isset($userid) && !empty($userid) && intval($userid) && isset($_SESSION["user_id"]) && isset($_SESSION['user_id']) && $userid == $_SESSION['user_id']) {
				$query = "SELECT COUNT(*) AS aantal FROM groeplid WHERE studentid = ".$_SESSION["studentid"]." AND lid=0;";
				$resultaat = mysql_query($query);
				if ($resultaat) {
					$groep = mysql_fetch_assoc($resultaat);
					if ($groep["aantal"] > 0) {
						?>
						<div style="float:right;" id="teaccepteren">
							Uitnodiging<?php if (mysql_num_rows($resultaat) > 0) { echo "en "; }
								echo "(".$groep["aantal"].")";
								?>
							<span class="accept" style="color:blue;text-decoration:underline;cursor:pointer;">Bekijken</span>
						</div>
						<?php
					}
				}
			}
			?>

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
			<?php
			database::getInstantie();
			if (isset($_GET["id"]) && !empty($_GET["id"]) && intval($_GET["id"])) {
				?>
				Mijn berichten ( <a href="plaatsenprofielbericht.php?id=<?php echo $studentid; ?>"> toevoegen </a>)
				<?php
				$id = mysql_real_escape_string($_GET["id"]);
				$query = "SELECT * FROM profielbericht WHERE studentid = ".$studentid.";";
				$resultaat_van_server = mysql_query($query);

				while($row = mysql_fetch_array($resultaat_van_server)  ) {
						$row = mysql_fetch_array($resultaat_van_server);
				echo "<table style=\"text-align:left;\">";
					echo "<tr><th>Datum</th><td> ".tijd::formatteerTijd($row["datum"], "d-m-Y")."</td></tr> ";
					echo "<tr><th>Onderwerp</th><td>" . $row["onderwerp"] . "</td></tr> ";
					echo "<tr><th>Bericht</th><td>" . specialetekens::vervangTekensInTekst($row["inhoud"]) . "</td></tr> ";
				
				echo"</table>";
				echo"<br/>";
			}
			}
			
			if (isset($_GET["id"]) && !empty($_GET["id"]) && intval($_GET["id"])) {
				$sql1 ="SELECT l.verenigingid, v.naam ,l.studentid
						FROM lidmaatschap AS l
						JOIN vereniging AS v
						ON v.verenigingid = l.verenigingid
						WHERE l.studentid =" .$studentid.";";
						$resultaat1 = mysql_query($sql1) ;
				if (mysql_num_rows($resultaat1) > 0) {
					echo"<table>";
					echo"<tr><td> is lid van </td></tr>";
					while( $row= mysql_fetch_array($resultaat1)) {
						echo"<tr><td>vereniging</td><td><a href=\"raadplegenvereniging.php?id=".$row["verenigingid"]." \">" .$row["naam"]." </a></td></tr> ";
					}
					echo"</table>";
				} else {
					echo"Student is nog geen lid van een vereniging";
					echo"<br/>";
				}
			}
			?>
			<br />
			<?php
			if (isset($_GET["id"]) && !empty($_GET["id"]) && intval($_GET["id"])) {
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
							echo "<tr><th>Naam</th><td><a href=\"evenement.php?id=" . $row["evenementid"] . "\">" . $row["evenementnaam"] . "</a></td></tr> ";
							echo "<tr><th>Begindatum</th><td>" . tijd::formatteerTijd($row["begindatum"], "d-m-Y") . "</td></tr> ";
							echo "<tr><th>Vereniging</th><td>" . $row["verenigingnaam"] . "</td></tr> ";
							echo "<tr><th>Categorie</th><td>" . $row["categorienaam"] . "</td></tr> ";
						}
						echo"</table> ";
					}

					if (mysql_num_rows($resultaat_van_server2) > 0) {
						echo"<br />Evenementen nog te bezoeken:";
						echo"<table style=\"text-align:left;\">";

						while ($row = mysql_fetch_array($resultaat_van_server2)) {
							echo "<tr><th>Naam</th><td><a href=\"evenement.php?id=" . $row["evenementid"] . "\">" . $row["evenementnaam"] . "</a></td></tr> ";
							echo "<tr><th>Begindatum</th><td>" . tijd::formatteerTijd($row["begindatum"], "d-m-Y") . "</td></tr> ";
							echo "<tr><th>Vereniging</th><td>" . $row["verenigingnaam"] . "</td></tr> ";
							echo "<tr><th>Categorie</th><td>" . $row["categorienaam"] . "</td></tr> ";
						}
						echo"</table> ";
					}
				}
				else{
					 echo"Student heeft zich nog niet aangemeld voor een evenement";
				}
				echo "<br />";
			}
			if(isMember()){
				if (isset($_GET["id"]) && !empty($_GET["id"]) && intval($_GET["id"])) {
					$groeplidquery = "SELECT * FROM groeplid INNER JOIN student ON groeplid.studentid = student.studentid INNER JOIN groep ON groeplid.groepid = groep.groepid WHERE groeplid.studentid = ".$_GET["id"]." AND groeplid.lid = 1;";
					$groeplidresult = mysql_query($groeplidquery);
					if ($groeplidresult && mysql_num_rows($groeplidresult) > 0) {
						echo "<br />Deze persoon is lid van de groepen van:<br />";
						echo "<table><tr><th>Groepnaam</th><th>Van</th></tr>";
						while ($groeplid = mysql_fetch_assoc($groeplidresult)) {
							echo "<tr><td><a href=\"vriendengroep.php?id=".$groeplid["eigenaar"]."&groepid=".$groeplid["groepid"]."\">".$groeplid["naam"]."</a></td><td><a href=\"raadplegenprofiel.php?id=".$groeplid["eigenaar"]."\">".$groeplid["voornaam"]." ".$groeplid["achternaam"]."</a></td></tr>";
						}
					}
					
					
					$sql = "SELECT * FROM groep WHERE eigenaar = ".mysql_real_escape_string($_GET["id"]);
					$resultaat_van_server = mysql_query($sql);
					if (mysql_num_rows($resultaat_van_server) > 0) {
						echo "<table style=\"text-align:left;\">";
						echo "<tr><th>Groepen:</th></tr>";
						while ($array = mysql_fetch_assoc($resultaat_van_server)) {
							echo "<tr><td valign=\"middle\"><a href=\"vriendengroep.php?id=".$_GET["id"]."&groepid=".$array["groepid"]."\">".$array["naam"]."</a></td><td>"; if (isset($_SESSION['user_id']) && $userid == $_SESSION['user_id']) { echo "<a href=\"wijziggroep.php?id=".$_GET["id"]."&groepid=".$array["groepid"]."\">Wijzig</a>"; } echo "</td><td>"; if (isset($_SESSION['user_id']) && $userid == $_SESSION['user_id']) { echo "<a href=\"verwijdergroep.php?id=".$_GET["id"]."&groepid=".$array["groepid"]."\">Verwijder</a>"; } echo "</td></tr>";
						}
						echo "</table><br /><br />";
					}
					if (isset($_SESSION['studentid']) && $_GET["id"] == $_SESSION['studentid']) {
						echo "<a href=\"groeptoevoegen.php?id=".$_GET["id"]."\">Groep toevoegen</a>";
					}
				}
			}

			?>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();