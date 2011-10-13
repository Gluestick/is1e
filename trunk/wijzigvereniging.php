<?php
/**
 * @author:
 * @description: Pagina waarop je een vereniging kunt registreren
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Wijzigen vereniging");
$pagina->setCss("style.css");

if(!isset($_GET['id']) && !isset($_POST['verstuur'])){
	header('Location: index.php');
}

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
			
			if (isset($_POST['verstuur'])) {
				$naam = $_POST['naam'];
				$plaats = $_POST['plaats'];
				$adres = $_POST['adres'];
				$postcode = $_POST['postcode'];
				$emailadres = $_POST['emailadres'];
				$contactpersoon = $_POST['contactpersoon'];
				$telefoonnr = $_POST['telefoonnr'];
				$kvk = $_POST['kvk'];
				$eigenleden = $_POST['eigenleden'];

				$id = $_POST['id'];
				$sql = "UPDATE vereniging SET
						naam = '$naam', 
						plaats = '$plaats', 
						adres = '$adres', 
						postcode = '$postcode', 
						emailadres = '$emailadres', 
						contactpersoon = '$contactpersoon', 
						telefoonnr = '$telefoonnr', 
						kvk = '$kvk', 
						aantaleigenleden = '$eigenleden'
					WHERE verenigingid = '$id';";
				$result = mysql_query($sql) or die('Er ging iets fout met de verbinding: ' . mysql_error());
				if($result){
					print("Wijzigen succesvol!");
				}
			}
				
			
			
			$query = "SELECT * FROM vereniging WHERE verenigingid = '" . $_GET['id'] . "';";
			$result = mysql_query($query);
			
			$row = mysql_fetch_assoc($result);
			
			
			?>
			<form method="post" action="<?php print($_SERVER['PHP_SELF']); ?>?id=<?php print($_GET['id']); ?>">
				<table class="registreren">
					<tr>
						<td>*</td>
						<td>Naam:</td>
						<td colspan="2">
							<input type="text" name="id" value="<?php print($_GET['id']); ?>" hidden="hidden" />
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
						<td colspan="2"><input type="text" name="emailadres" value="<?php print($row['emailadres']); ?>" /></td>
					</tr>
					<tr>
						<td>*</td>
						<td>Contactpersoon:</td>
						<td colspan="2"><input type="text" name="contactpersoon" value="<?php print($row['contactpersoon']); ?>" /></td>
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
						<td>Eigen leden:</td>
						<td colspan="2"><input type="text" name="eigenleden" value="<?php print($row['aantaleigenleden']); ?>" /></td>
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