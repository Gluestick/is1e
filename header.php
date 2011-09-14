<?php include("functions.php"); 
	/**
	* @author: Kay van Bree
	* @description: Deze pagina zorgt voor de structuur. De pagina wordt in elke opgevraagde pagina geladen.
	* 				Op het eind van elke pagina worden de div's van header.php afgesloten in footer.php.
	*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>EventPlaza</title>
	<link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
<div id="container">
	<div id="top">
		
	</div>
	<div id="header">
		<div id="login">
		<fieldset class="login">
		<h4>Inloggen:</h4>
		<form action="<?$_SERVER['php_self'];?>" method='post'>
			<input type="text" name="gebruiker" class="text" />
			<input type="password" name="password" class="pass" />
			<input type="submit" name="submit" value="Ga!" class="submit" />
		</form>
		<p>Geen account? <a href="#">Registreer!</a></p>
		</fieldset>
		</div>
	</div>
	<div id="menu">
			<?php include("menu.php"); ?>
	</div>
	
	<div id="content">