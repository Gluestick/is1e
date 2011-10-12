<?php
/**
 * @author:
 * @description: Pagina waarop je een vereniging kunt registreren
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Registreren vereniging");
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
			if (isset($_POST["verstuur"])) {
				if (!empty($_POST["vereniging_naam"]) && isset($_POST["vereniging_plaats"]) && isset($_POST["vereniging_adres"]) && isset($_POST["vereniging_postcode"]) && isset($_POST["vereniging_mail"]) && isset($_POST["vereniging_contactpersoon"]) && isset($_POST["vereniging_wachtwoord"]) && isset($_POST["vereniging_wachtwoord_herhaling"])) {
					if ($_POST["vereniging_wachtwoord"] != $_POST["vereniging_wachtwoord_herhaling"]) {
						print"<h3>Ingevulde wachtwoorden zijn niet gelijk!</h3>";
					}
					else {
						$sql = "INSERT INTO vereniging (naam, plaats, adres, postcode, emailadres, contactpersoon, telefoonnr, kvk, aantaleigenleden) VALUES ('".mysql_real_escape_string($_POST["vereniging_naam"])."', '".mysql_real_escape_string($_POST["vereniging_plaats"])."', '".mysql_real_escape_string($_POST["vereniging_adres"])."', '".mysql_real_escape_string($_POST["vereniging_postcode"])."', '".mysql_real_escape_string($_POST["vereniging_mail"])."', '".mysql_real_escape_string($_POST["vereniging_contactpersoon"])."'";
						if (!empty($_POST["vereniging_telefoon"])) {
							$sql .= ", '".mysql_real_escape_string($_POST["vereniging_telefoon"])."'";
						}
						else {
							$sql .= ", NULL";
						}
						if (!empty($_POST["vereniging_kvk"])) {
							$sql .= ", '".mysql_real_escape_string($_POST["vereniging_kvk"])."'";
						}
						else {
							$sql .= ", NULL";
						}
						$sql .= ", 0)";
						$result = mysql_query($sql);
						if ($result != true) {
							print"<h3>MySQL ERROR:</h3>".mysql_error();
						}
						else {
							print"<h3>Vereniging succesvol geregistreerd!</h3>";
						}
					}
				}
			}
			if (isset($_POST["verstuur"]) && (empty($_POST["vereniging_naam"]) || empty($_POST["vereniging_plaats"]) || empty($_POST["vereniging_adres"]) || empty($_POST["vereniging_postcode"]) || empty($_POST["vereniging_mail"]) || empty($_POST["vereniging_contactpersoon"]) || empty($_POST["vereniging_wachtwoord"]) || empty($_POST["vereniging_wachtwoord_herhaling"]))) {
				print "<h3>Niet alle velden zijn ingevuld!</h3>";
			}
			?>
			<form method="post" action="registrerenvereniging.php">
				<table class="registreren"> <!-- De class registreren is om de text voor de inputs aan de rechterkant van de cel te plakken. -->
					<tr>
						<td>*</td>
						<td>Naam:</td>
						<td colspan="2"><input type="text" name="vereniging_naam" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Plaats:</td>
						<td colspan="2"><input type="text" name="vereniging_plaats" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Adres:</td>
						<td colspan="2"><input type="text" name="vereniging_adres" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Postcode:</td>
						<td colspan="2"><input type="text" name="vereniging_postcode" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>E-mail:</td>
						<td colspan="2"><input type="text" name="vereniging_mail" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Contactpersoon:</td>
						<td colspan="2"><input type="text" name="vereniging_contactpersoon" /></td>
					</tr>
					<tr>
						<td></td>
						<td>Telefoonnr:</td>
						<td colspan="2"><input type="text" name="vereniging_telefoon" /></td>
					</tr>
					<tr>
						<td></td>
						<td>KVK:</td>
						<td colspan="2"><input type="text" name="vereniging_kvk" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Wachtwoord:</td>
						<td colspan="2"><input type="password" name="vereniging_wachtwoord" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Herhaling wachtwoord:</td>
						<td colspan="2"><input type="password" name="vereniging_wachtwoord_herhaling" /></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td align="center">
							<input type="reset" value="Herstellen" />
							<input type="submit" name="verstuur" value="Verstuur" />
						</td>
					</tr>
				</table>
			</form>
			<br/>Velden met "*" zijn verplicht.
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