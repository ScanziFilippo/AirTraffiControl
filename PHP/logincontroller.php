<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$password = md5($password);
$connessione = new mysqli('localhost', 'root', '', 'progetto');
if ($connessione->connect_errno)
{
    echo("Connessione fallita: ".$connessione->connect_error.".");
    exit();
}else{
    try{
        $login = "SELECT * FROM utenti WHERE username = '$username' AND password = '$password'";
        $risultato = $connessione->query($login);
        if($risultato->num_rows > 0){
            $_SESSION['username'] = $username;
            header("location: profilo.php?username=$username");
        }else{
            header("location: login.php?err=Username o password errati");
        }
    }
    catch(Exception $e){
        echo("Errore nella query: ".$e->getMessage());
        header("location: login.php");
    }
}