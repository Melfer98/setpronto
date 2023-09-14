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

$feedbackMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se sono stati inviati i dati del modulo
    if (isset($_POST['passwordAttuale'], $_POST['nuovaPassword'], $_POST['confermaNuovaPassword'])) {
        $passwordAttuale = $_POST['passwordAttuale'];
        $nuovaPassword = $_POST['nuovaPassword'];
        $confermaNuovaPassword = $_POST['confermaNuovaPassword'];

        // Verifica che la nuova password e la conferma siano uguali
        if ($nuovaPassword === $confermaNuovaPassword) {
            // Verifica che la password attuale sia corretta
            $userId = $_SESSION["idUtente"];
            $stmt = $conn->prepare("SELECT password FROM anag_ditte WHERE idUtente = :idUtente");
            $stmt->bindParam(':idUtente', $userId, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && $passwordAttuale === $row['password']) {
                // Verifica se la nuova password soddisfa i criteri
                if (preg_match('/^(?=.*[A-Z])(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/', $nuovaPassword)) {
                    // Hash della nuova password
                    $hashedPassword = $nuovaPassword; // Puoi utilizzare un algoritmo di hashing più sicuro come bcrypt

                    try {
                        // Esegui l'aggiornamento della password nel database
                        $stmt = $conn->prepare("UPDATE anag_ditte SET password = :password WHERE idUtente = :idUtente");
                        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                        $stmt->bindParam(':idUtente', $userId, PDO::PARAM_INT);
                        $stmt->execute();
                
                        $feedbackMessage = "<span class='success-message'>Password aggiornata con successo!</span>";
                    } catch (PDOException $e) {
                        $feedbackMessage = "<span class='error-message'>Errore durante l'aggiornamento della password: " . $e->getMessage() . "</span>";
                    }
                
                } else {
                    $feedbackMessage = "<span class='error-message'>La nuova password non soddisfa i criteri richiesti.";
                }
            } else {
                $feedbackMessage = "La password attuale non è corretta.";
            }
        } else {
            $feedbackMessage = "La nuova password e la conferma non corrispondono.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifica Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: block;
            justify-content: center;
            align-items: center;
        }

        .form-container {
        margin-top: 20px;
        padding: 20px;
        margin-left: 30%;
        margin-right: 30%;
        background-color: white;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        animation: pop 0.5s ease-in-out;
    }
        @media (max-width: 1000px) {
            .form-container {
            margin-top: 20px; 
            padding: 20px;
            margin-left: 10%;
            margin-right: 10%;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            animation: pop 0.5s ease-in-out;
    }
        }

        @keyframes pop {
            0% {
                transform: scale(0);
            }
            100% {
                transform: scale(1);
            }
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            position: relative;
        }

        .input-group-append {
            cursor: pointer;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .feedback {
            text-align: center;
            color: #0a0a0a;
            margin-top: 10px;
        }
        .success-message {
            color: green;
            font-weight: bold;
        }
        .error-message {
            color: red;
            font-weight: bold;
        }

        .b-form{
            background-color:#5ec9a0;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .b-form:hover {
            color: #5ec9a0;
            background-color: #dbffed;
            text-decoration: none; 
        }
    </style>
</head>
<body>
    <header>
        <?php require_once 'header.php'?>
    </header>
    <br>
    <div class="form-container">
        <h1>Modifica Password</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="passwordAttuale">
                    <i class="fas fa-lock"></i> Password Attuale
                </label>
                <div class="input-group">
                    <input type="password" name="passwordAttuale" id="passwordAttuale" class="form-control" required>
                    <div class="input-group-append">
                        <span class="input-group-text" id="toggle-password-attuale">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
            <label for="nuovaPassword">
                <i class="fas fa-lock"></i> Nuova Password
                <br><small class="text-muted"> (Minimo 8 caratteri, almeno una maiuscola e un carattere speciale: !@#$%^&*)</small>
            </label>

                <div class="input-group">
                    <input type="password" name="nuovaPassword" id="nuovaPassword" minlength="8" class="form-control" required>
                    <div class="input-group-append">
                        <span class="input-group-text" id="toggle-password-nuova">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="confermaNuovaPassword">
                    <i class="fas fa-lock"></i> Conferma Nuova Password
                </label>
                <div class="input-group">
                    <input type="password" name="confermaNuovaPassword" id="confermaNuovaPassword" minlength="8" class="form-control" required>
                    <div class="input-group-append">
                        <span class="input-group-text" id="toggle-password-conferma">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
            </div>
            <br>
            <button class="b-form" type="submit">Modifica Password</button>
        </form>
        <div class="feedback"><?php echo $feedbackMessage; ?></div>
    </div>

    <!-- Aggiungi questo script alla fine del tuo HTML -->
    <script>
        $(document).ready(function () {
            $("#toggle-password-attuale").click(function () {
                togglePassword("passwordAttuale");
            });

            $("#toggle-password-nuova").click(function () {
                togglePassword("nuovaPassword");
            });

            $("#toggle-password-conferma").click(function () {
                togglePassword("confermaNuovaPassword");
            });

            function togglePassword(fieldId) {
                var x = document.getElementById(fieldId);
                var icon = document.querySelector(`#${fieldId} + .input-group-append .input-group-text i`);
                if (x.type === "password") {
                    x.type = "text";
                    icon.classList.remove("fa-eye");
                    icon.classList.add("fa-eye-slash");
                } else {
                    x.type = "password";
                    icon.classList.remove("fa-eye-slash");
                    icon.classList.add("fa-eye");
                }
            }
        });
    </script>
</body>
</html>
