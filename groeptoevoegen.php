<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

$titel = "";
$resultaat = false;
if (isset($_GET["id"]) && !empty($_GET["id"])) {
	if (intval($_GET["id"])) {
		$query = "SELECT * FROM student WHERE studentid = ".mysql_real_escape_string($_GET["id"]).";";
		$resultaat_van_server = mysql_query($query);
		if (mysql_num_rows($resultaat_van_server) > 0) {
			$array = mysql_fetch_assoc($resultaat_van_server);
			$titel = " voor ".$array["voornaam"]." ".$array["achternaam"];
			$resultaat = true;
		}
	}
}

$pagina->setTitel("Een groep toevoegen".$titel);
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
			$error = "";
			if (isset($_POST["maakgroep"])) {
				if (isset($_POST["groepnaam"]) && !empty($_POST["groepnaam"])) {
					if ($resultaat) {
						$query = "INSERT INTO groep (naam, eigenaar) VALUES ('".mysql_real_escape_string($_POST["groepnaam"])."', ".mysql_real_escape_string($_GET["id"]).")";
						mysql_query($query) or $error .= "<li>".mysql_error()."</li>";
					} else {
						$error .= "<li>Deze gebruiker bestaat niet.</li>";
					}
				} else {
					$error .= "<li>U heeft geen naam ingevuld.</li>";
				}
			}
			
			if ($error != "") {
				echo "<ul>".$error."</ul>";
			} else if (isset($_POST["maakgroep"]) && $error == "") {
				header("location:raadplegenprofiel.php?id=".$_GET["id"]);
			}
			?>
			<form action="" method="post">
				<table>
					<tr>
						<th>
							Naam:
						</th>
						<td>
							<input type="text" name="groepnaam" />
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align:right;">
							<input type="submit" name="maakgroep" value="aanmaken" />
						</td>
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