<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['loggedin']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zona Admin - Police Portal</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <header class="main-header">
        <div class="container">
            <h1>Zona Admin</h1>
            <p>Accesso riservato per: <strong><?php echo htmlspecialchars($username); ?></strong></p>
        </div>
    </header>

    <main class="home-main">
        <section class="welcome-section">
            <h2>Benvenuto nella Zona Admin</h2>
            <p>Gestisci utenti e autorizzazioni da questa sezione.</p>
        </section>

        <section class="menu-section">
            <div class="menu-item">
                <a href="add_user.php">
                    <img src="assets/icons/add_user.png" alt="Aggiungi Utente">
                    <h3>Aggiungi Utente</h3>
                </a>
            </div>
            <div class="menu-item">
                <a href="view_users.php">
                    <img src="assets/icons/view_users.png" alt="Visualizza Utenti">
                    <h3>Visualizza Utenti</h3>
                </a>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <p>&copy; 2024 Police Portal. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>
