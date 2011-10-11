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
			<?php if(!isMember()){ ?><div><a href="registreer.php" class="button">Registreer<br /><font>Wordt lid!</font></a></div><?php } ?>
		</div>
	</li>
	<li>
		<a href="vereniging.php" class="drop">Verenigingen</a>
		<div class="dropdown">
			<div><a href="#">Verenigingenlijst<p>Een lijst van alle verenigingen</p></a></div>
			<div><a href="#">Registreren<p>Registreer je vereniging</p></a></div>
		</div>
	</li>
	<li>
		<a href="evenement.php" class="drop">Evenementen</a>
		<div class="dropdown">
			<div><a href="#">Evenementenlijst<p>Een lijst van alle evenementen</p></a></div>
			<div><a href="#">Toevoegen<p>Voeg een evenement toe</p></a></div>
		</div>
	</li>
	<li>
		<a href="beheer.php" class="drop">Beheer</a>
		<div class="dropdown">
			<div><a href="#">Categorieen<p>Beheer categorieen</p></a></div>
			<div><a href="#">Managements-rapport<p>Vraag rapporten op</p></a></div>
		</div>
	</li>
	<li class="align_right">
		<?php
			if(isset($_SESSION['login'])){
		?>
		<a href="#" class="drop">Ingelogd</a>
		<div id="login" class="dropdown">
			<div><a href="profiel.php" class="button">Profiel<br /><font>Je eigen profiel</font></a></div>
			<div><a href="index.php?logout=true" class="button">Uitloggen<br /><font>De verbinding verbreken</font></a></div>
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
		</div>
		<?php } ?>
	</li>
</ul>