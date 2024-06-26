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
}else if($nome_utente == "" || $codice == ""){
    $errorMessage = "Compila tutti i campi";
    header("location: login?err=" . urlencode($errorMessage));
}else if (!preg_match('/^[a-zA-Z0-9_]+$/', $nome_utente) || !preg_match('/^[a-zA-Z0-9_]+$/', $codice)) {
    $errorMessage = "Solo lettere, numeri e underscore sono ammessi";
    header("location: login?err=" . urlencode($errorMessage));
}else{
    $nome = $connessione->query("SELECT nome FROM controllori WHERE nome_utente = '$nome_utente'")->fetch_assoc()['nome'];
    $cognome = $connessione->query("SELECT cognome FROM controllori WHERE nome_utente = '$nome_utente'")->fetch_assoc()['cognome'];
    $ruolo = $connessione->query("SELECT ruolo FROM controllori WHERE nome_utente = '$nome_utente'")->fetch_assoc()['ruolo'];
    $aeroporto_id = $connessione->query("SELECT aeroporto_id FROM controllori WHERE nome_utente = '$nome_utente'")->fetch_assoc()['aeroporto_id'];
    $aeroporto_icao = $connessione->query("SELECT icao FROM aeroporti WHERE id = '$aeroporto_id'")->fetch_assoc()['icao'];

    try{
        $login = "SELECT * FROM controllori WHERE nome_utente = '$nome_utente' AND codice = '$codice'";
        $risultato = $connessione->query($login);
        if($risultato->num_rows > 0){
            $_SESSION['nome_utente'] = $nome_utente;
            $_SESSION['nome'] = $nome;
            $_SESSION['cognome'] = $cognome;
            $_SESSION['ruolo'] = $ruolo;
            $_SESSION['aeroporto_id'] = $aeroporto_id;
            $_SESSION['aeroporto_icao'] = $aeroporto_icao;
            header("location: ../index");
        }else{
            $errorMessage = "nome_utente o codice errati";
            header("location: login?err=" . urlencode($errorMessage));
        }
    }
    catch(Exception $e){
        echo("Errore nella query: ".$e->getMessage());
        header("location: login");
    }
}