<?php
    session_start();
    $param = $_GET["t"];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    $sql = "SELECT * FROM `controllori` WHERE `nome` LIKE '%$param%' AND `aeroporto_icao` = '".$_SESSION['aeroporto_icao']."'";
    $result = $connessione->query($sql);
    $res = $result->fetch_all();
    echo "<tr><th>Nome utente</th><th>Nome</th><th>Cognome</th><th>Aeroporto</th></tr>";
    foreach ($res as $r) {
        echo "<tr><td>" . $r[0] . "</td>" . "<td>" . $r[1] . "</td>" . "<td>" . $r[2] . "</td>" . "<td>" . $r[5] . "</td></tr>";
        //echo "<td>" $r[1] . $r[1] . "<br>";
    }
?>