<?php
    session_start();
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Visualizza voli</title>
<link rel="stylesheet" href="../CSS/index.css">    </head>
    <body>
    <div style='padding-left: 20px; padding-top:10px;'>
        <h1>Visualizza voli</h1>
        <table>
        <style>
    td, th {
        padding: 10px;
    }
</style>
<tr>
    <th>Codice</th>
    <th>Partenza</th>
    <th>Destinazione</th>
    <th>Orario partenza</th>
    <th>Orario arrivo</th>
</tr>
<?php
    $query = "SELECT * FROM voli WHERE partenza = '".$_SESSION['aeroporto_id']."' OR destinazione = '".$_SESSION['aeroporto_id']."'";
    $risultato = $connessione->query($query);
    while($riga = $risultato->fetch_assoc()){
        echo "<tr>";
        echo "<td>".$riga["id"]."</td>";
        echo "<td>".$connessione->query("SELECT immatricolazione FROM aerei WHERE id='".$riga["aereo_id"]."'")->fetch_assoc()["immatricolazione"]."</td>";
        echo "<td>".$connessione->query("SELECT icao FROM aeroporti WHERE id='".$riga["partenza"]."'")->fetch_assoc()["icao"]."</td>";
        //echo "<td>".$connessione->query("SELECT icao FROM aeroporti WHERE id='".$riga["destinazione"]."'")->fetch_assoc()["icao"]."</td>";
        if($riga["destinazione"] == NULL)
            echo "<td>-</td>";
        else
            echo "<td>".$connessione->query("SELECT icao FROM aeroporti WHERE id='".$riga["destinazione"]."'")->fetch_assoc()["icao"]."</td>";
        echo "<td>".$riga["data_partenza"]."</td>";
        echo "<td>".$riga["data_arrivo"]."</td>";
        echo "</tr>";
    }
?>
</table>
</div>
<div style='padding-left: 20px; padding-top:10px;'>
    <h2><a href='../'>Home</a></h2>
</div>
</body>