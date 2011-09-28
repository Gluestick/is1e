<?php
/**
 * @author: Kay van Bree
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
 
			<form action="evenementenlijst.php" method="POST">
                               
                            Naam:<input type="text" name="naam" />
                            Datum:<input type="text" name="begindatum" />
                            Tot:<input type="text" name="einddatum" />
							<?php
							database::getInstantie();
							?>
                            Vereniging:<Select>
											
											<?php
											$sql = "SELECT `naam` FROM `Vereniging`;";
                                
                            $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                            while ($array = mysql_fetch_array($resultaat_van_server)) {
								echo "<option>".$array["naam"]."<br/></option>";
							}
											?>
										
										</select>
                            Categorie:<Select>
											
											<?php
											$sql = "SELECT DISTINCT `naam` FROM `Categorie`;";
                                
                            $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                            while ($array = mysql_fetch_array($resultaat_van_server)) {
								echo "<option>".$array["naam"]."<br/></option>";
							}
											?>
										
										</select>
                            <input type="submit" name="submit" value="Zoeken" />
                           
                              

                            <?php

                            
                              if(!isset($_POST["naam"])){
                                
                            }
                            else{
							?>
							<table>     
                               <tr>
                          
                              <th align="left" width="150" height="50"></th>  
                                    
                              <th align="left" width="150" height="50">Naam</th>
                              
                              
                              
                              <th align="left" width="150" height="50">Begin</th> 
							  <th align="left" width="150" height="50">Eind</th>
							  <th align="left" width="150" height="50">Vereniging</th>
							  <th align="left" width="150" height="50">Categorie</th>
							  <th align="left" width="150" height="50">Aanmelden</th>
							  </tr>
							  <?php
                            $sql = "SELECT `naam`,`begindatum`,`einddatum`,`isAanmeldingVerplicht` FROM `Evenement` Where `naam` LIKE '%".$_POST["naam"]."%' AND `begindatum` LIKE '%".$_POST["begindatum"]."%' AND `einddatum`LIKE '%".$_POST["einddatum"]."%';";   
                            $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                            while ($array = mysql_fetch_array($resultaat_van_server)) {
                                  echo "<br/><tr><td></td><td> <a href= \"#\">".$array["naam"]." </a></td><td>".$array["begindatum"]."</td><td>".$array["einddatum"]."</td><td>.</td><td>.</td><td>".$array["isAanmeldingVerplicht"]."</td></tr>";     
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

//	database::getInstantie();
//
//	$sql = "SELECT * FROM `student`;";
//	$resultaat_van_server = mysql_query($sql);
//	while($array = mysql_fetch_array($resultaat_van_server)) {
//		echo $array["voornaam"]."<br />";
//	}
?>