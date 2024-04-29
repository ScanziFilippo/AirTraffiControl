<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: login");
    }
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }
?>
<html>
    <head>
        <title>Document</title>
        <link rel="stylesheet" href="../../CSS/index.css">
    </head>
    <body>
        <div style="padding-left: 20px; padding-top:10px;">
            <h1>Profilo</h1>
            <h3>Nome utente: 
                <?php 
                    echo $_SESSION['nome_utente'];
                ?>
            </h3>
            <h3>Nome e cognome: 
                <?php 
                    echo $_SESSION['nome'] . " " . $_SESSION['cognome'];
                ?>
            </h3>
            <h3>Aeroporto: 
                <?php 
                    if($connessione->query("SELECT * FROM aeroporti WHERE id = '$_SESSION[aeroporto_id]'")-> num_rows == 0){
                        echo "Aeroporto " . $_SESSION['aeroporto_icao'] . " non ancora registrato. <a href='../Aeroporti/registra'>Registrati</a>";
                    }else{
                        $connessione->query("SELECT * FROM aeroporti WHERE id = '$_SESSION[aeroporto_id]'");
                        if($_SESSION['ruolo'] == "Amministratore"){
                            echo "「 " . $_SESSION['aeroporto_icao'] . " 」 " . $connessione->query("SELECT * FROM aeroporti WHERE id = '$_SESSION[aeroporto_id]'")->fetch_assoc()['nome'] . " (" . $connessione->query("SELECT * FROM aeroporti WHERE id = '$_SESSION[aeroporto_id]'")->fetch_assoc()['citta'] . ", " . $connessione->query("SELECT * FROM aeroporti WHERE id = '$_SESSION[aeroporto_id]'")->fetch_assoc()['nazione'] . ") <a href='../Aeroporti/modifica'>Modifica</a>";
                        }else{
                            echo "「 " . $_SESSION['aeroporto_icao'] . " 」 " . $connessione->query("SELECT * FROM aeroporti WHERE id = '$_SESSION[aeroporto_id]'")->fetch_assoc()['nome'] . " (" . $connessione->query("SELECT * FROM aeroporti WHERE id = '$_SESSION[aeroporto_id]'")->fetch_assoc()['citta'] . ", " . $connessione->query("SELECT * FROM aeroporti WHERE id = '$_SESSION[aeroporto_id]'")->fetch_assoc()['nazione'] . ")";
                        }
                    }
                ?>
            </h3>
            <h3>Parcheggi:
                <?php
                echo " " . $connessione->query("SELECT * FROM parcheggi WHERE aeroporto_id = '$_SESSION[aeroporto_id]'")-> num_rows;
                    //if($_SESSION['ruolo'] == "Amministratore"){
                        echo " <a href='../Parcheggi/visualizza'>Visualizza</a>";
                    //}
                ?>
            </h3>
            <h3>Piste:
                <?php
                    echo " " . $connessione->query("SELECT * FROM piste WHERE aeroporto_id = '$_SESSION[aeroporto_id]'")-> num_rows;
                    //if($_SESSION['ruolo'] == "Amministratore"){
                        echo " <a href='../Piste/visualizza'>Visualizza</a>";
                    //}
                ?>
            </h3>
            <h3>Ruolo: 
                <?php 
                    echo $_SESSION['ruolo'];
                ?>
            </h3>
            <h3>Personale:
                <?php
                    echo " " . $connessione->query("SELECT * FROM controllori WHERE aeroporto_id = '$_SESSION[aeroporto_id]'")-> num_rows;
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo " <a href='visualizza_controllori'>Visualizza</a>";
                    }
                ?>
            </h3>
            <?php
                if($_SESSION['ruolo'] == "Amministratore"){?>
                    <a href="modifica_amministratore">Modifica</a>
                    <?php
                }else{?>
                    <a href="modifica">Modifica</a>
                    <?php
                }
            ?><br><br>
            <a href="logout" style="color: green">Logout</a><br><br>
            <a href="cancella" style="color: red">Cancella account</a><br><br>
            <br><br><br>
            <a href="../index">Torna alla home</a>
        </div>
    </body>
</html>