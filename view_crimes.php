<?php
session_start();

include 'includes/db_connection.php';
include 'navbar.php';

// Verifica se l'utente è autenticato
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

// Cattura il criterio di ricerca
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Modifica la query SQL per includere un filtro
$sql = "SELECT id, crime_name, description, data_inserimento, case_number, suspects FROM crimes";
if (!empty($search)) {
    $sql .= " WHERE case_number LIKE ? OR crime_name LIKE ?";
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
    <title>Visualizza Crimini</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
</head>
<body>

<header>
    <h1>Visualizza Crimini</h1>
</header>

<main>
    <!-- Barra di ricerca -->
    <form method="GET" action="view_crimes.php">
        <input type="text" name="search" placeholder="Cerca per numero caso o nome crimine" value="<?= htmlspecialchars($search); ?>">
        <button type="submit">Cerca</button>
    </form>

    <?php
    if ($result && $result->num_rows > 0) {
        echo "<table>
                <thead>
                    <tr>
                        <th>Numero Caso</th>
                        <th>Nome del Crimine</th>
                        <th>Descrizione</th>
                        <th>Data di Inserimento</th>
                        <th>Sospettati</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['case_number']) . "</td>
                    <td>" . htmlspecialchars($row['crime_name']) . "</td>
                    <td>" . htmlspecialchars($row['description']) . "</td>
                    <td>" . htmlspecialchars($row['data_inserimento']) . "</td>
                    <td>" . htmlspecialchars($row['suspects']) . "</td>
                    <td>
                        <a href='modifica_caso.php?case_number=" . urlencode($row['case_number']) . "' class='edit-link'>Modifica</a> |
                        <a href='delete_crime.php?id=" . urlencode($row['id']) . "' class='delete-link'>Elimina</a>
                    </td>
                  </tr>";
        }
        echo "</tbody>
              </table>";
    } else {
        echo "<p>Nessun crimine trovato.</p>";
    }

    $conn->close();
    ?>
</main>

</body>
</html>
