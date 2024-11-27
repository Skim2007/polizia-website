<?php
session_start();

// Connessione al database
$host = "localhost";
$user = "root";
$password = "";
$dbname = "polizia";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM utenti WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password_hash'])) {
                // Login riuscito, salva i dati nella sessione
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; // Salva il ruolo

                if ($user['role'] === 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: dashboard.php");
                }
                exit;
            } else {
                $error = "Password errata.";
            }
        } else {
            $error = "Utente non trovato.";
        }
        $stmt->close();
    } else {
        $error = "Nome utente e password sono obbligatori.";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Police Portal</title>
      <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
    <style>
        /* Stile base per rendere l'aspetto simile all'immagine */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .main-header {
            text-align: center;
            background-color: #003366;
            color: white;
            padding: 20px;
        }
        .login-section {
            max-width: 400px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .login-section h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #003366;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            font-weight: bold;
            margin-bottom: 5px;
        }
        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px;
            background-color: #003366;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #00509e;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }
        .main-footer {
            text-align: center;
            background-color: #003366;
            color: white;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header class="main-header">
        <h1>Police Portal</h1>
        <p>Effettua il login per accedere</p>
    </header>
    <main>
        <section class="login-section">
            <h2>Effettua il Login</h2>
            <?php if (!empty($error)): ?>
                <p class="error-message"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <label for="username">Nome Utente</label>
                <input type="text" name="username" id="username" placeholder="Inserisci il tuo nome utente" required>
                
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Inserisci la tua password" required>
                
                <button type="submit">Accedi</button>
            </form>
        </section>
    </main>
    <footer class="main-footer">
        <p>&copy; 2024 Police Portal. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>
