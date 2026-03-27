<?php

try {
    // Maak verbinding met de 'npo' database
    $connnpo = new PDO("mysql:host=$hostname;dbname=$databasenpo", $username, $password);
    $connnpo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Maak verbinding met de 'web' database
    $connweb = new PDO("mysql:host=$hostname;dbname=$databaseweb", $username, $password);
    $connweb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Fout bij database connectie: " . $e->getMessage());
}

?>
