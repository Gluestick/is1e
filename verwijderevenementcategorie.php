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

            if (isset($_GET['verwijder'])) {
                $id = mysql_real_escape_string($_GET["id"]);
                $sql = "Select evenementid from evenement where categorieid = $id";
                $resultaat_van_server = mysql_query($sql) or die(mysql_error());
                while ($array = mysql_fetch_assoc($resultaat_van_server)) {
                    $sql2 = "DELETE FROM aanmelding where evenementid = {$array["evenementid"]}";
                    $sql3 = "DELETE FROM reactie where evenementid = {$array["evenementid"]}";
                    $sql4 = "DELETE FROM evenement where evenementid = {$array["evenementid"]}";
                    $sql5 = "DELETE FROM categorie WHERE categorieid=$id";
                    mysql_query($sql2) or die(mysql_error());
                     mysql_query($sql3) or die(mysql_error());
                      mysql_query($sql4) or die(mysql_error());
                       mysql_query($sql5) or die(mysql_error());
                }

                print("Het verwijderen is gelukt!<br/>");
                print("Over 5 seconden wordt u doorverzonden naar de vorige pagina <br/>")
                ?>
                <script language="javascript">
                    setTimeout("location.href='./raadpleegevenementcategorieen.php'", 5000);
                </script> <?php
            echo "<a href=\"raadpleegevenementcategorieen.php\">Of klik hier om direct terug te gaan naar de vorige pagina </a>";
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