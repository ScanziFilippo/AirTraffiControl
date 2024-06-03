<?php
    session_start();
    $param = $_GET["t"];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    $sql = "SELECT * FROM `controllori` WHERE `nome` LIKE '%$param%' AND `aeroporto_id` = '".$_SESSION['aeroporto_id']."'";
    $result = $connessione->query($sql);
    $res = $result->fetch_all();
    echo "<tr><th>Nome utente</th><th>Nome</th><th>Cognome</th></tr>";
    foreach ($res as $r) {
        echo "<tr><td>" . $r[1] . "</td>" . "<td>" . $r[2] . "</td>" . "<td>" . $r[3] . "</td></tr>";
        //echo "<td>" $r[1] . $r[1] . "<br>";
    }
?>