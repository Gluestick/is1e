<?php
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
			<form method="GET" action="aanmeldenevenement2.php" > <!-- in action zet je wat er gedaan moet worden bij de 'submit' -->
				<select name ="studentenid">
					<?php
					database::getInstantie();

					$sql = "SELECT * FROM student";
					$resultaat_van_server = mysql_query($sql);

					while ($array = mysql_fetch_array($resultaat_van_server)) {
						echo "<option value=\"" . $array["studentId"] . "\">" . $array["voornaam"] . " " . $array["achternaam"] . "</option>";
					}
					?>

				</select>
				<br /><input type="submit" value="Aanmelden"/> <!-- knop -->
			</form>
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
