<?php
// Avvia la sessione
session_start();

// Distruggi tutte le variabili di sessione
session_destroy();

// Reindirizza l'utente alla pagina di login
header("Location: ricerca_per_categoria.php");
exit;
?>