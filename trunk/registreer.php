<?php
	/**
	* @author: Kay van Bree
	* @description: Op deze pagina kunnen mensen zich registreren om lid te worden van de website.
	*				Er wordt informatie ingevoerd en deze wordt door middel van PHP_SELF op dezelfde
	*				pagina verwerkt. Met het verwerken wordt er een rij in de tabel Gebruikers aangemaakt.
	*/

	if(isset($_SESSION['login'])){
		header('Location: index.php');
	}
	
	$pagina = pagina::getInstantie();

	$pagina->setTitel("Registreren");
	$pagina->setCss("style.css");

	echo $pagina->getVereisteHTML();
	print("<div id=\"container\">");
	echo $pagina->getHeader();
	print("<div id=\"page\">");
	echo $pagina->getMenu(); 
	print("<div id=\"content\">");
	print("<h1>" . $pagina->getTitel() . "</h1>");
	
	//Registratie
	$registreer = registreer::getInstantie();
	if(isset($_POST['submit'])){
		$registreer->maakGebruiker();
	}
	$registreer->getForm();
	
	print("</div></div>");
	echo $pagina->getFooter();
	print("</div>");
	echo $pagina->getVereisteHTMLafsluiting();
?>