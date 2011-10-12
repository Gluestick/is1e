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
                        <?php
                        database::getInstantie();
                         $sql = "SELECT MAX(categorieid),naam FROM categorie";
                $resultaat_van_server=mysql_query($sql) or die(mysql_error());
                $row = mysql_fetch_assoc($resultaat_van_server);
                
                $row["MAX(categorieid)"]++;
                 $naam= $row ['naam'];
                  
                if (isset($_POST['naam'])){
                    $sql = "INSERT INTO `categorie` (`categorieid`,`naam`)  Values ('". $row["MAX(categorieid)"] ."','". $_POST['naam'] ."')";
                    print("Het toevoegen is gelukt!<br/>");
                    
                    $query = mysql_query($sql);
                    if ($query == false){
                        print mysql_error();
                        
                    }
                     
                           
                             
                            while ($array = mysql_fetch_array($resultaat_van_server)) {
                                print ("<tr><td>" .$naam. "</td></tr>");
                                
                             
                            }
                            }
                        
                        ?>
                       Naam: <input type="text" name="naam"/><br>
                      
                        <input type="submit" name="submit" value="Toevoegen"/><br>
                        <a href="beheercategorieevenementtoevoegen.php">Terug naar vorige pagina</a>
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