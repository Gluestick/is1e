<?php

/**
 * @author: Kay van Bree
 * 
 * Tot nu toe wordt je alleen naar login.php doorverwezen als het inloggen fout gaat.
 */

	if(isset($_GET['logout'])){
		if($_GET['logout'] == TRUE){
			session_destroy();
			header('Location: index.php');
		}
	}
	
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
	
	$login = login::getInstantie();
	$login->login();
?>



<?php	
	print("</div></div>");
	echo $pagina->getFooter();
	print("</div>");
	echo $pagina->getVereisteHTMLafsluiting();
?>
	

