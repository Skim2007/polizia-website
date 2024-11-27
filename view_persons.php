<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'includes/db_connection.php';
include 'navbar.php';

// Protezione dalla non autenticazione
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Cattura il criterio di ricerca, se fornito
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Modifica la query SQL per filtrare i risultati
$sql = "SELECT id, name, surname, birth_date FROM persons";
if (!empty($search)) {
    $sql .= " WHERE name LIKE ? OR surname LIKE ?";
}

$stmt = $conn->prepare($sql);
if (!empty($search)) {
    $like_search = "%$search%";
    $stmt->bind_param("ss", $like_search, $like_search);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizza Persone</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <h1>Visualizza Persone</h1>

        <!-- Barra di ricerca -->
        <form method="GET" action="view_persons.php">
            <input type="text" name="search" placeholder="Cerca per nome o cognome" value="<?= htmlspecialchars($search); ?>">
            <button type="submit">Cerca</button>
        </form>

        <!-- Messaggi di feedback -->
        <?php if (isset($_GET['success'])): ?>
            <p class="success-message">Persona eliminata con successo!</p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="error-message">Errore durante l'eliminazione della persona.</p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Data di Nascita</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['surname']); ?></td>
                            <td><?= htmlspecialchars($row['birth_date']); ?></td>
                            <td>
                                <a href="delete_person.php?id=<?= $row['id']; ?>" onclick="return confirm('Sei sicuro di voler eliminare questa persona?')" class="delete-button">Elimina</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nessuna persona trovata.</p>
        <?php endif; ?>

        <div class="link-container">
            <a href="add_person.php" class="link">Aggiungi Persona</a> | <a href="view_crimes.php" class="link">Visualizza Crimini</a>
        </div>
    </div>
</body>
</html>
