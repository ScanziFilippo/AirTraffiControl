<?php
    $connessione = new mysqli("localhost","root","","progetto");
    if($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }
    /*if(isset($_GET['tabella'])){
        $tabella = $_GET['tabella'];*/
    if(isset($_REQUEST['tabella'])){
        $tabella = $_REQUEST['tabella'];
        if(isset($_REQUEST['id'])){
            $id = $_REQUEST['id'];
            if($tabella == 'compagnie' || $tabella == 'piste' || $tabella == 'parcheggi' || $tabella == 'voli')
                $query = "SELECT * FROM ".$tabella." WHERE id = ".$id;
            else if($tabella == 'aerei')
                $query = "SELECT * FROM ".$tabella." WHERE immatricolazione = '".$id."'";
            else if($tabella == 'aeroporti')
                $query = "SELECT * FROM ".$tabella." WHERE icao = '".$id."'";
            else if($tabella == 'controllori')
                $query = "SELECT * FROM ".$tabella." WHERE codice_fiscale = '".$id."'";
        }else{
            $query = "SELECT * FROM ".$tabella;
        }
        $risultato = $connessione->query($query);
        header('Content-Type: application/json');
        echo json_encode($risultato->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);    
    }else{
        echo("
        <!DOCTYPE html>
        <html>
            <head>
                <title>Api</title>
                <link rel='stylesheet' href='../CSS/index.css'>
            </head>
            <body>
                <div style='padding-left: 20px; padding-top:10px;'>
                    <h1>Api</h1>
                    <h2><a href='api/aerei'>Aerei</a></h2>
                    <h2><a href='api/aeroporti'>Aeroporti</a></h2>
                    <h2><a href='api/compagnie'>Compagnie</a></h2>
                    <h2><a href='api/controllori'>Controllori</a></h2>
                    <h2><a href='api/voli'>Voli</a></h2>
                    <h2><a href='api/parcheggi'>Parcheggi</a></h2>
                    <h2><a href='api/piste'>Piste</a></h2><br>
                    <h2><a href='index'>Home</a></h2>
                </div>
            </body>
        </html>");
    }
?>