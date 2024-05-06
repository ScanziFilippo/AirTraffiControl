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
        <title>Visualizza piste</title>
        <link rel="stylesheet" href="../../CSS/index.css">
    </head>
    <body>
        Visualizza piste<br><br>
        <table>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>Stato</th>
                <th></th>
            </tr>
            <?php
                $piste = $connessione->query("SELECT * FROM luoghi WHERE aeroporto_id = '".$_SESSION['aeroporto_id']."' AND tipo=2 ORDER BY nome");
                while($piste_row = $piste->fetch_assoc()){
                    echo("<form action='modificacontroller.php' method='post'>");
                    echo("<tr>");
                    echo("<td id='" . $piste_row['id'] . "'>");
                    echo("<input readonly type='text' name='id' value='");
                    echo($piste_row['id']);
                    echo("'></input></td>");
                    echo("<td>");
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo("<input type='text' name='nome' value='");
                    }
                    echo($piste_row['nome']);
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo("'></input></td>");
                    }
                    //TODO Metti stato
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo("<td><input type='submit'></input></td>");
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
                    echo("<input type='button' value='Aggiungi pista' onclick='window.location.href=\"aggiungicontroller.php\"'>");
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