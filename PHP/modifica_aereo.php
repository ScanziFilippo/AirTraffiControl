<?php
    $immatricolazione = $_GET['immatricolazione'];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    $icao = $connessione->query("SELECT aeroporto_icao FROM aerei WHERE immatricolazione = '".$immatricolazione."'")->fetch_assoc()['aeroporto_icao'];
    $modello = $connessione->query("SELECT modello FROM aerei WHERE immatricolazione = '".$immatricolazione."'")->fetch_assoc()['modello'];
    $compagnia = $connessione->query("SELECT compagnia FROM aerei WHERE immatricolazione = '".$immatricolazione."'")->fetch_assoc()['compagnia'];
    $posizione = $connessione->query("SELECT posizione FROM aerei WHERE immatricolazione = '".$immatricolazione."'")->fetch_assoc()['posizione'];
    $stato = $connessione->query("SELECT stato FROM aerei WHERE immatricolazione = '".$immatricolazione."'")->fetch_assoc()['stato'];
    $pista_id = $connessione->query("SELECT pista_id FROM aerei WHERE immatricolazione = '".$immatricolazione."'")->fetch_assoc()['pista_id'];
    $parcheggio_id = $connessione->query("SELECT parcheggio_id FROM aerei WHERE immatricolazione = '".$immatricolazione."'")->fetch_assoc()['parcheggio_id'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>modifica aereo</title>
        <link rel="stylesheet" href="../CSS/index.css">
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
                        $compagnie = $connessione->query("SELECT nome FROM compagnie ORDER BY nome");
                        while($compagnie_row = $compagnie->fetch_assoc()){
                            echo("<option value='".$compagnie_row['nome']."'>");
                        }
                    ?>
                </datalist>
            <!--<img src="" width="300px">
            <input type="file" name="foto_aereo" placeholder="foto_aereo" id="foto_aereo">
            <img src="" width="300px">
            <input type="file" name="foto_compagnia" placeholder="foto_compagnia">-->
            <input type="text" name="posizione" placeholder="posizione" value="<?php echo($posizione); ?>">
            <select name="stato">
                <?php
                    echo("<option value='Fermo'");
                    if($stato == "Fermo"){
                        echo(" selected");
                    }
                    echo(">Fermo</option>");
                    echo("<option value='In volo'");
                    if($stato == "In volo"){
                        echo(" selected");
                    }
                    echo(">In volo</option>");
                    echo("<option value='Atterrando'");
                    if($stato == "Atterrando"){
                        echo(" selected");
                    }
                    echo(">Atterrando</option>");
                    echo("<option value='Decollando'");
                    if($stato == "Decollando"){
                        echo(" selected");
                    }
                    echo(">Decollando</option>");
                    echo("<option value='In attesa'");
                    if($stato == "In attesa"){
                        echo(" selected");
                    }
                    echo(">In attesa</option>");
                ?>
            </select>
            <select name="pista_id">
                <option value="-">-</option>
                <?php
                    $piste = $connessione->query("SELECT id FROM piste ORDER BY id");
                    while($piste_row = $piste->fetch_assoc()){
                        echo("<option value='".$piste_row['id']."'");
                        if($piste_row['id'] == $pista_id){
                            echo(" selected");
                        }
                        echo(">".$piste_row['id']."</option>");
                    }
                ?>
            </select>
            <select name="parcheggio_id">
                <option value="-">-</option>
                <?php
                    $parcheggi = $connessione->query("SELECT id FROM parcheggi ORDER BY id");
                    while($parcheggi_row = $parcheggi->fetch_assoc()){
                        echo("<option value='".$parcheggi_row['id']."'");
                        if($parcheggi_row['id'] == $parcheggio_id){
                            echo(" selected");
                        }
                        echo(">".$parcheggi_row['id']."</option>");
                    }
                ?>
            </select>
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