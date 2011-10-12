<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Upload je profiel foto");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>
			<form action="" method="post" enctype="multipart/form-data">
				<table>
					<tr>
						<td>
							<input type="file" name="profielfoto" />
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" name="profielfoto" />
						</td>
					</tr>
				</table>
			</form>
			<?php
			database::getInstantie();
			
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
									
									$sql = "UPDATE `student` SET `profielfoto`='".mysql_real_escape_string(base64_encode($afbeelding2))."' WHERE `studentid` = 1";
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
			
			$sql = "SELECT `profielfoto` FROM `student` WHERE studentid=1";
			$result = mysql_query($sql);
			while ($array = mysql_fetch_assoc($result)) {
				echo "<img src=\"data:image/png;base64,".$array["profielfoto"]."\" alt=\"avatar\" title=\"avatar\" />";
			}
			?>
		</div>
	</div>
			<?php echo $pagina->getFooter(); ?>
</div>

	<?php
	echo $pagina->getVereisteHTMLafsluiting();
	?>