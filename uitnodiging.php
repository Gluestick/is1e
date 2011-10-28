<?php
if (!isset($_POST["action"])) {
	if (isset($_POST["studentid"]) && !empty($_POST["studentid"]) && intval($_POST["studentid"]) && isset($_POST["groepid"]) && !empty($_POST["groepid"]) && intval($_POST["groepid"])) {	
		database::getInstantie();
		$query = "INSERT INTO groeplid (groepid, studentid, lid) VALUES (".$_POST["groepid"].", ".$_POST["studentid"].", 0)";
		$resultaat = mysql_query($query);
		if ($resultaat) {
			echo "Deze persoon is uitgenodigd.";
		}
	}
} else if (isset($_POST["action"])) {
	if (isset($_POST["groepid"]) && !empty($_POST["groepid"]) && intval($_POST["groepid"])) {	
		database::getInstantie();
		if ($_POST["action"] == "Accepteren") {
			$query = "UPDATE groeplid SET lid=1 WHERE groepid=".$_POST["groepid"]." AND studentid = ".$_POST["studentid"];
			mysql_query($query);
		} else {
			$query = "DELETE FROM groeplid WHERE groepid = ".$_POST["groepid"]." AND studentid = ".$_SESSION["studentid"];
			$resultaat = mysql_query($query);
		}
	}
}
?>