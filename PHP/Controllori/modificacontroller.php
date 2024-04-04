<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: Controllori/login");
    }
    $nome_utente_nuovo = $_POST['nome_utente'];
    $nome_utente_vecchio = $_SESSION['nome_utente'];
    $nome_nuovo = $_POST['nome'];
    $cognome_nuovo = $_POST['cognome'];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }else if($nome_utente_nuovo == "" || $nome_nuovo == "" || $cognome_nuovo == ""){
        header("location: profilo?err=I campi non possono essere vuoti");
    }else if($connessione->query("SELECT * FROM controllori WHERE nome_utente = '$nome_utente_nuovo'")->num_rows > 0 && $nome_utente_nuovo != $nome_utente_vecchio){
        header("location: profilo?err=Nome utente già esistente");
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
