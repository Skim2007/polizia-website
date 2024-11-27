<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$username = $_SESSION['username'] ?? 'Guest';
$role = $_SESSION['role'] ?? '';

// Recupera la password dall'utente (assicurati che venga salvata correttamente nella sessione)
$password = $_SESSION['password'] ?? ''; // Assicurati che la password sia nella sessione quando necessario
?>
<nav class="navbar">
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="risorse.php">Risorse</a></li>
        <li><a href="news.php">Notizie</a></li>
        <?php if ($role === 'admin'): ?>
            <li class="dropdown">
                <a href="#" class="dropbtn">Admin</a>
                <div class="dropdown-content">
                    <a href="admin.php">Zona Admin</a>
                    <a href="dashboard.php">Dashboard</a>
                </div>
            </li>
        <?php endif; ?>
        <?php if (isset($_SESSION['loggedin'])): ?>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
        <?php endif; ?>
    </ul>

    <!-- Aggiungi il nome dell'utente e il badge della password -->
    <div class="user-info">
        <span class="username"><?php echo htmlspecialchars($username); ?></span> |
        <span class="password-badge" id="password-badge">****</span>
        <i class="eye-icon" id="toggle-eye" onclick="togglePassword()">👁️</i>
    </div>
</nav>

<style>
/* Stile per il menu a discesa */
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

li {
    display: inline;
    margin-right: 10px;
}

.dropdown {
    position: relative;
    display: inline-block;
}

.dropbtn {
    background-color: #002855;
    color: white;
    padding: 10px;
    border: none;
    cursor: pointer;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {
    background-color: #f1f1f1;
}

.dropdown:hover .dropdown-content {
    display: block;
}

/* Stile per il nome dell'utente e il badge */
.user-info {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 16px;
    color: #fff;
}

.username {
    font-weight: bold;
}

.password-badge {
    background-color: #f44336;
    color: white;
    padding: 5px 10px;
    border-radius: 10px;
    font-size: 14px;
    margin-left: 10px;
}

/* Icona dell'occhio */
.eye-icon {
    font-size: 18px;
    color: white;
    cursor: pointer;
    margin-left: 10px;
}

.eye-icon:hover {
    color: #f44336; /* Cambio colore al passaggio del mouse */
}
</style>

<script>
// Funzione per alternare la visibilità della password
function togglePassword() {
    var passwordBadge = document.getElementById("password-badge");
    var eyeIcon = document.getElementById("toggle-eye");

    // Controlla se la password è visibile o meno
    if (passwordBadge.innerText === "****") {
        // Mostra la password
        passwordBadge.innerText = "<?php echo htmlspecialchars($password); ?>"; // Mostra la password reale (prelevata dalla sessione)
        eyeIcon.style.color = "#f44336"; // Cambia il colore dell'icona per indicare che la password è visibile
    } else {
        // Nascondi la password
        passwordBadge.innerText = "****";
        eyeIcon.style.color = "white"; // Ripristina il colore dell'icona
    }
}
</script>
