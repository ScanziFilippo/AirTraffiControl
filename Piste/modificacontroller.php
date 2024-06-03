<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])/* || $_SESSION['ruolo'] != "Amministratore"*/){
        header("Location: ../Controllori/login");
    }
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    $id = $_POST['id'];
    //$idVecchio = $_POST['idVecchio'];
    $nome = $_POST['nome'];
        // check if contains only alphanumeric and whitespace
        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $nome)) {
            $error_message = urlencode("Solo lettere, numeri e spazi sono ammessi");
            header("location: visualizza?err=$error_message");
        }else if($nome == ""){
            $error_message = urlencode("Il campo non può essere vuoto");
            header("location: visualizza?err=$error_message");
        }
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }
    else{
        try{
            $connessione->query("UPDATE luoghi SET nome = '".$nome."' WHERE id = '".$id."'");
            header("Location: visualizza");
        }
        catch(Exception $e){
            echo("Errore: " . $e->getMessage());
        }
    }
?>