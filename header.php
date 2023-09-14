<style>
    :root {
      --colore-principale: #F9DB5C;
      --colore-secondario: #855C00;
      --colore-aggiuntivo-1: #ac7a7a;
      --colore-hover: #E2CB5C;
      --colore-sfondociaro: #FFFFE0;
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

    .button-container {
      display: flex;
      
    }

    .button {
      display: flex;
      padding: 40px 40px;
      font-weight: bold;
      text-decoration: none;
      position: relative;
      padding-left: 40px;
    }

    .button:hover {
      background-color: var(--colore-hover);
    }

    .button.active {
      background-color: var(--colore-secondario);
    }

    .button-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
    }

    .button-icon img {
      width: 45px;
      height: 45px;
      display: block;
    }

    .button-text {
      position: absolute;
      left: 0;
      bottom: -30px;
      display: none;
      background-color: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 4px 10px;
      border-radius: 5px;
      font-size: 12px;
      white-space: nowrap;
      z-index: 1;
    }

    .button:hover .button-text {
      display: block;
    }

    .button:hover .button-icon img {
      filter: brightness(0) invert(1);
    }

    .container {
      max-width: 700px;
      margin: 0 auto;
      padding: 20px;
      background-color: var(--colore-sfondociaro);
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .dropdown {
      position: relative;
      display: inline-block;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
      font-weight: bold;
      white-space: nowrap; 
    }

    .dropdown:hover .dropdown-content {
      display: block;
      white-space: nowrap; 
    }
    .dropdown-content a:active,
    .dropdown-content a:focus,
    .dropdown-content a:hover {
      background-color: var(--colore-secondario);
      color: var(--colore-sfondociaro);
    }
  </style>
  <header>
    <div class="header-content">
      <div class="logo-container">
        <img src="images/SETPRONTO.png" alt="Logo">
      </div>
      <div class="button-container">
        <a href="ricerca_per_categoria.php" class="button">
          <span class="button-icon">
            <img src="images/HOME.png" alt="Home">
          </span>
          <span class="button-text">HOME</span>
        </a>

        <a href="annunci.php" class="button">
          <span class="button-icon">
            <img src="images/RICERCA.png" alt="Ricerca">
          </span>
          <span class="button-text">RICERCA</span>
        </a>

        <?php
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
          echo '
          <div class="dropdown">
            <a class="button">
              <span class="button-icon">
                <img src="images/PROFILO.png" alt="Profilo">
              </span>
              <span class="button-text">AREA PERSONALE</span>
            </a>
            <div class="dropdown-content">
              <a href="nuovo_annuncio.php">NUOVO ANNUNCIO</a>
              <a href="i_miei_annunci.php">I MIEI ANNUNCI</a>
              <a href="pagina2.php?opzione=abbonamenti">ABBONAMENTI</a>
              <a href="anagrafia.php">ANAGRAFIA</a>
              <a href="modifica_password.php">MODIFICA PASSWORD</a>
            </div>
          </div>
          <a href="logout.php" class="button">
            <span class="button-icon">
              <img src="images/Esci.png" alt="Esci">
            </span>
            <span class="button-text">ESCI</span>
          </a>
          ';
        } else {
          echo '
          <a href="login.php" class="button">
            <span class="button-icon">
              <img src="images/PROFILO.png" alt="Login">
            </span>
            <span class="button-text">LOGIN</span>
          </a>
          ';
        }
        ?>
      </div>
    </div>
  </header>

