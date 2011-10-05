<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
			
		
		<?php 
		
			  $bericht = $_GET["bericht"];
			  //$datum = $_GET["datum"];
			  $onderwerp=$_GET["onderwerp"];
			  $sql= "INSERT INTO  profielbericht VALUES $datum,$onderwerp,$inhoud;";
		
		
		$con= mysql_connect("localhost","root","usbw");
		if(!$con){
			die ("could not connect:"   . mysql_error());
		}
		mysql_select_db(project, $con);
		//$sql= "INSERT INTO  profielbericht VALUES $datum,$onderwerp,$inhoud;";
		
		if(!mysql_query ($sql,$con)){
			die("Error" .mysql_error());	
		
		}
		echo "bericht toegevoegd";
	mysql_close ($con);	
		
		
		
		?>
		 
		<form action="plaatsenprofielbericht.php" method="GET">
		<table>
			<tr>
				<td>datum: </td> <td><input name="datum" disabled="disabled" type="text" value="<?php  /* $b=time();*/ echo date("m/d/y");  ?>" />  </td>  
			</tr>
			<tr>
				<td>onderwerp: </td> <td> <input name="onderwerp" type="text"/>  </td> 
			</tr>
			<tr>
				<td>bericht: </td> <td> <textarea name="bericht"   >  </textarea> </td>
				
			</tr>
			<tr>
				<td> <input type="submit" value="verzenden"/>   </td><td> <input type="reset" value="wis alles"/> </td>
				
				
			</tr>
		</form>		
			
			
			
			
			
			
			
			
		</table>
		
		
		<?php
		
		//$query= "INSERT INTO  profielbericht VALUES $datum,$onderwerp,$inhoud; "
		
		
		
		?>
    </body>
</html>
