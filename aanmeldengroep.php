<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

$naam = "";
$gegevens = true;
if (isset($_GET["groepid"])) {
	$sql = "SELECT * FROM groep WHERE groepid = ".mysql_real_escape_string($_GET["groepid"]);
	$resultaat = mysql_query($sql);
	$naam = "";
	if (mysql_num_rows($resultaat) > 0) {
		$array = mysql_fetch_assoc($resultaat);
		$naam = " voor de \"".$array["naam"]."\" groep";
	} else {
		$gegevens = false;
	}
}
$pagina->setTitel("Aanmelden".$naam);
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
			if (isset($_GET["groepid"])) {
				if (isset($_POST["aanmelden"]) && isset($_GET["groepid"])) {
					if (!empty($_POST["student"])) {
						if (intval($_GET["groepid"]) && intval($_POST["student"])) {
							$sql = "SELECT * FROM groeplid, groep WHERE groeplid.groepid = ".mysql_real_escape_string($_GET["groepid"])." AND (groeplid.studentid = ".mysql_real_escape_string($_POST["student"])." OR groep.eigenaar = ".mysql_real_escape_string($_POST["student"]).")";
							$result = mysql_query($sql);
							if (mysql_num_rows($result) == 0) {
								//persoon is niet reeds aangemeld voor de groep alle waardes kloppen dus inserten.
								$query = "INSERT INTO groeplid VALUES (".mysql_real_escape_string($_GET["groepid"]).", ".mysql_real_escape_string($_POST["student"]).")";
								mysql_query($query) or $error .= "<li>".mysql_error()."</li>";
							} else {
								$error .= "<li>Deze persoon is al lid van deze groep.</li>";
							}
						} else {
							$error .= "<li>Er is iets mis met de waardes.</li>";
						}
					} else {
						$error .= "<li>U heeft geen student geselecteerd.</li>";
					}
				}
			} else {
				$error .= "<li>U heeft geen groep geselecteerd.</li>";
			}
			
			if ($error != "") {
				echo "<ul>".$error."</ul>";
			} else if (isset($_POST["aanmelden"]) && $error == "") {
				header("location:vriendengroep.php?groepid=".$_GET["groepid"]);
			}
			if (isset($_GET["groepid"])) {
			?>
			<form method="post" action="aanmeldengroep.php?groepid=<?php echo $_GET["groepid"]; ?>">
				<table>
					<tr>
						<td>
							<select name="student">
								<?php
								$sql = "SELECT studentid, voornaam, achternaam FROM student WHERE studentid != ".$array["eigenaar"]." AND studentid NOT IN (SELECT studentid FROM groeplid WHERE groepid = ".$array["groepid"].");";
								$resultaat_van_server = mysql_query($sql);
								while ($rij = mysql_fetch_assoc($resultaat_van_server)) {
									echo "<option value=\"".$rij["studentid"]."\">".$rij["voornaam"]." ".$rij["achternaam"]."</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" name="aanmelden" value="aanmelden" />
						</td>
					</tr>
				</table>
			</form>
			<?php
			}
			?>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();
?>