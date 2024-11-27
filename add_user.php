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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Verifica se il nome utente esiste già
    $sql_check = "SELECT id FROM utenti WHERE username = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $username);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // L'utente con quel nome esiste già
        $error = "Il nome utente '$username' è già stato preso. Scegli un altro nome utente.";
        $stmt_check->close(); // Chiudi la statement qui se l'utente è trovato
    } else {
        // Hash della password
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO utenti (username, password_hash, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            // Se la preparazione della query fallisce
            $error = "Errore durante la preparazione della query.";
        } else {
            $stmt->bind_param("sss", $username, $password_hash, $role);

            if ($stmt->execute()) {
                $success = "Utente aggiunto con successo!";
            } else {
                $error = "Errore durante l'inserimento dell'utente.";
            }

            $stmt->close(); // Assicurati di chiudere la statement qui
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Utente</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <h1>Aggiungi Utente</h1>
        <?php if (!empty($success)): ?>
            <p class="success-message"><?= htmlspecialchars($success); ?></p>
        <?php elseif (!empty($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="add_user.php">
            <label for="username">Nome Utente:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <label for="role">Ruolo:</label>
            <select id="role" name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Aggiungi</button>
        </form>
    </div>
</body>
</html>
