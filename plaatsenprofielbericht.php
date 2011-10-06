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
		$studentid = $_GET["id"];
		if (isset($_POST["verstuur"])) {

			$bericht = $_POST["bericht"];
			$onderwerp = $_POST["onderwerp"];
			// $sql= "INSERT INTO  profielbericht VALUES $datum,$onderwerp,$inhoud;";


			$con = mysql_connect("localhost", "root", "usbw");
			if (!$con) {
				die("could not connect:" . mysql_error());
			}
			mysql_select_db("project", $con);
			$sql = "INSERT INTO  profielbericht (datum, onderwerp, inhoud, studentid) VALUES ('" . date("Y-m-d") . "','" . $onderwerp . "','" . $bericht . "', " . $studentid . ")";

			if (!mysql_query($sql, $con)) {
				die("Error" . mysql_error());
			}
			echo "bericht toegevoegd";
			mysql_close($con);
		}
		?>

		<form action="plaatsenprofielbericht.php?id=<?php echo $studentid; ?>" method="POST">
			<table>
				<tr>
					<td>datum: </td> <td><input name="datum" disabled="disabled" type="text" value="<?php /* $b=time(); */ echo date("d/m/Y"); ?>" />  </td>  
				</tr>
				<tr>
					<td>onderwerp: </td> <td> <input name="onderwerp" type="text"/>  </td> 
				</tr>
				<tr>
					<td>bericht: </td> <td> <textarea name="bericht"   >  </textarea> </td>

				</tr>
				<tr>
					<td> <input type="submit" value="verzenden" name="verstuur"/>   </td><td> <input type="reset" value="wis alles"/> </td>

					<td><a href="RaadplegenProfielb.php?id=<?php echo $studentid; ?>"> terug </a></td>
				</tr>
			</table>
		</form>		

		<?php
		//$query= "INSERT INTO  profielbericht VALUES $datum,$onderwerp,$inhoud; "
		?>
	</body>
</html>
