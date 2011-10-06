<?php
	session_start();

	include_once $_SERVER["DOCUMENT_ROOT"].'/project/classes/config.php';
	include_once $_SERVER["DOCUMENT_ROOT"].'/project/classes/database.php';
	include_once $_SERVER["DOCUMENT_ROOT"].'/project/classes/page.php';
	include_once $_SERVER["DOCUMENT_ROOT"].'/project/classes/login.php';
	include_once $_SERVER["DOCUMENT_ROOT"].'/project/classes/tijd.php';
	
	if(isset($_POST['login'])){
		$login = login::getInstantie();
		$login->login();
	}
?>
