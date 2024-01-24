<!DOCTYPE html>
<html>
    <head>
        <title>Registrazione</title>
    </head>
    <body>
        Registrazione del profilo<br><br>
        <form action="registracontroller.php" method="post">
            <input type="text" name="aeroporto_icao" style="text-transform:uppercase" placeholder="aeroporto_icao">
            <input type="text" name="nome_utente" placeholder="nome_utente">
            <input type="text" name="nome" placeholder="nome">
            <input type="text" name="cognome" placeholder="cognome">
            <input type="text" name="codice" placeholder="codice">
            <input type="checkbox" name="ruolo">Amministratore
            <input type="submit">
        </form>
    </body>
    <?php
        if(isset($_GET['err'])){?>
            <p> <?php echo $_GET['err']; ?> </p>
            <?php 
        }
    ?>
</html>