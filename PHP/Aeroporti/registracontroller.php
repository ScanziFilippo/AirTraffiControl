<?php
    //var_dump($_POST);
    $icao = $_POST["icao"];
    $iata = $_POST["iata"];
    $nome = $_POST["nome"];
    $citta = $_POST["citta"];
    $nazione = $_POST["nazione"];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }else if($icao == "" || $nome == "" || $nome == "" || $citta == "" || $nazione == ""){
        header("location: registra.php?err=Compila tutti i campi");
    }else if($connessione->query("SELECT * FROM aeroporti WHERE icao = '$icao'")->num_rows > 0){
        header("location: registra.php?err=ICAO già esistente");
    }else{
        try{
            $registra = "INSERT INTO aeroporti (icao, iata, nome, citta, nazione) VALUES ('$icao', '$iata', '$nome', '$citta', '$nazione')";
            $risultato = $connessione->query($registra);
            header("location: ../Controllori/profilo.php");
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
        //echo("Connesione corretta");
    }
    ?>