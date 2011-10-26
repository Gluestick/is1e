<?php
/**
 * @author: Kay van Bree, Kajel Bhikhoe
 * @description: 
 */
if (!isStudent()) {
	header("location:index.php");
}
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
			<form method="post" action="aanmeldenevenement2.php" > <!-- in action zet je wat er gedaan moet worden bij de 'submit' -->
				<input type="hidden" name ="evenementid" value = "<?php echo $_POST["evenementid"]; ?>"/>
				<select name ="studentenid">
					
					<?php
					database::getInstantie();

					$sql = "SELECT * FROM student WHERE student.studentid NOT IN (SELECT studentid FROM aanmelding WHERE evenementid = ". mysql_real_escape_string($_POST["evenementid"]).")";
					$resultaat_van_server = mysql_query($sql);

					while ($array = mysql_fetch_array($resultaat_van_server)) {
						echo "<option value=\"" . $array["studentid"] . "\">" . $array["voornaam"] . " " . $array["achternaam"] . "</option>";
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
