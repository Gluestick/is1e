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
				if (!empty($_POST["vereniging_naam"]) && !empty($_POST["vereniging_plaats"]) && !empty($_POST["vereniging_adres"]) && !empty($_POST["vereniging_postcode"]) && !empty($_POST["vereniging_mail"]) && !empty($_POST["vereniging_contactpersoon"])) {
					$sql = "INSERT INTO vereniging (naam, plaats, adres, postcode, emailadres, contactpersoon, telefoonnr, kvk, aantaleigenleden) VALUES ('" . mysql_real_escape_string($_POST["vereniging_naam"]) . "', '" . mysql_real_escape_string($_POST["vereniging_plaats"]) . "', '" . mysql_real_escape_string($_POST["vereniging_adres"]) . "', '" . mysql_real_escape_string($_POST["vereniging_postcode"]) . "', '" . mysql_real_escape_string($_POST["vereniging_mail"]) . "', '" . mysql_real_escape_string($_POST["vereniging_contactpersoon"]) . "'";
					if (!empty($_POST["vereniging_telefoon"])) {
						$sql .= ", '" . mysql_real_escape_string($_POST["vereniging_telefoon"]) . "'";
					} else {
						$sql .= ", NULL";
					}
					if (!empty($_POST["vereniging_kvk"])) {
						$sql .= ", '" . mysql_real_escape_string($_POST["vereniging_kvk"]) . "'";
					} else {
						$sql .= ", NULL";
					}
					$sql .= ", 0)";
					$result = mysql_query($sql);
					if ($result == false) {
						print"<h3>MySQL ERROR:</h3>" . mysql_error();
					} else {
						?>
						<script type="text/javascript">
							setTimeout("location.href='./verenigingenlijst.php'", 5000);
						</script>
						<h3>Vereniging succesvol geregistreerd!</h3>
						Wacht 5 seconden of <a href="verenigingenlijst.php">klik hier</a> om naar de verenigingenlijst te gaan.
						<?php
					}
				}
			}
			if (isset($_POST["verstuur"]) && (empty($_POST["vereniging_naam"]) || empty($_POST["vereniging_plaats"]) || empty($_POST["vereniging_adres"]) || empty($_POST["vereniging_postcode"]) || empty($_POST["vereniging_mail"]) || empty($_POST["vereniging_contactpersoon"]))) {
				print "<h3>Niet alle verplichte velden zijn ingevuld!</h3>";
			}
			?>
			<script type="text/javascript">
				function clearElements(el) {
					var x, y, type = null, object = [];
					object[0] = document.getElementById(el).getElementsByTagName('input');
					for (x = 0; x < object.length; x++) {
						for (y = 0; y < object[x].length; y++) {
							type = object[x][y].type;
							switch (type) {
								case 'text':
									object[x][y].value = '';
									break;
						}
					}
				}
			</script>
			<form method="post" action="registrerenvereniging.php" id="registreer_vereniging">
				<table class="registreren"> <!-- De class registreren is om de text voor de inputs aan de rechterkant van de cel te plakken. -->
					<tr>
						<td>*</td>
						<td>Naam:</td>
						<td colspan="2"><input type="text" name="vereniging_naam" value="<?php if (isset($_POST["vereniging_naam"])) {
				print $_POST["vereniging_naam"];
			} ?>"/></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Plaats:</td>
						<td colspan="2"><input type="text" name="vereniging_plaats" value="<?php if (isset($_POST["vereniging_plaats"])) {
				print $_POST["vereniging_plaats"];
			} ?>" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Adres:</td>
						<td colspan="2"><input type="text" name="vereniging_adres" value="<?php if (isset($_POST["vereniging_adres"])) {
				print $_POST["vereniging_adres"];
			} ?>"/></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Postcode:</td>
						<td colspan="2"><input type="text" name="vereniging_postcode" value="<?php if (isset($_POST["vereniging_postcode"])) {
				print $_POST["vereniging_postcode"];
			} ?>" maxlength="6" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>E-mail:</td>
						<td colspan="2"><input type="text" name="vereniging_mail" value="<?php if (isset($_POST["vereniging_mail"])) {
				print $_POST["vereniging_mail"];
			} ?>" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Contactpersoon:</td>
						<td colspan="2"><input type="text" name="vereniging_contactpersoon" value="<?php if (isset($_POST["vereniging_contactpersoon"])) {
				print $_POST["vereniging_contactpersoon"];
			} ?>" /></td>
					</tr>
					<tr>
						<td></td>
						<td>Telefoonnr:</td>
						<td colspan="2"><input type="text" name="vereniging_telefoon" value="<?php if (isset($_POST["vereniging_telefoon"])) {
				print $_POST["vereniging_telefoon"];
			} ?>" /></td>
					</tr>
					<tr>
						<td></td>
						<td>KVK:</td>
						<td colspan="2"><input type="text" name="vereniging_kvk" value="<?php if (isset($_POST["vereniging_kvk"])) {
				print $_POST["vereniging_kvk"];
			} ?>" /></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td align="center">
							<input type="button" name="reset_button" value="Herstellen"  onclick=" clearElements('registreer_vereniging')" />
							<input type="submit" name="verstuur" value="Verstuur"/>
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
?>