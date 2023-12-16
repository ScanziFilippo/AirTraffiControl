<?php
    session_start();
    if(!isset($_SESSION['nome_utente']) || $_SESSION['ruolo'] != "Amministratore"){
        header("Location: Controllori/login.php");
    }
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    if ($connessione->connect_errno)
    {
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Visualizza controllori</title>
    </head>
    <body>
        <h3>Visualizza controllori</h3>
        <table>
            <tr>
                <th>Nome utente</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Aeroporto</th>
                <th>Modifica</th>
                <th>Cancella</th>
            </tr>
            <?php
                $controllori = $connessione->query("SELECT * FROM controllori WHERE aeroporto_icao = '".$_SESSION['aeroporto_icao']."'");
                while($controllori_row = $controllori->fetch_assoc()){
                    echo("<tr>");
                    echo("<td>".$controllori_row['nome_utente']."</td>");
                    echo("<td>".$controllori_row['nome']."</td>");
                    echo("<td>".$controllori_row['cognome']."</td>");
                    echo("<td>".$controllori_row['aeroporto_icao']."</td>");
                    /*echo("<td><a href='modifica_controllori.php?nome_utente=".$controllori_row['nome_utente']."'>Modifica</a></td>");
                    echo("<td><a href='cancella_controllori.php?nome_utente=".$controllori_row['nome_utente']."'>Cancella</a></td>");*/
                    echo("</tr>");
                }
            ?>
        </table>
        <a href="profilo.php">Torna al profilo</a>
    </body>
</html>