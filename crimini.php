<?php
include 'connessione.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete_id"])) {
    $id = $_POST["delete_id"];
    $conn->query("DELETE FROM crimini WHERE id = $id");
    header("Location: crimini.php");
}

$result = $conn->query("SELECT * FROM crimini");
?>
<?php
session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Reindirizza alla pagina di login
    exit;
}
?>


<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Elenco Crimini</title>
</head>
<body>
    <h1>Lista Crimini</h1>
    <ul>
        <?php while($row = $result->fetch_assoc()): ?>
            <li>
                Data: <?= $row['data'] ?> - Tipo: <?= $row['tipo'] ?> - Descrizione: <?= $row['descrizione'] ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?= $row['id'] ?>">
                    <button type="submit">Rimuovi</button>
                </form>
            </li>
        <?php endwhile; ?>
    </ul>

    <a href="aggiungi_crimine.php">Aggiungi un nuovo crimine</a>
</body>
</html>
