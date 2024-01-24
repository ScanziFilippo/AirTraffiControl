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
            <a href="Controllori/profilo.php">
                <?php 
                    echo $_SESSION['nome_utente'];
                ?>
            </a>
        </h1>
        <a href="aggiungi_aereo.php"><h2>Aggiungi aereo</h2></a>
        <table>
        <?php
            if($connessione->query("SELECT * FROM aerei WHERE aeroporto_icao = '".$_SESSION['aeroporto_icao']."'")->num_rows > 0){
                echo("            <b><tr>
                <th>Immatricolazione</th>
                <th>Modello</th>
                <th>Compagnia</th>
                <th>Passeggeri</th>
                <th>Foto aereo</th>
                <th>Foto compagnia</th>
                <th>Posizione</th>
                <th>Stato</th>
                <th>Bandiera</th>
            </tr><b>
            ");
            }
        ?>
        <?php
            $aerei = $connessione->query("SELECT * FROM aerei WHERE aeroporto_icao = '".$_SESSION['aeroporto_icao']."'");
            while($aerei_row = $aerei->fetch_assoc()){
                echo("<tr>");
                echo("<td>".$aerei_row['immatricolazione']."</td>");
                echo("<td>".$aerei_row['modello']."</td>");
                echo("<td>".$aerei_row['compagnia']."</td>");
                echo("<td>".$aerei_row['passeggeri']."</td>");
                echo("<td><img src='../IMG/Aerei/".$aerei_row['modello']."' width='200px'></td>");
                echo("<td><img src='../IMG/Compagnie/".$aerei_row['compagnia']."' width='200px'></td>");
                echo("<td>".$aerei_row['posizione']."</td>");
                echo("<td>".$aerei_row['stato']."</td>");
                echo("<td><img src='https://flagsapi.com/". strtoupper(substr($aerei_row['immatricolazione'], 0, 2)) . "/flat/64.png'></td>");
                echo("</tr>");
            }
        ?>
        </table>
    </body>
</html>