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
            $sql = "SELECT evenement.evenementid, categorie.categorieid from evenement left OUTER join categorie on categorie.categorieid = evenement.categorieid WHERE categorie.categorieid = ".mysql_real_escape_string($_GET["id"])."";
            $resultaat_van_server = mysql_query($sql);
            if (mysql_num_rows($resultaat_van_server) > 0) {
                print("Wanneer u deze categorie verwijderd worden er ook evenementen,<br/> die deze categorie bevatten ook verwijderd.<br/>
                                    <a href=\"raadpleegevenementcategorieen.php\">Ga terug</a>
                            <a href=\"verwijderevenementcategorie.php?id={$_GET["id"]}&verwijder=true\">Ga door</a>");
            } 
            else{
                $id = mysql_real_escape_string($_GET["id"]);
                if (isset($_GET['verwijder'])) {

                    $sql = "DELETE FROM categorie WHERE categorieid=$id";
                    $resultaat_van_server = mysql_query($sql) or die(mysql_error());

                    print("Het verwijderen is gelukt!<br/>");
                    print("Over 5 seconden wordt u doorverzonden naar de vorige pagina <br/>")
                    ?>
                    <script language="javascript">
                        setTimeout("location.href='./raadpleegevenementcategorieen.php'", 5000);
                    </script> <?php
            echo "<a href=\"raadpleegevenementcategorieen.php\">Of klik hier om direct terug te gaan naar de vorige pagina </a>";
                }
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