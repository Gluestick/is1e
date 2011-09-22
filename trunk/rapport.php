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
			<center>
				<div>
					<a href="overzichtleden.php" style="display:block;width:200px;height:200px;">
						Overzicht lezen per vereniging
					</a>
					<a href="overzichtevenementen.php" style="display:block;width:200px;height:200px;">
						Overzicht evenementen per vereniging
					</a>
				</div>
			</center>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
