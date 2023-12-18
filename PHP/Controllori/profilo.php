<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: login.php");
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
    </head>
    <body>
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
                if($connessione->query("SELECT * FROM aeroporti WHERE icao = '$_SESSION[aeroporto_icao]'")-> num_rows == 0){
                    echo "Aeroporto " . $_SESSION['aeroporto_icao'] . " non ancora registrato. <a href='../Aeroporti/registra.php'>Registrati</a>";
                }else{
                    $connessione->query("SELECT * FROM aeroporti WHERE icao = '$_SESSION[aeroporto_icao]'");
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo "[ " . $_SESSION['aeroporto_icao'] . " ] " . $connessione->query("SELECT * FROM aeroporti WHERE icao = '$_SESSION[aeroporto_icao]'")->fetch_assoc()['nome'] . " (" . $connessione->query("SELECT * FROM aeroporti WHERE icao = '$_SESSION[aeroporto_icao]'")->fetch_assoc()['citta'] . ", " . $connessione->query("SELECT * FROM aeroporti WHERE icao = '$_SESSION[aeroporto_icao]'")->fetch_assoc()['nazione'] . ") <a href='../Aeroporti/modifica.php'>Modifica</a>";
                    }else{
                        echo "[ " . $_SESSION['aeroporto_icao'] . " ] " . $connessione->query("SELECT * FROM aeroporti WHERE icao = '$_SESSION[aeroporto_icao]'")->fetch_assoc()['nome'] . " (" . $connessione->query("SELECT * FROM aeroporti WHERE icao = '$_SESSION[aeroporto_icao]'")->fetch_assoc()['citta'] . ", " . $connessione->query("SELECT * FROM aeroporti WHERE icao = '$_SESSION[aeroporto_icao]'")->fetch_assoc()['nazione'] . ")";
                    }
                }
            ?>
        </h3>
        <h3>Ruolo: 
            <?php 
                echo $_SESSION['ruolo'];
            ?>
        </h3>
        <?php
            if($_SESSION['ruolo'] == "Amministratore"){?>
                <a href="visualizza_controllori.php">Visualizza controllori</a>
                <a href="modifica_amministratore.php">Modifica</a>
                <a href="modifica_altri.php">Modifica controllori</a>
                <?php
            }else{?>
                <a href="modifica.php">Modifica</a>
                <?php
            }
        ?>
        <a href="logout.php">Logout</a>
        <a href="cancella.php">Cancella account</a>
    </body>
</html>