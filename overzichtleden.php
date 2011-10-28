<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */

if (!isAdmin()) {
	header("location:index.php");
}

$pagina = pagina::getInstantie();
database::getInstantie();
$error = "";
if (isset($_POST["zoeken"]) && !empty($_POST["zoeknaam"])) {
	$sql = "SELECT `vereniging`.`naam`, COUNT(studentid) as leden FROM `vereniging` LEFT OUTER JOIN `lidmaatschap` ON `vereniging`.`verenigingId` = `lidmaatschap`.`verenigingId` WHERE naam LIKE '%".mysql_real_escape_string($_POST["zoeknaam"])."%' GROUP BY `vereniging`.`naam`;";
} else if (isset($_POST["zoeken"]) && empty($_POST["zoeknaam"])) {
	$error = "<li>U heeft geen naam ingevuld.</li>";
	$sql = "SELECT `vereniging`.`naam`, COUNT(studentid) as leden FROM `vereniging` LEFT OUTER JOIN `lidmaatschap` ON `vereniging`.`verenigingId` = `lidmaatschap`.`verenigingId` GROUP BY `vereniging`.`naam`;";
} else {
	$sql = "SELECT `vereniging`.`naam`, COUNT(studentid) as leden FROM `vereniging` LEFT OUTER JOIN `lidmaatschap` ON `vereniging`.`verenigingId` = `lidmaatschap`.`verenigingId` GROUP BY `vereniging`.`naam`;";
}
$resultaat_van_server = mysql_query($sql);

$pagina->setTitel("Overzicht leden per vereniging");
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
			if (mysql_num_rows($resultaat_van_server) == 0) {
				$error .= "<li>Geen resultaten.</li>";
			}
			if ($error != "") {
				echo "<ul>".$error."</ul>";
			}
			?>
			<div class="zoeken">
				<form action="" method="post">
					<table>
						<tr>
							<td>
								<label for="zoeknaam">Naam</label>
							</td>
							<td>
								<input type="text" name="zoeknaam" id="zoeknaam" />
							</td>
							<td>
								<input type="submit" name="zoeken" value="zoeken" />
							</td>
						</tr>
					</table>
				</form>
				<br />
			</div>
			<div class="gegevens">
				<?php
				
				if (mysql_num_rows($resultaat_van_server) > 0) {
					?>
					<table border="1">
						<th>Naam</th><th>Leden</th>
						<?php
						while($array = mysql_fetch_array($resultaat_van_server)) {
							echo "<tr><td>".$array["naam"]."</td><td>".$array["leden"]."</td></tr>";
						}
						?>
					</table>
					<?php
				}
				?>
				<br /><br /><a href="rapport.php">Terug</a>
			</div>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
