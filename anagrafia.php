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

$idUtente = $_SESSION["idUtente"];

$sql = "SELECT * FROM anag_ditte WHERE idUtente = '$idUtente'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "Anagrafica non trovata.";
    exit;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Anagrafica Profilo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="anagrafia_style.css">
</head>
<body>
    <header><?php require_once 'header.php'; ?></header><br>
    <main>
        <div class="profile-container">
            <div class="image-name-container">
                <img class="profile-picture" src="<?php echo $row['img_profile'] ? $row['img_profile'] : 'images/PROFILO.png'; ?>" alt="Immagine del profilo">
                <div class="profile-name">
                    <?php echo htmlspecialchars($row["nome"] . " " . $row["cognome"]); ?>
                </div>
            </div>
        </div> <br>
        <div class="profile-container">
            <div class="categories-list">
                <h2>Informazione</h2>
                <ul>
                    <li class="category-item selected" data-section="dati_personali">Dati personali</li>
                    <li class="category-item" data-section="dettagli_azienda">Dettagli sull'azienda</li>
                    <li class="category-item" data-section="indirizzo">Indirizzo</li>
                    <li class="category-item" data-section="informazioni_contatto">Contatti</li>
                    <li class="category-item" data-section="domande">Domande</li>
                </ul>
            </div>
            <div class="data-container">
                <div class="dati_personali personal-info">
                    <div class="h-container">
                        <h3>Dati personali</h3>
                    </div>
                    <!-- Dati personali -->
                    <p><strong><i class="fas fa-briefcase"></i>Professione:</strong> <?php echo htmlspecialchars($row["professione"]); ?></p>
                    <p><strong><i class="fas fa-envelope"></i>Email:</strong> <?php echo htmlspecialchars($row["mail"]); ?></p>
                    <p><strong><i class="fas fa-mobile-alt"></i>Cellulare:</strong> <?php echo htmlspecialchars($row["cellulare"]); ?></p>
                    <p><strong><i class="fas fa-phone"></i>Telefono 1:</strong> <?php echo htmlspecialchars($row["telefono"]); ?></p>
                    <p><strong><i class="fas fa-phone"></i>Telefono 2:</strong> <?php echo htmlspecialchars($row["telefono2"]); ?></p>
                    <p><strong><i class="fas fa-phone"></i>Telefono 3:</strong> <?php echo htmlspecialchars($row["telefono3"]); ?></p>
                    <p><strong><i class="fas fa-fax"></i>Fax:</strong> <?php echo htmlspecialchars($row["fax"]); ?></p>
                    <p><strong><i class="far fa-calendar"></i>Data di Registrazione:</strong> <?php echo date('d F Y', strtotime($row["dataReg"])); ?></p>
                    <br>
                    <!-- Pulsante per attivare il popup di modifica -->
                    <button id="modifica-button" data-target="popup-overlay" class="b-modifica">
                        <i class="fas fa-pencil-alt"></i> Modifica
                     </button>   
                    <!-- Popup Overlay -->
                    <div class="popup-overlay" id="popup-overlay">
                        <!-- Popup Container -->
                        <div class="popup-container">
                            <!-- Titolo del Popup -->
                            <div class="popup-title">Modifica Dati Personali</div>
                            <!-- Contenuto del Popup -->
                            <form method="post" action="update_anagrafia.php" id="form-modifica">
                                <!-- Campi per la modifica dei dati personali -->
                                <label for="nuovoNome"><i class="fas fa-briefcase"></i>Nome:</label>
                                <input type="text" name="nuovoNome" id="nuovoNome" placeholder="Nuovo Nome" value="<?php echo htmlspecialchars($row["nome"]); ?>">
                                <label for="nuovoCognome"><i class="fas fa-briefcase"></i>Cognome:</label>
                                <input type="text" name="nuovoCognome" id="nuovoCognome" placeholder="Nuovo Cognome" value="<?php echo htmlspecialchars($row["cognome"]); ?>">
                                <label for="nuovaProfessione"><i class="fas fa-briefcase"></i>Professione:</label>
                                <input type="text" name="nuovaProfessione" id="nuovaProfessione" placeholder="Nuova Professione" value="<?php echo htmlspecialchars($row["professione"]); ?>">
                                <label for="nuovaEmail"><i class="fas fa-envelope"></i>Nuova Email:</label>
                                <input type="text" name="nuovaEmail" id="nuovaEmail" placeholder="Nuova Email" value="<?php echo htmlspecialchars($row["mail"]); ?>">
                                <label for="nuovoCellulare"><i class="fas fa-mobile-alt"></i>Cellulare:</label>
                                <input type="text" name="nuovoCellulare" id="nuovoCellulare" placeholder="Nuovo Cellulare" value="<?php echo htmlspecialchars($row["cellulare"]); ?>">
                                <label for="nuovoTelefono1"><i class="fas fa-phone"></i>Telefono:</label>
                                <input type="text" name="nuovoTelefono1" id="nuovoTelefono1" placeholder="Nuovo Telefono" value="<?php echo htmlspecialchars($row["telefono"]); ?>">
                                <label for="nuovoTelefono2"><i class="fas fa-phone"></i>Telefono 2:</label>
                                <input type="text" name="nuovoTelefono2" id="nuovoTelefono2" placeholder="Nuovo Telefono 2" value="<?php echo htmlspecialchars($row["telefono2"]); ?>">
                                <label for="nuovoTelefono3"><i class="fas fa-phone"></i>Telefono 3:</label>
                                <input type="text" name="nuovoTelefono3" id="nuovoTelefono3" placeholder="Nuovo Telefono 3" value="<?php echo htmlspecialchars($row["telefono3"]); ?>">
                                <label for="nuovoFax"><i class="fas fa-fax"></i> Fax:</label>
                                <input type="text" name="nuovoFax" id="nuovoFax" placeholder="Nuovo Fax" value="<?php echo htmlspecialchars($row["fax"]); ?>">
                                <button class="popup-button b-salva" type="submit">Salva</button>
                                <button class="popup-button b-anulla" id="popup-cancel-button">Annulla</button>
                            </form>
                            <!-- Pulsante di chiusura del Popup -->
                            <span class="popup-close-button" id="popup-close-button">×</span>
                        </div>
                    </div>
                </div>
                <div class="dettagli_azienda personal-info">
                    <div class="h-container">
                        <h3>Dettagli sull'azienda</h3>
                    </div>
                    <!-- Dettagli sull'azienda -->
                    <p><strong><i class="fas fa-layer-group"></i> Tipologia:</strong> <?php echo htmlspecialchars($row["tipologia"]); ?></p>
                    <p><strong><i class="fas fa-building"></i> Ragione Sociale:</strong> <?php echo htmlspecialchars($row["ragioneSociale"]); ?></p>
                    <p><strong><i class="fas fa-id-card"></i> Codice Fiscale:</strong> <?php echo htmlspecialchars($row["cfiscPiva"]); ?></p>
                    <p><strong><i class="fas fa-sticky-note"></i> Descrizione Breve:</strong> <?php echo htmlspecialchars($row["descrBreve"]); ?></p>
                    <p><strong><i class="fas fa-file-alt"></i> Descrizione Completa:</strong> <?php echo htmlspecialchars($row["descrCompleta"]); ?></p>
                    <p><strong><i class="fas fa-globe"></i> Sito Web:</strong> <a href="<?php echo htmlspecialchars($row["sitoWeb"]); ?>" target="_blank"><?php echo htmlspecialchars($row["sitoWeb"]); ?></a></p>
                    <p><strong><i class="fab fa-skype"></i> Skype:</strong> <?php echo htmlspecialchars($row["skype"]); ?></p>

                    <!-- Pulsante per attivare il popup di modifica -->
                    <button id="modifica-button-azienda" data-target="popup-overlay-azienda" class="b-modifica">
                        <i class="fas fa-pencil-alt"></i> Modifica
                    </button>

                    <!-- Popup Overlay per la sezione "Dettagli Azienda" -->
                    <div class="popup-overlay" id="popup-overlay-azienda">
                        <!-- Popup Container -->
                        <div class="popup-container">
                            <!-- Titolo del Popup -->
                            <div class="popup-title">Modifica Dettagli Azienda</div>
                            <!-- Contenuto del Popup -->
                            <form method="post" action="update_anagrafia.php" id="form-modifica-azienda">
                                <!-- Campi per la modifica dei dettagli azienda -->
                                <label for="nuovaTipologia"><i class="fas fa-layer-group"></i>Tipologia:</label>
                                <input type="text" name="nuovaTipologia" id="nuovaTipologia" placeholder="Nuova Tipologia" value="<?php echo htmlspecialchars($row["tipologia"]); ?>">
                                <label for="nuovaRagioneSociale"><i class="fas fa-building"></i>Ragione Sociale:</label>
                                <input type="text" name="nuovaRagioneSociale" id="nuovaRagioneSociale" placeholder="Nuova Ragione Sociale" value="<?php echo htmlspecialchars($row["ragioneSociale"]); ?>">
                                <label for="nuovoCodiceFiscale"><i class="fas fa-id-card"></i>Codice Fiscale:</label>
                                <input type="text" name="nuovoCodiceFiscale" id="nuovoCodiceFiscale" placeholder="Nuovo Codice Fiscale" value="<?php echo htmlspecialchars($row["cfiscPiva"]); ?>">
                                <label for="nuovaDescrizioneBreve"><i class="fas fa-sticky-note"></i>Descrizione Breve:</label>
                                <input type="text" name="nuovaDescrizioneBreve" id="nuovaDescrizioneBreve" placeholder="Nuova Descrizione Breve" value="<?php echo htmlspecialchars($row["descrBreve"]); ?>">
                                <label for="nuovaDescrizioneCompleta"><i class="fas fa-file-alt"></i>Descrizione Completa:</label>
                                <input type="text" name="nuovaDescrizioneCompleta" id="nuovaDescrizioneCompleta" placeholder="Nuova Descrizione Completa" value="<?php echo htmlspecialchars($row["descrCompleta"]); ?>">
                                <label for="nuovoSitoWeb"><i class="fas fa-globe"></i>Sito Web:</label>
                                <input type="text" name="nuovoSitoWeb" id="nuovoSitoWeb" placeholder="Nuovo Sito Web" value="<?php echo htmlspecialchars($row["sitoWeb"]); ?>">
                                <label for="nuovoSkype"><i class="fab fa-skype"></i>Skype:</label>
                                <input type="text" name="nuovoSkype" id="nuovoSkype" placeholder="Nuovo Skype" value="<?php echo htmlspecialchars($row["skype"]); ?>">
                                <button class="popup-button b-salva" type="submit">Salva</button>
                                <button class="popup-button b-anulla" id="popup-cancel-azienda-button">Annulla</button>
                            </form>
                            <!-- Pulsante di chiusura del Popup -->
                            <span class="popup-close-button" id="popup-close-button-azienda">×</span>
                        </div>
                    </div>
                </div>

                <div class="indirizzo personal-info">
                    <div class="h-container">
                        <h3>Indirizzo</h3>
                    </div>
                    <!-- Indirizzo -->
                    <p><strong><i class="fas fa-map-marker-alt"></i> Indirizzo:</strong> <?php echo htmlspecialchars($row["indirizzo"]); ?></p>
                    <p><strong><i class="fas fa-map"></i> Provincia:</strong> <?php echo htmlspecialchars($row["provincia"]); ?></p>
                    <p><strong><i class="fas fa-city"></i> Città:</strong> <?php echo htmlspecialchars($row["citta"]); ?></p>
                    <p><strong><i class="fas fa-envelope-open-text"></i> CAP:</strong> <?php echo htmlspecialchars($row["cap"]); ?></p>

                    <!-- Pulsante per attivare il popup di modifica -->
                    <button id="modifica-button-indirizzo" data-target="popup-overlay-indirizzo" class="b-modifica">
                        <i class="fas fa-pencil-alt"></i> Modifica
                    </button>

                    <!-- Popup Overlay per la sezione "Indirizzo" -->
                    <div class="popup-overlay" id="popup-overlay-indirizzo">
                        <!-- Popup Container -->
                        <div class="popup-container">
                            <!-- Titolo del Popup -->
                            <div class="popup-title">Modifica Indirizzo</div>
                            <!-- Contenuto del Popup -->
                            <form method="post" action="update_anagrafia.php" id="form-modifica-indirizzo">
                                <!-- Campi per la modifica dell'indirizzo -->
                                <label for="nuovoIndirizzo"><i class="fas fa-map-marker-alt"></i>Indirizzo:</label>
                                <input type="text" name="nuovoIndirizzo" id="nuovoIndirizzo" placeholder="Nuovo Indirizzo" value="<?php echo htmlspecialchars($row["indirizzo"]); ?>">
                                <?php require_once 'provincia.php'; ?>
                                <label for="nuovaCitta"><i class="fas fa-city"></i>Città:</label>
                                <input type="text" name="nuovaCitta" id="nuovaCitta" placeholder="Nuova Città" value="<?php echo htmlspecialchars($row["citta"]); ?>">
                                <label for="nuovoCAP"><i class="fas fa-envelope-open-text"></i>CAP:</label>
                                <input type="text" name="nuovoCAP" id="nuovoCAP" placeholder="Nuovo CAP" value="<?php echo htmlspecialchars($row["cap"]); ?>">
                                <button class="popup-button b-salva" type="submit">Salva</button>
                                <button class="popup-button b-anulla" id="popup-cancel-indirizzo-button">Annulla</button>
                            </form>
                            <!-- Pulsante di chiusura del Popup -->
                            <span class="popup-close-button" id="popup-close-button-indirizzo">×</span>
                        </div>
                    </div>
                </div>

                <div class="informazioni_contatto personal-info">
                    <div class="h-container">
                        <h3>Contatti</h3>
                    </div>
                    <!-- Contatti -->
                    <p><strong><i class="fas fa-user"></i> Contatto:</strong> <?php echo htmlspecialchars($row["contatto"]); ?></p>
                    <p><strong><i class="fas fa-phone"></i> Telefono Contatto:</strong> <?php echo htmlspecialchars($row["telefonoContatto"]); ?></p>
                    <p><strong><i class="fas fa-mobile-alt"></i> Cellulare Contatto:</strong> <?php echo htmlspecialchars($row["cellulareContatto"]); ?></p>
                    <p><strong><i class="fas fa-fax"></i> Fax Contatto:</strong> <?php echo htmlspecialchars($row["faxContatto"]); ?></p>
                    <p><strong><i class="fas fa-envelope"></i> Email Contatto:</strong> <?php echo htmlspecialchars($row["mailContatto"]); ?></p>

                    <!-- Pulsante per attivare il popup di modifica -->
                    <button id="modifica-button-contatti" data-target="popup-overlay-contatti" class="b-modifica">
                        <i class="fas fa-pencil-alt"></i> Modifica
                    </button>

                    <!-- Popup Overlay per la sezione "Contatti" -->
                    <div class="popup-overlay" id="popup-overlay-contatti">
                        <!-- Popup Container -->
                        <div class="popup-container">
                            <!-- Titolo del Popup -->
                            <div class="popup-title">Modifica Contatti</div>
                            <!-- Contenuto del Popup -->
                            <form method="post" action="update_anagrafia.php" id="form-modifica-contatti">
                                <!-- Campi per la modifica dei contatti -->
                                <label for="nuovoContatto"><i class="fas fa-user"></i> Contatto:</label>
                                <input type="text" name="nuovoContatto" id="nuovoContatto" placeholder="Nuovo Contatto" value="<?php echo htmlspecialchars($row["contatto"]); ?>">
                                
                                <label for="nuovoTelefonoContatto"><i class="fas fa-phone"></i> Telefono Contatto:</label>
                                <input type="text" name="nuovoTelefonoContatto" id="nuovoTelefonoContatto" placeholder="Nuovo Telefono Contatto" value="<?php echo htmlspecialchars($row["telefonoContatto"]); ?>">
                                
                                <label for="nuovoCellulareContatto"><i class="fas fa-mobile-alt"></i> Cellulare Contatto:</label>
                                <input type="text" name="nuovoCellulareContatto" id="nuovoCellulareContatto" placeholder="Nuovo Cellulare Contatto" value="<?php echo htmlspecialchars($row["cellulareContatto"]); ?>">
                                
                                <label for="nuovoFaxContatto"><i class="fas fa-fax"></i> Fax Contatto:</label>
                                <input type="text" name="nuovoFaxContatto" id="nuovoFaxContatto" placeholder="Nuovo Fax Contatto" value="<?php echo htmlspecialchars($row["faxContatto"]); ?>">
                                
                                <label for="nuovaEmailContatto"><i class="fas fa-envelope"></i> Email Contatto:</label>
                                <input type="text" name="nuovaEmailContatto" id="nuovaEmailContatto" placeholder="Nuova Email Contatto" value="<?php echo htmlspecialchars($row["mailContatto"]); ?>">
                                
                                <button class="popup-button b-salva" type="submit">Salva</button>
                                <button class="popup-button b-anulla" id="popup-cancel-contatti-button">Annulla</button>
                            </form>
                            <!-- Pulsante di chiusura del Popup -->
                            <span class="popup-close-button" id="popup-close-button-contatti">×</span>
                        </div>
                    </div>
                </div>

                <div class="domande personal-info">
                    <div class="h-container">
                        <h3>Domande</h3>
                    </div>
                    <!-- Domande -->
                    <p><strong><i class="fas fa-question"></i> Domanda 1:</strong> <?php echo htmlspecialchars($row["domanda1"]); ?></p>
                    <p><strong><i class="fas fa-question"></i> Domanda 2:</strong> <?php echo htmlspecialchars($row["domanda2"]); ?></p>

                    <!-- Pulsante per attivare il popup di modifica -->
                    <button id="modifica-button-domande" data-target="popup-overlay-domande" class="b-modifica">
                        <i class="fas fa-pencil-alt"></i> Modifica
                    </button>

                    <!-- Popup Overlay per la sezione "Domande" -->
                    <div class="popup-overlay" id="popup-overlay-domande">
                        <!-- Popup Container -->
                        <div class="popup-container">
                            <!-- Titolo del Popup -->
                            <div class="popup-title">Modifica Domande</div>
                            <!-- Contenuto del Popup -->
                            <form method="post" action="update_anagrafia.php" id="form-modifica-domande">
                                <!-- Campi per la modifica delle domande -->
                                <label for="nuovaDomanda1"><i class="fas fa-question"></i> Domanda 1:</label>
                                <input type="text" name="nuovaDomanda1" id="nuovaDomanda1" placeholder="Nuova Domanda 1" value="<?php echo htmlspecialchars($row["domanda1"]); ?>">
                                
                                <label for="nuovaDomanda2"><i class="fas fa-question"></i> Domanda 2:</label>
                                <input type="text" name="nuovaDomanda2" id="nuovaDomanda2" placeholder="Nuova Domanda 2" value="<?php echo htmlspecialchars($row["domanda2"]); ?>">
                                
                                <button class="popup-button b-salva" type="submit">Salva</button>
                                <button class="popup-button b-anulla" id="popup-cancel-domande-button">Annulla</button>
                            </form>
                            <!-- Pulsante di chiusura del Popup -->
                            <span class="popup-close-button" id="popup-close-button-domande">×</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const categoryItems = document.querySelectorAll(".category-item");
        const personalInfoSections = document.querySelectorAll(".personal-info");

        // Nascondi tutte le sezioni tranne "Dati personali"
        personalInfoSections.forEach(function (section) {
            section.style.display = "none";
        });
        document.querySelector(".dati_personali").style.display = "block"; // Mostra solo "Dati personali" all'avvio

        categoryItems.forEach(function (item) {
            item.addEventListener("click", function () {
                categoryItems.forEach(function (item) {
                    item.classList.remove("selected");
                });
                this.classList.add("selected");

                const sectionToShow = this.getAttribute("data-section");
                personalInfoSections.forEach(function (section) {
                    section.style.display = "none";
                });
                document.querySelector("." + sectionToShow).style.display = "block"; // Usa "block" invece di "flex"
            });
        });

        // Gestione dei moduli di modifica per tutte le sezioni
        function setupModificaModulo(buttonId, formId, overlayId, closeButtonId, cancelId) {
            const modificaButton = document.getElementById(buttonId);
            const formModifica = document.getElementById(formId);
            const popupOverlay = document.getElementById(overlayId);
            const popupCloseButton = document.getElementById(closeButtonId);
            const popupCancelButton = document.getElementById(cancelId);

            modificaButton.addEventListener("click", function () {
                // Mostra il modulo di modifica quando il pulsante viene cliccato
                popupOverlay.style.display = "block";
            });

            popupCloseButton.addEventListener("click", function () {
                // Chiudi il popup quando il pulsante di chiusura viene cliccato
                popupOverlay.style.display = "none";
            });

            popupCancelButton.addEventListener("click", function () {
                // Chiudi il popup anche se si clicca su "Annulla"
                popupOverlay.style.display = "none";
            });
        }

        // Configura i moduli di modifica per tutte le sezioni
        setupModificaModulo("modifica-button", "form-modifica", "popup-overlay", "popup-close-button", "popup-cancel-button");
        setupModificaModulo("modifica-button-azienda", "form-modifica-azienda", "popup-overlay-azienda", "popup-close-button-azienda", "popup-cancel-azienda-button");
        setupModificaModulo("modifica-button-indirizzo", "form-modifica-indirizzo", "popup-overlay-indirizzo", "popup-close-button-indirizzo", "popup-cancel-indirizzo-button");
        setupModificaModulo("modifica-button-contatti", "form-modifica-contatti", "popup-overlay-contatti", "popup-close-button-contatti", "popup-cancel-contatti-button");
        setupModificaModulo("modifica-button-domande", "form-modifica-domande", "popup-overlay-domande", "popup-close-button-domande", "popup-cancel-domande-button");
    });
</script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
