<?php
session_start();
$nome_utente = $_POST['nome_utente'];
$codice = $_POST['codice'];
$codice = md5($codice);
$connessione = new mysqli('localhost', 'root', '', 'progetto');
if ($connessione->connect_errno)
{
    echo("Connessione fallita: ".$connessione->connect_error.".");
    exit();
}else{
    try{
        $login = "SELECT * FROM controllori WHERE nome_utente = '$nome_utente' AND codice = '$codice'";
        $risultato = $connessione->query($login);
        if($risultato->num_rows > 0){
            $_SESSION['nome_utente'] = $nome_utente;
            header("location: profilo.php?nome_utente=$nome_utente");
        }else{
            header("location: login.php?err=nome_utente o codice errati");
        }
    }
    catch(Exception $e){
        echo("Errore nella query: ".$e->getMessage());
        header("location: login.php");
    }
}