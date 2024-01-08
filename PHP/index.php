<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: Controllori/login.php");
    }
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
?>
<html>
    <head>
        <title>Home</title>
    </head>
    <body>
        <h1>Benvenuto 
            <?php 
                echo $_SESSION['nome_utente'];
            ?>
        </h1>
        <a href="Controllori/profilo.php"><h2>Profilo</h2></a>
        <a href="aggiungi_aereo.php"><h2>Aggiungi aereo</h2></a>
        <table>
            <tr>
                <th>Immatricolazione</th>
                <th>Modello</th>
                <th>Compagnia</th>
                <th>Passeggeri</th>
                <th>Foto aereo</th>
                <th>Foto compagnia</th>
                <th>Posizione</th>
                <th>Stato</th>
            </tr>
        <?php
            $aerei = $connessione->query("SELECT * FROM aerei WHERE aeroporto_icao = '".$_SESSION['aeroporto_icao']."'");
            while($aerei_row = $aerei->fetch_assoc()){
                echo("<tr>");
                echo("<td>".$aerei_row['immatricolazione']."</td>");
                echo("<td>".$aerei_row['modello']."</td>");
                echo("<td>".$aerei_row['compagnia']."</td>");
                echo("<td>".$aerei_row['passeggeri']."</td>");
                echo("<td>".$aerei_row['foto_aereo']."</td>");
                echo("<td>".$aerei_row['foto_compagnia']."</td>");
                echo("<td>".$aerei_row['posizione']."</td>");
                echo("<td>".$aerei_row['stato']."</td>");
                echo("</tr>");
            }
        ?>
        </table>
    </body>
</html>