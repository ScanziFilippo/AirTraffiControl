<?php
    $nome_utente = $_POST['nome_utente'];
    $codice = md5($_POST['codice']);
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }else if($nome_utente == "" || $codice == ""){
        header("location: recupera_login?err=Compila tutti i campi");
    }else if($connessione->query("SELECT * FROM controllori WHERE nome_utente = '$nome_utente'")->num_rows == 0){
        header("location: recupera_login?err=Nome utente non esistente");
    }else{
            $connessione->query("UPDATE controllori SET codice = '$codice' WHERE nome_utente = '$nome_utente'");
            session_start();
            header("location: profilo");
    }
?>