<?php
session_start();
require_once 'db.php';

try {
  $stmt = $conn->query("SELECT * FROM cat_merc WHERE immaginiCatMerc IS NOT NULL ORDER BY descrCatMerc ASC");
  $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Errore nella query: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
  <style>
    /* Stile generale */
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: none; /* Nascondi la pagina finché non è completamente caricata */
      flex-direction: column;
      min-height: 100vh;
      justify-content: center; /* Centra verticalmente il contenuto della pagina */
      align-items: center; /* Centra orizzontalmente il contenuto della pagina */
    }

    header {
      background-color: #333;
      color: white;
      text-align: center;
    }

    /* Stile per il container delle categorie */
    .category-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      margin: 20px;
      width: 65%;
      align-items: center; /* Centra verticalmente gli elementi all'interno del container */
    }

    /* Stile per le categorie */
    .category {
      width: calc(33.33% - 10px); /* Occupa 1/3 dello spazio con margine tra le categorie */
      margin-bottom: 20px;
      text-align: center;
    }

    /* Stile per le immagini delle categorie */
    .product-image {
      display: block;
      max-width: 200px;
      max-height: 200px;
      width: auto;
      height: auto;
      border-radius: 50%; /* Rende l'immagine circolare */
      margin: 0 auto;
    }
    .image-button {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        transition: transform 0.2s; /* Aggiungi una transizione per l'effetto di pop */
    }

    .image-button:hover {
        transform: scale(1.1); /* Aumenta leggermente la dimensione al passaggio del mouse */
    }
  </style>
  <title>Ricerca per Categoria</title>
  <script>
    // Nascondi la pagina fino a quando è completamente caricata
    window.addEventListener('load', function() {
      document.body.style.display = 'flex';
    });
  </script>
</head>
<body>
  <header>
    <?php require_once 'header.php'; ?>
  </header>

  <div class="category-container">
    <?php foreach ($categories as $category): ?>
        <div class="category">
          <form action="annunci.php" method="GET">
            <input type="hidden" name="keyword" value="<?= $category['descrCatMerc'] ?>">
            <button type="submit" class="image-button">
                <img
                    src="data:image/jpeg;base64,<?= base64_encode($category['immaginiCatMerc']) ?>"
                    alt="<?= $category['descrCatMerc'] ?>"
                    class="product-image"
                >
            </button>
        </form>

            <h3><?= $category['descrCatMerc'] ?></h3>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
