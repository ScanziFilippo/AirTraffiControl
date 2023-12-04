<!DOCTYPE html>
<html>
    <head>
        <title>Document</title>
    </head>
    <body>
        <form action="registracontroller.php" method="post">
            <input type="text" name="username">
            <input type="text" name="name">
            <input type="text" name="password">
            <input type="submit">
        </form>
    </body>
    <?php
        if(isset($_GET['err'])){?>
            <p> <?php echo $_GET['err']; ?> </p>
            <?php 
        }
    ?>
</html>