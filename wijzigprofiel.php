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
        $sql = "SELECT * FROM student WHERE studentId = $id ";
        $resultaat_van_server = mysql_query($sql);
        $array = mysql_fetch_array($resultaat_van_server);
		
		   
		   
		   
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
		
		    database::getInstantie();
			$id=  mysql_real_escape_string($_GET["id"]); 
			$sql= "SELECT * FROM profielbericht WHERE profielberichtId=$id";
			$resultaat_van_server= mysql_query ($sql);
			$array = mysql_fetch_array($resultaat_van_server);
			?>		
		<table> 
			<tr>
			<th> datum </th>
			<td> <input type="text" disabled="disabled" value=" <?php echo $array["datum"]; ?>  "</td>
		</tr>
		<tr>
			<th> onderwerp </th>
			<td>  <input type="text" disabled="disabled" value=" <?php echo $array["onderwerp"]; ?>" </td>
		</tr>
		<tr>
			<th> bericht </th>
			<td>  <input type="text" disabled="disabled" value=" <?php echo $array["inhoud"]; ?>" </td>
		</tr>
		</table>    
		
			
			
			
			
			
			
			
			
		</form>
		
		
    </body>
</html>
