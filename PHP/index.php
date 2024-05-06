<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: Controllori/login");
    }
    if(isset($_SESSION['aeroporto_icao'])){
        $connessione = new mysqli('localhost', 'root', '', 'progetto');
        $query = "SELECT * FROM aeroporti WHERE icao = '".$_SESSION['aeroporto_icao']."'";
        $result = $connessione->query($query);
        if($result->num_rows == 0 || $result->fetch_assoc()['nome'] == null){
            header("Location: Aeroporti/modifica");
        }
    }
?>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="../CSS/index.css">
    </head>
    <body>
        <div style='display: flex; justify-content: space-between;'>
            <div style='padding-left: 20px; padding-top:10px;'>
                <h1>Benvenuto
                    <a href="Controllori/profilo">
                        <?php 
                            echo $_SESSION['nome_utente'];
                        ?>
                    </a>
                    「 
                    <?php
                        echo $_SESSION['aeroporto_icao'];
                    ?>
                    」
                </h1>
                <a href="aggiungi_aereo"><h2>Aggiungi aereo (totali: 
                    <?php
                        echo($connessione->query("SELECT * FROM aerei INNER JOIN luoghi ON aerei.luogo=luoghi.id WHERE aeroporto_id = '".$_SESSION['aeroporto_id']."'")->num_rows);
                    ?>
                    )
                </h2></a>
            </div>
            <div style='padding-right: 20px; padding-top:10px;'>
                <!--<h2><a href="Voli/visualizza">Cronologia Voli</a></h2>-->
                <h2><a href="api">Api</a></h2>
            </div>
        </div>
        <?php
            $aerei = $connessione->query("SELECT immatricolazione, modello, compagnia, luogo, stato, aerei.id FROM aerei INNER JOIN luoghi ON aerei.luogo=luoghi.id WHERE aeroporto_id = '".$_SESSION['aeroporto_id']."' AND stato = 'in volo'");
            if($aerei->num_rows > 0){
            echo("<div style=padding:10px><h3 style=padding:10px;
            >In aria</h3>");
            }
            while($aerei_row = $aerei->fetch_assoc()){
                /*echo("<tr>");
                echo("<td>".$aerei_row['immatricolazione']."</td>");
                echo("<td>".$aerei_row['modello']."</td>");
                echo("<td>".$aerei_row['compagnia']."</td>");
                echo("<td><img src='../IMG/Aerei/".$aerei_row['modello']."' width='200px'></td>");
                echo("<td><img src='../IMG/Compagnie/".$aerei_row['compagnia']."' width='200px'></td>");
                echo("<td>".$aerei_row['posizione']."</td>");
                //echo("<td>".$aerei_row['stato']."</td>");
                echo("<td><img src='https://flagsapi.com/". strtoupper(substr($aerei_row['immatricolazione'], 0, 2)) . "/flat/64.png'></td>");
                //echo("<td><a href='modifica_aereo?id=".$aerei_row['id']."'>Modifica</a></td>");
                echo("</tr>");*/
                echo("<div style=display:inline-block;padding:10px; class='aereo' id=". $aerei_row['id']."> 
                    <div style=display:inline-block;>
                    <!--<img src='../IMG/Aerei/".$aerei_row['modello']."' width='200px'><br>-->
                    <img src='../IMG/aereo.jpg' border=1 width='200px'><br>
                </div>
                    <div style=display:inline-block;padding:10px>
                    <p>Immatricolazione: ".$aerei_row['immatricolazione']."</p>
                        <p>Modello: ".$aerei_row['modello']."</p>
                        <p>Compagnia: ".$aerei_row['compagnia']."</p>");
                        echo("<p>Posizione: In volo</p>
                        <img src='https://flagsapi.com/". strtoupper(substr($aerei_row['immatricolazione'], 0, 2)) . "/flat/64.png' width='32px'><br><br>
                        <a href='modifica_aereo?id=".$aerei_row['id']."'>Modifica</a>
                    </div>
                </div>");
            }
            if($aerei->num_rows > 0){
                echo("</div>");
            }
            $aerei = $connessione->query("SELECT immatricolazione, modello, compagnia, luogo, stato, aerei.id FROM aerei INNER JOIN luoghi ON aerei.luogo=luoghi.id WHERE aeroporto_id = '".$_SESSION['aeroporto_id']."' AND stato = 'fermo'");
            if($aerei->num_rows > 0){
            echo("<div style=padding:10px><h3 style=padding:10px;
            >Fermo</h3>");
            }
            while($aerei_row = $aerei->fetch_assoc()){
                echo("<div style=display:inline-block;padding:10px; class='aereo' id=". $aerei_row['id']."> 
                    <div style=display:inline-block;>
                        <!--<img src='../IMG/Aerei/".$aerei_row['modello']."' width='200px'><br>-->
                        <img src='../IMG/aereo.jpg' border=1 width='200px'><br>
                    </div>
                    <div style=display:inline-block;padding:10px>
                    <p>Immatricolazione: ".$aerei_row['immatricolazione']."</p>
                        <p>Modello: ".$aerei_row['modello']."</p>
                        <p>Compagnia: ".$aerei_row['compagnia']."</p>");
                        echo("<p>Posizione: Parcheggio ".$connessione->query("SELECT nome FROM luoghi WHERE id = '".$aerei_row['luogo']."'")->fetch_assoc()['nome']."</p>
                        <img src='https://flagsapi.com/". strtoupper(substr($aerei_row['immatricolazione'], 0, 2)) . "/flat/64.png' width='32px'><br><br>
                        <a href='modifica_aereo?id=".$aerei_row['id']."'>Modifica</a>
                    </div>
                </div>");
            }
            if($aerei->num_rows > 0){
                echo("</div>");
            }
            $aerei = $connessione->query("SELECT immatricolazione, modello, compagnia, luogo, stato, aerei.id FROM aerei INNER JOIN luoghi ON aerei.luogo=luoghi.id WHERE aeroporto_id = '".$_SESSION['aeroporto_id']."' AND stato = 'in attesa'");
            if($aerei->num_rows > 0){
            echo("<div style=padding:10px><h3 style=padding:10px;
            >In attesa</h3>");
            }
            while($aerei_row = $aerei->fetch_assoc()){
                echo("<div style=display:inline-block;padding:10px; class='aereo' id=". $aerei_row['id']."> 
                    <div style=display:inline-block;>
                        <!--<img src='../IMG/Aerei/".$aerei_row['modello']."' width='200px'><br>-->
                        <img src='../IMG/aereo.jpg' border=1 width='200px'><br>
                    </div>
                    <div style=display:inline-block;padding:10px>
                    <p>Immatricolazione: ".$aerei_row['immatricolazione']."</p>
                        <p>Modello: ".$aerei_row['modello']."</p>
                        <p>Compagnia: ".$aerei_row['compagnia']."</p>
                        <img src='https://flagsapi.com/". strtoupper(substr($aerei_row['immatricolazione'], 0, 2)) . "/flat/64.png' width='32px'><br><br>
                        <a href='modifica_aereo?id=".$aerei_row['id']."'>Modifica</a>
                    </div>
                </div>");
            }
            if($aerei->num_rows > 0){
                echo("</div>");
            }
            $aerei = $connessione->query("SELECT immatricolazione, modello, compagnia, luogo, stato, aerei.id FROM aerei INNER JOIN luoghi ON aerei.luogo=luoghi.id WHERE aeroporto_id = '".$_SESSION['aeroporto_id']."' AND stato = 'decollando'");
            if($aerei->num_rows > 0){
            echo("<div style=padding:10px><h3 style=padding:10px;
            >Decollando</h3>");
            }
            while($aerei_row = $aerei->fetch_assoc()){
                echo("<div style=display:inline-block;padding:10px; class='aereo' id=". $aerei_row['id']."> 
                    <div style=display:inline-block;>
                        <!--<img src='../IMG/Aerei/".$aerei_row['modello']."' width='200px'><br>-->
                        <img src='../IMG/aereo.jpg' border=1 width='200px'><br>
                    </div>
                    <div style=display:inline-block;padding:10px>
                    <p>Immatricolazione: ".$aerei_row['immatricolazione']."</p>
                        <p>Modello: ".$aerei_row['modello']."</p>
                        <p>Compagnia: ".$aerei_row['compagnia']."</p>");
                        echo("<p>Posizione: Pista ".$connessione->query("SELECT nome FROM luoghi WHERE id = '".$aerei_row['luogo']."'")->fetch_assoc()['nome']."</p>
                        <img src='https://flagsapi.com/". strtoupper(substr($aerei_row['immatricolazione'], 0, 2)) . "/flat/64.png' width='32px'><br><br>
                        <a href='modifica_aereo?id=".$aerei_row['id']."'>Modifica</a>
                    </div>
                </div>");
            }
            if($aerei->num_rows > 0){
                echo("</div>");
            }
            $aerei = $connessione->query("SELECT immatricolazione, modello, compagnia, luogo, stato, aerei.id FROM aerei INNER JOIN luoghi ON aerei.luogo=luoghi.id WHERE aeroporto_id = '".$_SESSION['aeroporto_id']."' AND stato = 'atterrando'");
            if($aerei->num_rows > 0){
            echo("<div style=padding:10px><h3 style=padding:10px;
            >Atterrando</h3>");
            }
            while($aerei_row = $aerei->fetch_assoc()){
                echo("<div style=display:inline-block;padding:10px; class='aereo' id=". $aerei_row['id']."> 
                    <div style=display:inline-block;>
                        <!--<img src='../IMG/Aerei/".$aerei_row['modello']."' width='200px'><br>-->
                        <img src='../IMG/aereo.jpg' border=1 width='200px'><br>
                    </div>
                    <div style=display:inline-block;padding:10px>
                    <p>Immatricolazione: ".$aerei_row['immatricolazione']."</p>
                        <p>Modello: ".$aerei_row['modello']."</p>
                        <p>Compagnia: ".$aerei_row['compagnia']."</p>");
                        echo("<p>Posizione: Pista ".$connessione->query("SELECT nome FROM luoghi WHERE id = '".$aerei_row['luogo']."'")->fetch_assoc()['nome']."</p>
                        <img src='https://flagsapi.com/". strtoupper(substr($aerei_row['immatricolazione'], 0, 2)) . "/flat/64.png' width='32px'><br><br>
                        <a href='modifica_aereo?id=".$aerei_row['id']."'>Modifica</a>
                    </div>
                </div>");
            }
            if($aerei->num_rows > 0){
                echo("</div>");
            }

            ?>
        <!--</table>-->
        <script>
            for(var i = 0; i < document.getElementsByClassName("aereo").length; i++){
                //document.getElementsByClassName("aereo")[i].getElementsByTagName("div")[1].appendChild(document.createElement("button")).innerHTML = "Sposta";
                document.getElementsByClassName("aereo")[i].addEventListener("mouseover", function(){
                    <?php
                        /*if($connessione->query("SELECT stato FROM aerei WHERE immatricolazione = '".?> this.id <?php."'")->fetch_assoc()['stato'] == "in aria") {
                            echo("this.getElementsByTagName('div')[1].appendChild(document.createElement('button')).innerHTML = 'Atterra';");
                        }*/
                    ?>
                    //this.getElementsByTagName("div")[1].appendChild(document.createElement("button")).innerHTML = "Sposta";
                });
            }
        </script>
    </body>
</html>