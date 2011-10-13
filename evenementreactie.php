<?php
/**
 * @author: Kay van Bree, Kajel Bhikhoe
 * @description: 
 */
$pagina = pagina::getInstantie();
$id = ($_GET["id"]);

$pagina->setTitel("Eventplaza");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>

			<form action="evenementreactie2.php" method="POST">
				<table>
					<tr>
						<td>Naam </td>
						<td><input type="text" name="naam"/><input type ="hidden" name ="evenementid" value = <?php echo $id ?>/></td>
					</tr>
					<tr>
						<td>Datum </td>
						<td><input type="text" name="datum" readonly="readonly" value="<?php echo date("d/m/Y"); ?>"></td>
					</tr>
					<tr>
						<td>Bericht </td>
						<td><textarea name ="tekstvak"></textarea></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="reset" value="Wis alles"/> <input type="submit" name="verstuur" value="Verstuur"/></td>
					</tr>		
				</table>
			</form>
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
