<?php
    $modello = $_POST['modello'];
    $connessione = new mysqli("localhost","root","","aeroporto_marconi");
    $foto = $connessione->query("SELECT foto_aereo FROM aerei WHERE modello = '$modello'");
    $foto = $foto->fetch_assoc();
    echo($foto['foto_aereo']);