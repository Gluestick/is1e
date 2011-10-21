<?php
/**
 * @author: Joep Kemperman
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
				if (!empty($_POST["vereniging_naam"]) && preg_match("/^[a-zA-Z0-9äëïöüÄËÏÖÜáéíóúàèìòù\s]+$/", $_POST["vereniging_naam"]) != 1) {
					$error["naam"] = "Ongeldige naam";
				}
				if (!empty($_POST["vereniging_plaats"]) && preg_match("/^[a-zA-Z0-9äëïöüÄËÏÖÜáéíóúàèìòù'-\s]+$/", $_POST["vereniging_plaats"]) != 1) {
					$error["plaats"] = "Ongeldige plaatsnaam";
				}
				if (!empty($_POST["vereniging_postcode"]) && preg_match("/^[0-9]{4}[a-zA-Z]{2}$/", $_POST["vereniging_postcode"]) != 1) {
					$error["postcode"] = "Ongeldige postcode";
				}
				if (!empty($_POST["vereniging_mail"]) && preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST["vereniging_mail"]) != 1) {
					$error["mail"] = "Ongeldig e-mail adres";
				}
				if (!empty($_POST["vereniging_adres"]) && preg_match("/^[a-zA-ZäëïöüÄËÏÖÜáéíóúàèìòù'\s]+[0-9]+$/", $_POST["vereniging_adres"]) != 1) {
					$error["adres"] = "Ongeldig adres";
				}
				if (!empty($_POST["vereniging_telefoon"]) && preg_match("/^[+]?[0-9]+[-]?[0-9]+$/", $_POST["vereniging_telefoon"]) != 1) {
					$error["telefoon"] = "Ongeldig telefoonnummer";
				}
				//if (!empty($_POST["vereniging_kvk"]) && preg_match("/^$/", $_POST["vereniging_kvk"])) {
				//$error["kvk"] = "Ongeldige KVK";
				//}
				if (empty($_POST["vereniging_naam"]) || empty($_POST["vereniging_plaats"]) || empty($_POST["vereniging_adres"]) || empty($_POST["vereniging_postcode"]) || empty($_POST["vereniging_mail"]) || empty($_POST["vereniging_contactpersoon"])) {
					print $error["velden"] = "Niet alle verplichte velden zijn ingevuld!<p/>";
				}
			}
			if (!isset($error) && isset($_POST["verstuur"])) {
				$sql = "INSERT INTO vereniging (naam, adres, postcode, plaats, contactpersoon, emailadres, kvk, telefoonnr) VALUES('" . mysql_real_escape_string($_POST["vereniging_naam"]) . "', '" . mysql_real_escape_string($_POST["vereniging_adres"]) . "', '" . mysql_real_escape_string($_POST["vereniging_postcode"]) . "', '" . mysql_real_escape_string($_POST["vereniging_plaats"]) . "', '" . mysql_real_escape_string($_POST["vereniging_contactpersoon"]) . "', '" . mysql_real_escape_string($_POST["vereniging_mail"]) . "'";
				if (!empty($_POST["vereniging_kvk"])) {
					$sql .= ", '" . mysql_real_escape_string($_POST["vereniging_kvk"]) . "'";
				} else {
					$sql .= ", NULL";
				}
				if (!empty($_POST["vereniging_telefoon"])) {
					$sql .= ", '" . mysql_real_escape_string($_POST["vereniging_telefoon"]) . "')";
				} else {
					$sql .= ", NULL)";
				}
				$resultaat_van_server = mysql_query($sql);
				if ($resultaat_van_server == true) {
					?>
					<script type="text/javascript">
						setTimeout("location.href='./verenigingenlijst.php'", 5000);
					</script>
					<h3>Vereniging succesvol geregistreerd!</h3>
					Wacht 5 seconden of <a href="verenigingenlijst.php">klik hier</a> om naar de verenigingenlijst te gaan.<p/>
					<?php
				}
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
				}
			</script>
			<form method="post" action="registrerenvereniging.php" id="registreer_vereniging">
				<table>
					<tr>
						<td>*</td>
						<td>Naam:</td>
						<td colspan="2"><input type="text" maxlength="45" name="vereniging_naam" value="<?php
			if (isset($_POST["vereniging_naam"])) {
				print $_POST["vereniging_naam"];
			}
			?>"/></td><?php
											   if (isset($error["naam"])) {
												   print "<td>{$error["naam"]}</td>";
											   }
			?>
					</tr>
					<tr>
						<td>*</td>
						<td>Plaats:</td>
						<td colspan="2"><input type="text" maxlength="45" name="vereniging_plaats" value="<?php
							if (isset($_POST["vereniging_plaats"])) {
								print $_POST["vereniging_plaats"];
							}
			?>" /></td><?php
											   if (isset($error["plaats"])) {
												   print "<td>{$error["plaats"]}</td>";
											   }
			?>
					</tr>
					<tr>
						<td>*</td>
						<td>Adres:</td>
						<td colspan="2"><input type="text" maxlength="45" name="vereniging_adres" value="<?php
							if (isset($_POST["vereniging_adres"])) {
								print $_POST["vereniging_adres"];
							}
			?>"/></td><?php if (isset($error["adres"])) {
												   print "<td>{$error["adres"]}</td>";
											   } ?>
					</tr>
					<tr>
						<td>*</td>
						<td>Postcode:</td>
						<td colspan="2"><input type="text" name="vereniging_postcode" value="<?php
											   if (isset($_POST["vereniging_postcode"])) {
												   print $_POST["vereniging_postcode"];
											   }
			?>" maxlength="6" /></td><?php
							if (isset($error["postcode"])) {
								print "<td>{$error["postcode"]}</td>";
							}
			?>
					</tr>
					<tr>
						<td>*</td>
						<td>E-mail:</td>
						<td colspan="2"><input type="text" maxlength="45" name="vereniging_mail" value="<?php
							if (isset($_POST["vereniging_mail"])) {
								print $_POST["vereniging_mail"];
							}
			?>" /></td><?php
							if (isset($error["mail"])) {
								print "<td>{$error["mail"]}</td>";
							}
			?>
					</tr>
					<tr>
						<td>*</td>
						<td>Contactpersoon:</td>
						<td colspan="2"><input type="text" maxlength="45" name="vereniging_contactpersoon" value="<?php
							if (isset($_POST["vereniging_contactpersoon"])) {
								print $_POST["vereniging_contactpersoon"];
							}
			?>" /></td>
					</tr>
					<tr>
						<td></td>
						<td>Telefoonnr:</td>
						<td colspan="2"><input type="text" maxlength="45" name="vereniging_telefoon" value="<?php
							if (isset($_POST["vereniging_telefoon"])) {
								print $_POST["vereniging_telefoon"];
							}
			?>" /></td><?php
							if (isset($error["telefoon"])) {
								print "<td>{$error["telefoon"]}</td>";
							}
			?>
					</tr>
					<tr>
						<td></td>
						<td>KVK:</td>
						<td colspan="2"><input type="text" maxlength="45" name="vereniging_kvk" value="<?php
							if (isset($_POST["vereniging_kvk"])) {
								print $_POST["vereniging_kvk"];
							}
			?>" /></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td align="center">
							<input type="button" name="reset_button" value="Herstellen"  onclick="clearElements('registreer_vereniging')" />
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