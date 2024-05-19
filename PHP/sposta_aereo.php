<?php
    session_start();
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    $aeroporto_id = $_SESSION['aeroporto_id'];
    $id = $_POST["id"];
    $stato = $_POST["azione"];
    $stato = strtolower($stato);
    //if(isset($_POST["luogo"]))
        $luogo = $_POST["luogo"];
    if($stato == "sposta"){
        $stato = "In volo";
        $luogo = $connessione->query("SELECT aeroporto_id FROM luoghi WHERE id = '$luogo'")->fetch_assoc()["aeroporto_id"];
        $connessione->query("UPDATE voli SET destinazione = '$luogo' WHERE aereo_id = '$id' AND data_arrivo is NULL");
        $connessione->query("UPDATE aerei SET luogo = 1 WHERE id = '$id'");
    }else{
        if($stato == "atterra"){
            $stato = "Atterrando";
        }
        else if($stato == "decolla"){
            $stato = "Decollando";
            $connessione->query("INSERT INTO voli (aereo_id, partenza, data_partenza) VALUES ('$id', '$aeroporto_id', NOW())");
        }
        else if($stato == "parcheggia"){
            $stato = "Fermo";
            $connessione->query("UPDATE voli SET destinazione = '$aeroporto_id', data_arrivo = NOW() WHERE aereo_id = '$id' AND data_arrivo is NULL");
        }
        else if($stato == "annulla_atterraggio"){
            $luogo = $connessione->query("SELECT id FROM luoghi WHERE aeroporto_id = '$_SESSION[aeroporto_id]' AND tipo = 0")->fetch_assoc()["id"];
            $stato = "In volo";
        }
        else if($stato == "annulla_decollo"){
            $stato = "Fermo";
            $connessione->query("UPDATE voli SET destinazione = '$aeroporto_id', data_arrivo = NOW() WHERE aereo_id = '$id' AND data_arrivo is NULL");
        }
        else if($stato == "decollato"){
            $luogo = $connessione->query("SELECT id FROM luoghi WHERE aeroporto_id = '$_SESSION[aeroporto_id]' AND tipo = 0")->fetch_assoc()["id"];
            $stato = "In volo";
        }
        else if($stato == "annulla_transito"){
            $stato = "In volo";
            $connessione->query("UPDATE voli SET destinazione = NULL WHERE aereo_id = '$id' AND data_arrivo is NULL");
            $luogo = $connessione->query("SELECT id FROM luoghi WHERE aeroporto_id = '$_SESSION[aeroporto_id]' AND tipo = 0")->fetch_assoc()["id"];
        }
        else if($stato == "accetta_transito"){
            $stato = "In volo";
            $connessione->query("UPDATE voli SET destinazione = '$_SESSION[aeroporto_id]' WHERE aereo_id = '$id' AND data_arrivo is NULL");
            $luogo = $connessione->query("SELECT id FROM luoghi WHERE aeroporto_id = '$_SESSION[aeroporto_id]' AND tipo = 0")->fetch_assoc()["id"];
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
        try{
            echo $luogo;
            //if($stato != "sposta"){
                $aggiorna = "UPDATE aerei SET stato = '$stato', luogo = '$luogo' WHERE id = '$id'";
                $risultato = $connessione->query($aggiorna);
            //}
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
    }
    header("location: index");
?>