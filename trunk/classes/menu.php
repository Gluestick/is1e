<?php
	/**
	* @author: IS1e-gwy
	* @description: Alle links die in het hoofdmenu komen te staan.
	*/
?>
<ul id="nav">
	<li class="single">
		<a href="index.php" class="button">Home</a>
	</li>
	<li>
		<a href="studentenlijst.php" class="drop" class="button">Studenten</a>
		<div class="dropdown">
			<div><a href="studentenlijst.php" class="button">Studentenlijst<br /><font>Ingeschreven studenten</font></a></div>
		</div>
	</li>
	<li>
		<a href="verenigingenlijst.php" class="drop" class = "button">Verenigingen</a>
		<div class="dropdown">
			<div><a href="verenigingenlijst.php" class="button">Overzicht<br /><font>Een lijst van alle verenigingen</font></a></div>
			<div><a href="registrerenvereniging.php" class="button">Registreer<br /><font>Voeg een vereniging toe</font></a></div>
		</div>
	</li>
	<li>
		<a href="overzichtevenementen.php" class="drop" class = "button">Evenementen</a>
		<div class="dropdown">
			<div><a href="overzichtevenementen.php" class="button">Overzicht<br /><font>Een lijst van alle evenementen</font></a></div>
			<div><a href="evenementtoevoegen.php" class="button">Toevoegen<br /><font>Een evenement toevoegen</font></a></div>
		</div>
	</li>
	<?php if(isAdmin()){ ?>
	<li>
		<a href="beheer.php" class="drop" class = "button">Beheer</a>
		<div class="dropdown">
			<div><a href="raadpleegevenementcategorieen.php" class="button">Categoriën<br /><font>Overzicht van categoriën</font></a></div>
			<div><a href="rapport.php" class="button">Rapport<br /><font>Rapporten opvragen</font></a></div>
		</div>
	</li>
	<?php } ?>
	
	
	<li class="align_right">
		<?php
			if(isMember()){
		?>
		<a href="#" class="drop">Ingelogd</a>
		<div id="login" class="dropdown">
			<div><a href="raadplegenprofiel.php" class="button">Profiel<br /><font>Je eigen profiel</font></a></div>
			<div><a href="login.php?logout=true" class="button">Uitloggen<br /><font>De verbinding verbreken</font></a></div>
		</div>
		<?php
			} else {
		?>
		<a href="#" class="drop">Inloggen</a>
		<div id="login" class="dropdown">
			<h4>Inloggen:</h4>
			<form action="<?php print($_SERVER["PHP_SELF"]); ?>" method="post">
				<input type="text" name="username" class="text" /><br />
				<input type="password" name="password" class="pass" />
				<input type="submit" name="login" value="Ga!" class="submit" />
			</form><br /><br />
			Geen account? <a href="#" class="login">Registreer!</a>
			<div><a href="registreer.php" class="button">Registreer<br /><font>Wordt lid!</font></a></div>
		</div>
		<?php } ?>
	</li>
</ul>