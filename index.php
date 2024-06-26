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
            header("Location: Aeroporti/registra");
        }
        if($connessione->query("SELECT * FROM luoghi WHERE aeroporto_id='". $_SESSION['aeroporto_id'] . "' AND tipo='0'")->num_rows == 0){
            $connessione->query("INSERT INTO luoghi (aeroporto_id, tipo, nome) VALUES ('". $_SESSION['aeroporto_id'] . "', '0', '". $_SESSION['aeroporto_icao'] ."')");
        }
        $aeroporti=$connessione->query("SELECT * FROM luoghi WHERE tipo=0");
        $parcheggi=$connessione->query("SELECT * FROM luoghi WHERE aeroporto_id='". $_SESSION['aeroporto_id'] . "' AND tipo='1'");
    }
?>
<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" href="CSS/index.css">
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
                <a href="Aerei/aggiungi_aereo"><h2>Aggiungi aereo (totali: 
                    <?php
                        echo($connessione->query("SELECT * FROM aerei INNER JOIN luoghi ON aerei.luogo=luoghi.id WHERE aeroporto_id = '".$_SESSION['aeroporto_id']."'")->num_rows);
                    ?>
                    )
                </h2></a>
            </div>
            <div style='padding-right: 20px; padding-top:10px;'>
                <!--<h2><a href="Voli/visualizza">Cronologia Voli</a></h2>-->
                <h2><a href="api">Api</a></h2>
                <h2><a href="Voli/visualizza">Cronologia voli</a></h2>
                <h2><a href="test">Test</a></h2>
            </div>
        </div>
        <?php
            $aerei = $connessione->query("SELECT immatricolazione, modello, compagnia, luogo, stato, aerei.id, destinazione FROM aerei INNER JOIN voli ON aerei.id = voli.aereo_id WHERE luogo = 1 AND partenza = ".$_SESSION['aeroporto_id'] ." AND data_arrivo is NULL");
            $aerei2 = $connessione->query("SELECT immatricolazione, modello, compagnia, luogo, stato, aerei.id, partenza FROM aerei INNER JOIN voli ON aerei.id = voli.aereo_id WHERE luogo = 1 AND destinazione = ".$_SESSION['aeroporto_id'] ." AND data_arrivo is NULL");
            if($aerei->num_rows > 0 || $aerei2->num_rows > 0){
            echo("<div style=padding:10px><h3 style=padding:10px;
            >In transito</h3>");
            }
            while($aerei_row = $aerei->fetch_assoc()){
                echo("<div style=display:inline-block;padding:10px; class='aereo' id=". $aerei_row['id']."> 
                    <div style=display:inline-block;>
                    <!--<img src='IMG/Aerei/".$aerei_row['modello']."' width='200px'><br>-->
                    <img src='IMG/aereoVola.jpg' border=1 width='200px'><br>
                </div>
                    <div style=display:inline-block;padding:10px>
                    <p>Immatricolazione: ".$aerei_row['immatricolazione']."</p>
                        <p>Modello: ".$aerei_row['modello']."</p>
                        <p>Compagnia: ".$aerei_row['compagnia']."</p>");
                        echo("<p>Posizione: In volo verso ".$connessione->query("SELECT icao FROM aeroporti WHERE id = '".$aerei_row['destinazione']."'")->fetch_assoc()['icao']."</p>
                        <img src='https://flagsapi.com/". strtoupper(substr($aerei_row['immatricolazione'], 0, 2)) . "/flat/64.png' width='32px'><br><br>
                        <a href='Aerei/modifica_aereo?id=".$aerei_row['id']."'>Modifica</a>
                    </div>
                    <div>
                        <form action='Aerei/sposta_aereo' method='post'>
                            <input type='hidden' name='id' value='" . $aerei_row['id'] . "'>
                            <input type='hidden' name='azione' value='annulla_transito'>
                            <input type='submit' value='Annulla'>
                        </form>
                    </div>
                </div>");
            }
            while($aerei_row = $aerei2->fetch_assoc()){
                echo("<div style=display:inline-block;padding:10px; class='aereo' id=". $aerei_row['id']."> 
                    <div style=display:inline-block;>
                    <!--<img src='IMG/Aerei/".$aerei_row['modello']."' width='200px'><br>-->
                    <img src='IMG/aereoVola.jpg' border=1 width='200px'><br>
                </div>
                    <div style=display:inline-block;padding:10px>
                    <p>Immatricolazione: ".$aerei_row['immatricolazione']."</p>
                        <p>Modello: ".$aerei_row['modello']."</p>
                        <p>Compagnia: ".$aerei_row['compagnia']."</p>");
                        echo("<p>Posizione: In volo da ".$connessione->query("SELECT icao FROM aeroporti WHERE id = '".$aerei_row['partenza']."'")->fetch_assoc()['icao']."</p>
                        <img src='https://flagsapi.com/". strtoupper(substr($aerei_row['immatricolazione'], 0, 2)) . "/flat/64.png' width='32px'><br><br>
                        <a href='Aerei/modifica_aereo?id=".$aerei_row['id']."'>Modifica</a>
                    </div>
                    <div>
                        <form action='Aerei/sposta_aereo' method='post'>
                            <input type='hidden' name='id' value='" . $aerei_row['id'] . "'>
                            <input type='hidden' name='azione' value='accetta_transito'>
                            <input type='submit' value='Accetta'>
                        </form>
                    </div>
                </div>");
            }
            if($aerei->num_rows > 0 || $aerei2->num_rows > 0){
                echo("</div>");
            }
            $aerei = $connessione->query("SELECT immatricolazione, modello, compagnia, luogo, stato, aerei.id FROM aerei INNER JOIN luoghi ON aerei.luogo=luoghi.id WHERE aeroporto_id = '".$_SESSION['aeroporto_id']."' AND stato = 'in volo'");
            if($aerei->num_rows > 0){
            echo("<div style=padding:10px><h3 style=padding:10px;
            >In aria</h3>");
            }
            while($aerei_row = $aerei->fetch_assoc()){
                echo("<div style=display:inline-block;padding:10px; class='aereo' id=". $aerei_row['id']."> 
                    <div style=display:inline-block;>
                    <!--<img src='IMG/Aerei/".$aerei_row['modello']."' width='200px'><br>-->
                    <img src='IMG/aereoVola.jpg' border=1 width='200px'><br>
                </div>
                    <div style=display:inline-block;padding:10px>
                    <p>Immatricolazione: ".$aerei_row['immatricolazione']."</p>
                        <p>Modello: ".$aerei_row['modello']."</p>
                        <p>Compagnia: ".$aerei_row['compagnia']."</p>");
                        echo("<p>Posizione: In volo</p>
                        <img src='https://flagsapi.com/". strtoupper(substr($aerei_row['immatricolazione'], 0, 2)) . "/flat/64.png' width='32px'><br><br>
                        <a href='Aerei/modifica_aereo?id=".$aerei_row['id']."'>Modifica</a>
                    </div>
                    <div>
                        <form action='Aerei/sposta_aereo' method='post'>
                            <input type='hidden' name='id' value='" . $aerei_row['id'] . "'>
                            <select name='azione'>
                                <option value='atterra'>Atterra</option>
                                <option value='sposta'>Sposta</option>
                            </select>
                            <select name='luogo'>
                                ");
                                $luoghi = $connessione->query("SELECT luoghi.id, luoghi.nome FROM luoghi LEFT JOIN aerei ON luoghi.id = aerei.luogo WHERE tipo=2 AND aeroporto_id ='". $_SESSION["aeroporto_id"]."' AND aerei.id iS NULL ORDER BY nome");
                                while($luogo = $luoghi->fetch_assoc()){
                                    echo("<option value='".$luogo['id']."'>Pista ".$luogo['nome']."</option>");
                                }
                                echo("
                            </select>
                            <input type='submit' value='Sposta'>
                        </form>
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
                        <!--<img src='IMG/Aerei/".$aerei_row['modello']."' width='200px'><br>-->
                        <img src='IMG/aereoDecolla.jpg' border=1 width='200px'><br>
                    </div>
                    <div style=display:inline-block;padding:10px>
                    <p>Immatricolazione: ".$aerei_row['immatricolazione']."</p>
                        <p>Modello: ".$aerei_row['modello']."</p>
                        <p>Compagnia: ".$aerei_row['compagnia']."</p>");
                        echo("<p>Posizione: Pista ".$connessione->query("SELECT nome FROM luoghi WHERE id = '".$aerei_row['luogo']."'")->fetch_assoc()['nome']."</p>
                        <img src='https://flagsapi.com/". strtoupper(substr($aerei_row['immatricolazione'], 0, 2)) . "/flat/64.png' width='32px'><br><br>
                        <a href='Aerei/modifica_aereo?id=".$aerei_row['id']."'>Modifica</a>
                    </div>
                    <div>
                        <form action='Aerei/sposta_aereo' method='post'>
                            <input type='hidden' name='id' value='" . $aerei_row['id'] . "'>
                            <select name='azione' onchange='if(this.value==\"decollato\"){this.form.luogo.visibility=\"hidden\";this.form.luogo.disabled=true;}else{this.form.luogo.visibility=\"visible\";this.form.luogo.disabled=false;}'>
                                <option value='decollato'>Decollato</option>
                                <option value='annulla_decollo'>Annulla decollo</option>
                            </select>
                            <select name='luogo' disabled>
                                ");
                                $luoghi = $connessione->query("SELECT luoghi.id, luoghi.nome FROM luoghi LEFT JOIN aerei ON luoghi.id = aerei.luogo WHERE tipo=1 AND aeroporto_id ='". $_SESSION["aeroporto_id"]."' AND aerei.id iS NULL ORDER BY nome");
                                while($luogo = $luoghi->fetch_assoc()){
                                    echo("<option value='".$luogo['id']."'>Parcheggio ".$luogo['nome']."</option>");
                                }
                                echo("
                            </select>
                            <input type='submit' value='Sposta'>
                        </form>
                        <!--<div style=display:inline-block;>
                            <form action='Aerei/sposta_aereo' method='post' style=display:inline-block;>
                                <input type='hidden' name='id' value='" . $aerei_row['id'] . "'>
                                <input type='hidden' name='azione' value='Decollato'>
                                <input type='submit' value='Decollato'>
                            </form>
                            <form action='Aerei/sposta_aereo' method='post' style=display:inline-block;>
                                <input type='hidden' name='id' value='" . $aerei_row['id'] . "'>
                                <input type='hidden' name='azione' value='Annulla decollo'>
                                <input type='submit' value='Annulla decollo'>
                        </div>-->
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
                        <!--<img src='IMG/Aerei/".$aerei_row['modello']."' width='200px'><br>-->
                        <img src='IMG/aereoAtterra.jpg' border=1 width='200px'><br>
                    </div>
                    <div style=display:inline-block;padding:10px>
                    <p>Immatricolazione: ".$aerei_row['immatricolazione']."</p>
                        <p>Modello: ".$aerei_row['modello']."</p>
                        <p>Compagnia: ".$aerei_row['compagnia']."</p>");
                        echo("<p>Posizione: Pista ".$connessione->query("SELECT nome FROM luoghi WHERE id = '".$aerei_row['luogo']."'")->fetch_assoc()['nome']."</p>
                        <img src='https://flagsapi.com/". strtoupper(substr($aerei_row['immatricolazione'], 0, 2)) . "/flat/64.png' width='32px'><br><br>
                        <a href='Aerei/modifica_aereo?id=".$aerei_row['id']."'>Modifica</a>
                    </div>
                    <div>
                        <form action='Aerei/sposta_aereo' method='post' style=display:inline-block;>
                            <input type='hidden' name='id' value='" . $aerei_row['id'] . "'> Parcheggia
                            <input type='hidden' name='azione' value='Parcheggia'>
                            <!--<select name='azione' onchange='//if(this.value==\"annulla_atterraggio\"){this.form.luogo.visibility=hidden;this.form.luogo.disabled=true;}else{this.form.luogo.visibility=visible;this.form.luogo.disabled=false;}'>
                                <option value='parcheggia'>Parcheggia</option>    
                                <option value='annulla_atterraggio'>Annulla atterraggio</option>
                            </select>-->
                            <select name='luogo'>
                                ");
                                $luoghi = $connessione->query("SELECT luoghi.id, luoghi.nome FROM luoghi LEFT JOIN aerei ON luoghi.id = aerei.luogo WHERE tipo=1 AND aeroporto_id ='". $_SESSION["aeroporto_id"]."' AND aerei.id iS NULL ORDER BY nome");
                                while($luogo = $luoghi->fetch_assoc()){
                                    echo("<option value='".$luogo['id']."'>".$luogo['nome']."</option>");
                                }
                                echo("
                            </select>
                            <input type='submit' value='Sposta'>
                        </form>
                        <form action='Aerei/sposta_aereo' method='post' style=display:inline-block;>
                            <input type='hidden' name='id' value='" . $aerei_row['id'] . "'>
                            <input type='hidden' name='azione' value='annulla_atterraggio'>
                            <input type='submit' value='Annulla atterraggio'>
                        </form>
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
                        <!--<img src='IMG/Aerei/".$aerei_row['modello']."' width='200px'><br>-->
                        <img src='IMG/aereoVola.jpg' border=1 width='200px'><br>
                    </div>
                    <div style=display:inline-block;padding:10px>
                    <p>Immatricolazione: ".$aerei_row['immatricolazione']."</p>
                        <p>Modello: ".$aerei_row['modello']."</p>
                        <p>Compagnia: ".$aerei_row['compagnia']."</p>");
                        echo("<p>Posizione: Parcheggio ".$connessione->query("SELECT nome FROM luoghi WHERE id = '".$aerei_row['luogo']."'")->fetch_assoc()['nome']."</p>
                        <img src='https://flagsapi.com/". strtoupper(substr($aerei_row['immatricolazione'], 0, 2)) . "/flat/64.png' width='32px'><br><br>
                        <a href='Aerei/modifica_aereo?id=".$aerei_row['id']."'>Modifica</a>
                    </div>
                    <div>
                        <form action='Aerei/sposta_aereo' method='post'>
                            <input type='hidden' name='id' value='" . $aerei_row['id'] . "'>
                            <select name='azione' onchange='//if(this.value==\"atterra\"){this.form.luogo.visibility=visible;this.form.luogo.disabled=false;}else{this.form.luogo.visibility=hidden;this.form.luogo.disabled=true;}'>
                                <option value='decolla'>Decolla</option>
                            </select>
                            <select name='luogo'>
                                ");
                                $luoghi = $connessione->query("SELECT luoghi.id, luoghi.nome FROM luoghi LEFT JOIN aerei ON luoghi.id = aerei.luogo WHERE tipo=2 AND aeroporto_id ='". $_SESSION["aeroporto_id"]."' AND aerei.id iS NULL ORDER BY nome");
                                while($luogo = $luoghi->fetch_assoc()){
                                    echo("<option value='".$luogo['id']."'>Pista ".$luogo['nome']."</option>");
                                }
                                echo("
                            </select>
                            <input type='submit' value='Sposta'>
                        </form>
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
                //document.getElementsByClassName("aereo")[i].appendChild(document.createElement("div")).innerHTML = "<form action='Aerei/sposta_aereo' method='post'><input type='hidden' name='id' value='" + document.getElementsByClassName("aereo")[i].id + "'><select name='azione' onchange='if(this.value==\"atterra\"){this.form.luogo.visibility=\"hidden\";this.form.luogo.disabled=\"true\";}else{this.form.luogo.visibility=\"visible\";this.form.luogo.disabled=\"false\";}'><option value='atterra'>Atterra</option><option value='decollo'>Sposta</option><select name='luogo'><?php $luoghi = $connessione->query("SELECT * FROM luoghi WHERE tipo=2 AND aeroporto_id = '".$_SESSION['aeroporto_id']."'"); while($luogo = $luoghi->fetch_assoc()){ echo("<option value='".$luogo['id']."'>".$luogo['nome']."</option>");}?></select><input type='submit' value='Sposta'></form>";
                /*document.getElementsByClassName("aereo")[i].addEventListener("mouseover", function(){
                    //document.getElementsByClassName("aereo")[i].getElementsByTagName("div")[1].appendChild(document.createElement("button")).innerHTML = "Sposta";
                    //this.getElementsByTagName("div")[1].appendChild(document.createElement("button")).innerHTML = "Sposta";
                });*/
                if(document.getElementsByClassName("aereo")[i].getElementsByTagName("div")[2].getElementsByTagName("select")[0] != null){ 
                    document.getElementsByClassName("aereo")[i].getElementsByTagName("div")[2].getElementsByTagName("select")[0].addEventListener("click", function(){
                        if(this.value == "atterra"){
                            //delete options
                            this.parentNode.getElementsByTagName("select")[1].innerHTML = "";
                            //add options
                            <?php
                                $luoghi = $connessione->query("SELECT luoghi.id, luoghi.nome FROM luoghi LEFT JOIN aerei ON luoghi.id = aerei.luogo WHERE tipo=2 AND aeroporto_id ='". $_SESSION["aeroporto_id"]."' AND aerei.id IS NULL ORDER BY nome");
                                ?>
                                this.parentNode.getElementsByTagName('select')[1].visibility = "visible";
                                this.parentNode.getElementsByTagName('input')[0].visibility = "visible";
                                <?php
                                while($luogo = $luoghi->fetch_assoc()){
                                    echo("this.parentNode.getElementsByTagName('select')[1].innerHTML += '<option value=\"".$luogo['id']."\">Pista ".$luogo['nome']."</option>';");
                                }
                            ?>
                        }else if(this.value == "sposta"){
                            //delete options
                            this.parentNode.getElementsByTagName("select")[1].innerHTML = "";
                            //add options
                            <?php
                                $luoghi = $connessione->query("SELECT luoghi.id, luoghi.nome FROM luoghi WHERE tipo=0 AND luoghi.aeroporto_id!='".$_SESSION['aeroporto_id']."' AND luoghi.id!=1 ORDER BY nome");
                                if($luoghi->num_rows == 0){?>
                                    this.parentNode.getElementsByTagName('input')[1].display = "none";
                                    this.parentNode.innerHTML += "Non ci sono altri aeroporti";
                                <?php
                                }else{
                                    while($luogo = $luoghi->fetch_assoc()){
                                        echo("this.parentNode.getElementsByTagName('select')[1].innerHTML += '<option value=\"".$luogo['id']."\">Aeroporto ".$luogo['nome']."</option>';");
                                    }
                                }
                            ?>
                        }
                    });
                }
            }
        </script>
    </body>
</html>