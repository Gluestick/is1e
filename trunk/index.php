<?php
/**
 * @author: Arjan Speiard
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
			<p>
				Welkom op de site van Zoen Eventplaza.<br/>
				De website waar studenten evenementen en verenigingen bij elkaar komen!<br/>
				Wilt u graag bij de nieuwste evenementen aanwezig zijn, dan zit u hier goed!<br/>
				Leer andere mensen kennen en sluit jezelf aan bij verenigingen, zodat je samen naar de mooiste evenementen kan gaan.<br/>
				Wat houd je tegen? Zoek evenementen en maak plezier!
			</p>
			<center><h3>Nieuwste evenement(en)</h3>
			<table>
				<tr>
					<th>Evenement</th>
					<th>Begindatum</th>
					<th>Einddatum</th>
					<th>Vereniging</th>
					<th>Categorie</th>

				</tr>
				<?php
				database::getInstantie();
				$sql = "SELECT evenementid,evenement.naam AS `evenementnaam`,evenement.begindatum,vereniging.verenigingid as id, evenement.einddatum,vereniging.naam AS `verenigingnaam`,categorie.naam AS `categorienaam`
						FROM `evenement` JOIN `vereniging` ON organiserendeverenigingid=verenigingid
						JOIN `categorie` ON evenement.categorieid=categorie.categorieid
						ORDER BY evenementid DESC
						LIMIT 3;";
				$resultaat_van_server = mysql_query($sql);
					while ($array = mysql_fetch_array($resultaat_van_server)) {
					$id = $array['evenementid'];
					$id1 = $array['id'];
					echo "<tr><td> <a href=\"evenement.php?id=$id\">" . $array["evenementnaam"] . " </a></td><td>" .tijd::formatteerTijd($array["begindatum"],"d-m-Y") . "</td><td>".tijd::formatteerTijd($array["einddatum"],"d-m-Y") . "</td><td><a href=\"raadplegenvereniging.php?id=$id1\">".$array["verenigingnaam"]."</a></td><td>".$array["categorienaam"]."</td></tr>";
}
				?>
			</table>
			</center>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();
?>