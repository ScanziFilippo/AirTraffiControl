<?php
    //var_dump($_POST);
    $username = $_POST["username"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $password = md5($password);
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }else{
        try{
            $registra = "INSERT INTO utenti (username, name, password) VALUES ('$username', '$name', '$password')";
            $risultato = $connessione->query($registra);
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
            header("location: profilo.php");
        }
        //echo("Connesione corretta");
    }
    ?>