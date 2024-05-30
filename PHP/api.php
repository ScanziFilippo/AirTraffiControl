<?php
    require __DIR__ . '/../vendor/autoload.php';

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    session_start();
    $chiave_segreta = "your_secret_key";
    $connessione = new mysqli("localhost","root","","progetto");
    if($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }
    /*if(isset($_GET['tabella'])){
        $tabella = $_GET['tabella'];*/
    if(isset($_GET['logout'])){
        $_SESSION['token'] = null;
        header('Location: api');
    }else
    if(isset($_SESSION['token'])){
        if(isset($_REQUEST['tabella']) && $_REQUEST['tabella']!=""){
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
                    $query = "SELECT * FROM ".$tabella." WHERE nome_utente = '".$id."'";
            }else{
                $query = "SELECT * FROM ".$tabella;
            }
            $risultato = $connessione->query($query);
            header('Content-Type: application/json');
            echo json_encode($risultato->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);    
        }/*else if(isset($_POST['token'])){
                $token = $_POST['token'];
                try{
                    //$decoded = JWT::decode($token, $chiave_segreta, array('HS256'));
                    //$decoded = JWT::decode($token, new Key($chiave_segreta, 'HS256'), $headers = new stdClass());
                    //$decoded = JWT::decode($token, $chiave_segreta, ['HS256', 'headers' => $headers]);
                    $decoded = JWT::decode($token, new Key($chiave_segreta, 'HS256'));
                    $json_payload = json_encode($decoded);
                    header('Content-Type: application/json');
                    echo $json_payload;
                }catch(Exception $e){
                    echo json_encode($e->getMessage(), JSON_PRETTY_PRINT);
                }
        }*/
        else{
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
                        <h3><a href='api/aerei'>Aerei</a></h3>
                        <h3><a href='api/aeroporti'>Aeroporti</a></h3>
                        <h3><a href='api/compagnie'>Compagnie</a></h3>
                        <h3><a href='api/controllori'>Controllori</a></h3>
                        <h3><a href='api/luoghi'>Luoghi</a></h3>
                        <h3><a href='api/voli'>Voli</a></h3>
                    </div>
                        <!--
                        <form action='api' method='post' style='background-color: #f1f1f1; padding: 20px;'>
                            <h2>Verifica token</h2>
                            <input type='text' name='token' placeholder='Token'>
                            <input type='submit' value='Invia'>
                        </form>-->
                    <div style='padding-left: 20px; padding-top:10px;'>
                        <h2><a href='index'>Home</a></h2>
                        <h2><a href='api?logout=true'>Logout</a></h2>
                    </div>
                </body>
            </html>");
        }
    }
        else if(isset($_POST['nome']) && isset($_POST['codice'])){
            $nome_utente = $_POST['nome'];
            $codice = md5($_POST['codice']);
            $query = $connessione->query("SELECT * FROM controllori WHERE nome_utente = '".$nome_utente."' AND codice = '".$codice."'");
            if($query->num_rows == 1){
                $row = $query->fetch_assoc();
                $id = $row['id'];
                $nome = $row['nome'];
                $cognome = $row['cognome'];
                $aeroporto_id = $row['aeroporto_id'];
                $ruolo = $row['ruolo'];
                $data =
                    [
                        'id' => $id,
                        'nome_utente' => $nome_utente, 
                        'profilo' => 
                            [
                                'nome' => $nome,
                                'cognome' => $cognome,
                                'ruolo' => $ruolo
                            ],
                    ];
                $token = JWT::encode($data, $chiave_segreta, 'HS256');    
                $_SESSION['token'] = $token;
            }
            header('Location: api');
    }else{
        echo "<html>
        <head>
            <title>Api</title>
            <link rel='stylesheet' href='../CSS/index.css'>
        </head>
        <body>
            <form action='api' method='post' style='background-color: #f1f1f1; padding: 20px;'>
                <h2>Accedi all'api</h2>
                <input type='text' name='nome' placeholder='Nome'>
                <input type='password' name='codice' placeholder='Codice'>
                <input type='submit' value='Invia'>
            </form>
            <div style='padding-left: 20px; padding-top:10px;'>
                <h2><a href='index'>Home</a></h2>
            </div>
        </body>
        </html>";
    }
?>