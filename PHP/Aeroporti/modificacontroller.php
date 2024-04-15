<?php
    session_start();
    if(!isset($_SESSION['nome_utente']) || $_SESSION['ruolo'] != "Amministratore"){
        header("Location: ../Controllori/login");
    }
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }
    else{
        $icao = strtoupper($_POST['icao']);
        $iata = strtoupper($_POST['iata']);
        if($connessione->query("SELECT * FROM aeroporti WHERE icao = '$icao'")->num_rows>0 && $_SESSION['icao']!=$icao )
        {
            header("Location: ../Controllori/profilo?err=Esiste già un aeroporto con questo ICAO");
        }
        else{
            if($_SESSION['aeroporto_icao']!=$icao){
                //$connessione->query("UPDATE voli SET partenza = '$icao' WHERE partenza = '$_SESSION[aeroporto_icao]'");
                //$connessione->query("UPDATE voli SET destinazione = '$icao' WHERE destinazione = '$_SESSION[aeroporto_icao]'");
                $connessione->query("UPDATE aerei SET aeroporto_icao = '$icao' WHERE aeroporto_icao = '$_SESSION[aeroporto_icao]'");
                $connessione->query("UPDATE controllori SET aeroporto_icao = '$icao' WHERE aeroporto_icao = '$_SESSION[aeroporto_icao]'");
                $connessione->query("UPDATE piste SET aeroporto_icao = '$icao' WHERE aeroporto_icao = '$_SESSION[aeroporto_icao]'");
                $connessione->query("UPDATE parcheggi SET aeroporto_icao = '$icao' WHERE aeroporto_icao = '$_SESSION[aeroporto_icao]'");
            }
        }
        try{
            $connessione->query("UPDATE aeroporti SET icao = '$icao', iata = '$iata', nome = '$_POST[nome]', citta = '$_POST[citta]', nazione = '$_POST[nazione]' WHERE icao = '$_SESSION[aeroporto_icao]'");
            $_SESSION['aeroporto_icao'] = $icao;
            header("Location: ../Controllori/profilo");
        }
        catch(Exception $e){
            echo("Errore: " . $e->getMessage());
        }   
    }
?>