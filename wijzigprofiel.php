<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>

<?php //daniel ?>

<?php
/**
 * @author: Daniel
 * @description: 
 */
$pagina = pagina::getInstantie();

$pagina->setTitel("wijzig profiel");
$pagina->setCss("style.css");

echo $pagina->getVereisteHTML();
?>
<div id="container">
	<?php echo $pagina->getHeader(); ?>
	<div id="page">
		<?php echo $pagina->getMenu(); ?>
		<div id="content">
			<h1><?php echo $pagina->getTitel();?></h1>


		<?php
		 
				   
				    database::getInstantie();
					
	
		
		  
	
		if(isset($_POST["wijzig"] )== "wijzig"
		/*&& isset($_GET["studentnr"])
	    && isset($_GET["voornaam"])
		&& isset($_GET["achternaam"])
		&& isset($_GET["adres"])
		&& isset($_GET["postcode"])
		&& isset($_GET["woonplaats"])
		&& isset($_GET["geslacht"])
		&& isset($_GET["geboortedatum"])
		&& isset($_GET["emailadres"])
		 */ ){
			
			             //   $id = $_GET['id'];

			
		   $studentnr = $_POST["studentnr"];
		   $voornaam= $_POST["voornaam"];
		   $achternaam= $_POST["achternaam"];
		   $adres= $_POST["adres"];
		   $postcode=$_POST["postcode"];
		   $woonplaats= $_POST["woonplaats"];
		   $geslacht=$_POST["geslacht"];
		   $geboortedatum=$_POST["geboortedatum"];
		   $emailadres=$_POST["emailadres"];
		   
		   
		   $id = mysql_real_escape_string($_GET["id"]);
		   $sql= "UPDATE student
		          SET  voornaam='".$voornaam."',
		               achternaam='".$achternaam."',
		               adres='".$adres."',
		               postcode='".$postcode."',
		               woonplaats='".$woonplaats."',
		               geslacht='".$geslacht."',
		               geboortedatum='".$geboortedatum."',
		               emailadres='".$emailadres."'
		   WHERE studentid=".$id.";" ;
		  $resultaat_van_server = mysql_query($sql) or die(mysql_error());
         // $array = mysql_fetch_array($resultaat_van_server);
		  
		   
		   echo"gewijzigd";
		   echo"<a href=\"raadplegenprofiel.php?id=".$id."\"> terug </a>";
		 }	   
	//if(isset($_POST["wijzig"])!= "wijzig"){ 	 
		$id = mysql_real_escape_string($_GET["id"]);
        $query = "SELECT * FROM student WHERE studentid =" .$id." ;";
        $resultaat_van_server = mysql_query($query);
        $array = mysql_fetch_array($resultaat_van_server);
		//echo"nu moet ik het ophalen";
	//}
		    
		?>

		<!-- <form action="RaadplegenProfielb.php?id= <?php // echo $id ?>   "method="GET" align="left"> -->
		<?php $id = mysql_real_escape_string($_GET["id"]); ?>
		<form action="wijzigprofiel.php?id=<?php echo $id; ?>   "method="POST" align="left">
		<table>
			<?php
			echo $id;?>
			
		<tr>	
				<td>Studentnummer: </td>	<td><input type="text" name="studentnr" value=" <?php echo $array["studentnr"]; ?>" readonly="readonly" /></br> </td> 
				
		</tr>
		<tr>
				<td>Voornaam:</td> <td>	    <input type="text" name="voornaam"  value="<?php echo $array["voornaam"]; ?>"/> </br></td>
		</tr>
		<tr>
				<td> Achternaam: </td>	<td>    <input type="text" name="achternaam" value="<?php echo $array["achternaam"]; ?>"/>  </br> </td>
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
		<tr>
			<td><input type="submit" name="wijzig" value="wijzig"/> </td>
		</tr>
		<tr>
				<td><a href="raadplegenprofiel.php?id=<?php echo $id; ?>"> terug </a></td>
		</tr>
			
		</table>
	
			
			
			
			
			
			
			
			
		</form>
		
		
  </div>
	</div>
	<?php echo $pagina->getFooter(); ?>
</div>



<?php
echo $pagina->getVereisteHTMLafsluiting();

