<?php
// Avvia la sessione
session_start();

// Verifica che l'utente sia loggato, altrimenti reindirizza alla pagina di login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

// Includi il file di connessione al database
require_once 'db.php'; 

// Ottieni l'ID dell'utente dalla sessione
$userId = $_SESSION["idUtente"];

// Query per selezionare gli annunci dell'utente corrente
$query = "SELECT * FROM annunci_ditte 
            WHERE idUtente = :userId 
            AND approvato < 3
            ORDER BY idAnnuncio DESC";
$stmt = $conn->prepare($query);
$stmt->bindParam(":userId", $userId, PDO::PARAM_INT);
$stmt->execute();
$anuncios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once 'i_miei_annunci_content.php'?>