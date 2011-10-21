<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();
if (isset($_GET["id"]) && intval($_GET["id"])) {
	$id = mysql_real_escape_string($_GET["id"]);
} else {
	$id = "";
}

$query = "(SELECT 
			onderwerp, bericht, CONCAT(voornaam, ' ', achternaam) AS naam, datum 
		FROM 
			bericht
		INNER JOIN 
			student
		ON
			van = student.studentid
		WHERE 
			naar = ".$id."
		OR 
			groepid
		IN (
			SELECT 
				groepid
			FROM
				groep
			WHERE
				eigenaar = ".$id."
		))
		UNION
		(
		 SELECT
			afzender as onderwerp, inhoud as bericht, CONCAT(voornaam, ' ', achternaam) AS naam, tijdstip 
			FROM 
				`reactie` 
			INNER JOIN 
				student
			ON 
				afzender_id = studentid 
			WHERE 
				afzender_id 
			IN (
				SELECT 
					studentid 
				FROM 
					groeplid 
				WHERE 
					groepid 
				IN 
					(
					SELECT 
						groepid 
					FROM 
						groep 
					WHERE
						eigenaar = ".$id.")))
		UNION
		(
		 SELECT 
			onderwerp, inhoud as bericht, CONCAT(voornaam, ' ', achternaam) AS naam, datum 
		FROM 
			`profielbericht` 
		INNER JOIN 
			student 
		ON 
			afzender = student.studentid 
		WHERE 
			afzender = ".$id.")
		ORDER BY datum DESC;";

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