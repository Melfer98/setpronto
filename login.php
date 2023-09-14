<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbsetpronto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Errore di connessione: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM anag_ditte WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION["loggedin"] = true;
        $_SESSION["idUtente"] = $row["idUtente"];
        $_SESSION["email"] = $row["email"];
        $_SESSION["username"] = ucfirst($row["cognome"]);
        header("Location: ricerca_per_categoria.php");
        exit();
    } else {
        $error = "Credenziali non valide.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            text-align: center;
            width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .error {
            color: red;
        }
        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2><br>
        <div><img src="images\SETPRONTO.png" width="250"></div><br><br><br>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div><label for="email">Email:</label>
            <input type="email" name="email" required></div>
            <br>
            <div><label for="password">Password:</label>
            <input type="password" name="password" required></div>
            <br>
            <input type="submit" value="Accedi">
        </form><br>
        <?php if (isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
        <p>Hai dimenticato la tua password? <a href="recuperar_contrasena.php">Recuperala qui</a></p>
        
    </div>
</body>
</html>

