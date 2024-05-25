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
    else if (!preg_match('/^[a-zA-Z0-9\s]+$/', $_POST['icao']) || !preg_match('/^[a-zA-Z0-9\s]+$/', $_POST['iata']) || !preg_match('/^[a-zA-Z0-9\s]+$/', $_POST['nome']) || !preg_match('/^[a-zA-Z0-9\s]+$/', $_POST['citta']) || !preg_match('/^[a-zA-Z0-9\s]+$/', $_POST['nazione'])) {
        $errorMessage = urlencode("Solo lettere, numeri e spazi sono ammessi");
        header("location: modifica?err=$errorMessage");
    }else if($_POST['icao'] == "" || $_POST['iata'] == "" || $_POST['nome'] == "" || $_POST['citta'] == "" || $_POST['nazione'] == ""){
        $errorMessage = urlencode("Compila tutti i campi");
        header("location: modifica?err=$errorMessage");
    }
    else{
        $icao = strtoupper($_POST['icao']);
        $iata = strtoupper($_POST['iata']);
        /*if($connessione->query("SELECT * FROM aeroporti WHERE icao = '$icao'")->num_rows>0 && $_SESSION['aeroporto_icao']!=$icao )
        {
            header("Location: ../Controllori/profilo?err=Esiste già un aeroporto con questo ICAO");
        }*/
        try{
            $connessione->query("UPDATE aeroporti SET iata = '$iata', nome = '$_POST[nome]', citta = '$_POST[citta]', nazione = '$_POST[nazione]' WHERE id = '$_SESSION[aeroporto_id]'");
            $_SESSION['aeroporto_icao'] = $icao;
            header("Location: ../Controllori/profilo");
        }
        catch(Exception $e){
            echo("Errore: " . $e->getMessage());
        }   
    }
?>