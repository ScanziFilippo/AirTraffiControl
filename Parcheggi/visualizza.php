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
<link rel="stylesheet" href="../CSS/index.css">    </head>
    <body style="padding-left:20px; padding-top:20px">
        Visualizza parcheggi<br><br>
        <table>
            <tr>
                <th hidden>Id</th>
                <th>Nome</th>
                <th>Stato</th>
                <th></th>
            </tr>
            <?php
                $parcheggi = $connessione->query("SELECT * FROM luoghi WHERE aeroporto_id = '".$_SESSION['aeroporto_id']."' AND tipo=1 ORDER BY nome");
                while($parcheggi_row = $parcheggi->fetch_assoc()){
                    echo("<form action='modificacontroller.php' method='post'>");
                    echo("<tr>");
                    echo("<td hidden id='" . $parcheggi_row['id'] . "'>");
                    echo("<input readonly type='text' name='id' value='");
                    echo($parcheggi_row['id']);
                    echo("'></input></td>");
                    echo("<td>");
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo("<input type='text' name='nome' value='");
                    }
                    echo($parcheggi_row['nome']);
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo("'></input></td>");
                    }
                    echo("<td>");
                    if($connessione->query("SELECT * FROM luoghi INNER JOIN aerei ON luoghi.id = aerei.luogo WHERE luoghi.id = ". $parcheggi_row['id'])->num_rows>0){
                        echo("Occupato");
                    }else{
                        echo("Libero");
                    }
                    echo("</td>");
                    //TODO Metti stato
                    if($_SESSION['ruolo'] == "Amministratore"){
                        echo("<td><input type='submit' value='Rinomina'></input></td>");
                        if($connessione->query("SELECT * FROM luoghi INNER JOIN aerei ON luoghi.id = aerei.luogo WHERE luoghi.id = ". $parcheggi_row['id'])->num_rows==0){
                            echo("<td><button>Elimina</button></td>");
                        }
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
        </form><br>
        <a href="../Controllori/profilo.php">Torna al profilo</a>
        <?php
            if(isset($_GET['err'])){?>
                <p> <?php echo $_GET['err']; ?> </p>
                <?php 
            }
        ?>
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
                if(totali[i] != undefined && totali[i].getElementsByTagName("td")[3] != undefined){
                    var idDaEliminare = totali[i].getElementsByTagName("td")[0].id;
                    console.log(idDaEliminare);
                    totali[i].getElementsByTagName("td")[4].getElementsByTagName("button")[0].addEventListener("click", elimina);
                }
            }
        </script>
    </body>
</html>