<?php
    session_start();
    if(!isset($_SESSION['nome_utente']) || $_SESSION['ruolo'] != "Amministratore"){
        header("Location: ../Controllori/login.php");
    }
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }
    else{
        if($connessione->query("SELECT * FROM aeroporti WHERE icao = '$_POST[icao]'")->num_rows>0 && $_SESSION['icao']!=$_POST['icao'] )
        {
            header("Location: ../Controllori/profilo.php?err=Esiste già un aeroporto con questo ICAO");
        }
        else{
            if($_SESSION['aeroporto_icao']!=$_POST['icao']){
                $connessione->query("UPDATE voli SET partenza = '$_POST[icao]' WHERE partenza = '$_SESSION[aeroporto_icao]'");
                $connessione->query("UPDATE voli SET destinazione = '$_POST[icao]' WHERE destinazione = '$_SESSION[aeroporto_icao]'");
                $connessione->query("UPDATE aerei SET aeroporto_icao = '$_POST[icao]' WHERE aeroporto_icao = '$_SESSION[aeroporto_icao]'");
                $connessione->query("UPDATE controllori SET aeroporto_icao = '$_POST[icao]' WHERE aeroporto_icao = '$_SESSION[aeroporto_icao]'");
                $connessione->query("UPDATE piste SET aeroporto_icao = '$_POST[icao]' WHERE aeroporto_icao = '$_SESSION[aeroporto_icao]'");
                $connessione->query("UPDATE parcheggi SET aeroporto_icao = '$_POST[icao]' WHERE aeroporto_icao = '$_SESSION[aeroporto_icao]'");
            }
            try{
                $connessione->query("UPDATE aeroporti SET icao = '$_POST[icao]', iata = '$_POST[iata]', nome = '$_POST[nome]', citta = '$_POST[citta]', nazione = '$_POST[nazione]' WHERE icao = '$_SESSION[aeroporto_icao]'");
                $_SESSION['aeroporto_icao'] = $_POST['icao'];
                header("Location: ../Controllori/profilo.php");
            }
            catch(Exception $e){
                echo("Errore: " . $e->getMessage());
            }
        }
    }
?>