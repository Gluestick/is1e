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

			if (isset($_POST['verstuur'])) {
				$sql = "UPDATE vereniging SET
						naam = '" . mysql_real_escape_string($_POST['naam']) . "', 
						plaats = '" . mysql_real_escape_string($_POST['plaats']) . "', 
						adres = '" . mysql_real_escape_string($_POST['adres']) . "', 
						postcode = '" . mysql_real_escape_string($_POST['postcode']) . "',  
						telefoonnr = '" . mysql_real_escape_string($_POST['telefoonnr']) . "', 
						kvk = '" . mysql_real_escape_string($_POST['kvk']) . "'
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
							<input type="text" name="naam" value="<?php print($row['naam']); ?>" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Plaats:</td>
						<td colspan="2"><input type="text" name="plaats" value="<?php print($row['plaats']); ?>" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Adres:</td>
						<td colspan="2"><input type="text" name="adres" value="<?php print($row['adres']); ?>" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Postcode:</td>
						<td colspan="2"><input type="text" name="postcode" maxlength="6" value="<?php print($row['postcode']); ?>" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>E-mail:</td>
						<td colspan="2"><input type="text" name="emailadres" value="<?php print($row['email']); ?>" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Contactpersoon:</td>
						<td colspan="2"><input type="text" name="contactpersoon" value="TODO. Database update.<?php //print($row['contactpersoon']);  ?>" /></td>
					</tr>
					<tr>
						<td></td>
						<td>Telefoonnr:</td>
						<td colspan="2"><input type="text" name="telefoonnr" value="<?php print($row['telefoonnr']); ?>" /></td>
					</tr>
					<tr>
						<td></td>
						<td>KVK:</td>
						<td colspan="2"><input type="text" name="kvk" value="<?php print($row['kvk']); ?>" /></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td align="center">
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
?>