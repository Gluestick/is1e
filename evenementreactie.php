<?php
/**
 * @author: Kay van Bree, Kajel Bhikhoe
 * @description: 
 */
$pagina = pagina::getInstantie();
$id = ($_GET["id"]);

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

			<form action="evenementreactie2.php" method="POST">
				<table>
					<tr>
						<td>Naam </td>
						<td><input type="text" name="naam"/><input type ="hidden" name ="evenementid" value = <?php echo $id ?>/></td>
					</tr>
					<tr>
						<td>Datum </td>
						<td><input type="text" name="datum" readonly="readonly" value="<?php echo date("d/m/Y"); ?>"></td>
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
						list($width, $height, $type, $attr) = getimagesize($_SERVER["DOCUMENT_ROOT"]."/project/images/".$smiley[0].".gif");
						$rwidth = 32 - $width;
						$marginleft = round(($rwidth / 2),0, PHP_ROUND_HALF_DOWN);
						$rheight = 22 - $height;
						$margintop = round(($rheight / 2),0, PHP_ROUND_HALF_DOWN);
						echo "<span title=\"".$smiley[1]."\"><img src=\"/project/images/".$smiley[0].".gif\" style=\"margin-left:".$marginleft."px;margin-top:".$margintop."px;width:".$width."px;height:".$height."px;\" /></span>";
					}
					?>
				</div></td>
					</tr>
					<tr>
						<td></td>
						<td><input type="reset" value="Wis alles"/> <input type="submit" name="verstuur" value="Verstuur"/></td>
					</tr>		
				</table>
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
