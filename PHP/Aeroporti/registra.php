<!DOCTYPE html>
<html>
    <head>
        <title>Registra aeroporto</title>
    </head>
    <body>
        Registrazione dell'aeroporto<br><br>
        <form action="registracontroller.php" method="post">
            <input type="text" name="icao" placeholder="icao">
            <input type="text" name="iata" placeholder="iata">
            <input type="text" name="nome" placeholder="nome">
            <input type="text" name="citta" placeholder="citta">
            <input type="text" name="nazione" placeholder="nazione">
            <input type="submit">
        </form>
    </body>
    <?php
        if(isset($_GET['err'])){?>
            <p> <?php echo $_GET['err']; ?> </p>
            <?php 
        }
    ?>