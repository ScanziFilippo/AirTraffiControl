<?php
    //var_dump($_POST);
    session_start();
    $icao = strtoupper($_POST["icao"]);
    $iata = strtoupper($_POST["iata"]);
    $nome = $_POST["nome"];
    $citta = $_POST["citta"];
    $nazione = $_POST["nazione"];
    $parcheggi = $_POST["parcheggi"];
    $piste = $_POST["piste"];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }else if($icao == "" || $nome == "" || $nome == "" || $citta == "" || $nazione == ""){
            $errorMessage = urlencode("Compila tutti i campi");
            header("location: registra?err=$errorMessage");
        }else if (!preg_match('/^[a-zA-Z0-9\s]+$/', $icao) || !preg_match('/^[a-zA-Z0-9\s]+$/', $iata) || !preg_match('/^[a-zA-Z0-9\s]+$/', $nome) || !preg_match('/^[a-zA-Z0-9\s]+$/', $citta) || !preg_match('/^[a-zA-Z0-9\s]+$/', $nazione)) {
            $errorMessage = urlencode("Solo lettere, numeri e spazi sono ammessi");
            header("location: registra?err=$errorMessage");
        } else {
        try{
            for($i = 0; $i < $parcheggi; $i++){
                $n = 1;
                while($connessione->query("SELECT * FROM luoghi WHERE nome = '$n' AND aeroporto_id = '$_SESSION[aeroporto_id]' AND tipo=1")->num_rows > 0){
                    $n++;
                }
                $connessione->query("INSERT INTO luoghi (nome, tipo, aeroporto_id) VALUES ('$n', 1, '$_SESSION[aeroporto_id]')");
            }
            for($i = 0; $i < $piste; $i++){
                $n = 1;
                while($connessione->query("SELECT * FROM luoghi WHERE nome = '$n' AND aeroporto_id = '$_SESSION[aeroporto_id]' AND tipo=2")->num_rows > 0){
                    $n++;
                }
                $connessione->query("INSERT INTO luoghi (nome, tipo, aeroporto_id) VALUES ('$n', 2, '$_SESSION[aeroporto_id]')");
            }
            $connessione->query("UPDATE aeroporti SET iata = '$iata', nome = '$_POST[nome]', citta = '$_POST[citta]', nazione = '$_POST[nazione]' WHERE id = '$_SESSION[aeroporto_id]'");
            //$_SESSION['aeroporto_icao'] = $icao;
            //if($connessione->query("SELECT * FROM luoghi WHERE aeroporto_id='". $_SESSION['aeroporto_id'] . "' AND tipo='0'")->num_rows == 0){
                //$connessione->query("INSERT INTO luoghi (aeroporto_id, tipo, nome) VALUES ('". $_SESSION['aeroporto_id'] . "', '0', ". $_SESSION['aeroporto_nome'] .")");
            //}
            header("location: ../Controllori/profilo");
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
        //echo("Connesione corretta");
    }
    ?>