<?php
session_start(); // Assicurati di avviare la sessione se non lo hai già fatto.

$dsn = "mysql:host=localhost;dbname=dbsetpronto";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connessione al database fallita: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se l'utente è autenticato. Puoi personalizzare questa parte in base al tuo sistema di autenticazione.
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
        $currentPassword = $_POST["current-password"];
        $newPassword = $_POST["new-password"];
        $confirmPassword = $_POST["confirm-password"];

        // Verifica se la nuova password e la conferma coincidono.
        if ($newPassword === $confirmPassword) {
            // Verifica la password corrente dell'utente dal database.
            $userId = $_SESSION["idUtente"]; // Sostituisci con il nome corretto della variabile di sessione dell'ID utente.
            $query = "SELECT password FROM anag_ditte WHERE idUtente = :idUtente";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":idUtente", $userId);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($row) {
                $storedPassword = $row["password"];
                // Verifica se la password corrente inserita coincide con la password nel database.
                if (password_verify($currentPassword, $storedPassword)) {
                    // Genera l'hash per la nuova password.
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    
                    // Aggiorna la password nel database.
                    $updateQuery = "UPDATE anag_ditte SET password = :password WHERE idUtente = :idUtente";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bindParam(":password", $hashedPassword);
                    $updateStmt->bindParam(":idUtente", $userId);
                    $updateStmt->execute();

                    echo "Password modificata con successo.";
                } else {
                    echo "La password corrente non è corretta.";
                }
            } else {
                echo "Utente non trovato nel database.";
            }
        } else {
            echo "La nuova password e la conferma non coincidono.";
        }
    } else {
        echo "L'utente non è autenticato.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
  :root {
    --colore-principale: #F9DB5C;
    --colore-secondario: #855C00;
    --colore-hover: #E2CB5C;
    --colore-sfondociaro: #FFFFE0;
  }

  body {
    font-family: Arial, sans-serif;
  }

  header {
    background-color: var(--colore-principale);
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
    width: 100%;
    z-index: 1000;
    position: relative;
  }

  .header-content {
    display: flex;
    align-items: center;
    height: 80px;
  }

  .logo-container {
    margin-right: 20px;
    overflow: hidden;
    width: 300px;
    height: 70px; 
  }

  .logo-container img {
    margin-top: 3px;
    width: 90%;
    height: 90%;
    object-fit: cover; 
    z-index: -1;
  }

  .container {
    max-width: 700px;
    margin: 20px auto;
    padding: 20px;
    background-color: var(--colore-sfondociaro);
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    font-weight: bold;
    display: block;
  }

  .form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }

  .form-group input[type="submit"] {
    background-color: var(--colore-secondario);
    color: white;
    font-weight: bold;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
  }

  .form-group input[type="submit"]:hover {
    background-color: var(--colore-hover);
  }
</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const newPasswordInput = document.getElementById("new-password");
    const confirmPasswordInput = document.getElementById("confirm-password");
    const newPasswordError = document.getElementById("new-password-error");
    const confirmPasswordError = document.getElementById("confirm-password-error");

    newPasswordInput.addEventListener("input", function () {
        const newPasswordValue = newPasswordInput.value;
        const confirmPasswordValue = confirmPasswordInput.value;

        if (newPasswordValue.length < 8) {
            newPasswordError.textContent = "La nuova password deve contenere almeno 8 caratteri.";
        } else {
            newPasswordError.textContent = "";
        }

        if (newPasswordValue !== confirmPasswordValue) {
            confirmPasswordError.textContent = "Le password non corrispondono.";
        } else {
            confirmPasswordError.textContent = "";
        }
    });

    confirmPasswordInput.addEventListener("input", function () {
        const newPasswordValue = newPasswordInput.value;
        const confirmPasswordValue = confirmPasswordInput.value;

        if (newPasswordValue !== confirmPasswordValue) {
            confirmPasswordError.textContent = "Le password non corrispondono.";
        } else {
            confirmPasswordError.textContent = "";
        }
    });
});
</script>

</head>
<body>
  <header>
    <div class="header-content">
      <div class="logo-container">
        <img src="images/SETPRONTO.png" alt="Logo">
      </div>
    </div>
  </header>
  <div class="container">
    <h2>Modifica Password</h2>
    <form action="process_password_change.php" method="POST">
      <div class="form-group">
        <label for="current-password">Password Corrente:</label>
        <input type="password" id="current-password" name="current-password" required>
      </div>
      <div class="form-group">
        <label for="new-password">Nuova Password:</label>
        <input type="password" id="new-password" name="new-password" required>
        <div id="new-password-error" class="error-message"></div>
    </div>
    <div class="form-group">
        <label for="confirm-password">Conferma Nuova Password:</label>
        <input type="password" id="confirm-password" name="confirm-password" required>
        <div id="confirm-password-error" class="error-message"></div>
    </div>
    <div class="form-group">
        <input type="submit" value="Salva Password">
    </div>
    </form>
  </div>
</body>
</html>
>
