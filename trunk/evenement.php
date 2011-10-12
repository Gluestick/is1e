<?php
/**
 * @author: Arjan Speiard
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();
$id=$_GET['id'];
$sql = "SELECT evenement.naam From evenement where evenementid=".$id."";
$resultaat_van_server = mysql_query($sql);
$array = mysql_fetch_array($resultaat_van_server);
$evenement = $array["naam"];
$pagina->setTitel($evenement);
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
            $id = $_GET['id'];
            print("<a href=\"wijzigevenement.php?id=$id\">Wijzigen</a><br /><br />");
            
            $id = $_GET['id'];
            $sql = "SELECT evenement.naam AS evenementnaam,begindatum,einddatum,categorie.naam AS categorienaam,vereniging.naam AS verenigingnaam,isaanmeldingverplicht,omschrijving FROM `evenement` JOIN `categorie` ON evenement.categorieid = categorie.categorieid JOIN `vereniging` ON `organiserendeverenigingid` = `verenigingid` WHERE evenementid=$id;";
            $resultaat_van_server = mysql_query($sql) or die(mysql_error());
            while ($array = mysql_fetch_array($resultaat_van_server)) {

                $naam = $array['evenementnaam'];
                $begin = $array['begindatum'];
                $eind = $array['einddatum'];
                $categorie = $array['categorienaam'];
                $organisator = $array['verenigingnaam'];
                $aanmelding = $array['isaanmeldingverplicht'];
                $omschrijving = $array['omschrijving'];
                $id=$_GET['id'];
                print("<form action=\"aanmeldenevenement.php?id=$id\" method=\"POST\">");
                ?>
                    <table>
                        <tr>
                            <td>Naam</td>
                            <td><?php print($naam); ?></td>
                        </tr>
                        <tr>
                            <td>Begindatum</td>
                            <td><?php print(tijd::formatteerTijd($begin, "d-m-Y")); ?></td>
                        </tr>
                        <tr>
                            <td>Einddatum</td>
                            <td><?php print(tijd::formatteerTijd($eind, "d-m-Y")); ?></td>
                        </tr>
                        <tr>
                            <td>Categorie</td>
                            <td><?php print($categorie); ?></td>
                        </tr>
                        <tr>
                            <td>Organisator</td>
                            <td><?php print($organisator); ?></td>
                        </tr>
                        <tr>
                            <td>Aanmelding verplicht?</td>
                            <td><?php print($aanmelding); ?></td>
                        </tr>
                        <tr>
                            <td>Omschrijving</td>
                            <td><?php print($omschrijving); ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" name="submit" value="Aanmelden!"/></td>
                        </tr>
                    </table>
                </form>


                <form action="#" method="POST"> 
                    <table border="1">
                        <tr>
                            <th>Door</th>
                            <th>Datum</th>
                            <th>Tekst</th>
                        </tr>
                        <?php
                    }
                    $id = $_GET['id'];
                    $sql = "SELECT afzender, tijdstip, inhoud FROM reactie WHERE evenementid=$id;";
                    $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                    while ($array = mysql_fetch_array($resultaat_van_server)) {

                        $naam = $array['afzender'];
                        $datum = $array['tijdstip'];
                        $inhoud = $array['inhoud'];
                        ?>


                        <tr>
                            <td><?php print($naam); ?></td>
                            <td><?php print($datum); ?></td>
                            <td><?php print($inhoud); ?></td>
                        </tr>

                        <?php
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

//	database::getInstantie();
//
//	$sql = "SELECT * FROM `student`;";
//	$resultaat_van_server = mysql_query($sql);
//	while($array = mysql_fetch_array($resultaat_van_server)) {
//		echo $array["voornaam"]."<br />";
//	}
?>