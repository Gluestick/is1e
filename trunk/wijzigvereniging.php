<?php
/**
 * @author:
 * @description: Pagina waarop je een vereniging kunt registreren
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Wijzigen vereniging");
$pagina->setCss("style.css");

if (!isset($_GET['id']) && !isset($_POST['verstuur'])) {
	header('Location: index.php');
}

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel();
		if(isset($_GET["id"])) { ?>&nbsp;<a href="raadplegenvereniging.php?id=<?php print $_GET["id"]; ?>">Terug</a><?php } ?></h1>
			<?php
			database::getInstantie();
			if (isset($_POST["verstuur"]) && (empty($_POST["naam"]) || empty($_POST["plaats"]) || empty($_POST["adres"]) || empty($_POST["postcode"]) || empty($_POST["emailadres"]) || empty($_POST["contactpersoon"]) || empty($_POST["emailadres"]))) {
				print $error["velden"] = "Niet alle verplichte velden zijn ingevuld!<br/><br/>";
			}
			if (!empty($_POST["naam"]) && !preg_match("/^[a-zA-Z0-9äëïöüÄËÏÖÜáéíóúàèìòù\s-]+$/", $_POST["naam"])) {
				$error["naam"] = "Ongeldige naams";
			}
			if (!empty($_POST["plaats"]) && !preg_match("/^[a-zA-Z0-9äëïöüÄËÏÖÜáéíóúàèìòù'\s-]+$/", $_POST["plaats"])) {
				$error["plaats"] = "Ongeldige plaatsnaam";
			}
			if (!empty($_POST["adres"]) && !preg_match("/^[a-zA-ZäëïöüÄËÏÖÜáéíóúàèìòù'\s-]+[0-9]+$/", $_POST["adres"])) {
				$error["adres"] = "Ongeldig adres";
			}
			if (!empty($_POST["postcode"]) && !preg_match("/^[0-9]{4}[a-zA-Z]{2}$/", $_POST["postcode"])) {
				$error["postcode"] = "Ongeldige postcode";
			}
			if (!empty($_POST["emailadres"]) && !preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $_POST["emailadres"])) {
				$error["emailadres"] = "Ongeldig e-mail adres";
			}
			if (!empty($_POST["contactpersoon"]) && !preg_match("/^[a-zA-Z0-9äëïöüÄËÏÖÜáéíóúàèìòù\s]+$/", $_POST["contactpersoon"])) {
				$error["contactpersoon"] = "Ongeldige naam";
			}
			if (!empty($_POST["aantal_leden"])) {
				if(!is_int($_POST["aantal_leden"]) && $_POST["aantal_leden"] < 1) {
					$error["aantal_leden"] = "Ongeldig aantal";
				}
			}
			if (!empty($_POST["telefoon"]) && !preg_match("/^[+]?[0-9]+[-]?[0-9]+$/", $_POST["telefoon"])) {
				$error["telefoon"] = "Ongeldig telefoonnummer";
			}
			if (!empty($_POST["kvk"]) && !preg_match("/^[0-9]{8}$/", $_POST["kvk"])) {
				$error["kvk"] = "Ongeldige KVK";
			}
			if (isset($_POST['verstuur']) && !isset($error)) {
				$sql = "UPDATE vereniging SET
						naam = '" . mysql_real_escape_string($_POST['naam']) . "', 
						plaats = '" . mysql_real_escape_string($_POST['plaats']) . "', 
						adres = '" . mysql_real_escape_string($_POST['adres']) . "', 
						postcode = '" . mysql_real_escape_string($_POST['postcode']) . "',  
						telefoonnr = '" . mysql_real_escape_string($_POST['telefoonnr']) . "', 
						kvk = '" . mysql_real_escape_string($_POST['kvk']) . "',
						aantaleigenleden = '" . mysql_real_escape_string($_POST['aantal_leden']) . "'
						WHERE verenigingid = '" . mysql_real_escape_string($_POST['id']) . "'";
				$sql2 = "UPDATE user SET email = '" . mysql_real_escape_string($_POST["emailadres"]) . "' WHERE user_id = (SELECT userid FROM vereniging WHERE verenigingid = " . mysql_real_escape_string($_GET["id"]) . ")";
				$result = mysql_query($sql) or die('Er ging iets fout met de verbinding: ' . mysql_error());
				$result2 = mysql_query($sql2) or die('Er ging iets fout met de verbinding: ' . mysql_error());
				if ($result && $result2) {
					print("Wijzigen succesvol!<br/><br/>");
				}
			}



			$query = "SELECT * FROM vereniging V JOIN user U ON V.userid = U.user_id WHERE verenigingid = '" . mysql_real_escape_string($_GET['id']) . "';";
			$result = mysql_query($query);

			$row = mysql_fetch_assoc($result);
			?>
			<form method="post" action="<?php print($_SERVER['PHP_SELF']); ?>?id=<?php print($_GET['id']); ?>">
				<table class="registreren">
					<tr>
						<td>*</td>
						<td>Naam:</td>
						<td colspan="2">
							<input type="hidden" name="id" value="<?php print($_GET['id']); ?>" />
							<input type="text" name="naam" value="<?php print($row['naam']); ?>" />
						</td>
						<td><?php if(isset($error["naam"])){ print $error["naam"]; } ?></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Plaats:</td>
						<td colspan="2"><input type="text" name="plaats" value="<?php print($row['plaats']); ?>" /></td>
						<td><?php if(isset($error["plaats"])){ print $error["plaats"]; } ?></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Adres:</td>
						<td colspan="2"><input type="text" name="adres" value="<?php print($row['adres']); ?>" /></td>
						<td><?php if(isset($error["adres"])){ print $error["adres"]; } ?></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Postcode:</td>
						<td colspan="2"><input type="text" name="postcode" maxlength="6" value="<?php print($row['postcode']); ?>" /></td>
						<td><?php if(isset($error["postcode"])){ print $error["postcode"]; } ?></td>
					</tr>
					<tr>
						<td>*</td>
						<td>E-mail:</td>
						<td colspan="2"><input type="text" name="emailadres" value="<?php print($row['email']); ?>" /></td>
						<td><?php if(isset($error["emailadres"])){ print $error["emailadres"]; } ?></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Contactpersoon:</td>
						<td colspan="2"><input type="text" name="contactpersoon" value="kolom bestaat niet<?php //print($row['contactpersoon']);  ?>" /></td>
						<td><?php if(isset($error["contactpersoon"])){ print $error["contactpersoon"]; } ?></td>
					</tr>
					<tr>
						<td></td>
						<td>Aantal leden:</td>
						<td colspan="2"><input type="text" name="aantal_leden" value="<?php print($row['aantaleigenleden']); ?>" /></td>
						<td><?php if(isset($error["aantal_leden"])){ print $error["aantal_leden"]; } ?></td>
					</tr>
					<tr>
						<td></td>
						<td>Telefoonnr:</td>
						<td colspan="2"><input type="text" name="telefoonnr" value="<?php print($row['telefoonnr']); ?>" /></td>
						<td><?php if(isset($error["telefoonnr"])){ print $error["telefoonnr"]; } ?></td>
					</tr>
					<tr>
						<td></td>
						<td>KVK:</td>
						<td colspan="2"><input type="text" name="kvk" value="<?php print($row['kvk']); ?>" /></td>
						<td><?php if(isset($error["kvk"])){ print $error["kvk"]; } ?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td><input type="submit" name="verstuur" value="Verstuur" /></td>
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