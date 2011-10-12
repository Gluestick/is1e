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

            <form action="evenementenlijst.php" method="POST">

                Naam:<input type="text" name="naam" />
                Datum:<input type="text" name="begindatum" />
                Tot:<input type="text" name="einddatum" />
                <?php
                database::getInstantie();
                ?>
                Vereniging:<select name="vereniging">
                    <option></option>
                    <?php
                    $sql = "SELECT `verenigingid`,`naam` FROM `vereniging`;";
                    $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                    while ($array = mysql_fetch_array($resultaat_van_server)) {
                        echo "<option value=\"".$array["verenigingid"]."\">" . $array["naam"] . "<br/></option>";
                    }
 
                    ?>

                </select>
                Categorie:<select name="categorie">
<option></option>
                    <?php
                    $sql = "SELECT DISTINCT `naam`, `categorieid` FROM `categorie`;";

                    $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                    while ($array = mysql_fetch_array($resultaat_van_server)) {
                        echo "<option value\"".$array["categorieid"]."\">".$array["naam"]."<br/></option>";
                    }
                    ?>

                </select>
                <input type="submit" name="submit" value="Zoeken" />



                <?php
                if (isset($_POST["naam"])) {
                    ?>
                    <table>     
                        <tr>

                            <th align="left" width="150" height="50"></th>  

                            <th align="left" width="150" height="50">Naam</th>



                            <th align="left" width="150" height="50">Begin</th> 
                            <th align="left" width="150" height="50">Eind</th>
                            <th align="left" width="150" height="50">Vereniging</th>
                            <th align="left" width="150" height="50">Categorie</th>
                            <th align="left" width="150" height="50">Aanmelden</th>
                        </tr>
    <?php
    
    
    $sql = "SELECT evenement.naam AS evenementnaam,begindatum,einddatum,omschrijving,vereniging.naam AS verenigingnaam, evenementid,evenement.categorieid AS evenementcategorie,categorie.categorieid AS categorieid1,isaanmeldingverplicht, categorie.naam AS categorienaam 
        FROM `evenement` JOIN vereniging ON organiserendeverenigingid = verenigingid
        JOIN categorie ON evenement.categorieid = categorie.categorieid
        Where evenement.naam LIKE '%" . $_POST["naam"] . "%' 
            AND `begindatum` LIKE '%" . $_POST["begindatum"] . "%' 
                AND `einddatum`LIKE '%" . $_POST["einddatum"] . "%'
                    AND categorie.naam LIKE '%".$_POST["categorie"]."%'
                    AND verenigingid LIKE '%".$_POST["vereniging"]."%'
                        ;";
    $resultaat_van_server = mysql_query($sql) or die(mysql_error());
    print $_POST["categorie"];

    while ($array = mysql_fetch_array($resultaat_van_server)) {
        $id = $array['evenementid'];
            echo "<br/><tr><td></td><td> <a href=\"evenement.php?id=$id\">" . $array["evenementnaam"] . " </a></td><td>" .tijd::formatteerTijd($array["begindatum"],"d-m-Y") . "</td><td>".tijd::formatteerTijd($array["einddatum"],"d-m-Y") . "</td><td>".$array["verenigingnaam"]."</td><td>".$array["categorienaam"]."</td><td>" . $array["isaanmeldingverplicht"] . "</td></tr>";
        
    }
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