<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

$query = "(SELECT 
			onderwerp, bericht, CONCAT(voornaam, ' ', achternaam) AS naam, datum 
		FROM 
			bericht
		INNER JOIN 
			student
		ON
			naar = student.studentid
		WHERE 
			naar = ".mysql_real_escape_string($_GET["id"]).")
		UNION
		(SELECT 
			onderwerp, bericht, naam, datum 
		FROM 
			bericht
		INNER JOIN 
			groep
		ON
			bericht.groepid = groep.groepid
		WHERE
			bericht.groepid IN (
				SELECT 
					groepid 
				FROM 
					groep 
				WHERE 
					eigenaar = ".mysql_real_escape_string($_GET["id"])."
			)
		);";
$resultaat_van_server = mysql_query($query);

$pagina->setTitel("Inbox");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>
			<div id="inbox">
				<div id="emails">
					<table style="width:100%;" cellpadding="0" cellspacing="0">
					<?php
						while ($array = mysql_fetch_assoc($resultaat_van_server)) {
							?><tr>
								<td><input type="checkbox" name="bericht[]" /></td>
								<td><?php echo "<div style=\"width:100%;float:left;\"><div style=\"float:right;\">".tijd::formatteerTijd($array["datum"], "d-m-Y")."</div>".$array["naam"]."</div><div style=\"width:100%;float:left;\">".$array["onderwerp"]."</div>"; ?></td>
							</tr><?php
						}
					?>
					</table>
				</div>
				<div id="emailcontent">
					
				</div>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();
?>