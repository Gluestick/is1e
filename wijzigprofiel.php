<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>

<?php //daniel ?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
	
    </head>
    <body>


		<?php
		 
				   
				    database::getInstantie();
					
				
		$id = mysql_real_escape_string($_GET["id"]);
        $sql = "SELECT * FROM student WHERE studentid = $id ";
        $resultaat_van_server = mysql_query($sql);
        $array = mysql_fetch_array($resultaat_van_server);
		
		  
		
		if(isset ($_GET["studentnr"]) && ($_GET["voornaam"]) && ($_GET["achternaam"]) && ( $_GET["adres"]) && ($_GET["postcode"]) && ( $_GET["woonplaats"]) && ($_GET["geslacht"]) && ($_GET["geboortedatum"]) && ($_GET["emailadres"]) ){
		   $studentnr = $_GET["studentnr"];
		   $voornaam= $_GET["voornaam"];
		   $achternaam= $_GET["achternaam"];
		   $adres= $_GET["adres"];
		   $postcode=$_GET["postcode"];
		   $woonplaats= $_GET["woonplaats"];
		   $geslacht=$_GET["geslacht"];
		   $geboortedatum=$_GET["geboortedatum"];
		   $emailadres=$_GET["emailadres"];
		   
		   
		   
		   }
		?>

		<form action="wijzigprofiel.php?id=$id" method="GET" align="left">
		<table>
			
		<tr>	
				<td>Studentnummer: </td>	<td><input type="text" name="studentnr" value=" <?php echo $array["studentnr"]; ?>" disabled="disabled"/></br> </td> 
				
		</tr>
		<tr>
				<td>Voornaam:</td> <td>	    <input type="text" name="voornaam"  value=" <?php echo $array["voornaam"]; ?>"/> </br></td>
		</tr>
		<tr>
				<td> Achternaam: </td>	<td>    <input type="text" name="achternaam" value=" <?php echo $array["achternaam"]; ?>"/>  </br> </td>
		</tr>
		<tr>
				<td>	Adres: 	 </td>   <td>    <input type="text" name="adres" value="<?php echo $array["adres"]; ?>" /> </br></td>
		</tr>
		<tr>
				<td>	Postcode: </td> <td>	    <input type="text" name="postcode" value="<?php echo $array["postcode"]; ?>" /> </br></td>
		</tr>
		<tr>
				<td>	Woonplaats:	 </td> <td>   <input type="text" name="woonplaats" value="<?php echo $array["woonplaats"]; ?>" /> </br></td>
		</tr>
		<tr>
				<td> Geslacht:	 </td> <td>   <input type="text" name="geslacht" value="<?php echo $array["geslacht"]; ?>" /> </br></td>
		</tr>	
		<tr>
				<td>Geboortedatum: </td> <td>	<input type="text" name="geboortedatum" value="<?php echo $array["geboortedatum"]; ?>" /> </br></td>
		</tr>
		<tr>
				<td>	E-mailadres: </td> <td> 	<input type="text" name="emailadres" value="<?php echo $array["emailadres"]; ?>" /> </br></td>
		</tr>
		</table>
		</form>
		
		
		<?php
		
		   /* 
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
		echo "</table>";*/
		
			
		
		
		
			
			?>
		
		
		
		
						<?php	/*  database::getInstantie();
		$id = mysql_real_escape_string($_GET["id"]);
		$sql = "SELECT * FROM aanmelding INNER JOIN evenement ON evenement.evenementid = aanmelding.evenementid WHERE studentid = ".$id." ;";
        $resultaat_van_server = mysql_query($sql); */
      
		
		
		
			
		?>	

		<!--<table> 
			<tr>
			<th> datum </th>
			<td> <input type="text" disabled="disabled" value=" <?php// echo $array["datum"]; ?>  "</td>
		</tr>
		<tr>
			<th> onderwerp </th>
			<td>  <input type="text" disabled="disabled" value=" <?php //echo $array["onderwerp"]; ?>" </td>
		</tr>
		<tr>
			<th> bericht </th>
			<td>  <input type="text" disabled="disabled" value=" <?php //echo $array["inhoud"]; ?>" </td>
		</tr>
		</table>-->    
		
		
		 
		
		
		<?php
		
		/*
						database::getInstantie();
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

		*/	
		?>	
		
		
		
		<?php
		  $studentnr = $_GET["studentnr"];
		   $voornaam= $_GET["voornaam"];
		   $achternaam= $_GET["achternaam"];
		   $adres= $_GET["adres"];
		   $postcode=$_GET["postcode"];
		   $woonplaats= $_GET["woonplaats"];
		   $geslacht=$_GET["geslacht"];
		   $geboortedatum=$_GET["geboortedatum"];
		   $emailadres=$_GET["emailadres"];
		   
		   
		   
		   
		$resultaat_van_server = mysql_query($sql);
        $array = mysql_fetch_array($resultaat_van_server);
		$sql= "UPDATE student SET  studentnr='$studentnr', voornaam='$voornaam', achternaam='$achternaam', adres='$adres', postcode='$postcode', woonplaats='$woonplaats', geslacht='$geslacht', geboortedatum='$geboortedatum', emailadres='$emailadres'"               ;
	
		?>
		
		<table>
			<tr>
			<td><input type="submit" name="submit"/> </td>
			</tr>
			
			
		</table>
		
			
			
			
			
			
			
			
			
		</form>
		
		
    </body>
</html>
