<!DOCTYPE html>
<html>
    <head>
        <title>Document</title>
    </head>
    <body>
        <form action="registracontroller.php" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="name" placeholder="Name">
            <input type="text" name="password" placeholder="Password">
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