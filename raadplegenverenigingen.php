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
			<form method="post" action="raadplegenverenigingen.php">
				<table>
					<tr>
						<td>Vereniging:</td>
						<td><input type="text" name="naam_vereniging" /></td>
					</tr>
					<tr>
						<td>Plaats</td>
						<td><input type="text" name="plaats_vereniging" /></td>
					</tr>
					<tr>
						<td><input type="submit" name="verstuur" value="Zoeken" /></td>
					</tr>
				</table>
			</form>
			<table>
				<tr>
					<td width="125"><b>Vereniging</b></td>
					<td width="60"><b>Plaats</b></td>
					<td><b>E-mail</b></td>
				</tr>
				<?php
				if (isset($_GET["naam_vereniging"])) {
					$naam_vereniging = $_GET["naam"];
				} else {
					
				}
				database::getInstantie();
				$sql = "SELECT * FROM vereniging";
				$resultaat_van_server = mysql_query($sql) or die(mysql_error());

				while ($array = mysql_fetch_array($resultaat_van_server)) {
					echo "<tr><td><a href= \"#\">" . $array["naam"] . " </a></td><td>" . $array["plaats"] . "</td><td>" . $array["emailadres"] . "</tr>";
				}
				?>
			</table>
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