<html>
    <head>
        <title>Document</title>
    </head>
    <body>
        <form action="logincontroller.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="password" placeholder="Password">
            <input type="submit">
        </form>
        <a href="registra.php">Registrati</a>
    </body>
    <?php
        if(isset($_GET['err'])){?>
        <p> <?php echo $_GET['err']; ?> </p>
        <?php 
        } 
    ?>
</html>