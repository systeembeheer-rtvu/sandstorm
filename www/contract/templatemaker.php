<?php
	$obj = array();
	
	$obj['template'] = "huurders.rtf";
	$obj['naam'] = "Brief voor bij tags huurders";
	$obj['actief'] = TRUE;
	
	$fields = array();
	$fields["voornaam"] = "Voornaam gebruiker";
	$fields['telefoonnummer'] = "Vast nummer gebruiker";
	$fields["wachtwoord"] = "Wachtwoord";
	
	
	$obj['fields'] = $fields;
	
	echo json_encode($obj,JSON_FORCE_OBJECT);
?>