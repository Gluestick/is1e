<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

$naam = "";
$error = "";
if (isset($_GET["groepid"])) {
	$sql = "SELECT * FROM groep INNER JOIN student ON eigenaar = studentid WHERE groepid = ".mysql_real_escape_string($_GET["groepid"]." LIMIT 1;");
	$resultaat_van_server = mysql_query($sql);
	if (mysql_num_rows($resultaat_van_server) > 0) {
		$array = mysql_fetch_assoc($resultaat_van_server);
		$naam = " ".$array["naam"]." van ".$array["voornaam"]." ".$array["achternaam"];
	}
}

if (isset($_POST["wijzig"])) {
	if (isset($_POST["groepnaam"]) && !empty($_POST["groepnaam"])) {
		$query = "UPDATE groep SET naam='".mysql_real_escape_string($_POST["groepnaam"])."' WHERE groepid = ".mysql_real_escape_string($_GET["groepid"]).";";
		mysql_query($query) or $error .= "<li>".mysql_error()."</li>";
	} else {
		$error .= "<li>Er ging iets mis.</li>";
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
			if ($error != "") {
				echo "<ul>".$error."</ul>";
			} else if (isset($_POST["wijzig"]) && $error == "") {
				header("location:vriendengroep.php?groepid=".$_GET["groepid"]);
			}
			if (isset($_GET["groepid"]) && isset($array)) {
				$query = "SELECT * FROM groep WHERE groepid = ".mysql_real_escape_string($_GET["groepid"]).";";
				$resultaat = mysql_query($query);
				if (mysql_num_rows($resultaat) > 0) {
					$data = mysql_fetch_assoc($resultaat);
					?>
					<form action="wijziggroep.php?groepid=<?php echo $_GET["groepid"]; ?>" method="post">
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
					</form>
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