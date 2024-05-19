<?php
    session_start();
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    $id = $_POST["id"];
    $stato = $_POST["azione"];
    $stato = strtolower($stato);
    //if(isset($_POST["luogo"]))
        $luogo = $_POST["luogo"];
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
        $luogo = $connessione->query("SELECT id FROM luoghi WHERE aeroporto_id = '$_SESSION[aeroporto_id]' AND tipo = 0")->fetch_assoc()["id"];
        $stato = "In volo";
    }
    else if($stato == "annulla_decollo"){
        $stato = "Fermo";
    }
    else if($stato == "decollato"){
        $luogo = $connessione->query("SELECT id FROM luoghi WHERE aeroporto_id = '$_SESSION[aeroporto_id]' AND tipo = 0")->fetch_assoc()["id"];
        $stato = "In volo";
    }
    
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
            echo $luogo;
            $aggiorna = "UPDATE aerei SET stato = '$stato', luogo = '$luogo' WHERE id = '$id'";
            $risultato = $connessione->query($aggiorna);
            header("location: index");
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
    }
?>