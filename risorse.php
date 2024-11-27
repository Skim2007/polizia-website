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
    <title>Risorse - Police Portal</title>
    <link rel="stylesheet" href="assets/css/styles.css?v=<?php echo time(); ?>">
    <style>
        .resources {
            padding: 20px;
        }
        .resources div {
            margin-bottom: 10px;
        }
        .resources a {
            font-weight: bold;
            text-decoration: none;
        }
        .resources a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <header class="main-header">
        <h1>Risorse</h1>
        <p>Benvenuto, <?= htmlspecialchars($username) ?></p>
    </header>
    <main>
        <section class="resources">
            <h2>Link utili - Ricercati e Notizie </h2>
            <div>
                <a href="https://www.fbi.gov/wanted" target="_blank" rel="noopener noreferrer">FBI</a> - Sezione ricercati dell'FBI (Stati Uniti)
            </div>
            <div>CIA - Non disponibile <a href="https://www.cia.gov/about/organization/privacy-and-civil-liberties/" target="_blank" rel="noopener noreferrer">(Privacy)</a></div>
            <div>
                <a href="https://eumostwanted.eu/" target="_blank" rel="noopener noreferrer">Europol</a> - Persone ricercate da Europol
            </div>
            <div>
                <a href="https://www.interpol.int/en/How-we-work/Notices/View-Red-Notices" target="_blank" rel="noopener noreferrer">Interpol</a> - Lista dei fuggitivi segnalati dall'Interpol
            </div>
            <div>
                <a href="https://www.carabinieri.it/in-vostro-aiuto/informazioni/news" target="_blank" rel="noopener noreferrer">Carabinieri</a> - Notizie e aggiornamenti 
            </div>
            <div>
                <a href="https://questure.poliziadistato.it/it/Lodi" target="_blank" rel="noopener noreferrer">Polizia di Stato</a> - Sezione notizie dalla Polizia di Stato (Lodi)
            </div>
            <div>
                <a href="https://www.secretservice.gov/investigations/mostwanted" target="_blank" rel="noopener noreferrer">Secret Service</a> - Persone ricercate dal Secret Service (USA)
            </div>
            <div>
                <a href="https://www.miamidade.gov/global/police/most-wanted-predators.page" target="_blank" rel="noopener noreferrer">Miami-Dade</a> - Predatori ricercati a Miami
            </div>
            <div>
                <a href="https://probation.lacounty.gov/las-most-wanted/" target="_blank" rel="noopener noreferrer">Los Angeles</a> - Fuggitivi ricercati a Los Angeles
            </div>
            <div>Chicago - Non disponibile <a href="https://www.chicagopolice.org/disclaimer/" target="_blank" rel="noopener noreferrer">(Disclaimer)</a></div>
            <div>
                <a href="https://www.usmarshals.gov/what-we-do/fugitive-investigations/15-most-wanted-fugitive" target="_blank" rel="noopener noreferrer">US Marshals</a> - I 15 fuggitivi più ricercati dagli US Marshals
            </div>
            <div>
                <a href="https://www.kernsheriff.org/Wanted_Persons" target="_blank" rel="noopener noreferrer">Kern Sheriff's Office</a> - Persone ricercate dallo sceriffo di Kern
            </div>
            <div>
                <a href="https://www.doc.wa.gov/information/wanted.htm" target="_blank" rel="noopener noreferrer">Washington DOC</a> - Lista dei ricercati del Dipartimento di Corrections di Washington
            </div>
        </section>
    </main>
    <footer class="main-footer">
        <p>&copy; 2024 Police Portal. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>
