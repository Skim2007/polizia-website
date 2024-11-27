<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'includes/db_connection.php';
include 'navbar.php';

// Protezione dalla non autenticazione
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Query per ottenere tutti gli utenti
$sql = "SELECT id, username, role FROM utenti";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $user_id = $_POST['delete_user_id'];
    $sql_delete = "DELETE FROM utenti WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: view_users.php?success=Utente eliminato con successo!");
    } else {
        header("Location: view_users.php?error=Errore durante l'eliminazione dell'utente.");
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestisci Utenti</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <h1>Gestisci Utenti</h1>

        <!-- Messaggi di feedback -->
        <?php if (isset($_GET['success'])): ?>
            <p class="success-message"><?= htmlspecialchars($_GET['success']); ?></p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="error-message"><?= htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome Utente</th>
                        <th>Ruolo</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['username']); ?></td>
                            <td><?= htmlspecialchars($row['role']); ?></td>
                            <td>
                                <form method="POST" action="view_users.php" style="display:inline;">
                                    <input type="hidden" name="delete_user_id" value="<?= $row['id']; ?>">
                                    <button type="submit" class="delete-button" onclick="return confirm('Sei sicuro di voler eliminare questo utente?')">Elimina</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nessun utente trovato.</p>
        <?php endif; ?>

        <a href="add_user.php" class="link">Aggiungi Utente</a>
    </div>
</body>
</html>
