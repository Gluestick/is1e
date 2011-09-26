<?php
/**
 * @author: Kay van Bree
 * @description: 
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Raadplegen verenigingen");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>
			<?php
			
			database::getInstantie();
			
			$sql = "SELECT * FROM vereniging;";
			$resultaat_van_server = mysql($sql);
			
			if (count($resultaat_van_server) > 0) {
			?>
			
			<?php
			
			}
			?>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>



<?php
echo $pagina->getVereisteHTMLafsluiting();

//	database::getInstantie();
//
//	$sql = "SELECT * FROM `student`;";
//	$resultaat_van_server = mysql_query($sql);
//	while($array = mysql_fetch_array($resultaat_van_server)) {
//		echo $array["voornaam"]."<br />";
//	}
?>