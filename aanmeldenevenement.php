<?php
/**
 * @author: Kay van Bree, Kajel Bhikhoe
 * @description: 
 */
if (!isStudent()) { //ben je ingelogd en ben je een student als dat niet zo is dan:
	header("location:index.php"); //stuur naar index.php
}

$error = false; //error vullen zodat er geen error komt en op false zodat de onderste if niet uitgevoerd word.
if (isset($_POST["submit"]) && isset($_GET["id"])) { //controleren of de benodigde waardes bestaan.
	if (!empty($_GET["id"])) { //controleren of evenementid niet leeg is
			$studentenid = $_SESSION['studentid']; //student ophalen uit de sessie

			$evenementid = mysql_real_escape_string($_GET["id"]); //evenementid in een variabele zetten en escapen
			$today = date("Y-m-d"); //datum van vandaag
			//oke, dus we hebben de gegevens die wij nodig hebben opgehaald, nu moeten we de query schrijven om iets in de database te gooien.
			//wil je dit doen;D? Ja, maar k maak wel gebruik van de presentatie :$ Ken t nog niet zo ksgoed.. isgoed;d
			$query1 = "INSERT INTO aanmelding (studentId, evenementId, aanmeldingsdatum) 
			VALUES(".$studentenid." , ".$evenementid.", '".$today."')";

			if (mysql_query($query1)) { //als de query succesvol is dan:
				header("location:evenement.php?id=".$evenementid); //stuur de student door naar de evenement pagina zonder dat de gebruiker het merkt.
			} else {
				$error = true;
				$value = "Query is onjuist";
			}
	} else {
		$error = true;
		$value = "Er geen evenement id meegestuurd";
	}
} else {
	$error = true;
	$value = "Beide waardes bestaan niet";
}

if ($error) { //als er een error is dan weergeef de pagina met de error:
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
				<?php echo $value; ?>
				<form method="post" action="aanmeldenevenement2.php" > <!-- in action zet je wat er gedaan moet worden bij de 'submit' -->
					<input type="hidden" name ="evenementid" value = "<?php echo $_POST["evenementid"]; ?>"/>
	<!--				<select name ="studentenid">

						<?php
	//					database::getInstantie();
	//
	//					$sql = "SELECT * FROM student WHERE student.studentid NOT IN (SELECT studentid FROM aanmelding WHERE evenementid = ". mysql_real_escape_string($_POST["evenementid"]).")";
	//					$resultaat_van_server = mysql_query($sql);
	//
	//					while ($array = mysql_fetch_array($resultaat_van_server)) {
	//						echo "<option value=\"" . $array["studentid"] . "\">" . $array["voornaam"] . " " . $array["achternaam"] . "</option>";
	//					}
						?>

					</select>-->
			</div>
		</div>
		<?php echo $pagina->getFooter(); ?>
	</div>
	<?php
	echo $pagina->getVereisteHTMLafsluiting();
}