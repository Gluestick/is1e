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
                <?php
                database::getInstantie();
                $sql = "SELECT MAX(categorieid),naam FROM categorie";
                $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                $row = mysql_fetch_assoc($resultaat_van_server);

                $row["MAX(categorieid)"]++;
                $naam = $row ['naam'];





                if (isset($_POST['submit']) && !empty($_POST["naam"])) { //hier kijkt hij of beide waardes zijn "ingevuld"
                    $sql = "INSERT INTO `categorie` (`categorieid`,`naam`)  Values ('" . $row["MAX(categorieid)"] . "','" . $_POST['naam'] . "')";




                    $query = mysql_query($sql);
                    if ($query == false) {
                        print mysql_error();
                    } else { //als het toevoegen is gelukt print dit
                        print("Het toevoegen is gelukt!<br/>");
                        print("U wordt over 5 seconden doorverzonden naar de categorieënpagina</br>");
                        print("<a href=\"raadpleegevenementcategorieen.php\">Of klik hier om direct naar de categorieënpagina te gaan.</a><br/>");
                         ?> <script language="javascript">
                                setTimeout("location.href='./raadpleegevenementcategorieen.php'", 5000);
                            </script><?php
                    }
                } Elseif(empty($_POST['naam'])&& isset($_POST['submit'])) {
                    
                    print("Gelieve naam in vullen<br/>");
                }
                ?>
                Naam: <input type="text" name="naam"/><br>

                <input type="submit" name="submit" value="Toevoegen"/><br>
                 

                
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