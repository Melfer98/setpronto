<?php
// Avvia la sessione
session_start();

// Includi il file di connessione al database
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idAnnuncio'])) {
    // Ottieni l'ID dell'annuncio da $_POST
    $idAnnuncio = $_POST['idAnnuncio'];

    // Esegui l'aggiornamento del campo "approvato" nel database
    $query = "UPDATE annunci_ditte SET approvato = 1 WHERE idAnnuncio = :idAnnuncio";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':idAnnuncio', $idAnnuncio, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Restituisci una risposta JSON di successo
        echo json_encode(array('success' => true));
    } else {
        // Restituisci una risposta JSON di errore se l'aggiornamento fallisce
        echo json_encode(array('success' => false, 'message' => 'Errore durante l\'approvazione dell\'annuncio.'));
    }
} else {
    // Restituisci una risposta JSON di errore se la richiesta non è valida
    echo json_encode(array('success' => false, 'message' => 'Richiesta non valida.'));
}
?>
