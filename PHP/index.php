<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: Controllori/login.php");
    }
?>
<html>
    <head>
        <title>Home</title>
    </head>
    <body>
        <h3>Benvenuto 
            <?php 
                echo $_SESSION['nome_utente'];
            ?>
        </h3>
        <a href="Controllori/profilo.php">Profilo</a>
    </body>
</html>