<label for="nuovaRProvincia"><i class="fas fa-map"></i> Regione:</label><br>
    <select name="nuovaProvincia" id="nuovaProvincia">
    <option value="AG" <?php if ($row["provincia"] === "AG") echo "selected"; ?>>Agrigento</option>
    <option value="AL" <?php if ($row["provincia"] === "AL") echo "selected"; ?>>Alessandria</option>
    <option value="AN" <?php if ($row["provincia"] === "AN") echo "selected"; ?>>Ancona</option>
    <option value="AO" <?php if ($row["provincia"] === "AO") echo "selected"; ?>>Aosta</option>
    <option value="AR" <?php if ($row["provincia"] === "AR") echo "selected"; ?>>Arezzo</option>
    <option value="AP" <?php if ($row["provincia"] === "AP") echo "selected"; ?>>Ascoli Piceno</option>
    <option value="AT" <?php if ($row["provincia"] === "AT") echo "selected"; ?>>Asti</option>
    <option value="AV" <?php if ($row["provincia"] === "AV") echo "selected"; ?>>Avellino</option>
    <option value="BA" <?php if ($row["provincia"] === "BA") echo "selected"; ?>>Bari</option>
    <option value="BT" <?php if ($row["provincia"] === "BT") echo "selected"; ?>>Barletta-Andria-Trani</option>
    <option value="BL" <?php if ($row["provincia"] === "BL") echo "selected"; ?>>Belluno</option>
    <option value="BN" <?php if ($row["provincia"] === "BN") echo "selected"; ?>>Benevento</option>
    <option value="BG" <?php if ($row["provincia"] === "BG") echo "selected"; ?>>Bergamo</option>
    <option value="BI" <?php if ($row["provincia"] === "BI") echo "selected"; ?>>Biella</option>
    <option value="BO" <?php if ($row["provincia"] === "BO") echo "selected"; ?>>Bolonia</option>
    <option value="BZ" <?php if ($row["provincia"] === "BZ") echo "selected"; ?>>Bolzano</option>
    <option value="BS" <?php if ($row["provincia"] === "BS") echo "selected"; ?>>Brescia</option>
    <option value="BR" <?php if ($row["provincia"] === "BR") echo "selected"; ?>>Brindisi</option>
    <option value="CA" <?php if ($row["provincia"] === "CA") echo "selected"; ?>>Cagliari</option>
    <option value="CL" <?php if ($row["provincia"] === "CL") echo "selected"; ?>>Caltanissetta</option>
    <option value="CB" <?php if ($row["provincia"] === "CB") echo "selected"; ?>>Campobasso</option>
    <option value="CI" <?php if ($row["provincia"] === "CI") echo "selected"; ?>>Carbonia-Iglesias</option>
    <option value="CE" <?php if ($row["provincia"] === "CE") echo "selected"; ?>>Caserta</option>
    <option value="CT" <?php if ($row["provincia"] === "CT") echo "selected"; ?>>Catania</option>
    <option value="CZ" <?php if ($row["provincia"] === "CZ") echo "selected"; ?>>Catanzaro</option>
    <option value="CH" <?php if ($row["provincia"] === "CH") echo "selected"; ?>>Chieti</option>
    <option value="CO" <?php if ($row["provincia"] === "CO") echo "selected"; ?>>Como</option>
    <option value="CS" <?php if ($row["provincia"] === "CS") echo "selected"; ?>>Cosenza</option>
    <option value="CR" <?php if ($row["provincia"] === "CR") echo "selected"; ?>>Cremona</option>
    <option value="KR" <?php if ($row["provincia"] === "KR") echo "selected"; ?>>Crotone</option>
    <option value="CN" <?php if ($row["provincia"] === "CN") echo "selected"; ?>>Cuneo</option>
    <option value="EN" <?php if ($row["provincia"] === "EN") echo "selected"; ?>>Enna</option>
    <option value="FM" <?php if ($row["provincia"] === "FM") echo "selected"; ?>>Fermo</option>
    <option value="FE" <?php if ($row["provincia"] === "FE") echo "selected"; ?>>Ferrara</option>
    <option value="FI" <?php if ($row["provincia"] === "FI") echo "selected"; ?>>Florencia</option>
    <option value="FG" <?php if ($row["provincia"] === "FG") echo "selected"; ?>>Foggia</option>
    <option value="FC" <?php if ($row["provincia"] === "FC") echo "selected"; ?>>Forlì-Cesena</option>
    <option value="FR" <?php if ($row["provincia"] === "FR") echo "selected"; ?>>Frosinone</option>
    <option value="GE" <?php if ($row["provincia"] === "GE") echo "selected"; ?>>Génova</option>
    <option value="GO" <?php if ($row["provincia"] === "GO") echo "selected"; ?>>Gorizia</option>
    <option value="GR" <?php if ($row["provincia"] === "GR") echo "selected"; ?>>Grosseto</option>
    <option value="IM" <?php if ($row["provincia"] === "IM") echo "selected"; ?>>Imperia</option>
    <option value="IS" <?php if ($row["provincia"] === "IS") echo "selected"; ?>>Isernia</option>
    <option value="SP" <?php if ($row["provincia"] === "SP") echo "selected"; ?>>La Spezia</option>
    <option value="AQ" <?php if ($row["provincia"] === "AQ") echo "selected"; ?>>L'Aquila</option>
    <option value="LT" <?php if ($row["provincia"] === "LT") echo "selected"; ?>>Latina</option>
    <option value="LE" <?php if ($row["provincia"] === "LE") echo "selected"; ?>>Lecce</option>
    <option value="LC" <?php if ($row["provincia"] === "LC") echo "selected"; ?>>Lecco</option>
    <option value="LI" <?php if ($row["provincia"] === "LI") echo "selected"; ?>>Livorno</option>
    <option value="LO" <?php if ($row["provincia"] === "LO") echo "selected"; ?>>Lodi</option>
    <option value="LU" <?php if ($row["provincia"] === "LU") echo "selected"; ?>>Lucca</option>
    <option value="MC" <?php if ($row["provincia"] === "MC") echo "selected"; ?>>Macerata</option>
    <option value="MN" <?php if ($row["provincia"] === "MN") echo "selected"; ?>>Mantua</option>
    <option value="MS" <?php if ($row["provincia"] === "MS") echo "selected"; ?>>Massa-Carrara</option>
    <option value="MT" <?php if ($row["provincia"] === "MT") echo "selected"; ?>>Matera</option>
    <option value="VS" <?php if ($row["provincia"] === "VS") echo "selected"; ?>>Medio Campidano</option>
    <option value="ME" <?php if ($row["provincia"] === "ME") echo "selected"; ?>>Mesina</option>
    <option value="MI" <?php if ($row["provincia"] === "MI") echo "selected"; ?>>Milán</option>
    <option value="MO" <?php if ($row["provincia"] === "MO") echo "selected"; ?>>Módena</option>
    <option value="MB" <?php if ($row["provincia"] === "MB") echo "selected"; ?>>Monza y Brianza</option>
    <option value="NA" <?php if ($row["provincia"] === "NA") echo "selected"; ?>>Nápoles</option>
    <option value="NO" <?php if ($row["provincia"] === "NO") echo "selected"; ?>>Novara</option>
    <option value="NU" <?php if ($row["provincia"] === "NU") echo "selected"; ?>>Nuoro</option>
    <option value="OG" <?php if ($row["provincia"] === "OG") echo "selected"; ?>>Ogliastra</option>
    <option value="OT" <?php if ($row["provincia"] === "OT") echo "selected"; ?>>Olbia-Tempio</option>
    <option value="OR" <?php if ($row["provincia"] === "OR") echo "selected"; ?>>Oristán</option>
    <option value="PD" <?php if ($row["provincia"] === "PD") echo "selected"; ?>>Padua</option>
    <option value="PA" <?php if ($row["provincia"] === "PA") echo "selected"; ?>>Palermo</option>
    <option value="PR" <?php if ($row["provincia"] === "PR") echo "selected"; ?>>Parma</option>
    <option value="PV" <?php if ($row["provincia"] === "PV") echo "selected"; ?>>Pavia</option>
    <option value="PG" <?php if ($row["provincia"] === "PG") echo "selected"; ?>>Perusa</option>
    <option value="PU" <?php if ($row["provincia"] === "PU") echo "selected"; ?>>Pesaro y Urbino</option>
    <option value="PE" <?php if ($row["provincia"] === "PE") echo "selected"; ?>>Pescara</option>
    <option value="PC" <?php if ($row["provincia"] === "PC") echo "selected"; ?>>Plasencia</option>
    <option value="PI" <?php if ($row["provincia"] === "PI") echo "selected"; ?>>Pisa</option>
    <option value="PT" <?php if ($row["provincia"] === "PT") echo "selected"; ?>>Pistoia</option>
    <option value="PN" <?php if ($row["provincia"] === "PN") echo "selected"; ?>>Pordenone</option>
    <option value="PZ" <?php if ($row["provincia"] === "PZ") echo "selected"; ?>>Potenza</option>
    <option value="PO" <?php if ($row["provincia"] === "PO") echo "selected"; ?>>Prato</option>
    <option value="RG" <?php if ($row["provincia"] === "RG") echo "selected"; ?>>Ragusa</option>
    <option value="RA" <?php if ($row["provincia"] === "RA") echo "selected"; ?>>Rávena</option>
    <option value="RC" <?php if ($row["provincia"] === "RC") echo "selected"; ?>>Reggio de Calabria</option>
    <option value="RE" <?php if ($row["provincia"] === "RE") echo "selected"; ?>>Reggio Emilia</option>
    <option value="RI" <?php if ($row["provincia"] === "RI") echo "selected"; ?>>Rieti</option>
    <option value="RN" <?php if ($row["provincia"] === "RN") echo "selected"; ?>>Rímini</option>
    <option value="RM" <?php if ($row["provincia"] === "RM") echo "selected"; ?>>Roma</option>
    <option value="RO" <?php if ($row["provincia"] === "RO") echo "selected"; ?>>Rovigo</option>
    <option value="SA" <?php if ($row["provincia"] === "SA") echo "selected"; ?>>Salerno</option>
    <option value="SS" <?php if ($row["provincia"] === "SS") echo "selected"; ?>>Sassari</option>
    <option value="SV" <?php if ($row["provincia"] === "SV") echo "selected"; ?>>Savona</option>
    <option value="SI" <?php if ($row["provincia"] === "SI") echo "selected"; ?>>Siena</option>
    <option value="SR" <?php if ($row["provincia"] === "SR") echo "selected"; ?>>Siracusa</option>
    <option value="SO" <?php if ($row["provincia"] === "SO") echo "selected"; ?>>Sondrio</option>
    <option value="TA" <?php if ($row["provincia"] === "TA") echo "selected"; ?>>Tarento</option>
    <option value="TE" <?php if ($row["provincia"] === "TE") echo "selected"; ?>>Teramo</option>
    <option value="TR" <?php if ($row["provincia"] === "TR") echo "selected"; ?>>Terni</option>
    <option value="TO" <?php if ($row["provincia"] === "TO") echo "selected"; ?>>Turín</option>
    <option value="TP" <?php if ($row["provincia"] === "TP") echo "selected"; ?>>Trapani</option>
    <option value="TN" <?php if ($row["provincia"] === "TN") echo "selected"; ?>>Trento</option>
    <option value="TV" <?php if ($row["provincia"] === "TV") echo "selected"; ?>>Treviso</option>
    <option value="TS" <?php if ($row["provincia"] === "TS") echo "selected"; ?>>Trieste</option>
    <option value="UD" <?php if ($row["provincia"] === "UD") echo "selected"; ?>>Údine</option>
    <option value="VA" <?php if ($row["provincia"] === "VA") echo "selected"; ?>>Varese</option>
    <option value="VE" <?php if ($row["provincia"] === "VE") echo "selected"; ?>>Venecia</option>
    <option value="VB" <?php if ($row["provincia"] === "VB") echo "selected"; ?>>Verbano-Cusio-Ossola</option>
    <option value="VC" <?php if ($row["provincia"] === "VC") echo "selected"; ?>>Vercelli</option>
    <option value="VR" <?php if ($row["provincia"] === "VR") echo "selected"; ?>>Verona</option>
    <option value="VV" <?php if ($row["provincia"] === "VV") echo "selected"; ?>>Vibo Valentia</option>
    <option value="VI" <?php if ($row["provincia"] === "VI") echo "selected"; ?>>Vicenza</option>
    <option value="VT" <?php if ($row["provincia"] === "VT") echo "selected"; ?>>Viterbo</option>
</select><br><br>
