<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])/* || $_SESSION['ruolo'] != "Amministratore"*/){
        header("Location: ../Controllori/login.php");
    }
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }
    else{
        try{
            $n = 1;
            //$n = $connessione->query("SELECT * FROM parcheggi WHERE aeroporto_icao = '$_SESSION[aeroporto_icao]'")->num_rows + 1;
            while($connessione->query("SELECT * FROM parcheggi WHERE id = '$n' AND aeroporto_icao = '$_SESSION[aeroporto_icao]'")->num_rows > 0){
                $n++;
            }
            $connessione->query("INSERT INTO parcheggi (id, stato, aeroporto_icao) VALUES ('$n','Libero', '$_SESSION[aeroporto_icao]')");
            header("Location: visualizza.php");
        }
        catch(Exception $e){
            echo("Errore: " . $e->getMessage());
        }
    }
?>