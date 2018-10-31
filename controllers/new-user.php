<?php
	include("../resources/php/base.php");
	
	if(mysqli_connect_errno()) { echo "Failed to connect to MySQL: " . mysqli_connect_error(); }
	
	foreach($_POST as $key => $value) {
	  $form_data[$key] = mysqli_real_escape_string($db, $value);
	}
	
	// Insert new user into the database
	
	mysqli_query($db,
		"INSERT INTO users (
			`name`,
			`phone_number`,
			`email_address`,
			`street_address_1`,
			`street_address_2`,
			`address_city`,
			`address_state`,
			`address_zip`,
			`birth_date`,
			`notes`
		) 
		VALUES (
			'".$form_data["name"]."',
			'".$form_data["phone_number"]."',
			'".$form_data["email_address"]."',
			'".$form_data["street_address_1"]."',
			'".$form_data["street_address_2"]."',
			'".$form_data["address_city"]."',
			'".$form_data["address_state"]."',
			'".$form_data["address_zip"]."',
			'".$form_data["birth_date"]."',
			'".$form_data["notes"]."'
		)");
	
	$new_user_id = mysqli_insert_id($db);
	mysqli_close($db);
	
	
	// Send QR code to inputted phone number	
	include("../../secrets/twilio-setup.php");

	$message = $twilio->messages
		->create("+1 ".$form_data["phone_number"], // to
			array(
				"body" => "Hi ".$form_data["name"].", you're signed up with AJC! Use this QR code to sign in to other services.",
				"from" => $twilio_from_number,
				"mediaUrl" => $server."/cfa/portable-profile/git/controllers/generate-qr-code.php?id=".$new_user_id
			)
		);
	
	header("Location: ../");
?>