<?php
/**
 * @author: Arjan Speiard
 * @description: 
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Toevoegen evenement");
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
                 if(isset($_POST['submit'])){       
                    if(isset($_POST['naam']) && isset($_POST['begindatum']) && isset($_POST['einddatum']) && isset($_POST['categorie']) && isset($_POST['organisator']) && isset($_POST['verplicht']) && isset($_POST['omschrijving'])){
                        $id = mysql_fetch_array(mysql_query("SELECT MAX(evenementid) FROM evenement"));
                        $id["MAX(evenementid)"]++;
                        
                        
                        $sql = "INSERT INTO `evenement` (`evenementid`,`naam`,`begindatum`,`einddatum`,`omschrijving`, `isaanmeldingverplicht`,`categorieid`,`organiserendeverenigingid`) VALUES('" . $id["MAX(evenementid)"] . "','".$_POST['naam']."','".tijd::formatteerTijd($_POST['begindatum'],"Y-m-d")."','".tijd::formatteerTijd($_POST['einddatum'],"Y-m-d")."','".$_POST['omschrijving']."','".$_POST['verplicht']."','".$_POST['categorie']."','".$_POST['organisator']."')";
                            
                        
                            $query = mysql_query($sql);

                            if ($query == false) {
                                print mysql_error();
                            }
                            print("Het evenement is toegevoegd!<br/>");
                            print("<a href=\"evenementenlijst.php\">Klik hier om terug te gaan naar de evenementen</a>");
                            
                    }
                    
                    Else {
                        print("U bent enkele velden vergeten in te vullen<br/>");
                        print("<a href=\"evenementtoevoegen.php\">Ga hier terug naar het formulier</a>");
                    }}
                        if(!isset($_POST['submit'])){ ?>
                        <form action="" method="POST">
                            <table>
                                <tr>
                                    <th>*</th>
                                    <th>Naam</th>
                                    <td><input type="text" name="naam"/></td>
                                </tr>
                                <tr>
                                    <th>*</th>
                                    <th>Begindatum</th>
                                    <td><input type="text" name="begindatum"/></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Einddatum</th>
                                    <td><input type="text" name="einddatum"/></td>
                                </tr>
                                <tr><?php
                                $sql = "SELECT `naam`,`categorieid` FROM `categorie` ORDER BY `naam` ASC;";
                                $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                                    ?>
                                    <th>*</th>
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
                                    <th>*</th>
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
                                    <th>*</th>
                                    <th>Is aanmelding verplicht?</th>
                                    <td>Ja<input type="radio" name="verplicht" value="Ja"/>&nbsp;&nbsp;Nee<input type="radio" name="verplicht" value="Nee"/></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Omschrijving</th>
                                    <td><textarea name="omschrijving"></textarea></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td><input type="submit" name="submit" value="Toevoegen" /></td>
                                </tr>
                            </table>
                            <p>Velden met "*" zijn verplicht.</p>
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