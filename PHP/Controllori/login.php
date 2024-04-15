<html>
    <head>
        <title>Accesso</title>
        <link rel="stylesheet" href="../../CSS/index.css">
    </head>
    <body style="padding-left:20px; padding-top:20px">
        Accesso al profilo<br><br>
        <form action="logincontroller" method="post">
            <input type="text" name="nome_utente" placeholder="nome_utente">
            <input type="password" name="codice" placeholder="codice">
            <input type="submit">
        </form>
        <a href="registra">Registrati</a><br><br>
        <a href="recupera_login">Non riesci a entrare?</a>
    </body>
    <?php
        if(isset($_GET['err'])){?>
        <p> <?php echo $_GET['err']; ?> </p>
        <?php 
        }
        session_start();
        if(isset($_SESSION['nome_utente'])){
            header("Location: profilo");
        }
    ?>
</html>