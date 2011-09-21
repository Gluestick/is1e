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
			<p></p>
			<div>
				<a href="categorie.php"><div style="float:left;width:200px;height:200px;">Categorieën</div></a><a href="rapport.php"><div style="float:left;width:200px;height:200px;">Management-rapport</div></a>
			</div>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
