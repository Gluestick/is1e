<?php
    /*
     * @author: Kay van Bree
     * @desc: Mijn kijk op het gebruik van een pageBuilder.
     */

	 $title = "Home";
	 $css = "style.css";

	 include("inc/pagebuilder.php");
	 $build = new pageBuilder();
	 $build->getHeader($title, $css);
?>
	<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Curabitur aliquet tempus ante. 
	Nam lorem ante, congue non, vulputate a, condimentum vel, neque. Donec ultricies tincidunt est. 
	Aenean fermentum porta neque. Vestibulum nisl pede, commodo et, vestibulum nec, sollicitudin eget, 
	pede. Vestibulum laoreet euismod lectus. Etiam placerat suscipit diam. Phasellus semper bibendum 
	est. Duis accumsan ipsum id odio. Aliquam sed mauris non nibh commodo dictum. Aenean vitae eros 
	vitae velit posuere mattis. Nullam tempus pulvinar felis. Suspendisse potenti. Proin ante metus, 
	gravida sit amet, lacinia sit amet, scelerisque et, magna. Nunc tempus.</p>
	
<?php
	$build->getFooter();
?>