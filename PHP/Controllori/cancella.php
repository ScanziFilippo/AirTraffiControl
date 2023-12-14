<?php
    session_start();
    $username = $_SESSION['username'];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }else{
        try{
            $cancella = "DELETE FROM utenti WHERE username = '$username'";
            $risultato = $connessione->query($cancella);
            echo("Account cancellato");
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
    }
?>