<?php
session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

include 'includes/db_connection.php';
include 'navbar.php';

// Verifica che il numero del caso sia fornito
if (!isset($_GET['case_number']) || empty($_GET['case_number'])) {
    die("Numero caso non fornito.");
}

$case_number = $_GET['case_number'];

// Recupera i dettagli del crimine dal database
$sql = "SELECT * FROM crimes WHERE case_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $case_number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Nessun crimine trovato per il numero di caso fornito.");
}

$crime = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera i dati inviati dal form
    $crime_name = trim($_POST['crime_name']);
    $crime_type = trim($_POST['crime_type']);
    $description = trim($_POST['description']);
    $crime_date = $_POST['crime_date'];
    $suspects = trim($_POST['suspects']);

    // Validazione dei dati
    if (empty($crime_name) || empty($crime_type) || empty($description) || empty($crime_date)) {
        $error_message = "Errore: tutti i campi sono obbligatori.";
    } else {
        // Aggiorna il record nel database
        $update_sql = "UPDATE crimes SET crime_name = ?, crime_type = ?, description = ?, crime_date = ?, suspects = ? WHERE case_number = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssssss", $crime_name, $crime_type, $description, $crime_date, $suspects, $case_number);

        if ($stmt->execute()) {
            $success_message = "Il crimine è stato aggiornato con successo.";
        } else {
            $error_message = "Errore durante l'aggiornamento: " . htmlspecialchars($stmt->error);
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Caso: <?= htmlspecialchars($case_number) ?></title>
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <header>
        <h1>Modifica Caso: <?= htmlspecialchars($case_number) ?></h1>
    </header>

    <main>
        <?php if (isset($error_message)): ?>
            <p class="error"><?= htmlspecialchars($error_message) ?></p>
        <?php elseif (isset($success_message)): ?>
            <p class="success"><?= htmlspecialchars($success_message) ?></p>
        <?php endif; ?>

        <form action="modifica_caso.php?case_number=<?= urlencode($case_number) ?>" method="post">
            <label for="crime_name">Nome del Crimine:</label>
            <input type="text" id="crime_name" name="crime_name" value="<?= htmlspecialchars($crime['crime_name']) ?>" required>

            <label for="crime_type">Tipo di Crimine:</label>
            <select id="crime_type" name="crime_type" required>
                <option value="Furto" <?= $crime['crime_type'] === 'Furto' ? 'selected' : '' ?>>Furto</option>
                <option value="Aggressione" <?= $crime['crime_type'] === 'Aggressione' ? 'selected' : '' ?>>Aggressione</option>
                <option value="Omicidio" <?= $crime['crime_type'] === 'Omicidio' ? 'selected' : '' ?>>Omicidio</option>
                <option value="Truffa" <?= $crime['crime_type'] === 'Truffa' ? 'selected' : '' ?>>Truffa</option>
                <!-- Altri tipi di crimine -->
            </select>

            <label for="description">Descrizione:</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($crime['description']) ?></textarea>

            <label for="crime_date">Data del Crimine:</label>
            <input type="date" id="crime_date" name="crime_date" value="<?= htmlspecialchars($crime['crime_date']) ?>" required>

            <label for="suspects">Sospettati:</label>
            <textarea id="suspects" name="suspects" required><?= htmlspecialchars($crime['suspects']) ?></textarea>

            <button type="submit">Salva Modifiche</button>
        </form>
    </main>
</body>
</html>
