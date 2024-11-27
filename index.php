<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Police Portal</title>
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
            padding: 20px 0;
            text-align: center;
            border-bottom: 4px solid #ffcc00; /* Accento giallo */
        }

        header.main-header .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        h1 {
            font-size: 2.5rem;
            margin: 0;
        }

        p {
            font-size: 1.1rem;
        }

        main.home-main {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .welcome-section {
            background-color: #ffffff;
            border: 2px solid #002244;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .welcome-section h2 {
            color: #002244;
        }

        /* Stile menu */
        .menu-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .menu-item {
            background-color: #ffffff;
            border: 2px solid #002244;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 10px rgba(0, 0, 0, 0.15);
        }

        .menu-item img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }

        .menu-item h3 {
            color: #002244;
            font-size: 1.2rem;
        }

        .menu-item a {
            text-decoration: none;
            color: inherit;
            font-weight: bold;
        }

        .menu-item a:hover {
            color: #ffcc00;
        }

        /* Footer */
        footer.main-footer {
            text-align: center;
            padding: 10px;
            background-color: #002244;
            color: #fff;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <header class="main-header">
        <div class="container">
            <h1>Police Portal</h1>
            <p>Gestione dei crimini e delle persone</p>
        </div>
    </header>

    <main class="home-main">
        <section class="welcome-section">
            <h2>Benvenuto al portale della polizia</h2>
            <p>Accedi alle funzionalità per aggiungere e visualizzare informazioni su crimini e persone.</p>
        </section>

        <section class="menu-section">
            <div class="menu-item">
                <a href="add_crime.php">
                    <img src="assets/icons/add_crime.png" alt="Aggiungi Crimine">
                    <h3>Aggiungi Crimine</h3>
                </a>
            </div>
            <div class="menu-item">
                <a href="view_crimes.php">
                    <img src="assets/icons/view_crimes.png" alt="Visualizza Crimini">
                    <h3>Visualizza Crimini</h3>
                </a>
            </div>
            <div class="menu-item">
                <a href="add_person.php">
                    <img src="assets/icons/add_person.png" alt="Aggiungi Persona">
                    <h3>Aggiungi Persona</h3>
                </a>
            </div>
            <div class="menu-item">
                <a href="view_people.php">
                    <img src="assets/icons/view_people.png" alt="Visualizza Persone">
                    <h3>Visualizza Persone</h3>
                </a>
            </div>
        </section>
    </main>

    <footer class="main-footer">
        <p>&copy; 2024 Police Portal. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>
