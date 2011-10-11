<?php
/**
 * @author: Joep Kemperman
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
				database::getInstantie();
				if (!empty($_POST["naam_vereniging"])) {
					$naam_vereniging = $_POST["naam_vereniging"];
				}
				if (!empty($_POST["plaats_vereniging"])) {
					$plaats_vereniging = $_POST["plaats_vereniging"];
				}
				
				if (!empty($naam_vereniging)) { /* Query als er alleen op naam wordt gezocht. */
					$sql = "SELECT * FROM vereniging WHERE naam LIKE '%$naam_vereniging%' ORDER BY naam";
				}
				elseif (!empty($plaats_vereniging)) { /* Query als er alleen op plaats wordt gezocht. */
					$sql = "SELECT * FROM vereniging WHERE plaats LIKE '%$plaats_vereniging%' ORDER BY naam";
				}
				elseif (!empty($naam_vereniging) && isset($plaats_vereniging)) { /* Query als er op naam en plaats wordt gezocht */
					$sql = "SELECT * FROM vereniging WHERE naam LIKE '%$naam_vereniging%' AND plaats LIKE '%$plaats_vereniging%' ORDER BY naam";
				}
				else { /* Query als er niet wordt gezocht of als er geen velden zijn ingevult */
					$sql = "SELECT * FROM vereniging ORDER BY naam";
				}
				$resultaat_van_server = mysql_query($sql) or die(mysql_error());

				while ($array = mysql_fetch_array($resultaat_van_server)) {
					echo "<tr><td><a href=raadplegenvereniging.php?id=".$array["verenigingId"].">" . $array["naam"] . " </a></td><td>" . $array["plaats"] . "</td><td>" . $array["emailadres"] . "</tr>";
				}
				?>
			</table>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>



<?php
echo $pagina->getVereisteHTMLafsluiting();
?>