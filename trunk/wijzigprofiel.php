<?php
/**
 * @author: Daniel
 * @description: 
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("wijzig profiel");
$pagina->setCss("style.css");

isHimSelf();

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

			if (isset($_POST["wijzig"])) {

				$studentId = $_POST['studentId'];

				$studentnr = $_POST["studentnr"];
				$voornaam = $_POST["voornaam"];
				$achternaam = $_POST["achternaam"];
				$adres = $_POST["adres"];
				$postcode = $_POST["postcode"];
				$woonplaats = $_POST["woonplaats"];
				$geslacht = $_POST["geslacht"];
				$geboortedatum = $_POST["geboortedatum"];
				$emailadres = $_POST["emailadres"];

				if (isset($_FILES["profielfoto"]["tmp_name"])) { //heeft de foto een tijdelijke naam?
					$afbeelding = $_FILES['profielfoto'];
					if (gebruiker::checkValideUpload($afbeelding["error"]) == "") {
						if (filesize($afbeelding['tmp_name']) < 100000) { //is de afbeelding in de temp map, minder dan 100kb?
							if (getimagesize($_FILES['profielfoto']['tmp_name'])) { //kunnen we eigenschappen ophalen van de afbeelding?
								list($width, $height, $type, $attr) = getimagesize($_FILES['profielfoto']['tmp_name']);
								if ($width <= 100 && $height <= 100) {

									$bestand = false;
									if (exif_imagetype($_FILES['profielfoto']['tmp_name']) == IMAGETYPE_GIF) {
										$bestand = true;
									} else if (exif_imagetype($_FILES['profielfoto']['tmp_name']) == IMAGETYPE_PNG) {
										$bestand = true;
									} else if (exif_imagetype($_FILES['profielfoto']['tmp_name']) == IMAGETYPE_JPEG) {
										$bestand = true;
									}

									if ($bestand) {
										$pointer = fopen($afbeelding['tmp_name'], "rb"); //open het bestand in binary format
										$afbeelding2 = fread($pointer, filesize($afbeelding['tmp_name'])); //geeft een string terug vam het bestand

										$sql = "UPDATE `student` SET `profielfoto`='" . mysql_real_escape_string(base64_encode($afbeelding2)) . "' WHERE `studentid` = ".mysql_real_escape_string($_GET["id"]);
										mysql_query($sql) or die(mysql_error());

//										if (!file_exists($_FILES['profielfoto']['name'])) {
//											$uploaddir = $_SERVER["DOCUMENT_ROOT"].'/project/profielfoto/';
//											$uploadfile = $uploaddir . basename($_FILES['profielfoto']['name']);
//
//											if (move_uploaded_file($_FILES['profielfoto']['tmp_name'], $uploadfile)) {
//												$sql = "UPDATE `student` SET `profielfoto`='".mysql_real_escape_string($uploadfile)."' WHERE `studentid` = 1";
//												mysql_query($sql) or die(mysql_error());
//												echo "Bestand ". $_FILES['profielfoto']['name'] ." is succesvol geupload.\n";
//											} else {
//												echo "Kon de afbeelding niet uploaden\n\r";
//											}
//										} else {
//											echo "Een bestand met deze naam bestaat reeds.";
//										}
									} else {
										echo "Bestand type onjuist";
									}
								} else {
									echo "Afbeelding is te groot.";
								}
							} else {
								echo "Onjuist afbeelding bestand";
							}
						} else {
							echo "Te groot bestand.";
						}
					} else {
						echo gebruiker::checkValideUpload($afbeelding["error"]);
					}
				}


				$id = mysql_real_escape_string($_GET["id"]);
				$sql = "UPDATE student 
				SET voornaam='" . $voornaam . "',
		               achternaam='" . $achternaam . "',
		               adres='" . $adres . "',
		               postcode='" . $postcode . "',
		               woonplaats='" . $woonplaats . "',
		               geslacht='" . $geslacht . "',
		               geboortedatum='" . $geboortedatum . "',
					   emailadres='".$emailadres."'
				WHERE studentid=" . $studentId . ";";
				
				$sql2 = "UPDATE user
							SET  email='" . $emailadres . "'
						WHERE user_id=" . $id . ";";
				$resultaat_van_server = mysql_query($sql) or die(mysql_error());
				$resultaat_van_server2 = mysql_query($sql2) or die(mysql_error());
				echo"gewijzigd";
				echo"<a href=\"raadplegenprofiel.php?id=" . $id . "\"> terug </a>";
				//header("location:raadplegenprofiel.php?id=".$id);
			}
			$id = mysql_real_escape_string($_GET["id"]);
			$query = "SELECT S.studentId, S.studentnr as studentnr, voornaam, achternaam, adres, postcode, woonplaats, geslacht, geboortedatum, email
				FROM student S JOIN user U ON S.studentId = U.studentId
				WHERE U.user_id = '$id' LIMIT 1;";
			$resultaat_van_server = mysql_query($query);
			$array = mysql_fetch_array($resultaat_van_server);
			$id = mysql_real_escape_string($_GET["id"]);
			?>
			<form enctype="multipart/form-data" action="wijzigprofiel.php?id=<?php echo $id; ?>   "method="POST" align="left">
				<table>
					<tr>
						<td>
							Profielfoto:
						</td>
						<td>
							<input type="file" name="profielfoto" />
						</td>
					</tr>
					<tr>	
						<td>
							Studentnummer:
						</td>
						<td>
							<input type="text" name="studentId" hidden="hidden" value="<?php echo $array['studentId']; ?>" />
							<input type="text" name="studentnr" value=" <?php echo $array["studentnr"]; ?>" readonly="readonly" />
						</td>
					</tr>
					<tr>
						<td>
							Voornaam:
						</td>
						<td>
							<input type="text" name="voornaam"  value="<?php echo $array["voornaam"]; ?>"/>
						</td>
					</tr>
					<tr>
						<td> Achternaam: </td>	<td>    <input type="text" name="achternaam" value="<?php echo $array["achternaam"]; ?>"/>  </br> </td>
					</tr>
					<tr>
						<td>	Adres: 	 </td>   <td>    <input type="text" name="adres" value="<?php echo $array["adres"]; ?>" /> </br></td>
					</tr>
					<tr>
						<td>	Postcode: </td> <td>	    <input type="text" name="postcode" value="<?php echo $array["postcode"]; ?>" /> </br></td>
					</tr>
					<tr>
						<td>	Woonplaats:	 </td> <td>   <input type="text" name="woonplaats" value="<?php echo $array["woonplaats"]; ?>" /> </br></td>
					</tr>
					<tr>
						<td> Geslacht:	 </td> <td>   <input type="text" name="geslacht" value="<?php echo $array["geslacht"]; ?>" /> </br></td>
					</tr>	
					<tr>
						<td>Geboortedatum: </td> <td>	<input type="text" name="geboortedatum" value="<?php echo $array["geboortedatum"]; ?>" /> </br></td>
					</tr>
					<tr>
						<td>	E-mailadres: </td> <td> 	<input type="text" name="emailadres" value="<?php echo $array["email"]; ?>" /> </br></td>
					</tr>
					<tr>
						<td><input type="submit" name="wijzig" value="wijzig"/> </td>
					</tr>
					<tr>
						<td><a href="raadplegenprofiel.php?id=<?php echo $id; ?>"> terug </a></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();

