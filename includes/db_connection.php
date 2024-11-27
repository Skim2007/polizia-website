<?php
$servername = "localhost";
$username = "root";
$password = ""; // Lascia vuoto se non hai impostato una password
$dbname = "polizia"; // Assicurati che questo sia il nome corretto del tuo database

// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>
