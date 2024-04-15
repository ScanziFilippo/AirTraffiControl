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
            header("location: registra?err=Non esiste un aeroporto con questo icao. Devi essere amministratore per crearlo");
        }else{
            try{
                $registra = "INSERT INTO controllori (aeroporto_icao, nome_utente, nome, cognome, codice, ruolo) VALUES ('$aeroporto_icao', '$nome_utente', '$nome', '$cognome', '$codice_criptato', '$ruolo')";
                $risultato = $connessione->query($registra);
                header("location: login");
            }
            catch(Exception $e){
                echo("Errore nella query: ".$e->getMessage());
            }
        }
    }else if($connessione->query("SELECT * FROM controllori WHERE nome_utente = '$nome_utente'")->num_rows > 0){
        header("location: registra?err=Nome utente già esistente");
    }
    else{
        try{
            $registra = "INSERT INTO controllori (aeroporto_icao, nome_utente, nome, cognome, codice, ruolo) VALUES ('$aeroporto_icao', '$nome_utente', '$nome', '$cognome', '$codice_criptato', '$ruolo')";
            $risultato = $connessione->query($registra);
            header("location: profilo");
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
        //echo("Connesione corretta");
    }
    ?>