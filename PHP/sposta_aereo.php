<?php
    $id = $_POST["id"];
    $stato = $_POST["azione"];
    if($stato == "sposta"){
        $stato = "In volo";
    }else if($stato == "atterra"){
        $stato = "Atterrando";
    }
    else if($stato == "decolla"){
        $stato = "Decollando";
    }
    else if($stato == "parcheggia"){
        $stato = "Fermo";
    }
    else if($stato == "annulla_atterraggio"){
        $stato = "In volo";
    }
    else if($stato == "annulla_decollo"){
        $stato = "Fermo";
    }
    else if($stato == "decollato"){
        $stato = "In volo";
    }
    
    $luogo = $_POST["luogo"];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }
    /*else if($id == "" || $stato == "" || $luogo == ""){
        header("location: sposta_aereo?err=Compila tutti i campi");
    }*/
    else{
        try{
            $aggiorna = "UPDATE aerei SET stato = '$stato', luogo = '$luogo' WHERE id = '$id'";
            $risultato = $connessione->query($aggiorna);
            header("location: index");
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
    }
?>