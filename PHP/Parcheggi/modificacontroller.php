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
            $connessione->query("UPDATE parcheggi SET id = '$_POST[id]' WHERE id = '$_GET[id]' AND aeroporto_icao = '$_SESSION[aeroporto_icao]'");
            header("Location: visualizza.php");
        }
        catch(Exception $e){
            echo("Errore: " . $e->getMessage());
        }
    }
?>