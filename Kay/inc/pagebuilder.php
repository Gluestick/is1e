<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
	class pageBuilder {
		private static $pageBuilder;
		 
		private static function ___construct(){}
		
		private static function getInstance(){
			if (!self::$instantie) {
				self::$instantie = new self();
			}
			return self::$instantie;
		}
		public function getHeader($title, $css){
			$pageTitle = $title;
			$pageCSS = $css;
			include("inc/header.php");
        }
		
		public function getFooter(){
				include "inc/footer.php";
		}
     }
?>
