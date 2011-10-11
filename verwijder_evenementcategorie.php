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
                        
                        
        $id =$_GET["id"];         
        if(isset($_GET['verwijder'])){
                   
                    $sql = "DELETE FROM categorie WHERE categorieid=$id";
                    $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                    
                    print("Het verwijderen is gelukt!<br/>");
                    echo "<a href=\"beheercategorieevenementtoevoegen.php\">Terug </a>";
                }
       
        

                        
                       ?>
                        
                        
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