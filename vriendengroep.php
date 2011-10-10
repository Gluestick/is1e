<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

$pagina->setTitel("Vriendengroep");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>
			
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();
?>