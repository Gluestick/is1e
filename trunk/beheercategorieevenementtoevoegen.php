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
			
                         <form action="" method="post">
                               
                            <input type="text" name="naam" />
                            <input type="submit" name="submit" value="Zoeken" /> 
                           
                        
                        <?php
                            
                            if(isset($_POST["naam"])){ ?>
                               <table>     
                                <tr>                   
                              <th alight="left" width="" height="50">  <br /></th>
                              <th align="left" width="150" height="50">Naam</th>                                                                                        
                              <th align="left" width="100" height="50">CategorieID</th> 
                              <th align="left" width="150" height="50">         </th>
                                </tr>
                          <?php  }
                            
                                
                            ?>  
                            
                                
                             
                                
                                
                                
                            <?php                          
                             database::getInstantie();
                             
                           
                             
                              if(!isset($_POST["naam"])){
                                
                            }
                            else{
                            $sql = "SELECT * FROM `categorie` WHERE `naam` LIKE '%".$_POST["naam"]."%' ORDER BY `categorieid` ;";                                
                            $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                             print("<br><a href=\"toevoeg_evenementcategorie.php\">Toevoegen</a> "); 
                            while ($array = mysql_fetch_array($resultaat_van_server)) {
                               
                                  echo "<tr><td> </td><td> <a href= \"#\">".$array["naam"]." </a></td> <td>".$array["categorieid"]."</td><td><a href= \"wijzig_evenementcategorie.php?id=".$array["categorieid"]."\">  Wijzig<a href=\"verwijder_evenementcategorie.php?id=" .$array ["categorieid"] . "&verwijder=true\"> Verwijder</tr>";   
                                  
                            }
          
                            }
                                                       

                            ?>            
                                
                                
                                
                                
                            </table>
                        </form>  
                        
                        <br/>
                        
                            
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>



<?php
echo $pagina->getVereisteHTMLafsluiting();

?>