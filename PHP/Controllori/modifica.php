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
        <title>Modifica profilo</title>
    </head>
    <body>
        Modifica del profilo<br><br>
        <form action="modificacontroller.php" method="post">
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