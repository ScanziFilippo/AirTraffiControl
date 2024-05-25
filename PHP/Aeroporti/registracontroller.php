<?php
    //var_dump($_POST);
    $icao = strtoupper($_POST["icao"]);
    $iata = strtoupper($_POST["iata"]);
    $nome = $_POST["nome"];
    $citta = $_POST["citta"];
    $nazione = $_POST["nazione"];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }else if (!preg_match('/^[a-zA-Z0-9\s]+$/', $icao) || !preg_match('/^[a-zA-Z0-9\s]+$/', $iata) || !preg_match('/^[a-zA-Z0-9\s]+$/', $nome) || !preg_match('/^[a-zA-Z0-9\s]+$/', $citta) || !preg_match('/^[a-zA-Z0-9\s]+$/', $nazione)) {
            $errorMessage = urlencode("Solo lettere, numeri e spazi sono ammessi");
            header("location: registra?err=$errorMessage");
    }else if($icao == "" || $nome == "" || $nome == "" || $citta == "" || $nazione == ""){
            $errorMessage = urlencode("Compila tutti i campi");
            header("location: registra?err=$errorMessage");
        } else if($connessione->query("SELECT * FROM aeroporti WHERE icao = '$icao'")->num_rows > 0){
            $errorMessage = urlencode("ICAO già esistente");
            header("location: registra?err=$errorMessage");
        } else {
        try{
            $registra = "INSERT INTO aeroporti (icao, iata, nome, citta, nazione) VALUES ('$icao', '$iata', '$nome', '$citta', '$nazione')";
            $risultato = $connessione->query($registra);
            $_SESSION['aeroporto_icao'] = $icao;
            $_SESSION['aeroporto_iata'] = $iata;
            $_SESSION['aeroporto_nome'] = $nome;
            $_SESSION['aeroporto_citta'] = $citta;
            $_SESSION['aeroporto_nazione'] = $nazione;
            //if($connessione->query("SELECT * FROM luoghi WHERE aeroporto_id='". $_SESSION['aeroporto_id'] . "' AND tipo='0'")->num_rows == 0){
                $connessione->query("INSERT INTO luoghi (aeroporto_id, tipo, nome) VALUES ('". $_SESSION['aeroporto_id'] . "', '0', ". $_SESSION['aeroporto_nome'] .")");
            //}
            header("location: ../Controllori/profilo");
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
        //echo("Connesione corretta");
    }
    ?>