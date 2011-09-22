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
				
			</div>
			<div>
				<?php
				
				database::getInstantie();

				$sql = "SELECT * FROM `vereniging`;";
				$resultaat_van_server = mysql_query($sql);
				
				if (count($resultaat_van_server) > 0) {
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
