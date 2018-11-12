<?php
	date_default_timezone_set('America/Los_Angeles');

	require_once("../resources/php/twilio/Twilio/autoload.php");
	include("../resources/php/base.php");
	
	if(mysqli_connect_errno()) { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }

	$sql = "SELECT * FROM users WHERE id = '".$_GET["id"]."'";

	if ($result = mysqli_query($db, $sql)) {
		$user_info = mysqli_fetch_array($result, MYSQLI_ASSOC);
		echo json_encode($user_info);
		mysqli_free_result($result);
	}

	mysqli_close($db);
	

	// Send notification to user that their data was looked up
	
	$name = explode(" ", $user_info["name"]);
	$first_name = $name[0];

	if($_GET['referrer'] != "") {
		$referrer = str_replace("https://", "", $_GET['referrer']);
		$referrer = str_replace("http://", "", $referrer);

		$referrer = explode("/", $referrer);
		$referrer_domain = $referrer[0];
		
		$message_body = $first_name.", your data was used by ".$referrer_domain." on ".date("F j, Y")." at ".date("g:ia").".";
	} else {
		$message_body = $first_name.", your data was used on ".date("F j, Y")." at ".date("g:ia").".";
	}
	
	$message = $twilio->messages
		->create("+1 ".$user_info["phone_number"], // to
			array(
				"body" => $message_body,
				"from" => $twilio_from_number
			)
		);
?>
