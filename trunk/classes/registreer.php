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
			
			$studentid = strtolower(mysql_real_escape_string($_POST['studentid']));
			$gebruikersnaam = strtolower(mysql_real_escape_string($_POST['gebruikersnaam']));
			$email = mysql_real_escape_string($_POST['email']);
			$pass1 = mysql_real_escape_string($_POST['pass1']);
			$pass2 = mysql_real_escape_string($_POST['pass2']);
			$voornaam = mysql_real_escape_string($_POST['voornaam']);
			$achternaam = mysql_real_escape_string($_POST['achternaam']);
			$studentnr = mysql_real_escape_string($_POST['studentnr']);
			$geboortedatum = mysql_real_escape_string(tijd::formatteerTijd($_POST['geb_dat'], "Y-m-d"));
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
			
			if(empty($_POST['studentnr'])){
				$studentnr = NULL;
			} elseif(!preg_match("/[sS]{1}[0-9]{7}/", $studentnr)){
					$error .= "<li>Je studentnummer moet beginnen met een s en 7 cijfers bevatten.</li>";
			}
			
			
			/***** Check voor error *****/
			if($error != "<ul>"){
				// Errormessage
				$error .= "</ul>";
				$bericht = "Het is niet gelukt om te registreren. Het systeem gaf de volgende foutmeldingen:<br />";
				$bericht .= $error;
				return $bericht;
			} else {
				//geen error
				$salt = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,32);
				$activation = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,32);
				$role = NULL;
				
				$password = md5($pass1 . "" . $salt);
				
				$query2 = " INSERT INTO user (username, password, salt, activation, email, role)
										VALUES ('$gebruikersnaam', '$password', '$salt', '$activation', '$email', '$role');";
				mysql_query($query2) or die(mysql_error() . $query2);
				$row = mysql_fetch_assoc(mysql_query("SELECT last_insert_id() as userid FROM user;"));
				$userid = $row['userid'];
				$query = "INSERT INTO `student` (`studentnr`, `voornaam`, `achternaam`, `adres`, `postcode`, `woonplaats`, `geslacht`, `geboortedatum`, `userid`)
									VALUES ('$studentnr', '$voornaam', '$achternaam', '$adres', '$postcode', '$woonplaats', '$geslacht', '$geboortedatum', '$userid');";
				mysql_query($query) or die(mysql_error() . $query);
				?>
					<script type="text/javascript">
						setTimeout("location.href='./index.php'", 5000);
					</script>
					<h3>Succesvol geregistreerd!</h3>
					Wacht 5 seconden of <a href="index.php">klik hier</a> om naar de homepage te gaan<p/>
				<?php	
			
			}
		}
		
		
		/****** Kijkt of er van de ingevoerde waarde al een waarde bestaat in een bepaald veld *****/
		public function checkDubbel($tabel, $waarde, $veldnaam){
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
?>
