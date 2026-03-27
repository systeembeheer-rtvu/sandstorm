<?php
	$obj = array();
	
	$obj['template'] = "protocol-telefonie-1.rtf";
	$obj['naam'] = "Contract protocol telefonie-1 (telefoon vanuit RTV Utrecht)";
	$obj['actief'] = TRUE;
	
	function AddItem($veld,$omschrijving,$default) {
			$item = array();
			$item['veld'] = $veld;
			$item['omschrijving'] = $omschrijving;
			$item['default'] = $default;
			return $item;
		
	}
	
	$fields = array();
	
	$fields[] = AddItem("naam","Naam gebruiker","");
	$fields[] = AddItem("datum","Datum contract","");
	$fields[] = AddItem("gebruikerscategorie","Gebruikers categorie (A/B/C)","");
	$fields[] = AddItem("merk","Merk telefoon","");
	$fields[] = AddItem("type","Type telefoon","");
	$fields[] = AddItem("imei","IMEI nummer","");
	$fields[] = AddItem("toebehoren","Toebehoren telefoon (wat bij de telefoon zelf zit zoals laadkabel)","Laadkabel");
	$fields[] = AddItem("accesoires","Extra accesoires (bv lader, oortjes)","");
	
	$obj['fields'] = array_values($fields);
	
	echo json_encode($obj,JSON_FORCE_OBJECT|JSON_PRETTY_PRINT);


?>