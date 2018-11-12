<?php
	if(	$_SERVER["REMOTE_ADDR"] == "localhost" ||
		$_SERVER["REMOTE_ADDR"] == "leo.local" ||
		$_SERVER["REMOTE_ADDR"] == "::1" ||
		strpos($_SERVER["REMOTE_ADDR"], '192.168.1') !== false
	) {
		include("../../secrets/db-config.php");
		include("../../secrets/twilio-setup.php");
	} else {		
		require_once("twilio/Twilio/autoload.php");
		use Twilio\Rest\Client;

		$sid = getenv("TWILIO_SID");
		$token = getenv("TWILIO_TOKEN");
		$twilio = new Client($sid, $token);

		$twilio_from_number = "+1".getenv("TWILIO_NUMBER");

		$url = parse_url(getenv("CLEARDB_DATABASE_URL"));

		$server = $url["host"];
		$username = $url["user"];
		$password = $url["pass"];
		$database = substr($url["path"], 1);

		$db = mysqli_connect($server, $username, $password, $database);
	}
	
	mysqli_set_charset($db, "utf8");		
?>