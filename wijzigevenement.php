<?php
database::getInstantie();
$id = ($_GET["id"]);
$sql = "SELECT * FROM `evenement` where evenementId = $id;";
$resultaat_van_server = mysql_query($sql);
$array = mysql_fetch_array($resultaat_van_server);
/**
 * @author: Kay van Bree, Kajel Bhikhoe
 * @description: 
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Eventplaza");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>
			<form action="wijzigevenement2.php" method="post">
				
				<table>
						<input type ="hidden" name ="evenementid" value = <?php echo $id ?>/>
					<tr>
						<td>Naam </td>
						<td><input type="text" name="naam" value="<?php echo $array["naam"]; ?>"/></td>
					</tr>
					<tr>
						<td>Begin </td>	
						<td><input type="text" name="bdatum" value="<?php echo $array["begindatum"]; ?>"/><i>jjjj-mm-dd</i></td>
					</tr>
					<tr>
						<td>Eind </td>
						<td><input type="text" name="edatum" value="<?php echo $array["einddatum"]; ?>"/><i>jjjj-mm-dd</i></td>
					</tr>
					<tr>
						<td>Categorie </td>
						<td><select name="categorie">
								<?php
								database::getInstantie();
								$sql = "SELECT * FROM `categorie`;";
								$resultaat_van_server = mysql_query($sql);
								while ($categorie = mysql_fetch_array($resultaat_van_server)) {
									$selected = "";
									if ($array["categorieid"] == $categorie["categorieid"]) {
										$selected = "selected=\"selected\"";
									}
									echo "<option ".$selected." value=\"" . $categorie["categorieid"] . "\">" . $categorie["naam"] . "</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Organisator </td>
						<td><select name="vereniging"/>
								<?php
								$sql = "SELECT * FROM `vereniging`;";
								$resultaat_van_server = mysql_query($sql);
								while ($vereniging = mysql_fetch_array($resultaat_van_server)) {
									$selected = "";
									if ($array["organiserendeverenigingid"] == $vereniging["verenigingid"]) {
										$selected = "selected=\"selected\"";
									}
									echo "<option ".$selected." value=\"" . $vereniging["verenigingid"] . "\">" . $vereniging["naam"] . "</option>";
								}
									?>							
							</select>
						</td>
					</tr>
					<tr>
						<td>Aanmelding verplicht? </td>

						<?php
						$sql = "SELECT * FROM `evenement` WHERE evenementid = $id;";
						$resultaat_van_server = mysql_query($sql);
						while ($array = mysql_fetch_array($resultaat_van_server)) {
						if ($array["isaanmeldingverplicht"] == "Ja") { // isAanmeldingVerplicht geeft Ja of Nee terug, dus je kijkt of het Ja terug geeft.
							?>	
							<td><input type="checkbox" name="aanmelden" value="Ja" checked="checked" /> </td>
							<?php //Zo ja, dan maak je een checkbox aan die 'checked' is, dus die is aangevinkt
						} else { // zo niet
							?>
							<td><input type="checkbox" name="aanmelden" value="Ja" /> </td> 
							<?php //  dan maak je een checkbox aan die niet is aangevinkt. De reden dat ze allebei 'value = Ja' hebben, is omdat
						} //het uuh, als je het aanvinkt, dan is het ja, maar als het niet in aangevinkt dan wordt er geen waarde meegegeven.
						// dus aangevinkt = ja en niet aangevinkt = ??(nee waarsschijnlijk)
						}
						?>

					</tr>
					<tr>
						<td>Omschrijving </td>
						<td><textarea name ="tekstvak" value="<?php echo $array["omschrijving"]; ?>"/><?php
							$sql = "SELECT * FROM `Evenement` WHERE evenementId = $id;";
							$resultaat_van_server = mysql_query($sql);
							while ($array = mysql_fetch_array($resultaat_van_server)) { echo $array["omschrijving"];}
							?></textarea>
						</td>
					</tr>
					<tr>
						<td><input type="submit" value="Opslaan"/></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>



<?php
echo $pagina->getVereisteHTMLafsluiting();
?>
