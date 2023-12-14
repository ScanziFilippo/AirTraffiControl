<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: login.php");
    }
?>
<html>
    <head>
        <title>Document</title>
    </head>
    <body>
        <h1>Profilo</h1>
        <h3>Benvenuto 
            <?php 
                echo $_SESSION['username'];
            ?>
        </h3>
        <a href="logout.php">Logout</a>
        <a href="cancella.php">Cancella account</a>
    </body>
</html>