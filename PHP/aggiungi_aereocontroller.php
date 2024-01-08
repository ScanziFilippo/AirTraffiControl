<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: login.php");
    }
    $nome_utente = $_SESSION['nome_utente'];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if($connessione->connect_errno){
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }else{
        try{
            $immatricolazione = $_POST['immatricolazione'];
            $modello = $_POST['modello'];
            $compagnia = $_POST['compagnia'];
            $passeggeri = $_POST['passeggeri'];
            $foto_aereo = $_POST['foto_aereo'];
            $foto_compagnia = $_POST['foto_compagnia'];
            $posizione = $_POST['posizione'];
            $stato = $_POST['stato'];
            $pista_id = $_POST['pista_id'];
            $parcheggio_id = $_POST['parcheggio_id'];
            $aeroporto_icao = $_POST['aeroporto_icao'];
            $connessione->query("INSERT INTO aerei (immatricolazione, modello, compagnia, passeggeri, foto_aereo, foto_compagnia, posizione, stato, pista_id, parcheggio_id, aeroporto_icao) VALUES ('$immatricolazione', '$modello', '$compagnia', '$passeggeri', '$foto_aereo', '$foto_compagnia', '$posizione', '$stato', '$pista_id', '$parcheggio_id', '$aeroporto_icao')");
            header("Location: index.php");
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
    }
?>