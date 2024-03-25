<?php
    require __DIR__ . '/../vendor/autoload.php';

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    $chiave_segreta = "your_secret_key";
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
            if($tabella == '')
                header("Location: api.php");
        }
        $risultato = $connessione->query($query);
        header('Content-Type: application/json');
        echo json_encode($risultato->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);    
    }else if(isset($_POST['nome']) && isset($_POST['codice'])){
        $username = $_POST['nome'];
        $codice = md5($_POST['codice']);
        if($connessione->query("SELECT * FROM controllori WHERE nome_utente = '".$username."' AND codice = '".$codice."'")->num_rows == 1){
            $nome = $connessione->query("SELECT nome FROM controllori WHERE nome_utente = '".$username."' AND codice = '".$codice."'")->fetch_assoc()['nome'];
            $cognome = $connessione->query("SELECT cognome FROM controllori WHERE nome_utente = '".$username."' AND codice = '".$codice."'")->fetch_assoc()['cognome'];
            $icao = $connessione->query("SELECT aeroporto_icao FROM controllori WHERE nome_utente = '".$username."' AND codice = '".$codice."'")->fetch_assoc()['aeroporto_icao'];
            $ruolo = $connessione->query("SELECT ruolo FROM controllori WHERE nome_utente = '".$username."' AND codice = '".$codice."'")->fetch_assoc()['ruolo'];
            $data =
                [
                    'username' => $username, 
                    'profilo' => 
                        [
                            'nome' => $nome,
                            'cognome' => $cognome,
                            'icao' => $icao,
                            'ruolo' => $ruolo
                        ],
                ];
            $token = JWT::encode($data, $chiave_segreta, 'HS256');    
            echo $token;
        }else if(isset($_POST['token'])){
            $token = $_POST['token'];
            try{
                $decoded = JWT::decode($token, $chiave_segreta, array('HS256'));
                echo $decoded;
            }catch(Exception $e){
                echo json_encode($e->getMessage());
            }
        }else{
            header("Location: api");
        }

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
                </div>
                    <form action='api.php' method='post' style='background-color: #f1f1f1; padding: 20px;'>
                        <h2>Ottieni token</h2>
                        <input type='text' name='nome' placeholder='Nome'>
                        <input type='text' name='codice' placeholder='Codice'>
                        <input type='submit' value='Invia'>
                    </form>
                    <form action='api.php' method='post' style='background-color: #f1f1f1; padding: 20px;'>
                        <h2>Verifica token</h2>
                        <input type='text' name='token' placeholder='Token'>
                        <input type='submit' value='Invia'>
                    </form>
                <div style='padding-left: 20px; padding-top:10px;'>
                    <h2><a href='index'>Home</a></h2>
                </div>
            </body>
        </html>");
    }
?>