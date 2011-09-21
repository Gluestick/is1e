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
			<p></p>
			<div>
				
			</div>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
