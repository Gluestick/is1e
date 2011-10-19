<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

$naam = "";
if (isset($_GET["groepid"])) {
	$sql = "SELECT * FROM groep INNER JOIN student ON eigenaar = studentid WHERE groepid = ".mysql_real_escape_string($_GET["groepid"]." LIMIT 1;");
	$resultaat_van_server = mysql_query($sql);
	if (mysql_num_rows($resultaat_van_server) > 0) {
		$array = mysql_fetch_assoc($resultaat_van_server);
		$naam = " ".$array["naam"]." van ".$array["voornaam"]." ".$array["achternaam"];
	}
}

$pagina->setTitel("Wijzig vriendengroep".$naam);
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>
			<a href="javascript:history.go(-1);">Terug</a><br />
			<?php
			if (isset($_GET["groepid"]) && isset($array)) {
				$query = "SELECT * FROM groep WHERE groepid = ".  mysql_real_escape_string($_GET["groepid"]).";";
				$resultaat = mysql_query($query);
				if (mysql_num_rows($resultaat) > 0) {
					$data = mysql_fetch_assoc($resultaat);
					?>
					<table style="text-align:left;">
						<tr>
							<th>
								Naam:
							</th>
							<td>
								<input type="text" name="groepnaam" value="<?php echo $data["naam"]; ?>" />
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:right;">
								<input type="submit" name="wijzig" value="Wijzig groepnaam" />
							</td>
						</tr>
					</table>
					<?php
				} else {
					echo "Er zijn nog geen vrienden aan deze groep gekoppeld.";
				}
			} else {
				echo "Geen resultaten beschikbaar.";
			}
			?>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();
?>