<?php
/**
 * @author: Daniel
 * @description: 
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Plaatsen bericht");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel();
			database::getInstantie();?></h1>
		<?php
		$studentid = $_GET["id"];
		if (isset($_POST["verstuur"])
				&&($_POST["onderwerp"])
				&& ($_POST["bericht"])) 
			{

			$bericht = mysql_real_escape_string($_POST["bericht"]);
			$onderwerp = mysql_real_escape_string($_POST["onderwerp"]);
			// $sql= "INSERT INTO  profielbericht VALUES $datum,$onderwerp,$inhoud;";


			
			$sql = "INSERT INTO  profielbericht (datum, onderwerp, inhoud, studentid) VALUES ('" . date("Y-m-d") . "','" . $onderwerp . "','" . $bericht . "', " . $studentid . ")";

			if (mysql_query($sql)) {
				echo"bericht toegevoegd";
			}
			else {
					die (mysql_error());
			}
			}
		?>

		<form action="plaatsenprofielbericht.php?id=<?php echo $studentid; ?>" method="POST">
			<table>
				<tr>
					<td>datum: </td> <td><input name="datum" disabled="disabled" type="text" value="<?php /* $b=time(); */ echo date("d/m/Y"); ?>" />  </td>  
				</tr>
				<tr>
					<td>onderwerp: </td> <td> <input name="onderwerp" type="text"/>  </td> 
				</tr>
				<tr>
					<td>bericht: </td> <td> <textarea name="bericht"   >  </textarea> </td>

				</tr>
				<tr>
					<td> <input type="submit" value="verzenden" name="verstuur"/>   </td><td> <input type="reset" value="wis alles"/> </td>

					<td><a href="raadplegenprofielb.php?id=<?php echo $studentid; ?>"> terug </a></td>
				</tr>
			</table>
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