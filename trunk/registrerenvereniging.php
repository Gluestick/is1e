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
				$registreer = registreer::getInstantie();
				if(!empty($_POST['gebruiker'])){
					if (strlen($_POST["gebruiker"]) < 3) {
						$error["gebruiker"] = "Gebruikersnaam te kort";
					}
					elseif ($registreer->checkDubbel("user", $_POST['gebruiker'], "username")) {
						$error["gebruiker"] = "Gebruikersnaam bestaat al";
					}
				}
				if(!isset($_POST['pass1']) || !isset($_POST['pass2'])){
					$error['password'] = "U heeft minstens 1 keer geen wachtwoord ingevuld.";
				} else {
					if($_POST['pass1'] != $_POST['pass2']){
						$error['password'] = "Uw wachtwoorden komen niet overeen.";
					}
				}
				if (!empty($_POST["vereniging_naam"]) && !preg_match("/^[a-zA-Z0-9äëïöüÄËÏÖÜáéíóúàèìòù\s-]+$/", $_POST["vereniging_naam"])) {
					$error["naam"] = "Ongeldige naam";
				}
				if (!empty($_POST["vereniging_plaats"]) && !preg_match("/^[a-zA-Z0-9äëïöüÄËÏÖÜáéíóúàèìòù'\s-]+$/", $_POST["vereniging_plaats"])) {
					$error["plaats"] = "Ongeldige plaatsnaam";
				}
				if (!empty($_POST["vereniging_postcode"]) && !preg_match("/^[0-9]{4}[a-zA-Z]{2}$/", $_POST["vereniging_postcode"])) {
					$error["postcode"] = "Ongeldige postcode";
				}
				if (!empty($_POST["email"]) && !preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $_POST["email"])) {
					$error["email"] = "Ongeldig e-mail adres";
				}
				if (!empty($_POST["vereniging_adres"]) && !preg_match("/^[a-zA-ZäëïöüÄËÏÖÜáéíóúàèìòù'\s-]+[0-9]+$/", $_POST["vereniging_adres"])) {
					$error["adres"] = "Ongeldig adres";
				}
				if (!empty($_POST["vereniging_telefoon"]) && !preg_match("/^[+]?[0-9]+[-]?[0-9]+$/", $_POST["vereniging_telefoon"])) {
					$error["telefoon"] = "Ongeldig telefoonnummer";
				}
				if (!empty($_POST["vereniging_contactpersoon"]) && !preg_match("/^[a-zA-Z0-9äëïöüÄËÏÖÜáéíóúàèìòù\s]+$/", $_POST["vereniging_contactpersoon"])) {
					$error["contactpersoon"] = "Ongeldige naam";
				}
				if (!empty($_POST["vereniging_aantal_leden"])) {
					if(!is_int($_POST["vereniging_aantal_leden"]) && $_POST["vereniging_aantal_leden"] < 1) {
						$error["aantal_leden"] = "Ongeldig aantal";
					}
				}
				if (!empty($_POST["vereniging_kvk"]) && !preg_match("/^[0-9]{8}$/", $_POST["vereniging_kvk"])) {
					$error["kvk"] = "Ongeldige KVK";
				}
				if (empty($_POST['gebruiker']) || empty($_POST['pass1']) || empty($_POST['pass2']) || empty($_POST["vereniging_naam"]) || empty($_POST["vereniging_plaats"]) || empty($_POST["vereniging_adres"]) || empty($_POST["vereniging_postcode"]) || empty($_POST["email"])) {
					print $error["velden"] = "Niet alle verplichte velden zijn ingevuld!<br/><br/>";
				}
			}
			if (!isset($error) && isset($_POST["verstuur"])) {
				
				
				$pass1 = mysql_real_escape_string($_POST['pass1']);
				$email = mysql_real_escape_string($_POST['email']);
				$salt = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,32);
				$activation = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,32);
				$role = NULL;
				
				$password = md5($pass1 . "" . $salt);
				
				
				$sql2 = "INSERT INTO user (`username`, `password`, `salt`, `activation`, `email`, `role`) VALUES('".mysql_real_escape_string($_POST['gebruiker'])."', '$password', '$salt', '$activation', '$email', '$role');";
				$resultaat2 = mysql_query($sql2);
				$lastid = mysql_fetch_assoc(mysql_query("SELECT last_insert_id() as userid FROM user"));
				$sql = "INSERT INTO vereniging (naam, adres, postcode, plaats, aantaleigenleden, kvk, telefoonnr, userid) VALUES('" . mysql_real_escape_string($_POST["vereniging_naam"]) . "', '" . mysql_real_escape_string($_POST["vereniging_adres"]) . "', '" . mysql_real_escape_string($_POST["vereniging_postcode"]) . "', '" . mysql_real_escape_string($_POST["vereniging_plaats"]) . "', '".mysql_real_escape_string($_POST["vereniging_aantal_leden"])."'";
				if (!empty($_POST["vereniging_kvk"])) {
					$sql .= ", '" . mysql_real_escape_string($_POST["vereniging_kvk"]) . "'";
				} else {
					$sql .= ", NULL";
				}
				if (!empty($_POST["vereniging_telefoon"])) {
					$sql .= ", '" . mysql_real_escape_string($_POST["vereniging_telefoon"]) . "'";
				} else {
					$sql .= ", NULL";
				}
				$sql .= ", '".$lastid['userid']."');";
				$resultaat_van_server = mysql_query($sql) or die(mysql_error());
				if ($resultaat_van_server == true && $resultaat2 == true) {
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
						<td colspan="3"><b>Inlog informatie:</b></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Gebruikersnaam:</td>
						<td colspan="2"><input type="text" maxlength="45" name="gebruiker" value="<?php
							if (isset($_POST["gebruiker"])) {
								print $_POST["gebruiker"];
							}
			?>" /></td>
					<td><?php if (isset($error["gebruiker"])) { print $error["gebruiker"]; } ?></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Wachtwoord:</td>
						<td colspan="2"><input type="password" name="pass1" value="<?php
							if (isset($_POST["pass1"])) {
								print $_POST["pass1"];
							}
			?>" /></td>
					<td><?php if (isset($error["password"])) { print $error["password"]; } ?></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Wachtwoord herhalen:</td>
						<td colspan="2"><input type="password" name="pass2" value="<?php
							if (isset($_POST["pass2"])) {
								print $_POST["pass2"];
							}
			?>" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>E-mail:</td>
						<td colspan="2"><input type="text" maxlength="45" name="email" value="<?php
							if (isset($_POST["email"])) {
								print $_POST["email"];
							}
			?>" /></td>
					<td><?php if (isset($error["email"])) { print $error["email"]; } ?></td>
					</tr>
					<tr>
						<td colspan="3"><b>Verenigings-informatie:</b></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Naam:</td>
						<td colspan="2"><input type="text" maxlength="45" name="vereniging_naam" value="<?php
			if (isset($_POST["vereniging_naam"])) {
				print $_POST["vereniging_naam"];
			}
			?>"/></td>
					<td><?php if (isset($error["naam"])) { print $error["naam"]; } ?></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Contactpersoon:</td>
						<td colspan="2"><input type="text" name="vereniging_contactpersoon" value="<?php if(isset($_POST["vereniging_contactpersoon"])){ print $_POST["vereniging_contactpersoon"]; } ?>"></td>
						<td><?php if (isset($error["contactpersoon"])) { print $error["contactpersoon"]; }?></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Aantal leden:</td>
						<td colspan="2"><input type="text" name="vereniging_aantal_leden" value="<?php if(isset($_POST["vereniging_aantal_leden"])){ print $_POST["vereniging_aantal_leden"]; } ?>"></td>
						<td><?php if (isset($error["aantal_leden"])) { print $error["aantal_leden"]; }?></td>
					</tr>
					<tr>
						<td></td>
						<td>Telefoonnr:</td>
						<td colspan="2"><input type="text" maxlength="45" name="vereniging_telefoon" value="<?php
							if (isset($_POST["vereniging_telefoon"])) {
								print $_POST["vereniging_telefoon"];
							}
			?>" /></td>
					<td><?php if (isset($error["telefoon"])) { print $error["telefoon"]; } ?></td>
					</tr>
					<tr>
						<td></td>
						<td>KVK:</td>
						<td colspan="2"><input type="text" maxlength="45" name="vereniging_kvk" value="<?php
							if (isset($_POST["vereniging_kvk"])) {
								print $_POST["vereniging_kvk"];
							}
			?>" /></td>
					<td><?php if (isset($error["kvk"])) { print $error["kvk"]; } ?></td>
					</tr>
					<tr>
						<td colspan="3"><b>Adres-gegevens:</b></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Adres:</td>
						<td colspan="2"><input type="text" maxlength="45" name="vereniging_adres" value="<?php
							if (isset($_POST["vereniging_adres"])) {
								print $_POST["vereniging_adres"];
							}
			?>"/></td>
					<td><?php if (isset($error["adres"])) { print $error["adres"]; } ?></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Postcode:</td>
						<td colspan="2"><input type="text" name="vereniging_postcode" value="<?php
											   if (isset($_POST["vereniging_postcode"])) {
												   print $_POST["vereniging_postcode"];
											   }
			?>" maxlength="6" /></td>
					<td><?php if (isset($error["postcode"])) { print $error["postcode"]; } ?></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Plaats:</td>
						<td colspan="2"><input type="text" maxlength="45" name="vereniging_plaats" value="<?php
							if (isset($_POST["vereniging_plaats"])) {
								print $_POST["vereniging_plaats"];
							}
			?>" /></td>
					<td><?php if (isset($error["plaats"])) { print $error["plaats"]; } ?></td>
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