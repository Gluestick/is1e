<?php
/**
 * @author: Joep Kemperman
 * @description: 
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Raadplegen studentenlijst");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>
			<form action="raadplegenstudentenlijst.php" method="post">
				<table>
					<tr>
						<td>Studentnummer:</td>
						<td><input type="text" name="studentnr" /></td>
					</tr>
					<tr>
						<td>Studentnummer:</td>
						<td><input type="text" name="studentnr" /></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();
?>