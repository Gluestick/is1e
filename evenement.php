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
            $id = mysql_real_escape_string($_GET['id']);
            if(isVereniging() || isAdmin()){
            print("<a href=\"wijzigevenement.php?id=$id\">Wijzigen</a><br /><br />");
            }
            $id = $_GET['id'];
            $sql = "SELECT evenement.evenementid, evenement.naam AS evenementnaam,begindatum,einddatum,categorie.naam AS categorienaam,vereniging.naam AS verenigingnaam,isaanmeldingverplicht,omschrijving, vereniging.verenigingid as id FROM `evenement` JOIN `categorie` ON evenement.categorieid = categorie.categorieid JOIN `vereniging` ON `organiserendeverenigingid` = `verenigingid` WHERE evenementid=$id;";
            $resultaat_van_server = mysql_query($sql) or die(mysql_error());
            while ($array = mysql_fetch_array($resultaat_van_server)) {
                $naam = $array['evenementnaam'];
                $begin = $array['begindatum'];
                $eind = $array['einddatum'];
                $categorie = $array['categorienaam'];
                $organisator = $array['verenigingnaam'];
                $aanmelding = $array['isaanmeldingverplicht'];
                $omschrijving = $array['omschrijving'];
                $id= $_GET['id'];
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
                            <td><?php 
                            $id1= $array['id'];
                            print("<a href=\"raadplegenvereniging.php?id=$id1\">".$organisator."</a>"); ?></td>
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
                            <td><?php if(tijd::formatteerTijd($begin, "d-m-Y") >= date("d-m-Y")){?>
                                
                                <input type="hidden" name ="evenementid" value = "<?php echo $array["evenementid"]; ?>"/>
								<?php if (isStudent() && mysql_num_rows(mysql_query("SELECT * FROM aanmelding WHERE studentid = {$_SESSION["studentid"]} AND evenementid = {$_GET["id"]}")) == 0) { ?><input type="submit" name="aanmelden" value="Aanmelden" /><?php } 
	elseif (isStudent() && mysql_num_rows(mysql_query("SELECT * FROM aanmelding WHERE studentid = {$_SESSION["studentid"]} AND evenementid = {$_GET["id"]}")) >= 1) { ?><input type="submit" name="afmelden" value="Afmelden" /><?php }} ?>
                        </tr>
                    </table>
                </form>


                <form action="#" method="POST"> 
                   <?php 
                   $sql = "SELECT afzender, tijdstip, inhoud FROM reactie WHERE evenementid=$id;";
                    $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                    if(mysql_num_rows($resultaat_van_server) > 0){
                   ?>
                    <table border="1">
                        <tr>
                            <th>Door</th>
                            <th>Datum</th>
                            <th>Tekst</th>
                        </tr>
                   
                        <?php
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
                            <td><?php print(tijd::formatteerTijd($datum, "d-m-Y")); ?></td>
                            <td><?php print(nl2br(specialetekens::vervangTekensInTekst($inhoud))); ?></td>
                        </tr>

                        <?php
                    }
                    ?>
                </table>
                    <?php } ?>
            </form>
              <?php 
              print("<a href=\"evenementreactie.php?id=$id\">Voeg een reactie toe!</a>");
            }
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