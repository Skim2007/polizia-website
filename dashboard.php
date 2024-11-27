<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Police Portal</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
    <style>
        /* Stile generale */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header.main-header {
            background-color: #002244; /* Colore blu scuro da polizia */
            color: #fff;
            padding: 20px;
            text-align: center;
            border-bottom: 4px solid #ffcc00; /* Giallo ispirato a distintivi della polizia */
        }

        h1 {
            margin: 0;
            font-size: 2.5rem;
        }

        p {
            margin: 5px 0 0;
        }

        /* Stile principale */
        main {
            padding: 20px;
        }

        .dashboard-section {
            background-color: #ffffff;
            border: 2px solid #002244;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .dashboard-section h2 {
            color: #002244;
            font-size: 1.8rem;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin: 10px 0;
        }

        ul li a {
            text-decoration: none;
            color: #002244;
            font-weight: bold;
        }

        ul li a:hover {
            color: #ffcc00;
        }

        /* Zona Admin */
        .dashboard-section h3 {
            margin-top: 20px;
            font-size: 1.5rem;
            color: #900; /* Colore rosso per distinguere l'area Admin */
        }

        .dashboard-section a {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #002244;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .dashboard-section a:hover {
            background-color: #ffcc00;
            color: #002244;
        }

        /* Footer */
        footer.main-footer {
            text-align: center;
            padding: 10px;
            background-color: #002244;
            color: #fff;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <header class="main-header">
        <h1>Dashboard</h1>
        <p>Benvenuto, <?= htmlspecialchars($username) ?></p>
    </header>
    <main>
        <section class="dashboard-section">
            <h2>I tuoi casi</h2>
            <ul>
                <li><a href="view_crimes.php">Visualizza Crimini</a></li>
                <li><a href="view_persons.php">Visualizza Persone</a></li>
                <li><a href="add_crime.php">Aggiungi Crimine</a></li>
                <li><a href="add_person.php">Aggiungi Persona</a></li>
            </ul>

            <?php if ($role === 'admin'): ?>
                <h3>Zona Admin</h3>
                <p>Accesso ai contenuti riservati agli amministratori.</p>
                <a href="admin.php">Vai alla sezione Admin</a>
            <?php endif; ?>
        </section>
    </main>
    <footer class="main-footer">
        <p>&copy; 2024 Police Portal. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>
