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
			<p><html>
				<head>

				</head>
				<body>
					<form action="toevoegen.php" method="get">
						<table>
							<tr>
								<td>Naam </td>
								<td><input type="text" name="naam" /></td>
							</tr>
							<tr>
								<td>Begin </td>	
								<td><input type="text" name="bdatum"/></td>
							</tr>
							<tr>
								<td>Eind </td>
								<td><input type="text" name="edatum"/></td>
							</tr>
							<form method="post" action="bestemming">
								<tr>
									<td>Categorie </td>
									<td><textarea name ="tekstvak" ></textarea></td>
								</tr>
							</form>
							<tr>
								<td>Organisator </td>
							</tr>
							<tr>
								<td>Aanmelding verplicht? </td>
								<td><input type="checkbox" name="aanmelden" value="jn" /></td>
							</tr>
							<form method="post" action="bestemming">
								<tr>
									<td>Omschrijving </td>
									<td><textarea name ="tekstvak" > </textarea></td>
								</tr>
							</form>
							<tr>
								<td><input type="submit" value="Toevoegen"/></td>
							</tr>
						</table>
					</form>
				</body>
			</html></p>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>



<?php
echo $pagina->getVereisteHTMLafsluiting();

	database::getInstantie();
	
	$sql = "SELECT * FROM `student`;";
	$resultaat_van_server = mysql_query($sql);
	while($array = mysql_fetch_array($resultaat_van_server)) {
		echo $array["voornaam"]."<br />";
	}
?>