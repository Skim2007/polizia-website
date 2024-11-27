<?php
session_start();

include 'includes/db_connection.php';
include 'navbar.php';

// Verifica se l'utente è autenticato
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $crime_name = trim($_POST['crime_name']);
    $crime_type = trim($_POST['crime_type']);
    $description = trim($_POST['description']);
    $crime_date = $_POST['crime_date'];
    $suspects = trim($_POST['suspects']); // Input libero per i sospettati

    // Validazione dei dati
    if (empty($crime_name) || empty($crime_type) || empty($description) || empty($crime_date)) {
        $error_message = "Errore: tutti i campi sono obbligatori.";
    } else {
        // Calcola il numero del caso
        $sql_case = "SELECT MAX(id) AS max_id FROM crimes";
        $result_case = $conn->query($sql_case);
        $row_case = $result_case->fetch_assoc();
        $case_number = str_pad($row_case['max_id'] + 1, 3, "0", STR_PAD_LEFT);

        // Inserimento del crimine
        $stmt = $conn->prepare("INSERT INTO crimes (crime_name, crime_type, description, crime_date, case_number, suspects) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $crime_name, $crime_type, $description, $crime_date, $case_number, $suspects);

        if ($stmt->execute()) {
            $success_message = "Crimine aggiunto con successo! Numero caso: <strong>$case_number</strong>";
        } else {
            $error_message = "Errore: " . htmlspecialchars($stmt->error);
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
    <title>Aggiungi Crimine</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <header>
        <h1>Aggiungi Crimine</h1>
    </header>

    <form action="add_crime.php" method="post">
        <label for="crime_name">Nome del Crimine:</label>
        <input type="text" id="crime_name" name="crime_name" required>

        <label for="crime_type">Tipo di Crimine:</label>
        <select id="crime_type" name="crime_type" required>
            <option value="Furto">Furto</option>
            <option value="Aggressione">Aggressione</option>
            <option value="Omicidio">Omicidio</option>
            <option value="Truffa">Truffa</option>
        </select>

        <label for="description">Descrizione:</label>
        <textarea id="description" name="description" required></textarea>

        <label for="crime_date">Data del Crimine:</label>
        <input type="date" id="crime_date" name="crime_date" required>

        <label for="suspects">Sospettati :</label>
        <input type="text" id="suspects" name="suspects" placeholder="Aggiungere sospettati o lasciare in bianco e modificare in seguito">

        <button type="submit">Aggiungi Crimine</button>
    </form>

    <?php if (isset($error_message)): ?>
        <p class="error"><?= htmlspecialchars($error_message); ?></p>
    <?php elseif (isset($success_message)): ?>
        <p class="success"><?= htmlspecialchars($success_message); ?></p>
    <?php endif; ?>
</body>
</html>
