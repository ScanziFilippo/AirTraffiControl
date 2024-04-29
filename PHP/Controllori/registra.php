<!DOCTYPE html>
<html>
    <head>
        <title>Registrazione</title>
        <link rel="stylesheet" href="../../CSS/index.css">
    </head>
    <body>
        Registrazione del profilo<br><br>
        <form action="registracontroller" method="post">
            <input type="text" name="aeroporto_icao" style="text-transform:uppercase" placeholder="aeroporto_icao">
            <input type="text" name="nome_utente" placeholder="nome_utente">
            <input type="text" name="nome" placeholder="nome">
            <input type="text" name="cognome" placeholder="cognome">
            <input type="password" name="codice" placeholder="codice">
            <input type="checkbox" name="ruolo">Amministratore
            <input type="submit">
        </form>
    </body>
    <?php
        if(isset($_GET['err'])){?>
        <p style="color: red"> <?php echo $_GET['err']; ?> </p> 
        <?php
            }
        ?>
</html>