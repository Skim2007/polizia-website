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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birth_date = $_POST['birth_date'];

    $sql = "INSERT INTO persons (name, surname, birth_date) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $surname, $birth_date);

    if ($stmt->execute()) {
        $success = "Persona aggiunta con successo!";
    } else {
        $error = "Errore durante l'inserimento della persona.";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi Persona</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="container">
        <h1>Aggiungi Persona</h1>
        <?php if (!empty($success)): ?>
            <p class="success-message"><?= htmlspecialchars($success); ?></p>
        <?php elseif (!empty($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST" action="add_person.php">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" required>
            <label for="surname">Cognome:</label>
            <input type="text" id="surname" name="surname" required>
            <label for="birth_date">Data di Nascita:</label>
            <input type="date" id="birth_date" name="birth_date" required>
            <button type="submit">Aggiungi</button>
        </form>
        <a href="view_persons.php" class="link">Visualizza Persone</a> | <a href="view_crimes.php" class="link">Visualizza Crimini</a>
    </div>
</body>
</html>
