<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>

<?php //daniel  ?>
 
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
		
		
		
		<?php $studentid=$_GET["id"]; ?>
		<a href="wijzigprofiel.php?id=<?php echo $studentid; ?>" method="GET" > wijzig </a>
        
        <table style="text-align:left; " >
		<?php
		
		        database::getInstantie();
		$id = mysql_real_escape_string($_GET["id"]);
        $sql = "SELECT * FROM student WHERE studentid = ".$id;" LIMIT 1;";
        $resultaat_van_server = mysql_query($sql);
        $array = mysql_fetch_array($resultaat_van_server);
        ?>
			<tr>
				<th>  Studentnummer  </th>
				<td> <?php echo $array["studentnr"]; ?> </td>
			</tr>
			<tr>
				<th>  Voornaam  </th>
				<td> <?php echo $array["voornaam"]; ?></td>
			</tr>
			<tr>
				<th>  Achternaam  </th>
				<td><?php echo $array["achternaam"]; ?></td>
			</tr>
			<tr>
				<th>  Adres  </th>
				<td><?php echo $array["adres"]; ?></td>
			</tr>
			<tr>
				<th>  Postcode  </th>
				<td><?php echo $array["postcode"]; ?></td> 
			</tr>
			<tr>
				<th>  Woonplaats </th>
				<td><?php echo $array["woonplaats"]; ?></td>
			</tr>
			<tr>
				<th>  Geslacht  </th>
				<td><?php echo $array["geslacht"]; ?></td>
			</tr>
			<tr>
				<th>  Geboortedatum   </th> 
				<td><?php echo $array["geboortedatum"]; ?></td>
			</tr>
			<tr>
				<th>  E-mail   </th> 
				<td><?php echo $array["emailadres"]; ?></td>
			</tr>
               
        </table> 
		</br>
		
		
		Mijn berichten ( <a href="plaatsenprofielbericht.php?id=<?php echo"$studentid" ?>"> toevoegen </a>)
			
			
			
		<?php
		database::getInstantie();
		$id = mysql_real_escape_string($_GET["id"]);
		$query = "SELECT * FROM Profielbericht WHERE studentid = ".$id.";";
		$resultaat_van_server = mysql_query($query);
		
		echo "<table style=\"text-align:left;\">";
		while($row = mysql_fetch_array($resultaat_van_server)){
			echo "<tr><th>datum</th><td>".$row["datum"]."</td></tr> ";
			echo "<tr><th>onderwerp</th><td>".$row["onderwerp"]."</td></tr> ";
		    echo "<tr><th>bericht</th><td>".$row["inhoud"]."</td></tr> ";
		}
		echo "</table>";
			
			
			?>
	
	
		
		<b>Evenementen</b> </br>
		
		Bezocht: 
		
		<table border="1">
			
				<?php	  database::getInstantie();
		$id = mysql_real_escape_string($_GET["id"]);
		$sql = "SELECT * FROM aanmelding INNER JOIN evenement ON evenement.evenementid = aanmelding.evenementid WHERE studentid = ".$id." ;";
        $resultaat_van_server = mysql_query($sql);
      
		
		
		echo" evenementen bezocht";
		    echo"<table style=\"text-align:left;\">";
		    while($row= mysql_fetch_array($resultaat_van_server)){
			   if( $row["begindatum"] <= date("Y-m-d")) {
        		    echo "<tr><th>naam</th><td>".$row["naam"]."</td></tr> ";
		            echo "<tr><th>begindatum</th><td>".tijd::formatteerTijd($row["begindatum"],"d-m-Y" )."</td></tr> ";
		            echo "<tr><th>vereniging</th><td>".$row["organiserendeverenigingid"]."</td></tr> ";
		            echo "<tr><th>categorie</th><td>".$row["categorieid"]."</td></tr> ";
		         
			  }
			}	
		    echo"</table> ";
	        echo"evenementen nog te bezoeken";
	        echo"<table style=\"text-align:left;\">";
			$sql = "SELECT * FROM aanmelding INNER JOIN evenement ON evenement.evenementid = aanmelding.evenementid WHERE studentid = ".$id." ;";
			$resultaat_van_server = mysql_query($sql);
		    while($row = mysql_fetch_array($resultaat_van_server)){
			   if( $row["begindatum"] > date("Y-m-d")) {
		            echo "<tr><th>naam</th><td>".$row["naam"]."</td></tr> ";
		            echo "<tr><th>begindatum</th><td>".tijd::formatteerTijd($row["begindatum"], "d-m-Y")."</td></tr> ";
		            echo "<tr><th>vereniging</th><td>".$row["organiserendeverenigingid"]."</td></tr> ";
		            echo "<tr><th>categorie</th><td>".$row["categorieid"]."</td></tr> ";
				}
			}	
		    echo"</table> ";

			
		?>	
		
			
		 <?php	
		 //<th> Naam </th> <th>Begin</th> <th> Vereniging </th> <th> Categorie </th> 
			//<tr>
		/*	<td> <?php echo $array["naam"];  ?></td> 
			<td> <?php echo $array["begindatum"];  ?></td> 
			<td> <?php echo $array["organiserendeVerenigingId"];  ?></td> 
			<td> <?php echo $array["categorieId"];  ?></td> 
			</tr>
		</table>  */ 
	?>
    </body>
</html>
