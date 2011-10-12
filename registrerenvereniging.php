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
						print"<h3>ERROR: Ingevulde wachtwoorden zijn niet gelijk!</h3>";
					}
					else {
						$sql = "INSERT INTO vereniging (naam, plaats, adres, postcode, emailadres, contactpersoon) VALUES ('".mysql_real_escape_string($_POST["vereniging_naam"])."', '".mysql_real_escape_string($_POST["vereniging_plaats"])."', '".mysql_real_escape_string($_POST["vereniging_adres"])."', '".mysql_real_escape_string($_POST["vereniging_postcode"])."', '".mysql_real_escape_string($_POST["vereniging_mail"])."', '".mysql_real_escape_string($_POST["vereniging_contactpersoon"])."')";
						$result = mysql_query($sql);
						if ($result != true) {
							print"<h3>ERROR:</h3>".mysql_error();
						}
						else {
							print"Vereniging succesvol geregistreerd!";
						}
					}
				}
			}
			?>
			<form method="post" action="registrerenvereniging.php">
				<table class="registreren"> <!-- De class registreren is om de text voor de inputs aan de rechterkant van de cel te plakken. -->
					<tr>
						<td>*Naam:</td>
						<td colspan="2"><input type="text" name="vereniging_naam" /></td>
					</tr>
					<tr>
						<td>*Plaats:</td>
						<td colspan="2"><input type="text" name="vereniging_plaats" /></td>
					</tr>
					<tr>
						<td>*Adres:</td>
						<td colspan="2"><input type="text" name="vereniging_adres" /></td>
					</tr>
					<tr>
						<td>*Postcode:</td>
						<td colspan="2"><input type="text" name="vereniging_postcode" /></td>
					</tr>
					<tr>
						<td>Telefoonnr:</td>
						<td colspan="2"><input type="text" name="vereniging_telefoon" /></td>
					</tr>
					<tr>
						<td>*E-mail:</td>
						<td colspan="2"><input type="text" name="vereniging_mail" /></td>
					</tr>
					<tr>
						<td>KVK:</td>
						<td colspan="2"><input type="text" name="vereniging_kvk" /></td>
					</tr>
					<tr>
						<td>*Contactpersoon:</td>
						<td colspan="2"><input type="text" name="vereniging_contactpersoon" /></td>
					</tr>
					<tr>
						<td>*Wachtwoord:</td>
						<td colspan="2"><input type="password" name="vereniging_wachtwoord" /></td>
					</tr>
					<tr>
						<td>*Herhaling wachtwoord:</td>
						<td colspan="2"><input type="password" name="vereniging_wachtwoord_herhaling" /></td>
					</tr>
					<tr>
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