<?php
/**
 * @author: Arjan Speiard
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
                        <?php database::getInstantie(); ?>
				<a href="wijzigen1.php">Wijzigen</a><br /><br />
	<form action="#">
		<table width="300px" border="1">
			<tr>
				<td>Naam:</td>
				<td>
                                    <?php
                                    $sql = "SELECT * FROM `evenement`;";
                                    $resultaat_van_server = mysql_query($sql);
                                    while($array = mysql_fetch_array($resultaat_van_server)) {
                                    echo $array["naam"]."<br />";
                                    }
                                    ?>
                                </td>
			</tr>
			
			<tr>
				<td>Begin:</td>
				<td>
                                    <?php
                                    $sql = "SELECT * FROM `evenement`;";
                                    $resultaat_van_server = mysql_query($sql);
                                    while($array = mysql_fetch_array($resultaat_van_server)) {
                                    echo $array["begindatum"]."<br />";
                                    }
                                    ?>    
                                </td>
			</tr>
			
			<tr>
				<td>Eind:</td>
				<td>
                                    <?php
                                    $sql = "SELECT * FROM `evenement`;";
                                    $resultaat_van_server = mysql_query($sql);
                                    while($array = mysql_fetch_array($resultaat_van_server)) {
                                    echo $array["einddatum"]."<br />";
                                    }
                                    ?> 
                                </td>
			</tr>
			
			<tr>
				<td>Categorie:</td>
				<td>
                                    <?php
                                    $sql = "SELECT * FROM `evenement`;";
                                    $resultaat_van_server = mysql_query($sql);
                                    while($array = mysql_fetch_array($resultaat_van_server)) {
                                    echo $array["categorieId"]."<br />";
                                    }
                                    ?>
                                </td>
			</tr>
			
			<tr>
				<td>Organisator:</td>
				<td>
                                                                        <?php
                                    $sql = "SELECT * FROM `evenement`;";
                                    $resultaat_van_server = mysql_query($sql);
                                    while($array = mysql_fetch_array($resultaat_van_server)) {
                                    echo $array["organiserendeVerenigingId"]."<br />";
                                    }
                                    ?>
                                </td>
			</tr>
			
			<tr>
				<td>Aanmelding verplicht?</td>
				<td>
                                                                        <?php
                                    $sql = "SELECT * FROM `evenement`;";
                                    $resultaat_van_server = mysql_query($sql);
                                    while($array = mysql_fetch_array($resultaat_van_server)) {
                                    echo $array["isAanmeldingVerplicht"]."<br />";
                                    }
                                    ?>
                                </td>
			</tr>
			
			<tr>
				<td>Omschrijving:</td>
				<td>
                                                                        <?php
                                    $sql = "SELECT * FROM `evenement`;";
                                    $resultaat_van_server = mysql_query($sql);
                                    while($array = mysql_fetch_array($resultaat_van_server)) {
                                    echo $array["omschrijving"]."<br />";
                                    }
                                    ?>
                                </td>
			</tr>
			
			<tr>
				<td></td>
				<td><input type="submit" href="#" value="Aanmelden!" /></td>
			</tr>
		</table>
            <table>
                <tr>
                    <td>.</td><td>.</td><td>.</td>
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