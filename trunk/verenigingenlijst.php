<?php
/**
 * @author: Joep Kemperman
 * @description: Lijst van geregistreerde verenigingen met zoekfunctie.
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
			<form method="post" action="verenigingenlijst.php">
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
				<?php
				database::getInstantie();
				if (isset($_POST["verstuur"])) {
					$sql = "SELECT * FROM vereniging WHERE naam LIKE '%{$_POST["naam_vereniging"]}%' AND plaats LIKE'%{$_POST["plaats_vereniging"]}%' ORDER BY naam";
				}
				else {
					$sql = "SELECT * FROM vereniging ORDER BY naam";
				}
				$resultaat_van_server = mysql_query($sql) or die(mysql_error());
				if (mysql_num_rows($resultaat_van_server) >= 1) {
				?>
				<table>
				<tr>
					<td><b>Vereniging</b></td>
					<td><b>Plaats</b></td>
					<td><b>E-mail</b></td>
				</tr>
				<?php
				while ($array = mysql_fetch_array($resultaat_van_server)) {
					echo "<tr><td><a href=\"raadplegenvereniging.php?id=".$array["verenigingid"]."\">" . $array["naam"] . " </a></td><td>" . $array["plaats"] . "</td><td><a href=\"mailto:{$array["emailadres"]}\">{$array["emailadres"]}</a></td></tr>";
				}
				?>
				</table>
				<?php
				}
				else {
					print "Geen resultaat gevonden!";
				}
				?>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>



<?php
echo $pagina->getVereisteHTMLafsluiting();
?>