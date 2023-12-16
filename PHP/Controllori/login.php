<html>
    <head>
        <title>Accesso</title>
    </head>
    <body>
        Accesso al profilo<br><br>
        <form action="logincontroller.php" method="post">
            <input type="text" name="nome_utente" placeholder="nome_utente">
            <input type="text" name="codice" placeholder="codice">
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