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
                        <?php 
                        database::getInstantie();
                        
                    if(isset($_GET['submit'])){
                        $id = mysql_fetch_array(mysql_query("SELECT MAX(evenementid) FROM evenement"));
                        $id["MAX(evenementid)"]++;
                        
                        
                        $sql = "INSERT INTO `evenement` (`evenementid`,`naam`,`begindatum`,`einddatum`,`omschrijving`, `isaanmeldingverplicht`,`categorieid`,`organiserendeverenigingid`) VALUES('" . $id["MAX(evenementid)"] . "','".$_GET['naam']."','".$_GET['begindatum']."','".$_GET['einddatum']."','".$_GET['omschrijving']."','".$_GET['verplicht']."','".$_GET['categorie']."','".$_GET['organisator']."')";
                            
                        
                            $query = mysql_query($sql);

                            if ($query == false) {
                                print mysql_error();
                            }
                            print("Het evenement is toegevoegd!<br/>");
                            print("<a href=\"evenementenlijst.php\">Klik hier om terug te gaan naar de evenementen</a>");
                            
                    }  
                        if(!isset($_GET['submit'])){ ?>
                        <form action="" method="GET">
                            <table>
                                <tr>
                                    <th>Naam</th>
                                    <td><input type="text" name="naam"/></td>
                                </tr>
                                <tr>
                                    <th>Begindatum</th>
                                    <td><input type="text" name="begindatum"/></td>
                                </tr>
                                <tr>
                                    <th>Einddatum</th>
                                    <td><input type="text" name="einddatum"/></td>
                                </tr>
                                <tr><?php
                                $sql = "SELECT `naam`,`categorieid` FROM `categorie` ORDER BY `naam` ASC;";
                                $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                                    ?>
                                    <th>Categorie</th>
                                    <td>
                                        <select name="categorie">
                                            <?php 
                                            while ($array = mysql_fetch_array($resultaat_van_server)) {
                                            echo "<option value=\"".$array["categorieid"]."\">" . $array["naam"] . "<br/></option>";
                                            }?>
                                            
                                        </select>
                                    </td>
                                </tr>
                                <tr><?php
                                $sql = "SELECT `naam`,`verenigingid` FROM `vereniging` ORDER BY `naam` ASC;";
                                $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                                    ?>
                                    <th>Organisator</th>
                                    <td>
                                        <select name="organisator">
                                            <?php 
                                            while ($array = mysql_fetch_array($resultaat_van_server)) {
                                            echo "<option value=\"".$array["verenigingid"]."\">" . $array["naam"] . "<br/></option>";
                                            }?>
                                            
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Is aanmelding verplicht?</th>
                                    <td><input type="checkbox" name="verplicht" value="Ja"/></td>
                                </tr>
                                <tr>
                                    <th>Omschrijving</th>
                                    <td><textarea name="omschrijving"></textarea></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><input type="submit" name="submit" value="Toevoegen" /></td>
                                </tr>
                            </table>
                        </form>
                        <?php }

?>
                            
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