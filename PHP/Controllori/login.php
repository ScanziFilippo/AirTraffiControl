<html>
    <head>
        <title>Accesso</title>
        <link rel="stylesheet" href="../../CSS/index.css">
    </head>
    <body>
        Accesso al profilo<br><br>
        <form action="logincontroller.php" method="post">
            <input type="text" name="nome_utente" placeholder="nome_utente">
            <input type="text" name="codice" placeholder="codice">
            <input type="submit">
        </form>
        <a href="registra.php">Registrati</a>
        <a href="recupera_login.php">Non riesci a entrare?</a>
    </body>
    <?php
        if(isset($_GET['err'])){?>
        <p> <?php echo $_GET['err']; ?> </p>
        <?php 
        }
        session_start();
        if(isset($_SESSION['nome_utente'])){
            header("Location: profilo.php");
        }
    ?>
</html>