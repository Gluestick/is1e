<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" href="style.css" type="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Eventplaza</title>
</head>
<body>
<div id="container">
	<div id="header">
		<a class="header_img" href="#"><img src="/images/hoofd.jpg" /></a>
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
<div id="midden">