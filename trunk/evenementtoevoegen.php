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
                        if (isset($_POST["submit"])) {
				if (empty($_POST["naam"]) || preg_match("/^[a-zA-Z0-9äëïöüÄËÏÖÜáéíóúàèìòù\s]+$/", $_POST["naam"]) != 1) {
					$error["naam"] = "Ongeldige naam";
				}
				if (empty($_POST["begindatum"]) || !preg_match("/^[0-9]{1,2}[-]{1}[0-9]{1,2}[-]{1}[0-9]{2,4}$/",$_POST["begindatum"])) {
				$error["begindatum"] = "Ongeldige begindatum";
				}
                                else{
                                    $datum1 = tijd::formatteerTijd($_POST["begindatum"],"Y-m-d");	
                                }
				if (!empty($_POST["einddatum"]) && !preg_match("/^[0-9]{1,2}[-]{1}[0-9]{1,2}[-]{1}[0-9]{2,4}$/",$_POST["einddatum"])) {
					$error["einddatum"] = "Ongeldige einddatum";
				}
                                elseif(!empty($_POST["einddatum"])){
                                    $datum2 = tijd::formatteerTijd($_POST["einddatum"],"Y-m-d");	
                                }
				if (!empty($_POST["omschrijving"]) && !preg_match("/^[a-zA-Z0-9äëïöüÄËÏÖÜáéíóúàèìòù\s]+$/",$_POST["omschrijving"])) {
                                        $error["omschrijving"] = "Ongeldige omschrijving";
				}
				if (!empty($_POST["naam"]) && isset($_POST["begindatum"]) && isset($_POST["einddatum"]) && isset($_POST["categorie"]) && isset($_POST["organisator"]) && isset($_POST["verplicht"]) && isset($_POST["omschrijving"])) {
                                    if($_POST['einddatum'] < $_POST['begindatum']){
                                       $error["velden"] = "Niet alle verplichte velden zijn ingevuld!";
                                    }
                                }
			}

                        if (isset($_POST["submit"]) && !isset($error)) {
	
                                    
                                        $id = mysql_fetch_array(mysql_query("SELECT MAX(evenementid) FROM evenement"));
                                        $id["MAX(evenementid)"]++;


                                        $sql = "INSERT INTO `evenement` (`evenementid`,`naam`,`begindatum`,`einddatum`,`omschrijving`, `isaanmeldingverplicht`,`categorieid`,`organiserendeverenigingid`) VALUES('" .mysql_real_escape_string($id["MAX(evenementid)"]) . "','".mysql_real_escape_string($_POST['naam'])."','".tijd::formatteerTijd(mysql_real_escape_string($_POST['begindatum']),"Y-m-d")."','".tijd::formatteerTijd(mysql_real_escape_string($_POST['einddatum']),"Y-m-d")."','".mysql_real_escape_string($_POST['omschrijving'])."','".mysql_real_escape_string($_POST['verplicht'])."','".mysql_real_escape_string($_POST['categorie'])."','".mysql_real_escape_string($_POST['organisator'])."')";
                                        $result = mysql_query($sql);
                                            if ($result == false) {
                                                    print"<h3>MySQL ERROR:</h3>".mysql_error();
                                            }
                                            else {

                                                    print"Het evenement is toegevoegd!</h3><br/>";
                                                    print("U wordt over 5 seconden doorgelinked naar de evenementenlijst<br/>");
                                                    print("<a href=\"evenementenlijst.php\">of klik hier om direct naar de evenementenlijst te gaan</a>");
                                                    ?><script language="javascript">
                                                    setTimeout("location.href='./evenementenlijst.php'", 5000);
                                                    </script>
                                            <?php

                                            }
			}
                                                else{
                                   if(isset($error)){
                                    foreach($error as $key => $val){
                                        print($val."<br/>");
                                    }
                            }

                        }
        
            ?>
                        <form action="evenementtoevoegen.php" method="POST">
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