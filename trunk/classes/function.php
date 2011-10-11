<?php
	/**
	 * Losse functies
	 * 
	 * @author: Kay van Bree
	 */
	 
	 /**
	  * Returns true als er iemand in is gelogd.
	  * @return type 
	  */
	 function isMember(){
		if(isset($_SESSION['login']) && $_SESSION['login'] == true){
			 return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Returns true als de gebruiker admin is.
	 * @return type 
	 */
	function isAdmin(){
		if(isMember() && $_SESSION['role'] == 1){
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Returns true als de gebruiker een student is.
	 */
	function isStudent(){
		if(isMember() && isset($_SESSION['studennr'])){
			return true;
		} else {
			return false;
		}
	}
?>