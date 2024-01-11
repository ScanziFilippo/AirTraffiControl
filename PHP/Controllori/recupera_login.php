<html>
    <head>
        <title>Recupera login</title>
    </head>
    <body>
        Recupera login<br><br>
        <form action="recupera_logincontroller.php" method="post">
            <input type="text" name="nome_utente" placeholder="nome_utente">
            <input type="text" name="codice" placeholder="nuovo codice">
            <input type="submit">
        </form>
        <a href="login.php">Torna al login</a>
    </body>
    <?php
        if(isset($_GET['err'])){?>
        <p> <?php echo $_GET['err']; ?> </p>
        <?php 
        } 
    ?>
</html>