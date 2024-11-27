<?php
include 'includes/db_connection.php';
session_start();

// Protezione dalla non autenticazione
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Controllo se l'ID è presente nella richiesta
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Conversione in numero per sicurezza

    // Query per eliminare la persona
    $sql = "DELETE FROM persons WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: view_persons.php?success=1"); // Ritorna alla pagina con un messaggio di successo
        exit;
    } else {
        header("Location: view_persons.php?error=1"); // Ritorna alla pagina con un messaggio di errore
        exit;
    }
} else {
    header("Location: view_persons.php?error=1"); // Ritorna alla pagina se l'ID non è valido
    exit;
}
?>
