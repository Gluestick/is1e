<?php
/**
 * @author: Daniel
 * @description: 
 */
$studentid = $_GET["id"];
$pagina = pagina::getInstantie();

$pagina->setTitel("Plaatsen bericht");
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
			<h1><?php echo $pagina->getTitel();
		database::getInstantie(); ?></h1>
			<?php
			$studentid = $_GET["id"];
			if (isset($_POST["verstuur"])
					&& isset($_POST["onderwerp"])
					&& isset($_POST["bericht"])) {

				$bericht = mysql_real_escape_string($_POST["bericht"]);
				$onderwerp = mysql_real_escape_string($_POST["onderwerp"]);

				$sql = "INSERT INTO  profielbericht (datum, onderwerp, inhoud, studentid) VALUES ('" . date("Y-m-d") . "','" . $onderwerp . "','" . $bericht . "', " . $studentid . ")";

				if (mysql_query($sql)) {
					echo"bericht toegevoegd";
				} else {
					die(mysql_error());
				}
			}
			?>
			<form action="plaatsenprofielbericht.php?id=<?php echo $studentid; ?>" method="POST">
				<table>
					<tr>
						<td>onderwerp: </td> <td> <input name="onderwerp" type="text"/>  </td> 
					</tr>
					<tr>
						<td>bericht: </td> <td> <textarea name="bericht" style="float:left;min-height:200px;min-width:200px;"></textarea>
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
							</div>
						</td>
					</tr>
					<tr>
						<td><input type="submit" value="verzenden" name="verstuur"/></td><td> <input type="reset" value="wis alles"/></td>
						<td><a href="raadplegenprofiel.php?id=<?php echo $studentid; ?>"> terug </a></td>
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