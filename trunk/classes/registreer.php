<?php
	/*
	 * @author: Kay van Bree
	 * @desc: Registratie, login classes
	 */

	class registreer {
		private static $instantie;
		private $error;
		private $gebruikersnaam;
		private $email;
		private $voornaam;
		private $geboortedatum;
		private $achternaam;
		private $studentnr;
		private $adres;
		private $postcode;
		private $woonplaats;
		
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
			$geboortedatum = mysql_real_escape_string($_POST['geb_dat']);
			if(!empty($_POST['geslacht'])){ $geslacht = mysql_real_escape_string($_POST['geslacht']); }
			$adres = mysql_real_escape_string($_POST['adres']);
			$postcode = mysql_real_escape_string($_POST['postcode']);
			$woonplaats = mysql_real_escape_string($_POST['woonplaats']);
			
			$this->error = null;
			
			/**** Check waarden *****/			
			if(empty($gebruikersnaam)){
				$this->error['gebruikersnaam'] = "U heeft geen gebruikersnaam ingevuld.";
			} elseif(strlen($gebruikersnaam) < 3){
				$this->error['gebruikersnaam'] = "Je gebruikersnaam moet minstens 3 letters/cijfers bevatten.";
			} elseif($this->checkDubbel("user", $gebruikersnaam, "username")){
				$this->error['gebruikersnaam'] = "De gebruikersnaam is al in gebruik.";
			}
			
			if(empty($email)){
				$this->error['email'] = "U heeft geen e-mailadres ingevuld.";
			} elseif(!preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $email)){
				$this->error['email'] = "Dit is geen geldig e-mailadres.";
			} elseif($this->checkDubbel("user", $email, 'email')){
				$this->error['email'] = "Dit e-mailadres is al in gebruik.";
			}
			
			if(empty($pass1)){
				$this->error['pass1'] = "Vul hier je wachtwoord in.";
			} elseif(empty($pass2)){
				$this->error['pass2'] = "Vul hier je wachtwoord een 2e keer in.";
			} elseif($pass1 != $pass2){
				$this->error['pass1'] = "Uw wachtwoorden komen niet overeen.";
			}
			
			if(empty($studentnr)){
				$this->error['studentnr'] = "Je moet een studentnummer invoeren.";
			} elseif(!preg_match("/[sS]{1}[0-9]{7}/", $studentnr)){
				if(preg_match("/[0-9]{7}/", $studentnr)){
					$studentnr = ("s" . $studentnr);
				} else {
					$this->error['studentnr'] = "Je studentnummer moet beginnen met een s en 7 cijfers bevatten.";
				}
			}
			
			if(empty($geslacht)){
				$this->error['geslacht'] = "Geen geslacht!?";
			}
			
			$today = date('Y-m-d');
			if(empty($geboortedatum)){
				$this->error['geboortedatum'] = "Geen geboortedatum ingevuld.";
			} elseif(!preg_match("/[0-9]{2}-[0-9]{2}-[0-9]{4}/", $geboortedatum)){
				$this->error['geboortedatum'] = "Je geboortedatum moet als volgt worden ingevuld: dd-mm-yyyy.";
			} elseif(tijd::formatteerTijd($geboortedatum, 'Y-m-d') > $today){
				$this->error['geboortedatum'] = "De ingevulde geboortedatum ligt in de toekomst.";
			}	
			
			if(!empty($this->error)){
				$this->gebruikersnaam = $gebruikersnaam;
				$this->email = $email;
				$this->geboortedatum = $geboortedatum;
				$this->voornaam = $voornaam;
				$this->achternaam = $achternaam;
				$this->studentnr = $studentnr;
				$this->adres = $adres;
				$this->postcode = $postcode;
				$this->woonplaats = $woonplaats;
			} else {
				//geen error
				$salt = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,32);
				$activation = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,32);
				$role = NULL;
				$geboortedatum = tijd::formatteerTijd($geboortedatum, 'Y-m-d');
				
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
			$this->error = FALSE;
			if(mysql_num_rows($result) > 0){
				$this->error = TRUE;
			}
			return $this->error;
		}
		
		/***** Return het hoogste studentnr + 1 ******/
		public function getStudentId(){
			database::getInstantie();
			$query = "SELECT max(studentId) as maxId FROM `student`;";
			$result = mysql_query($query) or die(mysql_error());
			print(mysql_result($result, 0) + 1);
		}
		
		public function getForm(){
?>
	<p>Wil je ook lid worden van deze community? Vul hieronder je gegevens in.</p>
	<script type="text/javascript">
		function clearElements(el) {
			var x, y, type = null, object = [];
			object[0] = document.getElementById(el).getElementsByTagName('input');
			for (x = 0; x < object.length; x++) {
				for (y = 0; y < object[x].length; y++) {
					type = object[x][y].type;
					switch (type) {
						case 'text':
							object[x][y].value = '';
							break;
					}
				}
			}
		}
	</script>
	<form action="<?php print($_SERVER['PHP_SELF']); ?>" method="post" id="registratie">
		<table>
			<tr><td colspan="2"><b>Inlog-informatie:</b></td></tr>
			<tr>
				<td>*</td>
				<td>Gebruikersnaam:</td>
				<td>
					<input type="text" name="studentid" hidden="hidden" value="<?php $this->getStudentId(); ?>" />
					<input type="text" name="gebruikersnaam" <?php if(isset($_POST['submit'])){ print("value=\"" . $this->gebruikersnaam . "\""); } ?> />
				</td>
				<td><?php if(isset($this->error['gebruikersnaam'])){ print $this->error['gebruikersnaam']; } ?></td>
			</tr>
			<tr>
				<td>*</td>
				<td>E-mailadres:</td>
				<td><input type="text" name="email" <?php if(isset($_POST['submit'])){ print("value=\"" . $this->email . "\""); } ?> /></td>
				<td><?php if(isset($this->error['email'])){ print $this->error['email']; } ?></td>
			</tr>
			<tr>
				<td>*</td>
				<td>Wachtwoord:</td>
				<td><input type="password" name="pass1" /></td>
				<td><?php if(isset($this->error['pass1'])){ print $this->error['pass1']; } ?></td>
			</tr>
			<tr>
				<td>*</td>
				<td>Opnieuw:</td>
				<td><input type="password" name="pass2" /></td>
				<td><?php if(isset($this->error['pass2'])){ print $this->error['pass2']; } ?></td>
			</tr>
			<tr><td colspan="2"><b>Gebruikers-informatie:</b></td></tr>
			<tr>
				<td>*</td>
				<td>Voornaam:</td>
				<td><input type="text" name="voornaam" <?php if(isset($_POST['submit'])){ print("value=\"" . $this->voornaam . "\""); } ?> /></td>
				<td><?php if(isset($this->error['voornaam'])){ print $this->error['voornaam']; } ?></td>
			</tr>
			<tr>
				<td>*</td>
				<td>Achternaam:</td>
				<td><input type="text" name="achternaam" <?php if(isset($_POST['submit'])){ print("value=\"" . $this->achternaam . "\""); } ?> /></td>
				<td><?php if(isset($this->error['achternaam'])){ print $this->error['achternaam']; } ?></td>
			</tr>
			<tr>
				<td>*</td>
				<td>Student-nummer:</td>
				<td><input type="text" name="studentnr" <?php if(isset($_POST['submit'])){ print("value=\"" . $this->studentnr . "\""); } ?> /></td>
				<td><?php if(isset($this->error['studentnr'])){ print $this->error['studentnr']; } ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Geboortedatum:</td>
				<td><input type="text" name="geb_dat" <?php if(isset($_POST['submit'])){ print("value=\"" . $this->geboortedatum . "\""); } ?> /></td>
				<td><?php if(isset($this->error['geboortedatum'])){ print $this->error['geboortedatum']; } ?></td>
			</tr>
			<tr>
				<td></td>
				<td>Geslacht:</td>
				<td><input type="radio" name="geslacht" value="Man" checked="checked" />Man <input type="radio" name="geslacht" value="Vrouw" />Vrouw</td>
				<td><?php if(isset($this->error['geslacht'])){ print $this->error['geslacht']; } ?></td>
			</tr>
			<tr><td colspan="2"><b>Adres-gegevens:</b></td></tr>
			<tr>
				<td></td>
				<td>Adres:</td>
				<td><input type="text" name="adres" <?php if(isset($_POST['submit'])){ print("value=\"" . $this->adres . "\""); } ?> /></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td>Postcode:</td>
				<td><input type="text" name="postcode" <?php if(isset($_POST['submit'])){ print("value=\"" . $this->postcode . "\""); } ?> /></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td>Woonplaats:</td>
				<td><input type="text" name="woonplaats" <?php if(isset($_POST['submit'])){ print("value=\"" . $this->woonplaats . "\""); } ?> /></td>
				<td></td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td><input type="button" name="reset_button" value="Herstellen"  onclick="clearElements('registratie')" /><input type="submit" name="submit" value="Verstuur" /></td>
				<td></td>
			</tr>

		</table>
	</form>
	<br />Velden met "*" zijn verplicht.
<?php
		}
	}
?>
