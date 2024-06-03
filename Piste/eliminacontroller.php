<?php
    session_start();
    if(!isset($_SESSION['nome_utente']) || $_SESSION['ruolo'] != "Amministratore"){
        header("Location: ../Controllori/login");
    }
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }
    else{
        try{
            $connessione->query("DELETE FROM luoghi WHERE id = '$_GET[id]'");
            /*for($i = $_GET[id]; $i <= $connessione->query("SELECT * FROM piste WHERE id>'$_GET[id]' AND aeroporto_icao = '$_SESSION[aeroporto_icao]'")->num_rows; $i++){
                $connessione->query("UPDATE piste SET id = '$i' WHERE id = '$i' + 1");
            }*/
            header("Location: visualizza");
        }
        catch(Exception $e){
            echo("Errore: " . $e->getMessage());
        }
    }
?>