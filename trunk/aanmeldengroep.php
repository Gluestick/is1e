<?php
/**
 * @author: Hans-Jurgen Bakkenes
 * @description: 
 */
$pagina = pagina::getInstantie();
database::getInstantie();

$sql = "SELECT * FROM groep WHERE groepid = ".mysql_real_escape_string($_GET["groepid"]);
$resultaat = mysql_query($sql);
$naam = "";
if (mysql_num_rows($resultaat) > 0) {
	$array = mysql_fetch_assoc($resultaat);
	$naam = " voor de \"".$array["naam"]."\" groep";
}
$pagina->setTitel("Aanmelden".$naam);
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
			if (isset($_POST["aanmelden"])) {
				$sql = "SELECT * FROM groeplid WHERE groepid = ".mysql_real_escape_string($_GET["id"])." AND studentid = ".mysql_real_escape_string($_POST["studentid"]);
				$result = mysql_query($sql);
				if (mysql_num_rows()) {
					
				}
			}
			?>
			<form method="post" action="aanmeldengroep.php?groepid=<?php echo $_GET["groepid"]; ?>">
				<table>
					<tr>
						<td>
							<select name="student">
								<?php
								$sql = "SELECT studentid, voornaam, achternaam FROM student";
								$resultaat_van_server = mysql_query($sql);
								while ($rij = mysql_fetch_assoc($resultaat_van_server)) {
									echo "<option value=\"".$rij["studentid"]."\">".$rij["voornaam"]." ".$rij["achternaam"]."</option>";
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							<input type="submit" name="aanmelden" value="aanmelden" />
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>
<?php
echo $pagina->getVereisteHTMLafsluiting();
?>