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
				$date = new DateTime("");
				if (isset($_POST["periode"]) && (!empty($_POST["beginperiode"]) || !empty($_POST["eindperiode"]))) {
					if (!empty($_POST["beginperiode"]) && !empty($_POST["eindperiode"])) {
						$where = "WHERE begindatum >= ".tijd::formatteerTijd($_POST["beginperiode"], "Y-m-d")." AND einddatum <= ".tijd::formatteerTijd($_POST["eindperiode"], "Y-m-d");
					} else if (!empty($_POST["beginperiode"])) {
						$where = "";
					} else {
						$where = "";
					}
					$sql = "SELECT * FROM `vereniging`".$where.";";
				} else {
					$sql = "SELECT * FROM `vereniging`;";
				}
				
				$resultaat_van_server = mysql_query($sql);
				
				if (mysql_num_rows($resultaat_van_server) > 0) {
					
					?>
					<table border="1">
						<th>Naam evenement</th><th>Evenementen</th>
						<?php
						while($array = mysql_fetch_array($resultaat_van_server)) {
							$query = "SELECT * FROM `evenement` WHERE organiserendeVerenigingId = ".$array["verenigingId"];
							$result = mysql_query($query);
							$aantal = null;
							if (mysql_num_rows($result) > 0) {
								$aantal = mysql_num_rows($result);
							}
							echo "<tr><td>".$array["naam"]."</td><td>".$aantal."</td></tr>";
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
