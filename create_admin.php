<?php
// Connessione al database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "polizia";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Dati dell'admin
$username = "Simone";
$password = "2707";  // Cambia questa password
$role = "admin";

// Hash della password
$password_hash = password_hash($password, PASSWORD_BCRYPT);

// Inserimento dell'utente nel database
$sql = "INSERT INTO utenti (username, password_hash, role) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $password_hash, $role);

if ($stmt->execute()) {
    echo "Utente admin creato con successo!";
} else {
    echo "Errore: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
