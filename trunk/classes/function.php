<?php

/**
 * Losse functies
 * 
 * @author: Kay van Bree
 */

/**
 * Returns true als er iemand in is gelogd.
 * @return boolean
 */
function isMember(){
	if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
		return true;
	} else {
		return false;
	}
}

/**
 * Returns true als de gebruiker admin is.
 * @return boolean 
 */
function isAdmin(){
	if (isMember() && $_SESSION['role'] == 1) {
		return true;
	} else {
		return false;
	}
}

/**
 * Returns true als de gebruiker een student is.
 */
function isStudent(){
	if (isMember() && isset($_SESSION['studentid'])) {
		return true;
	} else {
		return false;
	}
}

/**
 * Controleert of iemand de gegevens
 */
function isHimSelf(){
	if ($_GET['id'] != $_SESSION['user_id']) {
		header('Location: index.php');
	}
}

function isVereniging(){
	if(isset($_SESSION['verenigingid']) && $_SESSION['login'] == true){
		return true;
	} else {
		return false;
	}
}

function isThisVereniging(){
	if($_GET['id'] != $_SESSION['verenigingid']){
		header('Location: index.php');
	}
}

?>