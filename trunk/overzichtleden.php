<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();

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
								<input type="submit" name="zoeken" />
							</td>
						</tr>
					</table>
				</form>
				<br />
			</div>
			<div class="gegevens">
				<?php
				
				database::getInstantie();
				
				if (isset($_POST["zoeken"]) && !empty($_POST["zoeknaam"])) {
					$sql = "SELECT `naam`, `aantalEigenLeden` FROM `vereniging` WHERE naam LIKE '%".mysql_real_escape_string($_POST["zoeknaam"])."%';";
				} else {
					$sql = "SELECT `naam`, `aantalEigenLeden` FROM `vereniging`;";
				}
				$resultaat_van_server = mysql_query($sql);
				
				if (mysql_num_rows($resultaat_van_server) > 0) {
					?>
					<table border="1">
						<th>Naam</th><th>Leden</th>
						<?php
						while($array = mysql_fetch_array($resultaat_van_server)) {
							echo "<tr><td>".$array["naam"]."</td><td>".$array["aantalEigenLeden"]."</td></tr>";
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
