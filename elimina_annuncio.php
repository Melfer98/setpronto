<?php
// Includi il file di connessione al database
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idAnnuncio"])) {
    $idAnnuncio = $_POST["idAnnuncio"];

    // Esegui l'aggiornamento del campo "approvato" nell'annuncio
    $query = "UPDATE annunci_ditte SET approvato = 3 WHERE idAnnuncio = :idAnnuncio";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":idAnnuncio", $idAnnuncio, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        echo "Annuncio segnato come eliminato.";
    } else {
        echo "Errore durante l'aggiornamento dell'annuncio.";
    }
}
?>
