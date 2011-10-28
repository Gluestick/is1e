<?php
/**
 * @author: Kay van Bree, Kajel Bhikhoe
 * @description: 
 */
if (!isMember()) {
	header("location:index.php");
}
$pagina = pagina::getInstantie();

if (isset($_GET["id"])) {
	$id = $_GET["id"];
} else {
	$id = "";
}

if (isset($_POST["verstuur"])) {
	database::getInstantie();
	$naam = $_POST["naam"];
	$tekstvak = $_POST["tekstvak"];
	$tijdstip = date("Y-m-d");  
	
	if (empty ($naam)) {
     $error["naam"] = "";
	}
	if (empty ($tekstvak)) {
	($error["tekstvak"] = ""); 
	}
	
	}

$pagina->setTitel("Eventplaza");
$pagina->setCss("style.css");
$pagina->setJavascript("jquery.js");
$pagina->setJavascriptCode("
	$(document).ready(function() {
		$(\"#smiley\").click(function(){
			if ($(\"#list\").css('display') == 'none') {
				var position = $(this).position();
				$(\"#list\").css({'display':'block', 'left':position.left + 32, 'top':position.top});
			} else {
				$(\"#list\").css('display','none');
			}
		});
		$(\".bold, .italic, .underline\").click(function(){
			var html = $.trim($(this).html());
			$(\"textarea\").val( $(\"textarea\").val() + '[' + html.toLowerCase() + ']' + '[/' + html.toLowerCase() + ']');
		});
		$(\"#list span\").click(function(){
			$(\"textarea\").val( $(\"textarea\").val() + $(this).attr(\"title\"));
		});
	});
");

echo $pagina->getVereisteHTML();
?>
<div id="container">
		<?php echo $pagina->getHeader(); ?>
	<div id="page">
<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>
			<?php
			if (!empty($id) && !empty($naam) && !empty($tekstvak)) {
		$query1 = "INSERT INTO reactie (evenementid, afzender, inhoud, tijdstip) 
	VALUES(".mysql_real_escape_string($id).",'".mysql_real_escape_string($naam)."', '".mysql_real_escape_string($tekstvak)."', '$tijdstip')";
		echo"Reactie is toegevoegd!";
		mysql_query($query1);
	}
	?>
			<form action="evenementreactie.php?id=<?php echo $id; ?>" method="post">
				<table>
					<tr>
						<td>Naam </td>
						<td><input type="text" name="naam"/><input type ="hidden" name ="evenementid" value ="<?php echo $id; ?>" /></td>
						<td> <?php if (isset ($error["naam"])) { echo "Naam is verplicht!"; } ?> </td>
					</tr>
					<tr>
						<td>Bericht </td>
						<td><textarea name="tekstvak" style="float:left;min-height:200px;min-width:200px;"></textarea>
							<div id="tekstopties">
								<div id="smiley">
									<img src="/project/images/smile.gif" style="float:left;margin-left:8px;margin-top:3px;margin-right:8px;width:15px;height:15px;" />
								</div>
								<div class="bold">
									B
								</div>
								<div class="italic">
									I
								</div>
								<div class="underline">
									U
								</div>
							</div>
							<div id="list">
								<?php
								foreach (specialetekens::getSmileys() as $array) {
									$smiley = explode("_", $array, 2);
									list($width, $height, $type, $attr) = getimagesize($_SERVER["DOCUMENT_ROOT"] . "/project/images/" . $smiley[0] . ".gif");
									$rwidth = 32 - $width;
									$marginleft = round(($rwidth / 2), 0);
									$rheight = 22 - $height;
									$margintop = round(($rheight / 2), 0);
									echo "<span title=\"" . $smiley[1] . "\"><img src=\"/project/images/" . $smiley[0] . ".gif\" style=\"margin-left:" . $marginleft . "px;margin-top:" . $margintop . "px;width:" . $width . "px;height:" . $height . "px;\" /></span>";
								}
								?>
							</div></td>
							<td> <?php if (isset ($error["tekstvak"])) { echo "Bericht is niet ingevuld!"; } ?> </td>
					</tr>
					<tr>
						<td></td>
						<td><input type="reset" value="Wis alles"/> <input type="submit" name="verstuur" value="Verstuur"/> <a href="evenement.php?id=<?php echo $id; ?>"/> Ga terug</a></td>
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