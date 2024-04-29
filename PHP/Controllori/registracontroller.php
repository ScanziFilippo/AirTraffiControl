<?php
    //var_dump($_POST);
    $aeroporto_icao = strtoupper($_POST["aeroporto_icao"]);
    $nome_utente = $_POST["nome_utente"];
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $codice = $_POST["codice"];
    $codice_criptato = md5($codice);
    $ruolo = $_POST["ruolo"];
    if($ruolo == 0){
        $ruolo = "Base";
    }else{
        $ruolo = "Amministratore";
    }
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }else if($aeroporto_icao == "" || $nome_utente == "" || $nome == "" || $cognome == "" || $codice == ""){
        header("location: registra?err=Compila tutti i campi");
    }else if($connessione->query("SELECT * FROM aeroporti WHERE icao = '$aeroporto_icao'")->num_rows == 0){
        if($ruolo=="Base"){
            header("location: registra?err=Non%20esiste%20un%20aeroporto%20con%20questo%20icao.%20Devi%20essere%20amministratore%20per%20crearlo");
        }else{
            try{
                $registraAeroporto = "INSERT INTO aeroporti (icao) VALUES ('$aeroporto_icao')";
                $risultatoAeroporto = $connessione->query($registraAeroporto);
                $aeroporto_id = $connessione->query("SELECT id FROM aeroporti WHERE icao = '".$aeroporto_icao."'")->fetch_assoc()['id'];
                $registra = "INSERT INTO controllori (aeroporto_id, nome_utente, nome, cognome, codice, ruolo) VALUES ('$aeroporto_id', '$nome_utente', '$nome', '$cognome', '$codice_criptato', '$ruolo')";
                $risultato = $connessione->query($registra);
                header("location: login");
            }
            catch(Exception $e){
                echo("Errore nella query: ".$e->getMessage());
            }
        }
    }else if($connessione->query("SELECT * FROM controllori WHERE nome_utente = '$nome_utente'")->num_rows > 0){
        header("location: registra?err=Nome%20utente%20gi%C3%A0%20esistente");
    }
    else{
        try{
            $aeroporto_id = $connessione->query("SELECT id FROM aeroporti WHERE icao = '".$aeroporto_icao."'")->fetch_assoc()['id'];
            $registra = "INSERT INTO controllori (aeroporto_id, nome_utente, nome, cognome, codice, ruolo) VALUES ('$aeroporto_id', '$nome_utente', '$nome', '$cognome', '$codice_criptato', '$ruolo')";
            $risultato = $connessione->query($registra);
            header("location: login");
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
        //echo("Connesione corretta");
    }
    ?>