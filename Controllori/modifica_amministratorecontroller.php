<?php
    session_start();
    if(!isset($_SESSION['nome_utente']) || $_SESSION['ruolo'] != "Amministratore"){
        header("Location: Controllori/login");
    }
    //$aeroporto_icao = $_POST['aeroporto_icao'];
    $nome_utente_nuovo = $_POST['nome_utente'];
    $nome_utente_vecchio = $_SESSION['nome_utente'];
    $nome_nuovo = $_POST['nome'];
    $cognome_nuovo = $_POST['cognome'];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }
    // check if contains only alphanumeric and whitespace
    else if (!preg_match('/^[a-zA-Z0-9\s]+$/', $nome_utente_nuovo) || !preg_match('/^[a-zA-Z0-9\s]+$/', $nome_nuovo) || !preg_match('/^[a-zA-Z0-9\s]+$/', $cognome_nuovo)) {
        $error_message = urlencode("Solo lettere, numeri e spazi sono ammessi");
        header("location: modifica_amministratore?err=$error_message");
    }else if($nome_utente_nuovo == "" || $nome_nuovo == "" || $cognome_nuovo == ""){
        $error_message = urlencode("I campi non possono essere vuoti");
        header("location: modifica_amministratore?err=$error_message");
    } else if ($connessione->query("SELECT * FROM controllori WHERE nome_utente = '$nome_utente_nuovo'")->num_rows > 0 && $nome_utente_nuovo != $nome_utente_vecchio) {
        $error_message = urlencode("Nome utente già esistente");
        header("location: modifica_amministratore?err=$error_message");
    }else{
        try{
            $modifica = "UPDATE controllori SET nome_utente = '$nome_utente_nuovo', nome = '$nome_nuovo', cognome = '$cognome_nuovo' WHERE nome_utente = '$nome_utente_vecchio'";
            $risultato = $connessione->query($modifica);
            $_SESSION['nome_utente'] = $nome_utente_nuovo;
            $_SESSION['nome'] = $nome_nuovo;
            $_SESSION['cognome'] = $cognome_nuovo;
            header("location: profilo");
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
}
