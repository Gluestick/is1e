<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
if (!isAdmin()) {
	header("location:index.php");
}

$pagina = pagina::getInstantie();

$pagina->setTitel("Management-Rapport");
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
				<a href="overzichtleden.php" class="linkknop" style="float:left;">
					<div class="dubbel">Overzicht leden per<br /> vereniging</div>
				</a>
				<a href="overzichtevenementen.php" class="linkknop" style="float:right;">
					<div class="dubbel">Overzicht evenementen per<br /> vereniging</div>
				</a>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>