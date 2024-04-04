<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])/* || $_SESSION['ruolo'] != "Amministratore"*/){
        header("Location: ../Controllori/login");
    }
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    $idNuovo = $_POST['id'];
    $idVecchio = $_POST['idVecchio'];
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }
    else{
        try{
            $connessione->query("UPDATE parcheggi SET id = '".$idNuovo."' WHERE id = '".$idVecchio."'");
            header("Location: visualizza");
        }
        catch(Exception $e){
            echo("Errore: " . $e->getMessage());
        }
    }
?>