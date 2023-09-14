<?php
session_start();

// Connessione al database (sostituisci con le tue credenziali)
require_once 'db.php';

// Verifica se l'utente è loggato, altrimenti reindirizza alla pagina di login
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

// Funzione per ottenere le categorie mercadologiche dalla tabella cat_merc
function getCategorie($conn) {
    $query = "SELECT codCatMerc, descrCatMerc FROM cat_merc";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Ottenere le categorie e creare le opzioni per il menu a tendina
$categorie = getCategorie($conn);
$categoryOptions = "";
foreach ($categorie as $categoria) {
    $categoryOptions .= "<option value='" . $categoria["codCatMerc"] . "'>" . $categoria["descrCatMerc"] . "</option>";
}

// Recupera l'ID dell'annuncio da modificare dalla query string (assumendo che sia passato come parametro "id" nell'URL)
if (isset($_GET['annuncioId'])) {
    $annuncioId = $_GET['annuncioId'];
} else {
    // Gestione dell'errore se l'ID dell'annuncio non è stato fornito
    echo "ID dell'annuncio non specificato.";
    exit;
}
var_dump($annuncioId);
// Recupera i dati dell'annuncio da modificare dal database
$query = "SELECT * FROM annunci_ditte WHERE idAnnuncio = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$annuncioId]);
$annuncio = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$annuncio) {
    // Gestione dell'errore se l'annuncio non esiste
    echo "Annuncio non trovato.";
    exit;
}

// Verificare se il metodo di richiesta è POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ottieni i dati dal modulo
    $titolo = $_POST["titolo"];
    $categoriaMerc = $_POST["categoriaMerc"];
    $email_contatto = $_POST["email_contatto"];
    $link_vendita = $_POST["link_vendita"];
    $link_facebook = $_POST["link_facebook"];
    $posizione = $_POST["coordenadas"]; // Ottieni le coordinate dalla variabile nascosta
    $descr = $_POST["descr"];
    $dataInserimento = date("Y-m-d");
    $dataScadenza = date("Y-m-d", strtotime("+1 month", strtotime($dataInserimento)));
    $idUtente = $_SESSION["idUtente"];
    
    // Creare un array per memorizzare le foto caricate
    $fotos = array();
    
    // Scorrere i file caricati e salvarli nell'array se sono validi
    for ($i = 1; $i <= 6; $i++) {
        if (is_uploaded_file($_FILES['foto' . $i]['tmp_name'])) {
            $fotos[] = file_get_contents($_FILES['foto' . $i]['tmp_name']);
        } else {
            // Mantieni le foto esistenti se non vengono caricate nuove foto
            $fotos[] = $annuncio["foto" . $i];
        }
    }
    
    // Preparare la query per aggiornare l'annuncio nella tabella annunci_ditte
    $updateQuery = "UPDATE annunci_ditte SET 
                    idUtente = ?,
                    email = ?,
                    approvato = 2,
                    codCatMerc = ?,
                    posizione = ?,
                    dataInserimento = ?,
                    titolo = ?,
                    descr = ?,
                    linkVendita = ?,
                    linkFacebook = ?,
                    dataScadenza = ?,
                    foto1 = ?,
                    foto2 = ?,
                    foto3 = ?,
                    foto4 = ?,
                    foto5 = ?,
                    foto6 = ?
                    WHERE idAnnuncio = ?";
    $stmt = $conn->prepare($updateQuery);
    
    // Creare un array con i valori dei parametri
    $params = [
        $idUtente,
        $email_contatto,
        $categoriaMerc,
        $posizione,
        $dataInserimento,
        $titolo,
        $descr,
        $link_vendita,
        $link_facebook,
        $dataScadenza,
    ];
    
    // Unire l'array con l'array di foto
    $params = array_merge($params, $fotos);
    
    // Aggiungi l'ID dell'annuncio per l'aggiornamento
    $params[] = $annuncioId;
    
    // Eseguire il binding dei parametri
    for ($i = 0; $i < count($params); $i++) {
        $stmt->bindValue($i + 1, $params[$i]);
    }
    
    if ($stmt->execute()) {
        // Reindirizza l'utente alla pagina i_miei_annunci.php
        header("Location: i_miei_annunci.php");
        exit(); // Assicurati di terminare l'esecuzione dello script dopo il reindirizzamento
    } else {
        echo "Errore durante l'aggiornamento dell'annuncio: " . $stmt->errorInfo()[2];
    }    
    
    // Chiudere lo statement
    $stmt->closeCursor(); // Aggiunto per chiudere il cursore
}

// Chiudere la connessione PDO
$conn = null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Modifica Annuncio</title>
    <link rel="stylesheet" href="annuncio_form_style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        $(document).ready(function() {
            $('#imageCarousel').carousel(); // Inicializa el carrusel
        });
        function selectFile(inputId) {
            document.getElementById(inputId).click();
        }

    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <header>
        <?php require_once 'header.php'; ?>
    </header>
    <main>
        <div class="page-container">
            <br>
            <div class="form-container" id="annuncioForm">
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"] . "?annuncioId=" . $annuncioId; ?>" enctype="multipart/form-data" onsubmit="return confermaInvio();">
                    <div>
                        <h2 class='salutation'>Modifica Annuncio</h2>
                     </div>
                    <div class="row">
                    <div class="col-md-6">
                        <div id="imageCarousel" class="carousel-container carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                            <?php for ($i = 1; $i <= 6; $i++) {
                                $photoColumn = 'foto' . $i;
                                $imageData = $annuncio[$photoColumn] ?? null;
                                $isActive = ($i === 1) ? ' active' : '';
                                ?>

                                <div class="carousel-item<?= $isActive ?>">
                                    <div class="image-preview" id="preview<?= $i ?>" onclick="selectFile('foto<?= $i ?>');">
                                        <input type="file" name="foto<?= $i ?>" id="foto<?= $i ?>" accept="image/*" style="display: none;" onchange="showPreview('preview<?= $i ?>', this)">
                                        <?php if (!empty($imageData)) { ?>
                                            <img style="z-index: 0;" src="data:image/jpeg;base64,<?= base64_encode($imageData) ?>">
                                        <?php } else { ?>
                                            <div style="height: 450px;"></div>
                                            <span class="image-number" id="imageNumber<?= $i ?>"><?php echo $i; ?></span>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                            <a class="na-carousel-control-prev" href="#imageCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="na-carousel-control-next" href="#imageCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div><br>


                        <div class="form-group">
                            <label for="descr">Descrizione:</label>
                            <textarea name="descr" id="descr" rows="4" placeholder="Inserisci una descrizione"><?= $annuncio['descr'] ?></textarea>
                        </div>
                    </div>

    

                               
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="titolo" id="titolo" placeholder="Titolo" required value="<?= $annuncio['titolo'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="categoriaMerc">Categoria:</label>
                                <select name="categoriaMerc" id="categoriaMerc" required>
                                <option value="" disabled>Seleziona una categoria</option>
                                <?php
                                    foreach ($categorie as $categoria) {
                                        $selected = ($annuncio['codCatMerc'] == $categoria["codCatMerc"]) ? "selected" : "";
                                        echo "<option value='" . $categoria["codCatMerc"] . "' $selected>" . $categoria["descrCatMerc"] . "</option>";
                                    }
                                ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email_contatto"> Email di Contatto:</label>
                                <input type="text" name="email_contatto" id="email_contatto" placeholder="Inserisci un indirizzo email" value="<?= $annuncio['email'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="link_vendita">Link di Vendita:</label>
                                <input type="url" name="link_vendita" id="link_vendita" placeholder="Inserisci un link di vendita" value="<?= $annuncio['linkVendita'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="link_facebook">Link di Facebook:</label>
                                <input type="url" name="link_facebook" id="link_facebook" placeholder="Inserisci un link di Facebook" value="<?= $annuncio['linkFacebook'] ?>">
                            </div>
                            <div class="form-group">
                                <label for="posizione">Posizione:</label>
                                <input type="text" name="posizione" id="posizione" placeholder="Cerca l'area di diffusione" required value="<?= $annuncio['posizione'] ?>">
                                <div id="map" style="width: 95%; height: 250px; margin-top: 20px"></div>
                            </div>
                            <!-- ... Altri campi ... -->
                            <input type="hidden" name="coordenadas" id="coordenadas" value="<?= $annuncio['posizione'] ?>">
                            <div class="form-group">
                                <input type="submit" value="Salva Modifiche">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
 
        </div>
        
    </main>


    <script>
        function showPreview(previewId, input) {
            var preview = document.getElementById(previewId);
            var plusIcon = document.getElementById("plusIcon" + input.id.slice(-1));

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.style.backgroundImage = `url('${e.target.result}')`;
                    plusIcon.style.display = "none";
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.backgroundImage = "none";
                plusIcon.style.display = "block";
            }
        }
    </script>
    <script>
        var map = L.map("map").setView([41.9028, 12.4964], 10);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: "© OpenStreetMap"
        }).addTo(map);

        var marker;

        document.getElementById("posizione").addEventListener("input", function() {
            var inputText = this.value;

            if (marker) {
                map.removeLayer(marker);
            }

            if (inputText) {
                var apiUrl = "https://nominatim.openstreetmap.org/search?format=json&q=" + encodeURIComponent(inputText);

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            var lat = parseFloat(data[0].lat);
                            var lon = parseFloat(data[0].lon);

                            map.setView([lat, lon], 15);
                            marker = L.marker([lat, lon]).addTo(map);

                            document.getElementById("coordenadas").value = lat + "," + lon;
                        }
                    })
                    .catch(error => {
                        console.error("Error:", error);
                    });
            }
        });
    </script>
    <script>
        function confermaInvio() {
            // Mostra un messaggio di conferma
            var confermato = confirm("Sei sicuro di voler inviare questo modulo?");

            // Se l'utente ha confermato, restituisci true per inviare il form
            // Se l'utente ha annullato, restituisci false per impedire l'invio del form
            return confermato;
        }
    </script>
</body>
</html>
