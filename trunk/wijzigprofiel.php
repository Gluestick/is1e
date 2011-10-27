<?php
/**
 * @author: Daniel
 * @description: 
 */
isHimSelf($_GET["id"]);

$pagina = pagina::getInstantie();

$pagina->setTitel("wijzig profiel");
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
		
	if (isset($_POST["wijzig"])) {
		if (empty($_POST["studentnr"])||
			empty($_POST["voornaam"]) || 
			empty($_POST["achternaam"])|| 
			empty($_POST["achternaam"])|| 
			empty($_POST["adres"]) || 
			empty($_POST["postcode"])||
			empty($_POST["woonplaats"]) ||
			empty($_POST["geboortedatum"])) {
			
				echo"alle velden zijn verplicht !";
				
		} else{
				$studentId = $_POST['studentId'];

				$studentnr = mysql_real_escape_string($_POST["studentnr"]);
				$voornaam = mysql_real_escape_string($_POST["voornaam"]);
				$achternaam = mysql_real_escape_string($_POST["achternaam"]);
				$adres = mysql_real_escape_string($_POST["adres"]);
				$postcode = mysql_real_escape_string($_POST["postcode"]);
				$woonplaats = mysql_real_escape_string($_POST["woonplaats"]);
				if (isset($_POST["geslacht"] ) ) {
					$geslacht = mysql_real_escape_string($_POST["geslacht"]);
				} else {
					$geslacht = NULL; 
				}
				if (tijd::checkCorrectieDatum($_POST["geboortedatum"])) {
					$geboortedatum = mysql_real_escape_string(tijd::formatteerTijd($_POST["geboortedatum"], "Y-m-d"));
				} else {
					$geboortedatum = "";
				}
				$emailadres = mysql_real_escape_string($_POST["emailadres"]);
				
				if(!empty($_FILES['profielfoto']["name"]) && !empty($_FILES['profielfoto']["type"]) && !empty($_FILES['profielfoto']["tmp_name"]) && empty($_FILES['profielfoto']["error"]) && !empty($_FILES['profielfoto']["size"])){
					if (isset($_FILES["profielfoto"]["tmp_name"])) { //heeft de foto een tijdelijke naam?
						$afbeelding = $_FILES['profielfoto'];
						if (gebruiker::checkValideUpload($afbeelding["error"]) == "") {
							if (filesize($afbeelding['tmp_name']) < 100000) { //is de afbeelding in de temp map, minder dan 100kb?
								if (getimagesize($_FILES['profielfoto']['tmp_name'])) { //kunnen we eigenschappen ophalen van de afbeelding?
									list($width, $height, $type, $attr) = getimagesize($_FILES['profielfoto']['tmp_name']);
									if ($width <= 200 && $height <= 200) {

//										$bestand = false;
//										if (exif_imagetype($_FILES['profielfoto']['tmp_name']) == IMAGETYPE_GIF) {
//											$bestand = true;
//										} else if (exif_imagetype($_FILES['profielfoto']['tmp_name']) == IMAGETYPE_PNG) {
//											$bestand = true;
//										} else if (exif_imagetype($_FILES['profielfoto']['tmp_name']) == IMAGETYPE_JPEG) {
//											$bestand = true;
//										}

//										if ($bestand) {
											$pointer = fopen($afbeelding['tmp_name'], "rb"); //open het bestand in binary format
											$afbeelding2 = fread($pointer, filesize($afbeelding['tmp_name'])); //geeft een string terug vam het bestand

											$sql = "UPDATE `student` SET `profielfoto`='" . mysql_real_escape_string(base64_encode($afbeelding2)) . "' WHERE `studentid` = ".mysql_real_escape_string($_GET["id"]);
											mysql_query($sql);

	//										if (!file_exists($_FILES['profielfoto']['name'])) {
	//											$uploaddir = $_SERVER["DOCUMENT_ROOT"].'/project/profielfoto/';
	//											$uploadfile = $uploaddir . basename($_FILES['profielfoto']['name']);
	//
	//											if (move_uploaded_file($_FILES['profielfoto']['tmp_name'], $uploadfile)) {
	//												$sql = "UPDATE `student` SET `profielfoto`='".mysql_real_escape_string($uploadfile)."' WHERE `studentid` = 1";
	//												mysql_query($sql);
	//												echo "Bestand ". $_FILES['profielfoto']['name'] ." is succesvol geupload.\n";
	//											} else {
	//												echo "Kon de afbeelding niet uploaden\n\r";
	//											}
	//										} else {
	//											echo "Een bestand met deze naam bestaat reeds.";
	//										}
//										} else {
//											echo "Bestand type onjuist";
//										}
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
				}

				$id = mysql_real_escape_string($_GET["id"]);
				$sql = "UPDATE student 
				SET voornaam='" . $voornaam . "',
		               achternaam='" . $achternaam . "',
		               adres='" . $adres . "',
		               postcode='" . $postcode . "',
		               woonplaats='" . $woonplaats . "',
		               geslacht='" . $geslacht . "',
		               geboortedatum='".$geboortedatum ."',
					   studentnr='" . $studentnr . "'
				WHERE studentid=" . $id . ";";
				
				$sql2 = "UPDATE user
							SET  email='" . $emailadres . "'
						WHERE user_id=" . $id . ";";
				$resultaat_van_server = mysql_query($sql);
				$resultaat_van_server2 = mysql_query($sql2);
				echo"gewijzigd";
				echo"<a href=\"raadplegenprofiel.php?id=" . $id . "\"> terug </a></br>";
				print("U wordt over 5 seconden doorgelinked naar je profiel pagina<br/>");
                                                    print("<a href=\"raadplegenprofiel.php?id=$id\">of klik hier om direct naar de evenementenlijst te gaan</a>");
                                                    
				//header("location:raadplegenprofiel.php?id=".$id);
			}
	}
			$id = mysql_real_escape_string($_GET["id"]);
			$query =   "SELECT S.studentid as studentid, U.user_id as user_id, S.studentnr as studentnr, voornaam, achternaam, adres, postcode, woonplaats, geslacht, geboortedatum, email, profielfoto
						FROM student S 
						JOIN user U ON S.userid = U.user_id
						WHERE S.studentid = '$id' LIMIT 1;";
			$resultaat_van_server = mysql_query($query);
			$array = mysql_fetch_assoc($resultaat_van_server);
			if($array['geboortedatum'] == '0000-00-00'){
				$geboortedatum = NULL;
			} else {
				$geboortedatum = mysql_real_escape_string(tijd::formatteerTijd($array["geboortedatum"], 'd-m-Y'));
			}
			?>
			<form enctype="multipart/form-data" action="wijzigprofiel.php?id=<?php echo $id; ?>" method="POST" align="left">
				<table>
					<tr>
						<td valign="top">
							Profielfoto:
						</td>
						<td>
							<?php if (!empty($array["profielfoto"])) { ?>
								<img src="data:image/png;base64,<?php echo $array["profielfoto"]; ?>" alt="avatar" title="avatar" />
							<?php } else { ?>
								Geen profielfoto.
							<?php } ?>
								<br />
							<input type="file" name="profielfoto" />
						</td>
					</tr>
					<tr>	
						<td>
							Studentnummer:
						</td>
						<td>
							<input type="text" name="studentId" hidden="hidden" value="<?php echo $array['studentid']; ?>" />
							<input type="text" name="studentnr" value="<?php echo $array["studentnr"]; ?>" />
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
						<td> Geslacht:	 </td> <td>   <input type="radio" name="geslacht" value="Man" <?php if($array["geslacht"] == "Man") {echo "checked='checked'";} ?> /> Man <input type="radio" name="geslacht" value="Vrouw" <?php if ($array["geslacht"] == "Vrouw") { echo "checked='checked'"; } ?> />Vrouw  </br> </td>
					</tr>	
					<tr>
						<td>Geboortedatum: </td> <td>	<input type="text" name="geboortedatum" value="<?php echo $geboortedatum; ?>" /> </br></td>
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

