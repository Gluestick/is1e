<?php

/*
 * @author: Kay van Bree
 * @decs: Laat een lijst van studenten zien, met links naar de pagina om ze te bewerken.
 */
	
	$pagina = pagina::getInstantie();

	$pagina->setTitel("Studenten");
	$pagina->setCss("style.css");

	echo $pagina->getVereisteHTML();
	print("<div id=\"container\">");
	echo $pagina->getHeader();
	print("<div id=\"page\">");
	echo $pagina->getMenu(); 
	print("<div id=\"content\">");
	print("<h1>" . $pagina->getTitel() . "</h1>");
	
	class studentenLijst {
		public function printStudenten($aantalrijen){
			database::getInstantie();

			if(!isset($_GET['pagina'])){
				$page = 1;
			} else {
				$page = $_GET['pagina'];
			}

			$vanaf = (($page * $aantalrijen) - $aantalrijen);
			$query = $this->makeQuery($aantalrijen, $vanaf);
			$limit_query = ($query . "ORDER BY `studentnr` LIMIT ". $vanaf .",". $aantalrijen .";");

			$result = mysql_query($limit_query) or die(mysql_error());

			$total_results = mysql_num_rows(mysql_query($query));		

			if($total_results < 1){
				print("Geen resultaten");
			} else {
			$this->printPaginator($page, $total_results, $aantalrijen);
				print("<tr><td><b>Student nr</b></td><td><b>Naam</b></td><td><b>Geslacht</b></td><td><b>Geboortedatum</b></td></tr>");
				while($row = mysql_fetch_array($result)){
					print("<tr><td>" . $row['studentnr'] . "</td>");
					print("<td><a href=\"raadplegenprofiel.php?id=" . $row['studentid'] . "\">" . $row['voornaam'] . " " . $row['achternaam'] . "</a></td>");
					print("<td>" . $row['geslacht'] . "</td>");
					print("<td>" . $row['geboortedatum'] . "</td></tr>");
				}
				$this->printPaginator($page, $total_results, $aantalrijen);
			}
		}

		public function printPaginator($page, $total_results, $aantalrijen){
			$prev = ($page - 1);
			$next = ($page + 1);
			$total_pages = ceil($total_results / $aantalrijen);
			
			if($total_results > $aantalrijen){
				print("<tr><td colspan=\"4\">");
				if($page > 1){
					print("<a href=\"studentenlijst.php?pagina=". $prev ."\">Vorige</a> || ");
				}

				for($i = 1; $i <= $total_pages; $i++){
					if($i == $page){
						print($i . " | ");
					} else {
						print("<a href=\"studentenlijst.php?pagina=". $i ."\">". $i . "</a> | ");
					}
				}

				if($page < $total_pages){
					print("| <a href=\"studentenlijst.php?pagina=". $next ."\">Volgende</a>");
				}
				print("</td></tr>");
			}
		}

		public function makeQuery($aantalrijen, $vanaf){
			if(!isset($_POST['submit'])){		
				$query = "SELECT studentid, studentnr, voornaam, achternaam, geslacht, geboortedatum, userid 
						FROM student ";
			} else {
				$vind = mysql_real_escape_string($_POST['vind']);

				$where = "WHERE studentnr = '%$vind%' or voornaam LIKE '%$vind%' or achternaam LIKE '%$vind%' ";

				$query = "SELECT studentid, studentnr, voornaam, achternaam, geslacht, geboortedatum 
						FROM student ".$where." ";
			}
			return $query;
		}
	}
?>
	<form action="<?php print($_SERVER['PHP_SELF']); ?>" method="post">
		<table>
			<tr>
				<td>Zoek studenten op nummer of naam:</td>
			</tr>
			<tr>
				<td><input type="text" name="vind" /></td>
				<td><input type="submit" name="submit" value="Zoeken!" /></td>
				<td><a href="studentenlijst.php">Alle studenten</a></td>
			</tr>
		</table>
	</form>
	
	<table>
		<?php 
			$studentenLijst = new studentenLijst;
			$studentenLijst->printStudenten("10");
		?>
	</table>

<?php
	print("</div></div>");
	echo $pagina->getFooter();
	print("</div>");
	echo $pagina->getVereisteHTMLafsluiting();
?>