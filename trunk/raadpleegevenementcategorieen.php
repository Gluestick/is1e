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
			
                        <form action="raadpleegevenementcategorieen.php" method="POST">
                               
                            <input type="text" name="naam" />
                            <input type="submit" name="submit" value="Zoeken" />
                           
                              
                            <?php
                            
                            if(!isset($_POST["naam"])){
                                
                            }
                            else{
                            ?>
                            <table>     
                                <tr>
                          
                                
                                    
                              <th align="left" width="150" height="50">Naam</th>
                              
                              
                              
                              <th>CategorieID</th> 
                                </tr>
                            <?php }?>    
                            <?php
                          
                             database::getInstantie();
                            
                              if(!isset($_POST["naam"])){
                                
                            }
                            else{
                            $sql = "SELECT * FROM `Categorie` WHERE `naam` LIKE '%".$_POST["naam"]."%' ORDER BY `categorieId` ;";
                                
                            $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                            while ($array = mysql_fetch_array($resultaat_van_server)) {
                                  echo "<tr><td> <a href= \"#\">".$array["naam"]." </a></td> <td>".$array["categorieid"]."</td></tr>";     
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
