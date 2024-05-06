<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])/* || $_SESSION['ruolo'] != "Amministratore"*/){
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
            $n = 1;
            //$n = $connessione->query("SELECT * FROM piste WHERE aeroporto_icao = '$_SESSION[aeroporto_icao]'")->num_rows + 1;
            while($connessione->query("SELECT * FROM luoghi WHERE nome = '$n' AND aeroporto_id = '$_SESSION[aeroporto_id]' AND tipo=2")->num_rows > 0){
                $n++;
            }
            $connessione->query("INSERT INTO luoghi (nome, tipo, aeroporto_id) VALUES ('$n', 2, '$_SESSION[aeroporto_id]')");
            header("Location: visualizza");
        }
        catch(Exception $e){
            echo("Errore: " . $e->getMessage());
        }
    }
?>