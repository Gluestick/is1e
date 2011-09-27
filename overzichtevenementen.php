<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Overzicht aantal evenementen per vereniging");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>
			<div class="zoeken">
				<form action="" method="post">
					<table>
						<tr>
							<th>
								<label for="beginperiode">Van</label>
							</th>
							<td>
								<input type="text" name="beginperiode" id="beginperiode" />
							</td>
							<th>
								<label for="eindperiode">Tot</label>
							</th>
							<td>
								<input type="text" name="eindperiode" id="eindperiode" />
							</td>
							<td>
								<input type="submit" name="periode" value="Zoek" />
							</td>
						</tr>
					</table>
				</form>
			</div>
			<br />
			<div class="gegevens">
				<?php
				
				database::getInstantie();

				if (isset($_POST["periode"]) && (!empty($_POST["beginperiode"]) || !empty($_POST["eindperiode"]))) {
					if (!empty($_POST["beginperiode"]) && !empty($_POST["eindperiode"])) {
						$where = "AND begindatum >= '".tijd::formatteerTijd($_POST["beginperiode"], "Y-m-d")."' AND einddatum <= '".tijd::formatteerTijd($_POST["eindperiode"], "Y-m-d")."'";
					} else if (!empty($_POST["beginperiode"])) {
						$where = "AND begindatum >= '".tijd::formatteerTijd($_POST["beginperiode"], "Y-m-d")."'";
					} else {
						$where = "AND einddatum <= ".tijd::formatteerTijd($_POST["eindperiode"], "Y-m-d");
					}
					$sql = "SELECT `vereniging`.`naam`, (SELECT COUNT(*) FROM `evenement` WHERE `evenement`.`organiserendeVerenigingId` = `vereniging`.`verenigingId` ".$where.") AS totaal FROM `vereniging` WHERE (SELECT COUNT(*) FROM `evenement` WHERE `evenement`.`organiserendeVerenigingId` = `vereniging`.`verenigingId` ".$where.") > 0;";
				} else {
					$sql = "SELECT `vereniging`.`naam`, (SELECT COUNT(*) FROM `evenement` WHERE `evenement`.`organiserendeVerenigingId` = `vereniging`.`verenigingId`) AS totaal FROM `vereniging` WHERE (SELECT COUNT(*) FROM `evenement` WHERE `evenement`.`organiserendeVerenigingId` = `vereniging`.`verenigingId`) > 0;";
				}
				
				$resultaat_van_server = mysql_query($sql);
				
				if (mysql_num_rows($resultaat_van_server) > 0) {
					?>
					<table border="1">
						<th>Naam vereniging</th><th>Evenementen</th>
						<?php
						while($array = mysql_fetch_array($resultaat_van_server)) {
							echo "<tr><td>".$array["naam"]."</td><td>".$array["totaal"]."</td></tr>";
						}
						?>
					</table>
					<?php
				}
				
				?>
			</div>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
