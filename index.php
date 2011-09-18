<?php
	/**
	* @author: Kay van Bree
	* @description: 
	*/
	$pagina = pagina::getInstantie();
	
	$pagina->setTitel("Eventplaza");
	$pagina->setCss("style.css");
	
	echo $pagina->getVereisteHTML();
?>
<div id="container">
<?php
	echo $pagina->getHeader();
?>
	<div id="page">
<?php
		echo $pagina->getMenu();
?>
		<div id="content">
			<h1><?php echo $pagina->getTitel(); ?></h1>
			<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur aliquet tempus ante. 
			Nam lorem ante, congue non, vulputate a, condimentum vel, neque. Donec ultricies tincidunt est. 
			Aenean fermentum porta neque. Vestibulum nisl pede, commodo et, vestibulum nec, sollicitudin eget, 
			pede. Vestibulum laoreet euismod lectus. Etiam placerat suscipit diam. Phasellus semper bibendum 
			est. Duis accumsan ipsum id odio. Aliquam sed mauris non nibh commodo dictum. Aenean vitae eros 
			vitae velit posuere mattis. Nullam tempus pulvinar felis. Suspendisse potenti. Proin ante metus, 
			gravida sit amet, lacinia sit amet, scelerisque et, magna. Nunc tempus.</p>
		</div>
	</div>
<?php
	echo $pagina->getFooter();
?>
</div>
<?php
	echo $pagina->getVereisteHTMLafsluiting();