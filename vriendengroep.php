<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

$pagina->setTitel("Vriendengroep");
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
			$sql = "SELECT * FROM groep WHERE eigenaar = ".mysql_real_escape_string($_GET["id"]);
			$resultaat_van_server = mysql_query($sql);
			if (mysql_num_rows($resultaat_van_server) > 0) {
				echo "<table>";
				while ($array = mysql_fetch_assoc($resultaat_van_server)) {
					echo "<tr><td>".$array["naam"]."</td>";
					
					$query = "SELECT * FROM groeplid WHERE groepid = ".$array["groepid"];
					$resultaat = mysql_query($query);
					while ($rij = mysql_fetch_assoc($resultaat)) {
						echo "";
					}
					echo "</tr>";
				}
				echo "</table>";
			} else {
				echo "U heeft nog geen groepen aangemaakt";
			}
			?>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();
?>