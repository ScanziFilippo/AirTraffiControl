<?php
    session_start();
    if(!isset($_SESSION['nome_utente']) || $_SESSION['ruolo'] != "Amministratore"){
        header("Location: Controllori/login");
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
        <link rel="stylesheet" href="../../CSS/index.css">
    </head>
    <body style="padding-left:20px; padding-top:20px">
        <h3>Visualizza controllori</h3>
        <input type="text" id="valore" name="name" placeholder="ricerca nome" />
        <p>(Puoi vedere solo i controllori del tuo aeroporto)</p>
        <table id="tabella">
            <tr>
                <th>Nome utente</th>
                <th>Nome</th>
                <th>Cognome</th>
                <!--<th>Modifica</th>
                <th>Cancella</th>-->
            </tr>
            <?php
                $controllori = $connessione->query("SELECT * FROM controllori WHERE aeroporto_id = '".$_SESSION['aeroporto_id']."'");
                while($controllori_row = $controllori->fetch_assoc()){
                    echo("<tr>");
                    echo("<td id=".$controllori_row['nome_utente'].">".$controllori_row['nome_utente']."</td>");
                    echo("<td>".$controllori_row['nome']."</td>");
                    echo("<td>".$controllori_row['cognome']."</td>");
                    /*echo("<td><a href='modifica_controllori?nome_utente=".$controllori_row['nome_utente']."'>Modifica</a></td>");
                    echo("<td><a href='cancella_controllori?nome_utente=".$controllori_row['nome_utente']."'>Cancella</a></td>");*/
                    if($_SESSION['ruolo'] == "Amministratore" && $controllori_row['nome_utente'] != $_SESSION['nome_utente']){
                        echo("<td><button>Elimina</button></td>");
                        echo("</tr>");
                    }
                    echo("</tr>");
                }
            ?>
        </table><br>
        <a href="profilo">Torna al profilo</a>
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {
                var ricerca = document.getElementById("valore");
                ricerca.addEventListener("keyup", sulClick);
            });

            function sulClick(e) {
                e.preventDefault();
                var contenuto = document.getElementById("valore").value;
                
                console.log(e);

                let xhr = new XMLHttpRequest();
                xhr.open('GET', 'visualizza_controlloricontroller?t=' + contenuto);
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
            
            function elimina(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                idDaEliminare=this.parentNode.parentNode.getElementsByTagName("td")[0].id;
                console.log("id" + idDaEliminare);
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById(idDaEliminare).parentNode.remove();
                    }
                };
                xmlhttp.open("POST", "eliminacontroller?id=" + idDaEliminare, true);
                xmlhttp.send();
            }
            totali = document.getElementsByTagName("tr");
            console.log(totali.length);
            for(i=0; i<totali.length; i++){
                if(totali[i] != undefined && totali[i].getElementsByTagName("td")[4] != undefined && totali[i].getElementsByTagName("td")[4].getElementsByTagName("button")[0] != undefined){
                    var idDaEliminare = totali[i].getElementsByTagName("td")[0].id;
                    console.log(idDaEliminare);
                    totali[i].getElementsByTagName("td")[4].getElementsByTagName("button")[0].addEventListener("click", elimina);
                }
            }

        </script>
    </body>
</html>