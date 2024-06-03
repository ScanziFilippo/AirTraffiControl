<?php
    session_start();
    $nome_utente = $_GET['id'];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }else{
        try{
            $cancella = "DELETE FROM controllori WHERE nome_utente = '$nome_utente'";
            $risultato = $connessione->query($cancella);
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
    }
?>