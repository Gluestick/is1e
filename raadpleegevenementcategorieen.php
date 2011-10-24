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
			
                         <form action="" method="post">
                               
                            <input type="text" name="naam" />
                            <input type="submit" name="submit" value="Zoeken" /> 
                           
                        
                      
                               <table>     
                                <tr>                   
                              <th alight="left" width="" height="50">  <br /></th>
                              <th align="left" width="150" height="50">Naam</th>                                                                                        
                              <th align="left" width="100" height="50">CategorieID</th> 
                              <th align="left" width="150" height="50">         </th>
                                </tr>
                          
                            
                     
                                
                                
                                
                            <?php                          
                             database::getInstantie();
                             
                           
                            if(!isset($_POST["naam"])){
                                $_POST["naam"] = "";
                            }
                            
                            $sql = "SELECT DISTINCT categorie.categorieid,categorie.naam AS categorienaam,evenement.evenementid AS evenementid FROM `categorie` JOIN evenement ON categorie.categorieid = evenement.categorieid WHERE categorie.naam LIKE '%".$_POST["naam"]."%' ORDER BY `categorieid` ;";                                
                            var_dump($sql);
							$resultaat_van_server = mysql_query($sql) or die(mysql_error());
                            
                            while ($array = mysql_fetch_array($resultaat_van_server)) {
                               $id = $array['evenementid'];
							   var_dump($array);
                                  echo "<tr><td> </td><td> <a href=\"evenement.php?id=$id\">".$array["categorienaam"]." </a></td> <td>".$array["categorieid"]."</td><td><a href= \"wijzig_evenementcategorie.php?id=".$array["categorieid"]."\">  Wijzig<a href=\"verwijder_evenementcategorie.php?id=" .$array ["categorieid"] . "&verwijder=true\"> Verwijder</tr>";   
                                  
                            
      
                            }
                                                       

                            ?>            
                                
                                
                                
                                
                            </table>
                            
                            <?php
                                 print("<br><a href=\"toevoeg_evenementcategorie.php\">Toevoegen</a> "); 
                            ?>
                            
                        </form>  
                        
                        <br/>
                        
                            
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>



<?php
echo $pagina->getVereisteHTMLafsluiting();

?>