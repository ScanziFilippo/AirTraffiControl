<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: login.php");
    }
    $nome_utente = $_SESSION['nome_utente'];
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
                echo $_SESSION['aeroporto_icao'];
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