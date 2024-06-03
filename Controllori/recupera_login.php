<html>
    <head>
        <title>Recupera login</title>
<link rel="stylesheet" href="../CSS/index.css">    </head>
    <body>
        Recupera login<br><br>
        <form action="recupera_logincontroller" method="post">
            <input type="text" name="nome_utente" placeholder="nome_utente">
            <input type="text" name="codice" placeholder="nuovo codice">
            <input type="submit">
        </form>
        <a href="login">Torna al login</a>
    </body>
    <?php
        if(isset($_GET['err'])){?>
        <p> <?php echo $_GET['err']; ?> </p>
        <?php 
        } 
    ?>
</html>