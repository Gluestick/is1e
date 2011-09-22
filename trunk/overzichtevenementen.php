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
				
			</div>
			<div>
				<?php
				
				database::getInstantie();

				$sql = "SELECT * FROM `vereniging`;";
				$resultaat_van_server = mysql_query($sql);
				
				if (count($resultaat_van_server) > 0) {
					
					?>
					<table border="1">
						<th>Naam evenement</th><th>Evenementen</th>
						<?php
						while($array = mysql_fetch_array($resultaat_van_server)) {
							$query = "SELECT * FROM `evenement` WHERE organiserendeVerenigingId = ".$array["verenigingId"];
							$result = mysql_query($sql);
							$aantal = null;
							if (count($result) > 0) {
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
