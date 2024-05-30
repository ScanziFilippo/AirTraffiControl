<?php
    session_start();
    $id=$_GET["id"];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');
    $immatricolazione = $connessione->query("SELECT immatricolazione FROM aerei WHERE id=$id")->fetch_assoc()["immatricolazione"];
    $modello = $connessione->query("SELECT modello FROM aerei WHERE id=$id")->fetch_assoc()["modello"];
    $compagnia = $connessione->query("SELECT compagnia FROM aerei WHERE id=$id")->fetch_assoc()["compagnia"];
    $luogo = $connessione->query("SELECT luogo FROM aerei WHERE id=$id")->fetch_assoc()["luogo"];
    $stato = $connessione->query("SELECT stato FROM aerei WHERE id=$id")->fetch_assoc()["stato"];

?>
<!DOCTYPE html>
<html>
    <head>
        <title>modifica aereo</title>
        <link rel="stylesheet" href="../../CSS/index.css">
    </head>
    <body style="padding-left:20px; padding-top:20px">
        modifica un aereo<br><br>
        <form action="modifica_aereocontroller" method="post" enctype="multipart/form-data">
            <input name="id" value="<?php echo $id; ?>" type="hidden">
            <input type="text" name="immatricolazione" placeholder="immatricolazione" style="text-transform:uppercase" value="<?php echo($immatricolazione); ?>">
            <input list="aerei" name="modello" placeholder="modello" id="modello" value="<?php echo($modello); ?>">
                <datalist id="aerei">
                    <option value="A220">
                    <option value="A300">
                    <option value="A320">
                    <option value="A330">
                    <option value="A340">
                    <option value="A350">
                    <option value="A380">
                    <option value="BAC Concorde">
                    <option value="Boom Overture">
                    <option value="B707">
                    <option value="B717">
                    <option value="B727">
                    <option value="B737">
                    <option value="B747">
                    <option value="B757">
                    <option value="B767">
                    <option value="B777">
                    <option value="B787">
                    <option value="CRJ200">
                    <option value="CRJ700">
                    <option value="CRJ900">
                    <option value="CRJ1000">
                    <option value="E170">
                    <option value="E175">
                    <option value="E190">
                    <option value="E195">
                    <option value="MD11">
                    <option value="MD80">
                    <option value="MD90">
                    <option value="MD95">
                </datalist>
            <input list="compagnie" name="compagnia" placeholder="compagnia" id="compagnia" value="<?php echo($compagnia); ?>">
                <datalist id="compagnie">
                    <?php
                        $compagnie = $connessione->query("SELECT nome FROM compagnie ORDER BY nome");
                        while($compagnie_row = $compagnie->fetch_assoc()){
                            echo("<option value='".$compagnie_row['nome']."'>");
                        }
                    ?>
                </datalist>
            <!--<img src="" width="300px">
            <input type="file" name="foto_aereo" placeholder="foto_aereo" id="foto_aereo">
            <img src="" width="300px">
            <input type="file" name="foto_compagnia" placeholder="foto_compagnia">-->
            <input type="submit">
        </form>
        <br>
        <a href="elimina_aereo.php?id=<?php echo $id;?>" style="color: red">Elimina aereo</a>
        <br>
        <br>
        <?php
        if(isset($_GET['err'])){?>
        <p style="color: red"> <?php echo $_GET['err']; ?> </p> 
        <?php
            }
        ?>
        <a href="../index">Torna alla home</a>
        <script>
            /*function aggiornaConStato(){
                var stato = document.getElementsByName("stato")[0].value;
                if(stato == "Fermo"){
                    document.getElementById("parcheggi").style.display = "block";
                }else{
                    document.getElementById("parcheggi").style.display = "none";
                }
            }*/
        </script>
    </body>
</html>