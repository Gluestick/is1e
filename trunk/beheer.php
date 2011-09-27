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
			<div style="margin:0 auto;width:600px;">
				<a href="categorie.php" style="float:left;display:block;width:200px;height:200px;">
					Categorieën
				</a>
				<a href="rapport.php" style="float:right;display:block;width:200px;height:200px;">
					Management-rapport
				</a>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
