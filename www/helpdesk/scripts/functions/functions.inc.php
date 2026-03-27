<?php
	function createPassword($length) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$password = '';
		$length = 8;
		
		$max = strlen($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$password .= $characters[rand(0, $max)];
		}
		
		return $password;    
	}
?>