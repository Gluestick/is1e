<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Beheer");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>
			<div style="width:500px;margin:0 auto;">
				<a href="raadpleegevenementcategorieen.php" class="linkknop" style="float:left;">
					<div class="enkel">Categorieën</div>
				</a>
				<a href="rapport.php" class="linkknop" style="float:right;">
					<div class="enkel">Management-rapport</div>
				</a>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
