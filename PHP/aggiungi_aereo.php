<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: login");
    }
    $nome_utente = $_SESSION['nome_utente'];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    $compagnie = $connessione->query("SELECT nome FROM compagnie ORDER BY nome");
    $parcheggi = $connessione->query("SELECT id FROM parcheggi WHERE aeroporto_id='". $_SESSION['aeroporto_id'] . "' ORDER BY id");
    $piste = $connessione->query("SELECT id FROM piste WHERE aeroporto_id='". $_SESSION['aeroporto_id'] . "' ORDER BY id");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Aggiungi aereo</title>
        <link rel="stylesheet" href="../CSS/index.css">
    </head>
    <body style="padding-left:20px; padding-top:20px">
        Aggiungi un aereo<br><br>
        <form action="aggiungi_aereocontroller" method="post" enctype="multipart/form-data">
            <input type="text" name="immatricolazione" placeholder="immatricolazione" style="text-transform:uppercase">
            <input list="aerei" name="modello" placeholder="modello" id="modello" onchange="cercaFotoModello()">
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
            <input list="compagnie" name="compagnia" placeholder="compagnia" id="compagnia" onchange="cercaFotoCompagnia()">
                <datalist id="compagnie">
                    <?php
                        while($compagnie_row = $compagnie->fetch_assoc()){
                            echo("<option value='".$compagnie_row['nome']."'>");
                        }
                    ?>
                </datalist>
            <img src="" width="300px"><!--
            <input type="file" name="foto_aereo" placeholder="foto_aereo" id="foto_aereo">
            <img src="" width="300px">
            <input type="file" name="foto_compagnia" placeholder="foto_compagnia">
            <input type="text" name="posizione" placeholder="posizione">-->
            <!--<input type="text" name="stato" placeholder="stato">-->
            <select name="stato">
                <option value="Fermo">Fermo</option>
                <option value="In volo">In volo</option>
                <option value="Atterrando">Atterrando</option>
                <option value="Decollando">Decollando</option>
                <option value="In attesa">In attesa</option>
            </select>
            <!--<input type="number" name="pista_id" placeholder="pista_id">
            <input type="number" name="parcheggio_id" placeholder="parcheggio_id">-->
            Pista
            <select name="pista_id">
                <option value="-">-</option>
                <?php
                    while($piste_row = $piste->fetch_assoc()){
                        echo("<option value='".$piste_row['id']."'>".$piste_row['id']."</option>");
                    }
                ?>
            </select>
            Parcheggio
            <select name="parcheggio_id">
                <option value="-">-</option>
                <?php
                    while($parcheggi_row = $parcheggi->fetch_assoc()){
                        echo("<option value='".$parcheggi_row['id']."'>".$parcheggi_row['id']."</option>");
                    }
                ?>
            </select>
            <!--<input list="aeroporti" type="text" name="aeroporto_icao" placeholder="aeroporto_icao" style="text-transform:uppercase">
                <datalist id="aeroporti">
                    <?php
                        $aeroporti = $connessione->query("SELECT icao FROM aeroporti ORDER BY icao");
                        while($aeroporti_row = $aeroporti->fetch_assoc()){
                            echo("<option value='".$aeroporti_row['icao']."'>");
                        }
                    ?>
                </datalist>-->
            <input type="submit">
        </form>
        <br>
        <?php
        if(isset($_GET['err'])){?>
        <p style="color: red"> <?php echo $_GET['err']; ?> </p> 
        <?php
            }
        ?>
        <a href="index">Torna alla home</a>
        <script>
            /*function cercaFotoModello(){
                var modello = document.getElementById("modello").value;
                document.getElementsByTagName("img")[0].src='../IMG/Aerei/' + modello;
            }
            function cercaFotoCompagnia(){
                var compagnia = document.getElementById("compagnia").value;
                document.getElementsByTagName("img")[1].src='../IMG/Compagnie/' + compagnia;
            }*/
        </script>
    </body>
</html>