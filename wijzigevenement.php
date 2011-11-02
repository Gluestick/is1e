<?php
/**
 * @author: Kay van Bree, Kajel Bhikhoe
 * @description: 
 */
if (!isAdmin() && !isVereniging()) {
	header("location:index.php");
}
$pagina = pagina::getInstantie();
database::getInstantie();


if (isset($_POST["wijzigen"])) {
	$error = array();
	if (empty($_POST["naam"])) {
		$error["naam"] = "U heeft geen naam ingevuld";
	}
	if (empty($_POST["bdatum"])) {
		$error["bdatum"] = "U heeft geen begin datum ingevuld";
	} else if (!tijd::checkCorrectieDatum($_POST["bdatum"])) {
		$error["bdatum"] = "U heeft een onjuiste begin datum ingevuld";
	}
	if (!empty($_POST["edatum"]) && !tijd::checkCorrectieDatum($_POST["edatum"])) {
		$error["edatum"] = "U heeft een onjuiste eind datum ingevuld";
	}
	if (empty($_POST["tekstvak"])) {
		$error["tekstvak"] = "U heeft geen omschrijving ingevuld";
	}
	if (empty($_POST["categorie"])) {
		$error["categorie"] = "U heeft geen categorie ingevuld";
	}
	if (empty($_POST["vereniging"])) {
		$error["vereniging"] = "U heeft geen vereniging ingevuld";
	}
	if (empty($_POST["evenementid"])) {
		$error["evenementid"] = "Er is een fout opgetreden";
	}
	
	if (count(array_keys($error)) == 0) {
		$naam = mysql_real_escape_string($_POST["naam"]);
		$bdatum = mysql_real_escape_string(tijd::formatteerTijd($_POST["bdatum"], "Y-m-d"));
		$edatum = mysql_real_escape_string(tijd::formatteerTijd($_POST["edatum"], "Y-m-d"));
		$tekstvak = mysql_real_escape_string($_POST["tekstvak"]);
		$categorie = mysql_real_escape_string($_POST["categorie"]);
		$vereniging = mysql_real_escape_string($_POST["vereniging"]);
		$evenement = mysql_real_escape_string($_POST["evenementid"]);
		
		if (isset($_POST["aanmelden"])) {
			$aanmelden = "Ja";
		} else {
			$aanmelden = "Nee";
		}
		
		$query = "UPDATE evenement 
				SET categorieid='".$categorie."', naam='".$naam."', omschrijving='".$tekstvak."', begindatum='".$bdatum."', einddatum='".$edatum."', isaanmeldingverplicht='".$aanmelden."', organiserendeverenigingid='".$vereniging."' 
				where evenementid=".$evenement.";";
				mysql_query($query);
	}
}


if (isset($_GET["id"])) {
	$id = ($_GET["id"]);
} else {
	$id = null;
}

$sql = "SELECT * FROM `evenement` where evenementId = $id;";
$resultaat_van_server = mysql_query($sql);

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
			<?php
			if ($resultaat_van_server) {
				if (mysql_num_rows($resultaat_van_server) > 0) {
					$array = mysql_fetch_array($resultaat_van_server);
					
					if ((!isset($error)) || (count(array_keys($error)) == 0)) {
						echo "Wijzigen is gelukt!";
					}
					?>
			<form action="" method="post">
				<table>
					<tr>
						<td>Naam </td>
						<td><input type="text" name="naam" value="<?php echo $array["naam"]; ?>"/><?php if (isset($error["naam"])) { echo "<td>".$error["naam"]."</td>"; } ?>
						<input type="hidden" name="evenementid" value="<?php echo $id; ?>" /></td>
					</tr>
					<tr>
						<td>Begin </td>	
						<td><input type="text" name="bdatum" value="<?php echo tijd::formatteerTijd($array["begindatum"], "d-m-Y"); ?>"/><?php if (isset($error["bdatum"])) { echo "<td>".$error["bdatum"]."</td>"; } else { ?><i>dd-mm-jjjj</i><?php } ?></td>
					</tr>
					<tr>
						<td>Eind </td>
						<td><input type="text" name="edatum" value="<?php echo tijd::formatteerTijd($array["einddatum"], "d-m-Y"); ?>"/><?php if (isset($error["edatum"])) { echo "<td>".$error["edatum"]."</td>"; } else { ?><i>dd-mm-jjjj</i><?php } ?></td>
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
							</select><?php if (isset($error["categorie"])) { echo "<td>".$error["categorie"]."</td>"; } ?>
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
							</select><?php if (isset($error["vereniging"])) { echo "<td>".$error["vereniging"]."</td>"; } ?>
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
							?></textarea><?php if (isset($error["tekstvak"])) { echo "<td>".$error["tekstvak"]."</td>"; } ?>
						</td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" name="wijzigen" value="Opslaan"/><a href ="evenement.php?id=<?php echo $_GET["id"]; ?>">Terug</a></td>
					</tr>
				</table>
			</form>
			<?php
				} else {
					echo "Geen resultaten.";
				}
			} else {
				echo "Geen resultaten.";
			}
			?>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>



<?php
echo $pagina->getVereisteHTMLafsluiting();
?>
