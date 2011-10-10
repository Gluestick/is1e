<?php
	/**
	* @author: Kay van Bree
	* @description: Op deze pagina kunnen mensen zich registreren om lid te worden van de website.
	*				Er wordt informatie ingevoerd en deze wordt door middel van PHP_SELF op dezelfde
	*				pagina verwerkt. Met het verwerken wordt er een rij in de tabel Gebruikers aangemaakt.
	*/

	if(isset($_SESSION['login'])){
		header('Location: index.php');
	}
	
	$pagina = pagina::getInstantie();

	$pagina->setTitel("Registreren");
	$pagina->setCss("style.css");

	echo $pagina->getVereisteHTML();
	print("<div id=\"container\">");
	echo $pagina->getHeader();
	print("<div id=\"page\">");
	echo $pagina->getMenu(); 
	print("<div id=\"content\">");
	print("<h1>" . $pagina->getTitel() . "</h1>");
	
	//Registratie
	$registreer = registreer::getInstantie();
	if(isset($_POST['submit'])){
		$registreer = $registreer->maakGebruiker();
		print($registreer);
	} else {
?>
	<p>Wil je ook lid worden van deze community? Vul hieronder je gegevens in. Vul je echte e-mailadres in
		want deze heb je nodig om je account te kunnen activeren. Zonder activeren kun je niet inloggen!</p>
	
	<form action="<?php print($_SERVER['PHP_SELF']); ?>" method="post">
		<table>
			<tr><td colspan="2"><b>Inlog-informatie:</b></td></tr>
			<tr>
				<td>Gebruikersnaam:</td>
				<td>
					<input type="text" name="studentid" hidden="hidden" value="<?php $registreer->getStudentId(); ?>" />
					<input type="text" name="gebruikersnaam" />
				</td>
			</tr>
			<tr>
				<td>E-mailadres:</td>
				<td><input type="text" name="email" /></td>
			</tr>
			<tr>
				<td>Wachtwoord:</td>
				<td><input type="password" name="pass1" /></td>
			</tr>
			<tr>
				<td>Opnieuw:</td>
				<td><input type="password" name="pass2" /></td>
			</tr>
			<tr><td colspan="2"><b>Gebruikers-informatie:</b></td></tr>
			<tr>
				<td>Voornaam:</td>
				<td><input type="text" name="voornaam" /></td>
			</tr>
			<tr>
				<td>Achternaam:</td>
				<td><input type="text" name="achternaam" /></td>
			</tr>
			<tr>
				<td>Student-nummer:</td>
				<td><input type="text" name="studentnr" /></td>
			</tr>
			<tr>
				<td>Geboortedatum:</td>
				<td><input type="text" name="geb_dat" /></td>
			</tr>
			<tr>
				<td>Geslacht:</td>
				<td><input type="radio" name="geslacht" value="Man" checked="checked" />Man <input type="radio" name="geslacht" value="Vrouw" />Vrouw</td>
			</tr>
			<tr><td colspan="2"><b>Adres-gegevens:</b></td></tr>
			<tr>
				<td>Adres:</td>
				<td><input type="text" name="adres" /></td>
			</tr>
			<tr>
				<td>Postcode:</td>
				<td><input type="text" name="postcode" /></td>
			</tr>
			<tr>
				<td>Woonplaats:</td>
				<td><input type="text" name="woonplaats" /></td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" name="submit" value="Registreer!" /></td>
			</tr>

		</table>
	</form>


<?php
	}
	print("</div></div>");
	echo $pagina->getFooter();
	print("</div>");
	echo $pagina->getVereisteHTMLafsluiting();
?>