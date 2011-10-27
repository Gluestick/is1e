<?php
/**
 * @author: Marissa van Essen
 * @description: 
 */
if (!isAdmin()) {
	header("location:index.php");
}
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
                        
                      
                       
                        $id = mysql_real_escape_string ($_GET["id"]);
                        
                        if(isset($_POST['wijzigen'])){
                    $naam1 = mysql_real_escape_string ($_POST["naam"]);
                    $sql = "UPDATE categorie SET `naam` ='".$naam1."' WHERE categorieid = " .$id."";
                    print("Het wijzigen is gelukt!<br>");
                    print("U wordt over 5 seconden doorverzonden naar de vorige pagina <br>");
                    $resultaat_van_server = mysql_query($sql) or die(mysql_error());?>
                        <script language="javascript">
                                setTimeout("location.href='./raadpleegevenementcategorieen.php'", 5000);
                            </script> 
                        <?php
                        print("<a href=\"raadpleegevenementcategorieen.php\">Of klik hier om direct terug te gaan naar de vorige pagina </a>");

                        } 
                        
                        $sql =  "SELECT * FROM `categorie` WHERE `categorieid`=$id";
                        $resultaat_van_server = mysql_query($sql);
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
                                
                                <td> <center> <?php print ($id1);?></center>     </td>      
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