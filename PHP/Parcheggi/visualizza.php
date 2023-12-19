<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])/* || $_SESSION['ruolo'] != "Amministratore"*/){
        header("Location: ../Controllori/login.php");
    }
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Visualizza Parcheggi</title>
    </head>
    <body>
        Visualizza parcheggi<br><br>
        <table>
            <tr>
                <th>Id</th>
                <th>Stato</th>
            </tr>
            <?php
                $parcheggi = $connessione->query("SELECT * FROM parcheggi WHERE aeroporto_icao = '".$_SESSION['aeroporto_icao']."'");
                while($parcheggi_row = $parcheggi->fetch_assoc()){
                    echo("<tr>");
                    echo("<td>".$parcheggi_row['id']."</td>");
                    echo("<td>".$parcheggi_row['stato']."</td>");
                    echo("<td><a href='eliminacontroller.php?id=".$parcheggi_row['id']."'>Elimina</a></td>");
                    echo("</tr>");
                }
            ?>
        </table>
        <form>
            <input type="button" value="Aggiungi parcheggio" onclick="window.location.href='aggiungicontroller.php'">
        </form>
        <a href="../Controllori/profilo.php">Torna al profilo</a>
    </body>
</html>