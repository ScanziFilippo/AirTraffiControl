<?php
    session_start();
    $immatricolazione = $_GET['immatricolazione'];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }else{
        try{
            $cancella = "DELETE FROM aerei WHERE immatricolazione = '$immatricolazione'";
            $risultato = $connessione->query($cancella);
            header ("location: index");
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
    }
?>