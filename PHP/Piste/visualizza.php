<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])/* || $_SESSION['ruolo'] != "Amministratore"*/){
        header("Location: ../Controllori/login");
    }
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Visualizza Piste</title>
        <link rel="stylesheet" href="../../CSS/index.css">
    </head>
    <body>
        Visualizza Piste<br><br>
        <table>
            <tr>
                <th>Id</th>
                <th>Stato</th>
            </tr>
            <?php
                $piste = $connessione->query("SELECT * FROM piste WHERE aeroporto_id = '".$_SESSION['aeroporto_id']."'");
                while($piste_row = $piste->fetch_assoc()){
                    echo("<form action='modificacontroller' method='post'>");
                    echo("<tr>");
                    echo("<td id='" . $piste_row['id'] . "'>");
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo("<input type='text' name='id' value='");
                    }
                    echo($piste_row['id']);
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo("'></input></td>");
                    }
                    echo("<input type='hidden' name='idVecchio' value='".$piste_row['id']."'></input>");
                    echo("<td>".$piste_row['stato']."</td>");
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo("<td><input type='submit'></input></td>");
                        //echo("<td><a href='eliminacontroller?id=".$piste_row['id']."'>Elimina</a></td>");
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
                    echo("<input type='button' value='Aggiungi pista' onclick='window.location.href=\"aggiungicontroller\"'>");
                }
            ?>
        </form>
        <a href="../Controllori/profilo">Torna al profilo</a>
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
                xmlhttp.open("POST", "eliminacontroller?id=" + idDaEliminare, true);
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