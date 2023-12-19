<?php
    session_start();
    if(!isset($_SESSION['nome_utente']) || $_SESSION['ruolo'] != "Amministratore"){
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
            $connessione->query("UPDATE aeroporti SET icao = '$_POST[icao]', iata = '$_POST[iata]', nome = '$_POST[nome]', citta = '$_POST[citta]', nazione = '$_POST[nazione]' WHERE icao = '$_SESSION[aeroporto_icao]'");
            $_SESSION['aeroporto_icao'] = $_POST['icao'];
            header("Location: ../Controllori/profilo.php");
        }
        catch(Exception $e){
            echo("Errore: " . $e->getMessage());
        }
    }
?>