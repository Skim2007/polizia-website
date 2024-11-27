<?php
include 'includes/db_connection.php';

// Controlla che sia stato passato un ID valido tramite l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepara la query per eliminare il crimine
    $sql = "DELETE FROM crimes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    // Esegue la query e controlla se ha successo
    if ($stmt->execute()) {
        // Reindirizza alla pagina di visualizzazione dei crimini
        header("Location: view_crimes.php");
        exit;
    } else {
        echo "Errore nell'eliminazione del crimine.";
    }

    $stmt->close();
} else {
    echo "ID non valido.";
}

$conn->close();
?>
<?php
session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Reindirizza alla pagina di login
    exit;
}
?>
