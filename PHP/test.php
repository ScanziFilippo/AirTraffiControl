<?php
    $connessione = mysqli_connect('localhost', 'root', '', 'progetto');
    //add 5k rows to the table and print the time it takes
?>
<html>
    <head>
        <title>Test</title>
        <link rel="stylesheet" href="../CSS/index.css">
    </head>
    <body>
        <div style='padding-left: 20px; padding-top:10px;'>
            <?php
                $inizio = microtime(true);
                for($i = 0; $i < 100; $i++){
                    $connessione->query("INSERT INTO luoghi (aeroporto_id, tipo) VALUES (-1, -1)");
                }
                $fine = microtime(true);
                $tempo = $fine - $inizio;
                echo "Aggiunte 100 righe in " . $tempo . " secondi";
                $inizio = microtime(true);
                $connessione->query("DELETE FROM luoghi WHERE aeroporto_id = -1 AND tipo = -1");
                $fine = microtime(true);
                $tempo = $fine - $inizio;
                echo "<br><br>Eliminate in " . $tempo . " secondi";
            ?>
        </div>
    </body>
</html>