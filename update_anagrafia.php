<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbsetpronto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (!isset($_SESSION["idUtente"])) {
    header("Location: login.php");
    exit();
}
$idUtente = $_SESSION["idUtente"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nuovoNome = mysqli_real_escape_string($conn, $_POST["nuovoNome"]);
    $nuovoCognome = mysqli_real_escape_string($conn, $_POST["nuovoCognome"]);
    $nuovaProfessione = mysqli_real_escape_string($conn, $_POST["nuovaProfessione"]);
    $nuovaEmail = mysqli_real_escape_string($conn, $_POST["nuovaEmail"]);
    $nuovoCellulare = mysqli_real_escape_string($conn, $_POST["nuovoCellulare"]);
    $nuovoTelefono1 = mysqli_real_escape_string($conn, $_POST["nuovoTelefono1"]);
    $nuovoTelefono2 = mysqli_real_escape_string($conn, $_POST["nuovoTelefono2"]);
    $nuovoTelefono3 = mysqli_real_escape_string($conn, $_POST["nuovoTelefono3"]);
    $nuovoFax = mysqli_real_escape_string($conn, $_POST["nuovoFax"]);
    $nuovaDataRegistrazione = mysqli_real_escape_string($conn, $_POST["nuovaDataRegistrazione"]);
    $nuovaTipologia = mysqli_real_escape_string($conn, $_POST["nuovaTipologia"]);
    $nuovaRagioneSociale = mysqli_real_escape_string($conn, $_POST["nuovaRagioneSociale"]);
    $nuovoCodiceFiscale = mysqli_real_escape_string($conn, $_POST["nuovoCodiceFiscale"]);
    $nuovaDescrizioneBreve = mysqli_real_escape_string($conn, $_POST["nuovaDescrizioneBreve"]);
    $nuovaDescrizioneCompleta = mysqli_real_escape_string($conn, $_POST["nuovaDescrizioneCompleta"]);
    $nuovoSitoWeb = mysqli_real_escape_string($conn, $_POST["nuovoSitoWeb"]);
    $nuovoSkype = mysqli_real_escape_string($conn, $_POST["nuovoSkype"]);
    $nuovoIndirizzo = mysqli_real_escape_string($conn, $_POST["nuovoIndirizzo"]);
    $nuovaCitta = mysqli_real_escape_string($conn, $_POST["nuovaCitta"]);
    $nuovaProvincia = mysqli_real_escape_string($conn, $_POST["nuovaProvincia"]);
    $nuovoCAP = mysqli_real_escape_string($conn, $_POST["nuovoCAP"]);
    $nuovoContatto = mysqli_real_escape_string($conn, $_POST["nuovoContatto"]);
    $nuovoTelefonoContatto = mysqli_real_escape_string($conn, $_POST["nuovoTelefonoContatto"]);
    $nuovoCellulareContatto = mysqli_real_escape_string($conn, $_POST["nuovoCellulareContatto"]);
    $nuovoFaxContatto = mysqli_real_escape_string($conn, $_POST["nuovoFaxContatto"]);
    $nuovaEmailContatto = mysqli_real_escape_string($conn, $_POST["nuovaEmailContatto"]);
    $nuovaDomanda1 = mysqli_real_escape_string($conn, $_POST["nuovaDomanda1"]);
    $nuovaDomanda2 = mysqli_real_escape_string($conn, $_POST["nuovaDomanda2"]);

    $sql = "UPDATE anag_ditte SET ";
    if (!empty($nuovaImg_profile)) {
        $sql .= "nome = '$nuovaImg_profile', ";
    }

    if (!empty($nuovoNome)) {
        $sql .= "nome = '$nuovoNome', ";
    }

    if (!empty($nuovoCognome)) {
        $sql .= "cognome = '$nuovoCognome', ";
    }

    if (!empty($nuovaProfessione)) {
        $sql .= "professione = '$nuovaProfessione', ";
    }

    if (!empty($nuovaEmail)) {
        $sql .= "mail = '$nuovaEmail', ";
    }

    if (!empty($nuovoCellulare)) {
        $sql .= "cellulare = '$nuovoCellulare', ";
    }

    if (!empty($nuovoTelefono1)) {
        $sql .= "telefono = '$nuovoTelefono1', ";
    }

    if (!empty($nuovoTelefono2)) {
        $sql .= "telefono2 = '$nuovoTelefono2', ";
    }

    if (!empty($nuovoTelefono3)) {
        $sql .= "telefono3 = '$nuovoTelefono3', ";
    }

    if (!empty($nuovoFax)) {
        $sql .= "fax = '$nuovoFax', ";
    }

    if (!empty($nuovaDataRegistrazione)) {
        $sql .= "dataReg = '$nuovaDataRegistrazione', ";
    }
    
    if (!empty($nuovaTipologia)) {
        $sql .= "tipologia = '$nuovaTipologia', ";
    }

    if (!empty($nuovaRagioneSociale)) {
        $sql .= "ragioneSociale = '$nuovaRagioneSociale', ";
    }

    if (!empty($nuovoCodiceFiscale)) {
        $sql .= "cfiscPiva = '$nuovoCodiceFiscale', ";
    }

    if (!empty($nuovaDescrizioneBreve)) {
        $sql .= "descrBreve = '$nuovaDescrizioneBreve', ";
    }

    if (!empty($nuovaDescrizioneCompleta)) {
        $sql .= "descrCompleta = '$nuovaDescrizioneCompleta', ";
    }

    if (!empty($nuovoSitoWeb)) {
        $sql .= "sitoWeb = '$nuovoSitoWeb', ";
    }

    if (!empty($nuovoSkype)) {
        $sql .= "skype = '$nuovoSkype', ";
    }

    if (!empty($nuovoIndirizzo)) {
        $sql .= "indirizzo = '$nuovoIndirizzo', ";
    }

    if (!empty($nuovaCitta)) {
        $sql .= "citta = '$nuovaCitta', ";
    }

    if (!empty($nuovaProvincia)) {
        $sql .= "provincia = '$nuovaProvincia', ";
    }

    if (!empty($nuovoCAP)) {
        $sql .= "cap = '$nuovoCAP', ";
    }

    if (!empty($nuovoContatto)) {
        $sql .= "contatto = '$nuovoContatto', ";
    }

    if (!empty($nuovoTelefonoContatto)) {
        $sql .= "telefonoContatto = '$nuovoTelefonoContatto', ";
    }

    if (!empty($nuovoCellulareContatto)) {
        $sql .= "cellulareContatto = '$nuovoCellulareContatto', ";
    }

    if (!empty($nuovoFaxContatto)) {
        $sql .= "faxContatto = '$nuovoFaxContatto', ";
    }

    if (!empty($nuovaEmailContatto)) {
        $sql .= "mailContatto = '$nuovaEmailContatto', ";
    }

    if (!empty($nuovaDomanda1)) {
        $sql .= "domanda1 = '$nuovaDomanda1', ";
    }

    if (!empty($nuovaDomanda2)) {
        $sql .= "domanda2 = '$nuovaDomanda2', ";
    }

    $sql = rtrim($sql, ", ");

    $sql .= " WHERE idUtente = '$idUtente'";

    if ($conn->query($sql) === TRUE) {
        header("Location: anagrafia.php");
        exit();
    } else {
        echo "Error al actualizar los datos: " . $conn->error;
    }
}

$conn->close();
?>
