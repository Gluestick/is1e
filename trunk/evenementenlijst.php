<?php
/**
 * @author: Arjan Speiard
 * @description: 
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("Evenementen");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
    <?php echo $pagina->getHeader(); ?>
    <div id="page">
        <?php echo $pagina->getMenu(); ?>
        <div id="content">
           <h1><?php echo $pagina->getTitel(); ?></h1>

            <form action="evenementenlijst.php" method="POST">

                Naam:<input type="text" name="naam" style="width:120px;" />
                Datum:<input type="text" name="begindatum" style="width:90px;" maxlength="10" />
                Tot:<input type="text" name="einddatum" style="width:90px;" maxlength="10" />
                <?php
                database::getInstantie();
                ?>
                Vereniging:<select name="vereniging" style="width:100px;">
                    <option></option>
                    <?php
                    $sql = "SELECT `verenigingid`,`naam` FROM `vereniging`;";
                    $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                    while ($array = mysql_fetch_array($resultaat_van_server)) {
                        echo "<option value=\"".mysql_real_escape_string($array["verenigingid"])."\">" . mysql_real_escape_string($array["naam"]) . "</option>";
                    }
 
                    ?>

                </select>
                Categorie:<select name="categorie" style="width:100px;">
                    <option></option>
                    <?php
                    $sql = "SELECT DISTINCT `naam`, `categorieid` FROM `categorie`;";

                    $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                    while ($array = mysql_fetch_array($resultaat_van_server)) {
                        echo "<option value\"".mysql_real_escape_string($array["categorieid"])."\">".mysql_real_escape_string($array["naam"])."</option>";
                    }
                    ?>

                </select>
                <input type="submit" name="submit" value="Zoeken" />



                <?php
               
               
               if(isset($_POST['submit'])){
               
   $sql = "SELECT evenement.naam AS evenementnaam,begindatum,einddatum,omschrijving,vereniging.naam AS verenigingnaam, evenementid,evenement.categorieid AS evenementcategorie,categorie.categorieid AS categorieid1,isaanmeldingverplicht, categorie.naam AS categorienaam 
        FROM `evenement` JOIN vereniging ON organiserendeverenigingid = verenigingid
        JOIN categorie ON evenement.categorieid = categorie.categorieid
        Where evenement.naam LIKE '%" . mysql_real_escape_string($_POST["naam"]) . "%' 
            AND `begindatum` LIKE '%" . mysql_real_escape_string($_POST["begindatum"]) . "%' 
                AND `einddatum`LIKE '%" . mysql_real_escape_string($_POST["einddatum"]). "%'
                    AND categorie.naam LIKE '%".mysql_real_escape_string($_POST["categorie"])."%'
                    AND verenigingid LIKE '%".mysql_real_escape_string($_POST["vereniging"])."%'
                        ;";
    
               
        
    while ($array = mysql_fetch_array($resultaat_van_server)) {
        $id = mysql_real_escape_string($array['evenementid']);
            echo "<tr><td></td><td> <a href=\"evenement.php?id=$id\">" . mysql_real_escape_string($array["evenementnaam"]) . " </a></td><td>" .tijd::formatteerTijd(mysql_real_escape_string($array["begindatum"]),"d-m-Y") . "</td><td>".tijd::formatteerTijd(mysql_real_escape_string($array["einddatum"]),"d-m-Y") . "</td><td>".mysql_real_escape_string($array["verenigingnaam"])."</td><td>".mysql_real_escape_string($array["categorienaam"])."</td><td>" . mysql_real_escape_string($array["isaanmeldingverplicht"]) . "</td></tr>";
    }
               }
        
               else {
	$sql = "SELECT evenement.evenementid, evenement.naam AS evenementnaam,begindatum,einddatum,omschrijving,vereniging.naam AS verenigingnaam, evenementid,evenement.categorieid AS evenementcategorie,categorie.categorieid AS categorieid1,isaanmeldingverplicht, categorie.naam AS categorienaam 
        FROM `evenement` JOIN vereniging ON organiserendeverenigingid = verenigingid
        JOIN categorie ON evenement.categorieid = categorie.categorieid
        ORDER BY evenement.evenementid ASC";

               }     
?>
                    <table>     
                        <tr> 
                            <th align="left" width="150" height="50">Naam</th>
                            <th align="left" width="150" height="50">Begin</th> 
                            <th align="left" width="150" height="50">Eind</th>
                            <th align="left" width="150" height="50">Vereniging</th>
                          <th align="left" width="150" height="50">Categorie</th>
                            <th align="left" width="150" height="50">Aanmelden</th>
                        </tr>
    <?php
$resultaat_van_server = mysql_query($sql) or die(mysql_error());
while ($array = mysql_fetch_array($resultaat_van_server)) {
	$id = mysql_real_escape_string($array['evenementid']);
		echo "<tr><td> <a href=\"evenement.php?id=$id\">" . mysql_real_escape_string($array["evenementnaam"]) . " </a></td><td>" .tijd::formatteerTijd(mysql_real_escape_string($array["begindatum"]),"d-m-Y") . "</td><td>".tijd::formatteerTijd(mysql_real_escape_string($array["einddatum"]),"d-m-Y") . "</td><td>".mysql_real_escape_string($array["verenigingnaam"])."</td><td>".mysql_real_escape_string($array["categorienaam"])."</td><td>" . mysql_real_escape_string($array["isaanmeldingverplicht"]) . "</td></tr>";
}
                
                              
?>

                </table> 




            </form>

        </div>
    </div>
<?php echo $pagina->getFooter(); ?>
</div>



    <?php
    echo $pagina->getVereisteHTMLafsluiting();
    ?>