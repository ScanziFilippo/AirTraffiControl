<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: ../Controllori/login");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Registra aeroporto</title>
<link rel="stylesheet" href="../CSS/index.css">    </head>
    <body style="padding-left:20px; padding-top:20px">
        Registrazione dell'aeroporto<br><br>
        <form action="registracontroller" method="post">
            <input type="text" name="icao" placeholder="icao" style="text-transform:uppercase" readonly="readonly" value="<?php echo $_SESSION['aeroporto_icao']; ?>">
            <input type="text" name="iata" placeholder="iata" style="text-transform:uppercase" >
            <input type="text" name="nome" placeholder="nome">
            <input type="text" name="citta" placeholder="citta">
            <input type="text" name="nazione" placeholder="nazione">
            <input type="number" name="parcheggi" placeholder="parcheggi">
            <input type="number" name="piste" placeholder="piste">
            <input type="submit">
        </form>
    </body>
    <?php
        if(isset($_GET['err'])){?>
            <p> <?php echo $_GET['err']; ?> </p>
            <?php 
        }
    ?>