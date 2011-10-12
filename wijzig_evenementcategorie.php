<?php
/**
 * @author: Marissa van Essen
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
                        
                      
                       
                        $id = $_GET["id"];
                        
                        if(isset($_POST['wijzigen'])){
                    $naam1 = $_POST["naam"];
                    $sql = "UPDATE categorie SET `naam` ='".$naam1."' WHERE categorieid = " .$id."";
                    print("Het wijzigen is gelukt!<br>");
                    $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                        print("<a href=\"raadpleegevenementcategorieen.php\">Terug </a>");

                        } 
                        
                        $sql =  "SELECT * FROM `categorie` WHERE `categorieid`=$id";
                        $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                        $row = mysql_fetch_assoc($resultaat_van_server);
                        $id1 = $row["categorieid"];
                        $naam = $row["naam"];
                    
                        ?>
                        <form method="post" action="wijzig_evenementcategorie.php?id=<?php print($id);?>"> 
                        <table>
                            <th></th>
                            <th></th>
                            <tr>
                                <td> CategorieID:</td>
                                <td> <input type="text" name="categorieid" value="<?php print ($id1);?>" readonly/>     </td>      
                            </tr>
                            
                            <tr>
                                <td>
                                    
                                </td>
                            </tr>
                          
                            <tr>
                                <td>Naam:</td>
                                <td><input type="text" name="naam" value="<?php print ($naam);?>"/>            </td>
                            </tr>
                            
                        </table><br/>
                        <input type="submit" name="wijzigen" value="Wijzigen"/>
                        </form>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>



<?php

echo $pagina->getVereisteHTMLafsluiting();
?>