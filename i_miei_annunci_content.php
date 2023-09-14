<!DOCTYPE html>
<html>
<head>
    <!-- Includi il foglio di stile Bootstrap -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="i_miei_annunci_style.css">
    <title>I miei annunci</title>

    <script>
        // Mostra il contenuto una volta che il DOM è pronto
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector(".page-container").style.opacity = "1";
        });

        // Funzione per il caricamento asincrono delle immagini
        function loadImagesAsync() {
            const images = document.querySelectorAll(".lazy-load");
            images.forEach(image => {
                const src = image.getAttribute("data-src");
                if (src) {
                    image.src = src;
                }
            });
        }
    </script>
</head>
<body>
    <header>
        <?php require_once 'header.php'; ?>
        
    </header>
    <main> 
        
        <div class="d-flex justify-content-center mt-4">
            <a href="i_miei_annunci.php" class="b-annunci m-2">Annunci</a>
            <a href="i_miei_annunci_approvati.php" class="b-approvati m-2">Approvati</a>
            <a href="i_miei_annunci_non_approvati.php" class="b-nonapprovati m-2">Non Approvati</a>
            <a href="i_miei_annunci_in_approvazione.php" class="b-inapprovazione m-2">In Approvazione</a>
        </div><br>
            <?php if (!empty($anuncios)) { ?>
                <?php foreach ($anuncios as $anuncio) { ?>
                    <div class="announcement">
                        <!-- Colonna sinistra con il carosello -->
                        <div class="left-column col-md-6">
                            <?php
                            $approvalStatus = '';
                            if ($anuncio["approvato"] === 1) {
                                $approvalStatus = 'approved';
                            } elseif ($anuncio["approvato"] === 0) {
                                $approvalStatus = 'not-approved';
                            } else {
                                $approvalStatus = 'pending';
                            }
                            ?>
                            <div class="approval-status <?php echo $approvalStatus; ?>">
                                <?php
                                if ($approvalStatus === 'approved') {
                                    echo 'Approvato';
                                } elseif ($approvalStatus === 'not-approved') {
                                    echo 'Non Approvato';
                                } else {
                                    echo 'In Processo di Approvazione';
                                }
                                ?>
                            </div>
                            <div class="carousel-container">
                                <div id="carouselExample<?php echo $anuncio['idAnnuncio']; ?>" class="carousel slide" data-interval="false">
                                    <div class="carousel-inner">
                                        <?php for ($i = 1; $i <= 6; $i++) {
                                            displayCarouselItem($i, $anuncio);
                                        } ?>
                                    </div>
                                    <?php if (countPhotos($anuncio) > 1) { ?>
                                        <!-- Freccia sinistra per scorrere all'immagine precedente -->
                                        <a class="carousel-control-prev" href="#carouselExample<?php echo $anuncio['idAnnuncio']; ?>" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" style="background-color:#855C00" aria-hidden="true"></span>
                                            <span class="sr-only">Precedente</span>
                                        </a>
                                        
                                        <!-- Freccia destra per scorrere all'immagine successiva -->
                                        <a class="carousel-control-next" href="#carouselExample<?php echo $anuncio['idAnnuncio']; ?>" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Successivo</span>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="right-column col-md-6">
                            <div class="announcement-content">
                                <h3><?php echo $anuncio["titolo"]; ?></h3>
                                <p style='margin-bottom: 0px'><?php echo ottieniDescrizioneCategoria($anuncio["codCatMerc"], $conn); ?></p>
                                <?php
                                $dataInserimento = new DateTime($anuncio["dataInserimento"]);
                                $today = new DateTime();
                                $differenza = $dataInserimento->diff($today);

                                $intervallo = "";

                                if ($differenza->y > 0) {
                                    $intervallo = $differenza->y . " anni fa";
                                } elseif ($differenza->m > 0) {
                                    $intervallo = $differenza->m . " mesi fa";
                                } elseif ($differenza->d > 0) {
                                    $intervallo = $differenza->d . " giorni fa";
                                } elseif ($differenza->days >= 7) {
                                    $settimane = floor($differenza->days / 7);
                                    $intervallo = $settimane . " settimane fa";
                                } else {
                                    $intervallo = "Oggi";
                                }
                                ?>


                                <i><p style='font-size: 13px; color:#855C00'><?php echo $intervallo; ?></p></i>
                                <p><strong>Descrizione: <br></strong><?php echo $anuncio["descr"]; ?></p>
                                <?php if (!empty($anuncio["email"])) { ?>
                                    <div>
                                        <i class="fas fa-envelope" style="color:#855C00;; font-size: 14px"></i>   <?php echo $anuncio["email"]; ?>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($anuncio["linkFacebook"])) { ?>
                                    <div>
                                        <i class="fab fa-facebook" style="color:#855C00"></i> <a href="<?php echo $anuncio["linkFacebook"]; ?>" target="_blank" style= 'color: black; font-size: 14px'>Pagina Facebook</a>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($anuncio["linkVendita"])) { ?>
                                    <div>
                                        <i class="fas fa-external-link-alt" ></i> <a href="<?php echo $anuncio["linkVendita"]; ?>" target="_blank" style= 'color: black; font-size: 14px'>Link di Vendita</a>
                                    </div>
                                <?php } ?>
           
                                <div id="map_<?php echo $anuncio['idAnnuncio']; ?>" style="height: 160px; margin-bottom: 10px; margin-top: 10px"></div>
                                <script>
                                    var coords = '<?php echo $anuncio["posizione"]; ?>'.split(',');
                                    var lat = parseFloat(coords[0].trim());
                                    var lon = parseFloat(coords[1].trim());

                                    var mapElement = document.getElementById("map_<?php echo $anuncio['idAnnuncio']; ?>");

                                    if (mapElement !== null) {
                                        var map = L.map(mapElement).setView([lat, lon], 15);

                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            maxZoom: 19,
                                            attribution: 'OpenStreetMap'
                                        }).addTo(map);

                                        L.marker([lat, lon]).addTo(map)
                                            .bindPopup('Posizione')
                                            .openPopup();
                                    } else {
                                        console.error("Elemento mappa non trovato: map_<?php echo $anuncio['idAnnuncio']; ?>");
                                    }
                                </script>

                                <?php
                                $coords = explode(',', $anuncio["posizione"]);
                                $lat = trim($coords[0]);
                                $lon = trim($coords[1]);

                                $geocodeUrl = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat={$lat}&lon={$lon}";

                                $opts = [
                                    'http' => [
                                        'method' => 'GET',
                                        'header' => "User-Agent: setpronto/1.0\r\n"
                                    ]
                                ];
                                $context = stream_context_create($opts);

                                $geocodeData = file_get_contents($geocodeUrl, false, $context);

                                if ($geocodeData === false) {
                                    echo "Errore durante il recupero dei dati dall'API";
                                } else {
                                    $geocodeJson = json_decode($geocodeData, true);

                                    if ($geocodeJson && isset($geocodeJson["address"])) {
                                        $region = isset($geocodeJson["address"]["state"]) ? $geocodeJson["address"]["state"] : '';
                                        $city = isset($geocodeJson["address"]["city"]) ? $geocodeJson["address"]["city"] : '';

                                        echo "<p style='margin-bottom: 0px'><strong>";

                                        if (!empty($city)) {
                                            echo "{$city}";
                                        }

                                        if (!empty($region)) {
                                            if (!empty($city)) {
                                                echo ", ";
                                            }
                                            echo "{$region}";
                                        }

                                        echo "</strong></p><i><p style='font-size: 13px; color:#855C00''>La posizione è approssimativa.</p></i>";
                                    }
                                }
                                ?>
                       
                     
                            </div>
                            <!-- Aggiungi ulteriori informazioni nella parte destra se necessario -->
                            <!-- Aggiungi questo all'interno del loop foreach -->
                            <div><br><br></div>
                            <div class="b-container">
                                <button class="btn btn-danger" onclick="eliminaAnnuncio(<?php echo $anuncio['idAnnuncio']; ?>)">Elimina</button>
                                <button class="btn btn-primary" onclick="location.href='modifica_annuncio.php?annuncioId=<?php echo $anuncio['idAnnuncio']; ?>'">Modifica</button>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <br><br><br><br><p style = 'font-weight: bold; color:grey; font-size:16px; text-align: center'>In questa sezione non sono presenti annunci.</p>
            <?php } ?>
        </div>
    </main>
    <!-- Includi le librerie JavaScript necessarie -->
    <script>
        // Carica le immagini in modo asincrono dopo il caricamento del DOM
        loadImagesAsync();
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
</body>
</html>

<?php
// Funzione per verificare se ci sono foto in un annuncio
function anyPhotos($anuncio) {
    for ($i = 1; $i <= 6; $i++) {
        if (!empty($anuncio["foto" . $i])) {
            return true;
        }
    }
    return false;
}

// Funzione per contare il numero di foto in un annuncio
function countPhotos($anuncio) {
    $count = 0;
    for ($i = 1; $i <= 6; $i++) {
        if (!empty($anuncio["foto" . $i])) {
            $count++;
        }
    }
    return $count;
}

// Funzione per mostrare l'elemento del carousel
function displayCarouselItem($i, $anuncio) {
    if (!empty($anuncio["foto" . $i])) { ?>
        <div class="carousel-item <?php if ($i === 1) echo 'active'; ?>">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($anuncio["foto" . $i]); ?>" class="d-block mx-auto" alt="Foto <?php echo $i; ?>">
        </div>
    <?php }
}

// Funzione per ottenere la descrizione della categoria
function ottieniDescrizioneCategoria($codCatMerc, $conn) {
    $query = "SELECT descrCatMerc FROM cat_merc WHERE codCatMerc = :codCatMerc";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(":codCatMerc", $codCatMerc, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result["descrCatMerc"];
}

?>

<script>
    function eliminaAnnuncio(idAnnuncio) {
        if (confirm("Sei sicuro di voler segnare l'annuncio come eliminato?")) {
            // Esegui una richiesta AJAX per aggiornare il campo "approvato" nel database
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "elimina_annuncio.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Ricarica la pagina dopo l'aggiornamento del database
                    location.reload();
                }
            };
            xhr.send("idAnnuncio=" + idAnnuncio);
        }
    }
</script>
