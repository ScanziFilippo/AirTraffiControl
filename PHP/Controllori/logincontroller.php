<?php
session_start();
$nome_utente = $_POST['nome_utente'];
$codice = $_POST['codice'];
$codice = md5($codice);
$connessione = new mysqli('localhost', 'root', '', 'progetto');
$nome = $connessione->query("SELECT nome FROM controllori WHERE nome_utente = '$nome_utente'")->fetch_assoc()['nome'];
$cognome = $connessione->query("SELECT cognome FROM controllori WHERE nome_utente = '$nome_utente'")->fetch_assoc()['cognome'];
$ruolo = $connessione->query("SELECT ruolo FROM controllori WHERE nome_utente = '$nome_utente'")->fetch_assoc()['ruolo'];
$aeroporto_icao = $connessione->query("SELECT aeroporto_icao FROM controllori WHERE nome_utente = '$nome_utente'")->fetch_assoc()['aeroporto_icao'];
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
            $_SESSION['nome'] = $nome;
            $_SESSION['cognome'] = $cognome;
            $_SESSION['ruolo'] = $ruolo;
            $_SESSION['aeroporto_icao'] = $aeroporto_icao;
            header("location: ../index");
        }else{
            header("location: login?err=nome_utente o codice errati");
        }
    }
    catch(Exception $e){
        echo("Errore nella query: ".$e->getMessage());
        header("location: login");
    }
}