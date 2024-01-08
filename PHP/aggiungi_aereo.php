<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: login.php");
    }
    $nome_utente = $_SESSION['nome_utente'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Aggiungi aereo</title>
    </head>
    <body>
        Aggiungi un aereo<br><br>
        <form action="aggiungi_aereocontroller.php" method="post">
            <input type="text" name="immatricolazione" placeholder="immatricolazione">
            <input type="text" name="modello" placeholder="modello">
            <input type="text" name="compagnia" placeholder="compagnia">
            <input type="number" name="passeggeri" placeholder="passeggeri">
            <input type="file" name="foto_aereo" placeholder="foto_aereo">
            <input type="file" name="foto_compagnia" placeholder="foto_compagnia">
            <input type="text" name="posizione" placeholder="posizione">
            <input type="text" name="stato" placeholder="stato">
            <input type="number" name="pista_id" placeholder="pista_id">
            <input type="number" name="parcheggio_id" placeholder="parcheggio_id">
            <input type="text" name="aeroporto_icao" placeholder="aeroporto_icao">
            <input type="submit">
        </form>
        <br>
        <a href="index.php">Torna alla home</a>
    </body>
</html>