<?php
	/*
	 * @author: Kay van Bree
	 * @desc: Wordt aangeroepen door getHeader(), deze geeft ook de nodige variabelen door.
	 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>EventPlaza - <?php print($pageTitle); ?></title>
	<link rel="stylesheet" type="text/css" href="<?php print($pageCSS); ?>" />
</head>
<body>
<div id="container">
	<div id="header">
		<img src="images/header.png" />
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
	<div id="page">
	<div id="menu">
			<?php include("menu.php"); ?>
	</div>
	
	<div id="content">
            <h1><?php print($pageTitle); ?></h1>