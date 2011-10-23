<?php

if (isset($_POST["informatie"])) {
	if (!empty($_POST["informatie"])) {
		if (strstr($_POST["informatie"], "_")) {
			$info = explode("_", $_POST["informatie"]);
			if (intval($info[1])) {
				
				database::getInstantie();
				
				
				if ($info[0] == "bericht") {
					$query = "SELECT * FROM bericht INNER JOIN student ON van = studentid WHERE berichtid = ".$info[1].";";
					$resultaat_van_server = mysql_query($query);
					$array = mysql_fetch_assoc($resultaat_van_server);
					if (!is_null($array["groepid"])) {
						$sql = "SELECT * FROM groep WHERE groepid = ".$array["groepid"].";";
						$resultaat = mysql_query($sql);
						$groep = mysql_fetch_assoc($resultaat);
						
						?>
						<div id="emailonderwerp"><?php echo $array["onderwerp"]; ?></div>
						<table cellpadding="0" cellspacing="0">
							<tr class="emailheader">
								<th>Van:</th><td><?php echo $array["voornaam"]." ".$array["achternaam"]; ?></td>
							</tr>
							<tr class="emailheader">
								<th>Verzonden:</th><td><?php echo tijd::vervangEngelsDoorNederlands(tijd::formatteerTijd($array["datum"], "l j F Y")); ?></td>
							</tr>
							<tr class="emailheader last">
								<th>Aan:</th><td><?php echo $groep["naam"]; ?></td>
							</tr>
							<tr>
							<td colspan="2" style="padding:14px 3px;">
								<?php echo nl2br($array["bericht"]); ?>
								<br />
								<br />
								<a href="vriendengroep.php?groepid=<?php echo $groep["groepid"]; ?>"><?php echo "Klik hier om naar de vriendengroep \"".$groep["naam"]."\" te gaan."; ?></a>
							</td>
						</tr>
						</table>
						<?php
					} else if (!is_null($array["naar"])) {
						$sql = "SELECT * FROM student WHERE studentid = ".$array["naar"].";";
						$resultaat = mysql_query($sql);
						$student = mysql_fetch_assoc($resultaat);
						
						?>
						<div id="emailonderwerp"><?php echo $array["onderwerp"]; ?></div>
						<table cellpadding="0" cellspacing="0">
							<tr class="emailheader">
								<th>Van:</th><td><?php echo $array["voornaam"]." ".$array["achternaam"]; ?></td>
							</tr>
							<tr class="emailheader">
								<th>Verzonden:</th><td><?php echo tijd::vervangEngelsDoorNederlands(tijd::formatteerTijd($array["datum"], "l j F Y")); ?></td>
							</tr>
							<tr class="emailheader last">
								<th>Aan:</th><td><?php echo $student["voornaam"]." ".$student["achternaam"]; ?></td>
							</tr>
							<tr>
							<td colspan="2" style="padding:14px 3px;">
								<?php echo nl2br($array["bericht"]); ?>
								<br />
								<br />
								<a href="raadplegenprofiel.php?id=<?php echo $student["studentid"]; ?>"><?php echo "Klik hier om naar het profiel van \"".$student["voornaam"]." ".$student["achternaam"]."\" te gaan."; ?></a>
							</td>
						</tr>
						</table>
						<?php
					}
				} else if ($info[0] == "reactie") {
					$query = "SELECT * FROM reactie INNER JOIN evenement ON reactie.evenementid = evenement.evenementid INNER JOIN student ON afzender_id = student.studentid WHERE reactieid = ".$info[1].";";
					$resultaat_van_server = mysql_query($query);
					$array = mysql_fetch_assoc($resultaat_van_server);
					?>
					<div id="emailonderwerp"><?php echo "Evenement: ".$array["naam"]; ?></div>
					<table cellpadding="0" cellspacing="0">
						<tr class="emailheader">
							<th>Van:</th><td><?php echo $array["voornaam"]." ".$array["achternaam"]; ?></td>
						</tr>
						<tr class="emailheader">
							<th>Geplaatst:</th><td><?php echo tijd::vervangEngelsDoorNederlands(tijd::formatteerTijd($array["tijdstip"], "l j F Y")); ?></td>
						</tr>
						<tr class="emailheader last">
							<th>Bericht bij evenement:</th><td><?php echo $array["naam"]; ?></td>
						</tr>
						<tr>
							<td colspan="2" style="padding:14px 3px;">
								<?php echo nl2br($array["inhoud"]); ?>
								<br />
								<br />
								<a href="evenement.php?id=<?php echo $array["evenementid"]; ?>"><?php echo "Klik hier om naar evenement \"".$array["naam"]."\" te gaan."; ?></a>
							</td>
						</tr>
					</table>
					<?php
				} else if ($info[0] == "profielbericht") {
					$query = "SELECT *,profielbericht.studentid as aan, CONCAT(O.voornaam,' ',O.achternaam) as ontvanger FROM profielbericht INNER JOIN student as O ON O.studentid = profielbericht.studentid INNER JOIN student as A ON afzender = A.studentid WHERE profielberichtid = ".$info[1].";";
					$resultaat_van_server = mysql_query($query);
					$array = mysql_fetch_assoc($resultaat_van_server);
					?>
					<div id="emailonderwerp"><?php echo $array["onderwerp"]; ?></div>
					<table cellpadding="0" cellspacing="0">
						<tr class="emailheader">
							<th>Van:</th><td><?php echo $array["voornaam"]." ".$array["achternaam"]; ?></td>
						</tr>
						<tr class="emailheader">
							<th>Geplaatst:</th><td><?php echo tijd::vervangEngelsDoorNederlands(tijd::formatteerTijd($array["datum"], "l j F Y")); ?></td>
						</tr>
						<tr class="emailheader last">
							<th>Profielbericht aan:</th><td><?php echo $array["ontvanger"]; ?></td>
						</tr>
						<tr>
							<td colspan="2" style="padding:14px 3px;">
								<?php echo nl2br($array["inhoud"]); ?>
								<br />
								<br />
								<a href="raadplegenprofiel.php?id=<?php echo $array["aan"]; ?>"><?php echo "Klik hier om naar het profiel van \"".$array["ontvanger"]."\" te gaan."; ?></a>
							</td>
						</tr>
					</table>
					<?php
				} else {
					echo "Geen gegevens beschikbaar.";
				}
			}
		}
	}
}

?>