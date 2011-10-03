<?php
	/**
	* @author: Hans-Jurgen Bakkenes
	* @description: 
	*/
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
					Overzicht lezen per vereniging
				</a>
				<a href="overzichtevenementen.php" class="linkknop" style="float:right;">
					Overzicht evenementen per vereniging
				</a>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>