<?php
    session_start();
    if(!isset($_SESSION['nome_utente']) || $_SESSION['ruolo'] != "Amministratore"){
        header("Location: login.php");
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Modifica Amministratore</title>
    </head>
    <body>
        Modifica del profilo<br><br>
        <form action="modifica_amministratorecontroller.php" method="post">
            <!--<input type="text" name="aeroporto_icao" placeholder="aeroporto_icao" value="<?php echo $_SESSION['aeroporto_icao']; ?>">-->
            <input type="text" name="nome_utente" placeholder="nome_utente" value="<?php echo $_SESSION['nome_utente']; ?>">
            <input type="text" name="nome" placeholder="nome" value="<?php echo $_SESSION['nome']; ?>">
            <input type="text" name="cognome" placeholder="cognome" value="<?php echo $_SESSION['cognome']; ?>">
            <input type="submit">
        </form>
        <br>
        <a href="../Controllori/profilo.php">Torna al profilo</a>
    </body>
    <?php
        if(isset($_GET['err'])){?>
            <p> <?php echo $_GET['err']; ?> </p>
            <?php 
        }
    ?>
</html>