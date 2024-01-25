<?php
    $immatricolazione = $_GET['immatricolazione'];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    $modello = $connessione->query("SELECT modello FROM aerei WHERE immatricolazione = '".$immatricolazione."'")->fetch_assoc()['modello'];
    $compagnia = $connessione->query("SELECT compagnia FROM aerei WHERE immatricolazione = '".$immatricolazione."'")->fetch_assoc()['compagnia'];
    $passeggeri = $connessione->query("SELECT passeggeri FROM aerei WHERE immatricolazione = '".$immatricolazione."'")->fetch_assoc()['passeggeri'];
    $posizione = $connessione->query("SELECT posizione FROM aerei WHERE immatricolazione = '".$immatricolazione."'")->fetch_assoc()['posizione'];
    $stato = $connessione->query("SELECT stato FROM aerei WHERE immatricolazione = '".$immatricolazione."'")->fetch_assoc()['stato'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>modifica aereo</title>
    </head>
    <body>
        modifica un aereo<br><br>
        <form action="modifica_aereocontroller.php" method="post" enctype="multipart/form-data">
            <input type="text" name="immatricolazione" placeholder="immatricolazione" value="<?php echo($immatricolazione); ?>">
            <input list="aerei" name="modello" placeholder="modello" id="modello" value="<?php echo($modello); ?>" onchange="cercaFotoModello()">
                <datalist id="aerei">
                    <option value="A220">
                    <option value="A300">
                    <option value="A320">
                    <option value="A330">
                    <option value="A340">
                    <option value="A350">
                    <option value="A380">
                    <option value="BAC Concorde">
                    <option value="Boom Overture">
                    <option value="B707">
                    <option value="B717">
                    <option value="B727">
                    <option value="B737">
                    <option value="B747">
                    <option value="B757">
                    <option value="B767">
                    <option value="B777">
                    <option value="B787">
                    <option value="CRJ200">
                    <option value="CRJ700">
                    <option value="CRJ900">
                    <option value="CRJ1000">
                    <option value="E170">
                    <option value="E175">
                    <option value="E190">
                    <option value="E195">
                    <option value="MD11">
                    <option value="MD80">
                    <option value="MD90">
                    <option value="MD95">
                </datalist>
            <input list="compagnie" name="compagnia" placeholder="compagnia" id="compagnia" value="<?php echo($compagnia); ?>" onchange="cercaFotoCompagnia()">
                <datalist id="compagnie">
                    <?php
                        while($compagnie_row = $compagnie->fetch_assoc()){
                            echo("<option value='".$compagnie_row['nome']."'>");
                        }
                    ?>
                </datalist>
            <input type="number" name="passeggeri" value="<?php echo($passeggeri); ?>" placeholder="passeggeri">
            <!--<img src="" width="300px">
            <input type="file" name="foto_aereo" placeholder="foto_aereo" id="foto_aereo">
            <img src="" width="300px">
            <input type="file" name="foto_compagnia" placeholder="foto_compagnia">-->
            <input type="text" name="posizione" placeholder="posizione" value="<?php echo($posizione); ?>">
            <input type="text" name="stato" placeholder="stato" value="<?php echo($stato); ?>">
            <!--<input type="number" name="pista_id" placeholder="pista_id">
            <input type="number" name="parcheggio_id" placeholder="parcheggio_id">-->
            <input list="aeroporti" type="text" name="aeroporto_icao" placeholder="aeroporto_icao" value="<?php echo($icao); ?>" style="text-transform:uppercase">
                <datalist id="aeroporti">
                    <?php
                        $aeroporti = $connessione->query("SELECT icao FROM aeroporti ORDER BY icao");
                        while($aeroporti_row = $aeroporti->fetch_assoc()){
                            echo("<option value='".$aeroporti_row['icao']."'>");
                        }
                    ?>
                </datalist>
            <input type="submit">
        </form>
        <br>
        <a href="index.php">Torna alla home</a>
        <script>
            function cercaFotoModello(){
                var modello = document.getElementById("modello").value;
                document.getElementsByTagName("img")[0].src='../IMG/Aerei/' + modello;
            }
            function cercaFotoCompagnia(){
                var compagnia = document.getElementById("compagnia").value;
                document.getElementsByTagName("img")[1].src='../IMG/Compagnie/' + compagnia;
            }
        </script>
    </body>
</html>