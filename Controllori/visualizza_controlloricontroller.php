<?php
    session_start();
    $param = $_GET["t"];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    $sql = "SELECT * FROM `controllori` WHERE `nome` LIKE '%$param%' AND `aeroporto_id` = '".$_SESSION['aeroporto_id']."'";
    $result = $connessione->query($sql);
    $res = $result->fetch_all();
    echo '<th style="padding:10px">Nome utente</th>
    <th style="padding:10px">Nome</th>
    <th style="padding:10px">Cognome</th>';
    foreach ($res as $r) {
        echo "<tr><td>" . $r[1] . "</td>" . "<td>" . $r[2] . "</td>" . "<td>" . $r[3] . "</td></tr>";
        //echo "<td>" $r[1] . $r[1] . "<br>";
    }
?>