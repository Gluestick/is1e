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
                            
                            $naam = mysql_real_escape_string($_POST["naam"]);
                            $begindatum = mysql_real_escape_string($_POST["begindatum"]);
                            $einddatum = mysql_real_escape_string($_POST["einddatum"]);
                            $verplicht = mysql_real_escape_string($_POST["verplicht"]);
                            
				if (empty($naam)) {
					$error["naam"] = "Geen naam opgegeven";
				}
                                elseif(!preg_match("/^[a-zA-Z0-9äëïöüÄËÏÖÜáéíóúàèìòù'\s]+$/", $naam)){
                                    $error["naam"] = "Naam is ongeldig";
                                }
				if (empty($begindatum)) {   
				$error["begindatum"] = "Begindatum is leeggelaten";
				}
                                elseif(!preg_match("/^[0-9]{1,2}[-]{1}[0-9]{1,2}[-]{1}[0-9]{2,4}$/",$begindatum)){
                                    $error["begindatum"] = "Begindatum is ongeldig";
                                }
                                elseif(!tijd::checkCorrectieDatum($begindatum)){
                                    $error["begindatum"] = "Begindatum bestaat niet";
                                }
                                else{
                                    $datum1 = tijd::formatteerTijd($begindatum,"Y-m-d");	
                                }
                                
				if (!empty($einddatum) && preg_match("/^[0-9]{1,2}[-]{1}[0-9]{1,2}[-]{1}[0-9]{2,4}$/",$einddatum) && tijd::checkCorrectieDatum($einddatum)) {
                                        $datum2 = tijd::formatteerTijd($_POST["einddatum"],"Y-m-d");
				}
                                elseif(!empty($einddatum) && !preg_match("/^[0-9]{1,2}[-]{1}[0-9]{1,2}[-]{1}[0-9]{2,4}$/",$einddatum)){
                                        $error["einddatum"] = "Einddatum is ongeldig";
                                }
                                else{
                                        $error["einddatum"] = "Einddatum bestaat niet";
                                }
                                
                                if(tijd::formatteerTijd($begindatum, 'Y-m-d') < date('Y-m-d')){
                                    $error["begindatum"] = "Begindatum is in het verleden";
                                }
                                if(!empty($einddatum)){
                                if($einddatum < $begindatum){
                                    $error["einddatum"] = "Begindatum kan niet na de einddatum zijn";
                                  
                                }
                                }
                                if(empty($verplicht)){
                                    $error["verplicht"] = "Je moet kiezen";
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
                                               
        
            ?>
                        <form action="evenementtoevoegen.php" method="POST">
                            <table>
                                <tr>
                                    <th>*</th>
                                    <th>Naam</th>
                                    <td><input type="text" name="naam"/></td>
                                    <td><?php if(isset($error["naam"])){ print($error["naam"]);} ?></td>
                                </tr>
                                <tr>
                                    <th>*</th>
                                    <th>Begindatum</th>
                                    <td><input type="text" name="begindatum"/></td>
                                    <td><?php if(isset($error["begindatum"])){ print($error["begindatum"]);} ?></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Einddatum</th>
                                    <td><input type="text" name="einddatum"/></td>
                                    <td><?php if(isset($error["einddatum"])){ print($error["einddatum"]);} ?></td>
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
                                        <input type="text" hidden="hidden" value="<?php print($_SESSION['verenigingid']); ?>" name="organisator" />

                                    </td>
                                </tr>
                                <tr>
                                    <th>*</th>
                                    <th>Is aanmelding verplicht?</th>
                                    <td>Ja<input type="radio" name="verplicht" value="Ja"/>&nbsp;&nbsp;Nee<input type="radio" name="verplicht" value="Nee"/></td>
                                    <td><?php if(isset($error["verplicht"])){ print($error["verplicht"]);} ?></td>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th>Omschrijving</th>
                                    <td><textarea name="omschrijving"></textarea></td>
                                    <td><?php if(isset($error["omschrijving"])){ print($error["omschrijving"]);} ?></td>
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