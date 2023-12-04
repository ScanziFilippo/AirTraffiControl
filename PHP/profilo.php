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
        <p>Benvenuto 
            <?php 
                echo $_SESSION['username'];
            ?>
        </p>
        <a href="logout.php">Logout</a>
    </body>
</html>