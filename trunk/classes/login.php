<?php

/*
 * @author: Kay van Bree
 */

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
			if(isset($_POST['login'])){
				$username = strtolower(mysql_real_escape_string($_POST['username']));
				$pass1 = mysql_real_escape_string($_POST['password']);
				$salt = $this->getSalt($username);
				$password = md5($pass1 . "" . $salt);

				if(empty($_POST['username'])){
					$error['username_leeg'] = "Geen gebruikersnaam ingevuld";
				}
				if(empty($_POST['password'])){
					$error['wachtwoord_leeg'] = "Geen wachtwoord ingevuld";
				}
				if(!isset($error)){
					if($this->checkUser($username, $password) != true){
						$error['geen_combinatie'] = "Er is geen geldige combinatie van gebruikersnaam en wachtwoord gevonden!";
					}
				}
			
				if(!isset($error)){
					$query =   "SELECT U.user_id as user_id, S.studentid as studentid, U.role as role, S.studentnr as studentnr, V.verenigingid as verenigingid
								FROM user U 
								LEFT JOIN student S ON (U.user_id = S.userid)
								LEFT JOIN vereniging V ON (U.user_id = V.userid) 
								WHERE U.username = '$username';";
					$result = mysql_query($query) or die(mysql_error());
					if(mysql_num_rows($result) < 1){
						die('De username is niet in de database gevonden: <br />' . $query);
					}
					$row = mysql_fetch_assoc($result);
					if($result == true){
						$studentnr = $row['studentnr'];
						if(isset($studentnr)){
							$_SESSION['studentnr'] = $studentnr;
							$_SESSION['studentid'] = $row['studentid'];
						}
						$verenigingid = $row['verenigingid'];
						if(isset($verenigingid)){
							$_SESSION['verenigingid'] = $verenigingid;
						}
						$_SESSION['user_id'] = $row['user_id'];
						$_SESSION['role'] = $row['role'];
						$_SESSION['username'] = $username;
						$_SESSION['login'] = TRUE;
						
						if(isset($_POST['url'])){
							header('Location: ' . $_POST['url']);
						} else {
							header('Location: index.php');
						}
					}
				} else {
					print("<b>Inloggen mislukt:</b><br />");
					foreach($error as $key => $value){
						print("- " . $value . "<br />");
					}
					print("Probeer het nog eens of ga naar de <a href=\"registreer.php\">registratie-pagina</a>.<br /><br />");
					$this->getForm();
				}
			} else {
				$this->getForm();
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
		
		public function getForm(){
?>
			Username + Password:
			<div class="form">
				<form action="login.php" method="post">
				<input type="text" name="username" class="text" /><br />
				<input type="password" name="password" class="pass" />
				<input type="submit" name="login" value="Ga!" class="submit" />

			</form>
<?php
		}
	}
?>
