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
        <input type="text" id="valore" name="name" placeholder="ricerca nome" />
        <p>(Puoi vedere solo i controllori del tuo aeroporto)</p>
        <table id="tabella">
            <tr>
                <th>Nome utente</th>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Aeroporto</th>
                <!--<th>Modifica</th>
                <th>Cancella</th>-->
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
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {
                console.log("DOM fully loaded and parsed");
                var ricerca = document.getElementById("valore");
                ricerca.addEventListener("keyup", sulClick);
            });

            function sulClick(e) {
                e.preventDefault();
                var contenuto = document.getElementById("valore").value;
                
                console.log(e);

                let xhr = new XMLHttpRequest();
                xhr.open('GET', 'visualizza_controlloricontroller.php?t=' + contenuto);
                xhr.send();

                xhr.onload = function() {
                    if (xhr.status != 200) { // analyze HTTP status of the response
                        alert(`Error ${xhr.status}: ${xhr.statusText}`); // e.g. 404: Not Found
                    } else { // show the result
                        console.log(`Done, got ${xhr.response.length} bytes`); // response is the server
                        //var res = JSON.parse(xhr.response);
                        res = xhr.response;
                        console.log(res);
                        var t = document.getElementById("tabella");
                        t.innerHTML = res;
                    }
                };
                return false;
            }
        </script>
    </body>
</html>