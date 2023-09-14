<?php
session_start();
require_once 'db.php';

try {
  $stmt = $conn->query("SELECT * FROM cat_merc WHERE immaginiCatMerc IS NOT NULL ORDER BY descrCatMerc ASC");
  $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Errore nella query: " . $e->getMessage());
}

$descrCatMerc = $_GET['descrCatMerc'] ?? null;
$keyword = $_GET['keyword'] ?? null;

$query = "SELECT ad.*, adt.nome, adt.cognome, cm.descrCatMerc
          FROM annunci_ditte ad
          INNER JOIN anag_ditte adt ON ad.idUtente = adt.idUtente
          INNER JOIN cat_merc cm ON ad.codCatMerc = cm.codCatMerc
          WHERE ad.approvato = 1";

if (!is_null($keyword)) {
  $query .= " AND (
      (cm.descrCatMerc IS NOT NULL AND (cm.descrCatMerc LIKE :keyword))
      OR (ad.titolo IS NOT NULL AND (ad.titolo LIKE :keyword))
  )";
}

if (!is_null($descrCatMerc)) {
  $query .= " AND cm.descrCatMerc = :descrCatMerc";
}

$query .= " ORDER BY ad.idAnnuncio DESC";

$stmt = $conn->prepare($query);

if (!is_null($keyword)) {
  $keyword = '%' . $keyword . '%';
  $stmt->bindValue(":keyword", $keyword, PDO::PARAM_STR);
}

if (!is_null($descrCatMerc)) {
  $stmt->bindParam(":descrCatMerc", $descrCatMerc, PDO::PARAM_STR);
}

$stmt->execute();
$anuncios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="i_miei_annunci_style.css">
  <title>Annunci</title>

  <style>
    .search-container {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
    }

    .search-container input[type="text"] {
      padding: 10px;
      border-radius: 10px;
      border-color: #855C00;
      border-width: 1.5px;
      width: 40%;
      margin-right: 10px;
    }

    .search-container button {
      background-color: #855C00;
      color: white;
      border: none;
      border-radius: 5px;
      padding: 10px 15px;
      cursor: pointer;
    }

    .search-container button i {
      font-size: 18px;
    }

    .category-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      width: 65%;
      align-items: center;
    }
    .dropbtn {
    background-color: #855C00;
    color: white;
    padding: 10px 10px 10px 10px;
    border: none;
    cursor: pointer;
    height: 80px;
    width: 70px;
    }
</style>
</head>

<body>
  <header>
    <div class="dropdown">
        <button class="dropbtn">
        <i class="fas fa-bars" style="font-size: 30px;"></i> <!-- Icona "caret-down" di FontAwesome -->
        </button>
        <div class="dropdown-content" style="text-align: left;">
        <?php foreach ($categories as $category): ?>
            <a style="font-size: 13px;" href="annunci.php?keyword=<?= $category['descrCatMerc'] ?>"><?= $category['descrCatMerc'] ?></a>
        <?php endforeach; ?>
        </div>
    </div>
    <?php require_once 'header.php'; ?>

  </header>
  <main>
    <br>
    <div class="search-container">
      <input type="text" id="filterInput" name="filterInput" placeholder="Cerca per categoria o titolo">
      <button onclick="applyFilter()"><i class="fas fa-search"></i></button>
    </div>

    <?php if (!empty($anuncios)) : ?>
      <?php foreach ($anuncios as $anuncio) : ?>
        <div class="announcement">
          <div class="left-column col-md-6">
            <p><?= $anuncio['cognome'] . ', ' . $anuncio['nome'][0] . '.'; ?></p>
            <div class="carousel-container">
              <div id="carouselExample<?= $anuncio['idAnnuncio']; ?>" class="carousel slide" data-interval="false">
                <div class="carousel-inner">
                  <?php for ($i = 1; $i <= 6; $i++) {
                    displayCarouselItem($i, $anuncio);
                  } ?>
                </div>
                <?php if (countPhotos($anuncio) > 1) : ?>
                  <a class="carousel-control-prev" href="#carouselExample<?= $anuncio['idAnnuncio']; ?>" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Precedente</span>
                  </a>

                  <a class="carousel-control-next" href="#carouselExample<?= $anuncio['idAnnuncio']; ?>" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Successivo</span>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="right-column col-md-6">
            <div class="announcement-content">
              <div>
                <?php $userId; ?>
              </div>
              <h3><?= $anuncio["titolo"]; ?></h3>
              <p style='margin-bottom: 0px'><?= ottieniDescrizioneCategoria($anuncio["codCatMerc"], $conn); ?></p>
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
              <i><p style='font-size: 13px; color:#855C00'><?= $intervallo; ?></p></i>
              <p><strong>Descrizione: <br></strong><?= $anuncio["descr"]; ?></p>
              <?php if (!empty($anuncio["email"])) : ?>
                <div>
                  <i class="fas fa-envelope" style="color:#855C00;; font-size: 14px"></i> <?= $anuncio["email"]; ?>
                </div>
              <?php endif; ?>
              <?php if (!empty($anuncio["linkFacebook"])) : ?>
                <div>
                  <i class="fab fa-facebook" style="color:#855C00"></i> <a href="<?= $anuncio["linkFacebook"]; ?>" target="_blank" style='color: black; font-size: 14px'>Pagina Facebook</a>
                </div>
              <?php endif; ?>
              <?php if (!empty($anuncio["linkVendita"])) : ?>
                <div>
                  <i class="fas fa-external-link-alt"></i> <a href="<?= $anuncio["linkVendita"]; ?>" target="_blank" style='color: black; font-size: 14px'>Link di Vendita</a>
                </div>
              <?php endif; ?>

              <div id="map_<?= $anuncio['idAnnuncio']; ?>" style="height: 160px; margin-bottom: 10px; margin-top: 10px"></div>
              <script>
                var coords = '<?= $anuncio["posizione"]; ?>'.split(',');
                var lat = parseFloat(coords[0].trim());
                var lon = parseFloat(coords[1].trim());

                var mapElement = document.getElementById("map_<?= $anuncio['idAnnuncio']; ?>");

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
                  console.error("Elemento mappa non trovato: map_<?= $anuncio['idAnnuncio']; ?>");
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
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <br><br><br><br>
      <p style='font-weight: bold; color:grey; font-size:16px; text-align: center'>In questa sezione non sono presenti annunci.</p>
    <?php endif; ?>
  </main>
  <script>
    loadImagesAsync();

    function applyFilter() {
      const filterInput = document.getElementById("filterInput").value;
      const currentUrl = window.location.href;

      const urlWithoutQuery = currentUrl.split('?')[0];
      const newUrl = urlWithoutQuery + '?keyword=' + filterInput;

      window.location.href = newUrl;
    }
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
function anyPhotos($anuncio) {
  for ($i = 1; $i <= 6; $i++) {
    if (!empty($anuncio["foto" . $i])) {
      return true;
    }
  }
  return false;
}

function countPhotos($anuncio) {
  $count = 0;
  for ($i = 1; $i <= 6; $i++) {
    if (!empty($anuncio["foto" . $i])) {
      $count++;
    }
  }
  return $count;
}

function displayCarouselItem($i, $anuncio) {
  if (!empty($anuncio["foto" . $i])) { ?>
    <div class="carousel-item <?= ($i === 1) ? 'active' : ''; ?>">
      <img src="data:image/jpeg;base64,<?= base64_encode($anuncio["foto" . $i]); ?>" class="d-block mx-auto" alt="Foto <?= $i; ?>">
    </div>
  <?php }
}

function ottieniDescrizioneCategoria($codCatMerc, $conn) {
  $query = "SELECT descrCatMerc FROM cat_merc WHERE codCatMerc = :codCatMerc";
  $stmt = $conn->prepare($query);
  $stmt->bindParam(":codCatMerc", $codCatMerc, PDO::PARAM_STR);
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  return $result["descrCatMerc"];
}
?>
