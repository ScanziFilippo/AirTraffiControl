<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: login");
    }
    $nome_utente = $_SESSION['nome_utente'];
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Modifica profilo</title>
<link rel="stylesheet" href="../CSS/index.css">    </head>
    <body style="padding-left:20px; padding-top:20px">
        Modifica del profilo<br><br>
        <form action="modificacontroller" method="post">
            <input type="text" name="nome_utente" placeholder="nome_utente" value="<?php echo $_SESSION['nome_utente']; ?>">
            <input type="text" name="nome" placeholder="nome" value="<?php echo $_SESSION['nome']; ?>">
            <input type="text" name="cognome" placeholder="cognome" value="<?php echo $_SESSION['cognome']; ?>">
            <input type="submit">
        </form>
        <br>
        <a href="../Controllori/profilo">Torna al profilo</a>
    </body>
    <?php
        if(isset($_GET['err'])){?>
            <p> <?php echo $_GET['err']; ?> </p>
            <?php 
        }
    ?>
</html>