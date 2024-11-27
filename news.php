<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<?php
include 'includes/db_connection.php';
include 'navbar.php';

// Carica il file JSON con le notizie estratte dallo script Python
$news_data = json_decode(file_get_contents('news.json'), true);

if (!$news_data) {
    echo "<p>Errore nel recupero delle notizie.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notizie - Basso Lodigiano</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        /* Body Styles */
        body {
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header Styles */
        header {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        header h1 {
            font-size: 2.5rem;
        }

        /* Main Section Styles */
        main {
            padding: 20px;
            flex: 1;
        }

        .news-item {
            background-color: white;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .news-item h3 {
            margin: 0 0 10px;
            font-size: 1.5em;
        }

        .news-item p {
            margin: 0 0 10px;
            font-size: 1.1em;
            color: #333;
        }

        .news-item a {
            color: #007bff;
            text-decoration: none;
        }

        .news-item a:hover {
            text-decoration: underline;
        }

        /* Footer Styles */
        footer {
            background-color: #002855;
            color: white;
            text-align: center;
            padding: 10px 0;
            font-size: 0.9rem;
            margin-top: auto;
            border-top: 5px solid #004d99;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <header>
        <h1>Notizie Basso Lodigiano</h1>
    </header>

    <main>
        <?php foreach ($news_data as $news): ?>
            <div class="news-item">
                <h3><a href="<?= htmlspecialchars($news['link']) ?>" target="_blank"><?= htmlspecialchars($news['title']) ?></a></h3>
                <p><?= htmlspecialchars($news['description']) ?></p>
            </div>
        <?php endforeach; ?>
    </main>

    <footer>
        <p>&copy; 2024 Police Portal. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>
