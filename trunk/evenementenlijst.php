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
                    $resultaat_van_server = mysql_query($sql);
                    while ($array = mysql_fetch_array($resultaat_van_server)) {
                        echo "<option value=\"".mysql_real_escape_string($array["verenigingid"])."\">" . mysql_real_escape_string($array["naam"]) . "</option>";
                    }
 
                    ?>

                </select>
                Categorie:<select name="categorie" style="width:100px;">
                    <option></option>
                    <?php
                    $sql = "SELECT DISTINCT `naam`, `categorieid` FROM `categorie`;";

                    $resultaat_van_server = mysql_query($sql);
                    while ($array = mysql_fetch_array($resultaat_van_server)) {
                        echo "<option value\"".mysql_real_escape_string($array["categorieid"])."\">".mysql_real_escape_string($array["naam"])."</option>";
                    }
                    ?>

                </select>
                <input type="submit" name="submit" value="Zoeken" />



                <?php
                if(isset($_POST['submit'])){
                   
               $naam = mysql_real_escape_string($_POST["naam"]);
               
               if(tijd::checkCorrectieDatum($_POST["begindatum"])){
               $begindatum = tijd::formatteerTijd(mysql_real_escape_string($_POST["begindatum"]), "Y-m-d");
               }
               else{
                   $begindatum = "";
                   $error["begindatum"] = "Ongeldige begindatum";
               }
               if(tijd::checkCorrectieDatum($_POST["einddatum"])){
               $einddatum = tijd::formatteerTijd(mysql_real_escape_string($_POST["einddatum"]),"Y-m-d");
               }
               else{
                   $array = mysql_fetch_row(mysql_query("SELECT MAX(einddatum) From evenement;"));
                   
                   foreach($array as $index => $waarde){
                   $einddatum = $waarde;
                   }
                   $error["einddatum"] = "Ongeldige einddatum";
               }
               $categorie = mysql_real_escape_string($_POST["categorie"]);
               $vereniging = mysql_real_escape_string($_POST["vereniging"]); 
                }
               if(isset($_POST['submit']) && !empty($naam) || !empty($begindatum) || !empty($einddatum) || !empty($categorie) || !empty($vereniging)){

    $sql = "SELECT evenement.naam AS evenementnaam,begindatum,einddatum,vereniging.verenigingid as id,omschrijving,vereniging.naam AS verenigingnaam, evenementid,evenement.categorieid AS evenementcategorie,categorie.categorieid AS categorieid1,isaanmeldingverplicht, categorie.naam AS categorienaam 
        FROM `evenement` JOIN vereniging ON organiserendeverenigingid = verenigingid
        JOIN categorie ON evenement.categorieid = categorie.categorieid
        Where evenement.naam LIKE '%" . $naam . "%' 
            AND `begindatum` >= '" . $begindatum . "' 
                AND `einddatum` <= '" .$einddatum. "'
                    AND categorie.naam LIKE '%".$categorie."%'
                    AND verenigingid LIKE '%".$vereniging."%'
                        ORDER BY evenement.evenementid ASC;";
    
	
        
   
    
    while ($array = mysql_fetch_array($resultaat_van_server)) {
        
        $id = mysql_real_escape_string($array['evenementid']);
        $id2= mysql_real_escape_string($array['id']);
            echo "<tr><td></td><td> <a href=\"evenement.php?id=$id\">" . mysql_real_escape_string($array["evenementnaam"]) . " </a></td><td>" .tijd::formatteerTijd(mysql_real_escape_string($array["begindatum"]),"d-m-Y") . "</td><td>".tijd::formatteerTijd(mysql_real_escape_string($array["einddatum"]),"d-m-Y") . "</td><td><a href=\"raadplegenvereniging.php?id=$id2\">".mysql_real_escape_string($array["verenigingnaam"])."</a></td><td>".mysql_real_escape_string($array["categorienaam"])."</td><td>" . mysql_real_escape_string($array["isaanmeldingverplicht"]) . "</td></tr>";
    }
               }
        
               else {
	$sql = "SELECT evenement.evenementid, evenement.naam AS evenementnaam,begindatum,einddatum,omschrijving,vereniging.verenigingid as id,vereniging.naam AS verenigingnaam, evenementid,evenement.categorieid AS evenementcategorie,categorie.categorieid AS categorieid1,isaanmeldingverplicht, categorie.naam AS categorienaam 
        FROM `evenement` JOIN vereniging ON organiserendeverenigingid = verenigingid
        JOIN categorie ON evenement.categorieid = categorie.categorieid
        ORDER BY evenement.evenementid ASC";

               }   
              
               
                   
               
?>
                    
    <?php
$resultaat_van_server = mysql_query($sql);
if(mysql_num_rows($resultaat_van_server)>0){
               ?>
                <?php   
                    if(!empty($_POST["begindatum"]) && isset($error['begindatum'])){
                        print($error['begindatum']."<br/>"); 
                    }
                    if(!empty($_POST["einddatum"]) && isset($error['einddatum'])){
                        print($error['einddatum']);
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
    }
while ($array = mysql_fetch_array($resultaat_van_server)) {
    $id2= mysql_real_escape_string($array['id']);
	$id = mysql_real_escape_string($array['evenementid']);
		echo "<tr><td> <a href=\"evenement.php?id=$id\">" . mysql_real_escape_string($array["evenementnaam"]) . " </a></td><td>" .tijd::formatteerTijd(mysql_real_escape_string($array["begindatum"]),"d-m-Y") . "</td><td>".tijd::formatteerTijd(mysql_real_escape_string($array["einddatum"]),"d-m-Y") . "</td><td><a href=\"raadplegenvereniging.php?id=$id2\">".mysql_real_escape_string($array["verenigingnaam"])."</a></td><td>".mysql_real_escape_string($array["categorienaam"])."</td><td>" . mysql_real_escape_string($array["isaanmeldingverplicht"]) . "</td></tr>";
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