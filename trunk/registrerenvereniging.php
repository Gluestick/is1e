<?php
/**
 * @author: Kay van Bree, Joep Kemperman
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
			<form method="POST" action="#">
				<table class="registreren"> <!-- De class registreren is om de text voor de inputs aan de rechterkant van de cel te plakken. -->
					<tr>
						<td>*Naam:</td>
						<td colspan="2"><input type="text" name="vereniging_naam" /></td> <!-- De naam van de inputs kunnen nog verkort worden door het "vereniging" stukje weg te laten. Laat me weten als je denkt dat dat beter uitkomt. -->
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
							<input type="submit" value="Verstuur" />
						</td>
					</tr>
				</table>
			</form>
			<br/>Velden met * zijn verplicht. <!-- Astrisk in het formulier kan later nog "mooier" worden gemaakt -->
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