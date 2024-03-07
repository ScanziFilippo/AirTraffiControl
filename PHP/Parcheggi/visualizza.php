<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])/* || $_SESSION['ruolo'] != "Amministratore"*/){
        header("Location: ../Controllori/login.php");
    }
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Visualizza Parcheggi</title>
        <link rel="stylesheet" href="../../CSS/index.css">
    </head>
    <body>
        Visualizza parcheggi<br><br>
        <table>
            <tr>
                <th>Id</th>
                <th>Stato</th>
            </tr>
            <?php
                $parcheggi = $connessione->query("SELECT * FROM parcheggi WHERE aeroporto_icao = '".$_SESSION['aeroporto_icao']."'");
                while($parcheggi_row = $parcheggi->fetch_assoc()){
                    echo("<form action='modificacontroller.php' method='post'>");
                    echo("<tr>");
                    echo("<td id='" . $parcheggi_row['id'] . "'>");
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo("<input type='text' name='id' value='");
                    }
                    echo($parcheggi_row['id']);
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo("'></input></td>");
                    }
                    echo("<input type='hidden' name='idVecchio' value='".$parcheggi_row['id']."'></input>");
                    echo("<td>".$parcheggi_row['stato']."</td>");
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo("<td><input type='submit'></input></td>");
                        //echo("<td><a href='eliminacontroller.php?id=".$parcheggi_row['id']."'>Elimina</a></td>");
                        echo("<td><button>Elimina</button></td>");
                        echo("</tr>");
                    }
                    echo("</form>");
                }
            ?>
        </table>
        <form>
            <?php
                if($_SESSION['ruolo'] == "Amministratore"){
                    echo("<input type='button' value='Aggiungi parcheggio' onclick='window.location.href=\"aggiungicontroller.php\"'>");
                }
            ?>
        </form>
        <a href="../Controllori/profilo.php">Torna al profilo</a>

        <script>
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
                xmlhttp.open("POST", "eliminacontroller.php?id=" + idDaEliminare, true);
                xmlhttp.send();
            }

            totali = document.getElementsByTagName("tr");
            console.log(totali.length);
            for(i=0; i<totali.length; i++){
                if(totali[i] != undefined && totali[i].getElementsByTagName("td")[3] != undefined && totali[i].getElementsByTagName("td")[3].getElementsByTagName("button")[0] != undefined){
                    var idDaEliminare = totali[i].getElementsByTagName("td")[0].id;
                    console.log(idDaEliminare);
                    totali[i].getElementsByTagName("td")[3].getElementsByTagName("button")[0].addEventListener("click", elimina);
                }
            }
        </script>
    </body>
</html>