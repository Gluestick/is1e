<?php

if (isset($_POST["informatie"])) {
	if (!empty($_POST["informatie"])) {
		if (strstr($_POST["informatie"], "_")) {
			$info = explode("_", $_POST["informatie"]);
			if (intval($info[1])) {
				
				switch ($info[0]) {
					case "bericht":
						$recipient = "";
						break;
					case "reactie":
						$recipient = "";
						break;
					case "profielbericht":
						$recipient = "";
						break;
				}
				
				database::getInstantie();
				$query = "SELECT * FROM ".$info[0]." WHERE ".$info[0]."id = ".$info[1].";";
				$resultaat_van_server = mysql_query($query);
				$array = mysql_fetch_assoc($resultaat_van_server);
				var_dump($array);
			}
		}
	}
}

?>