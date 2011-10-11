<?php
	/*
	 * @author: Kay van Bree
	 * @desc: Registratie, login classes
	 */

	class registreer {
		private static $instantie;
		
		private function __construct(){}
		
		public static function getInstantie(){
			if(!self::$instantie){
				self::$instantie = new self();
			}
			return self::$instantie;
		}
		
		public function maakGebruiker(){
			/****** escape alle waarden *****/
			database::getInstantie();
			
			$studentid = mysql_real_escape_string($_POST['studentid']);
			$gebruikersnaam = mysql_real_escape_string($_POST['gebruikersnaam']);
			$email = mysql_real_escape_string($_POST['email']);
			$pass1 = mysql_real_escape_string($_POST['pass1']);
			$pass2 = mysql_real_escape_string($_POST['pass2']);
			$voornaam = mysql_real_escape_string($_POST['voornaam']);
			$achternaam = mysql_real_escape_string($_POST['achternaam']);
			$studentnr = mysql_real_escape_string($_POST['studentnr']);
			$geboortedatum = mysql_real_escape_string($_POST['geb_dat']);
			$geslacht = mysql_real_escape_string($_POST['geslacht']);
			$adres = mysql_real_escape_string($_POST['adres']);
			$postcode = mysql_real_escape_string($_POST['postcode']);
			$woonplaats = mysql_real_escape_string($_POST['woonplaats']);
			
			/**** Check waarden *****/
			$error = "<ul>";
			$bericht = "";
			
			if(!isset($gebruikersnaam)){
				$error .= "<li>U heeft geen gebruikersnaam ingevuld.</li>";
			} else {
				if(strlen($gebruikersnaam) < 3){
					$error .= "<li>Je gebruikersnaam moet minstens 3 letters/cijfers bevatten.</li>";
				}
				if($this->checkDubbel("user", $gebruikersnaam, "username")){
					$error .= "<li>De gebruikersnaam is al in gebruik.</li>";
				}
			}
			
			if(!isset($email)){
				$error .= "<li>U heeft geen e-mailadres ingevuld.</li>";
			} else {
				if(preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $email)){
					if($this->checkDubbel("user", $email, 'email')){
					$error .= "<li>Dit e-mailadres is al in gebruik.</li>";
					}
				} else {
					$error .= "<li>U heeft geen geldig e-mailadres ingevuld.</li>";
				}
			}
			
			if(!isset($pass1) || !isset($pass2)){
				$error .= "<li>U heeft minstens 1 keer geen wachtwoord ingevuld.</li>";
			} else {
				if($pass1 != $pass2){
					$error .= "<li>Uw wachtwoorden komen niet overeen.</li>";
				}
			}
			
			if(!isset($_POST['studentnr'])){
				$studentnr = NULL;
			} elseif(!preg_match("/s{1}[0-9]{7}/", $studentnr)){
					$error .= "<li>Je studentnummer moet beginnen met een s en 7 cijfers bevatten.</li>";
			}
			
			
			/***** Check voor error *****/
			if($error != "<ul>"){
				// Errormessage
				$error .= "</ul>";
				$bericht = "Het is niet gelukt om te registreren. Het systeem gaf de volgende foutmeldingen:<br />";
				$bericht .= $error;
			} else {
				//geen error
				$salt = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,32);
				$activation = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,32);
				$role = NULL;
				
				$password = md5($pass1 . "" . $salt);

				$query = "INSERT INTO `student` (`studentId`, `studentnr`, `voornaam`, `achternaam`, `adres`, `postcode`, `woonplaats`, `geslacht`, `geboortedatum`)
										VALUES ('$studentid', '$studentnr', '$voornaam', '$achternaam', '$adres', '$postcode', '$woonplaats', '$geslacht', '$geboortedatum');";
				$query2 = " INSERT INTO user (username, password, salt, activation, email, role, studentId)
										VALUES ('$gebruikersnaam', '$password', '$salt', '$activation', '$email', '$role', '$studentid');";
				mysql_query($query) or die(mysql_error() . $query);
				mysql_query($query2) or die(mysql_error() . $query2);
				$bericht = "<p>U bent succesvol geregistreerd. Binnen 24 uur ontvangt u een mail met daarin de activatie-code.";
				$bericht .= "Na het activeren kunt u inloggen. Klik <a href=\"index.php\">hier</a> om terug naar de home-pagina te gaan.</p>";
			}
			
			return $bericht;
		}
		
		
		/****** Kijkt of er van de ingevoerde waarde al een waarde bestaat in een bepaald veld *****/
		private function checkDubbel($tabel, $waarde, $veldnaam){
			database::getInstantie();
			$query = "SELECT $veldnaam FROM `$tabel` WHERE `$veldnaam` = '$waarde';";
			$result = mysql_query($query) or die(mysql_error());
			$error = FALSE;
			if(mysql_num_rows($result) > 0){
				$error = TRUE;
			}
			return $error;
		}
		
		/***** Return het hoogste studentnr + 1 ******/
		public function getStudentId(){
			database::getInstantie();
			$query = "SELECT max(studentId) as maxId FROM `student`;";
			$result = mysql_query($query) or die(mysql_error());
			print(mysql_result($result, 0) + 1);
		}
	}
	
	class login {
		private static $instantie;
		private $connection;
		
		private function __construct(){
			$this->connection = database::getInstantie();
		}
		
		public static function getInstantie(){
			if(!self::$instantie){
				self::$instantie = new self();
			}
			return self::$instantie;
		}
		
		public function login(){
			$username = mysql_real_escape_string($_POST['username']);
			$pass1 = mysql_real_escape_string($_POST['password']);
			$salt = $this->getSalt($username);
			$password = md5($pass1 . "" . $salt);
			
			$error = "<ul>";
			if(!isset($_POST['username'])){
				$error .= "<li>Geen gebruikersnaam ingevuld</li>";
			}
			if(!isset($_POST['password'])){
				$error .= "<li>Geen wachtwoord ingevuld</li>";
			}
			if(!$this->checkUser($username, $password)){
				$error .= "<li>Er is geen geldige combinatie van gebruikersnaam en wachtwoord gevonden!</li>";
			}
			
			if($error != "<ul>"){
				$error .= "</ul>";
				header('Location: login.php?error='.$error.'');
			} else {
				$_SESSION['username'] = $username;
				$_SESSION['login'] = TRUE;
			}
		}
		
		private function checkUser($username, $password){
			$query = "SELECT `username` FROM `user` WHERE `username` = '$username' AND `password` = '$password';";
			$result = mysql_query($query);
			if(mysql_num_rows($result) == 1){
				return TRUE;
			} else {
				return FALSE;
			}
		}
		
		private function getSalt($username){
			$query = "SELECT `salt` FROM `user` WHERE `username` = '$username';";
			$result = mysql_query($query);
			if(mysql_num_rows($result) < 1){
				$salt = "Error, no '$username' not found.";
			} else {
				$row = mysql_fetch_assoc($result);
				$salt = $row['salt'];
			}				
			return $salt;
		}
	}
