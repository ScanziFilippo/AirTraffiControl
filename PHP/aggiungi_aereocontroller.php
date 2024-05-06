<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: login");
    }
    $nome_utente = $_SESSION['nome_utente'];
    $aeroporto_id = $_SESSION['aeroporto_id'];
    $connessione = new mysqli('localhost', 'root', '', 'progetto');

    if($connessione->connect_errno){
        echo("Connessione fallita: ".$connessione->connect_error.".");
        exit();
    }else{
        try{
            $immatricolazione = $_POST['immatricolazione'];
            $immatricolazione = strtoupper($immatricolazione);
            $modello = $_POST['modello'];
            $compagnia = $_POST['compagnia'];
            $stato = $_POST['stato'];
            $luogo = $_POST['luogo'];
            if($luogo == '-') 
                //header("location: aggiungi_aereo?err=Seleziona%20un%20parcheggio");
                $luogo = $connessione->query("SELECT id FROM luoghi WHERE aeroporto_id='". $_SESSION['aeroporto_id'] . "' AND tipo='0'")->fetch_assoc()['id'];
            if($luogo == ' ' or $luogo == '' or $luogo == NULL) 
                //header("location: aggiungi_aereo?err=Seleziona%20una%20pista");
                $luogo = $connessione->query("SELECT id FROM luoghi WHERE aeroporto_id='". $_SESSION['aeroporto_id'] . "' AND tipo='0'")->fetch_assoc()['id'];
            $aeroporto_id = $_SESSION['aeroporto_id'];
            $target_dir_aerei = "../IMG/Aerei/";
            $target_dir_compagnie = "../IMG/Compagnie/";
            $target_file_aereo = $target_dir_aerei . $modello;
            $target_file_compagnia = $target_dir_compagnie . $compagnia;
            $uploadOk = 1;        
            $imageFileType_aereo = strtolower(pathinfo($target_file_aereo,PATHINFO_EXTENSION));
            $imageFileType_compagnia = strtolower(pathinfo($target_file_compagnia,PATHINFO_EXTENSION));  
            $target_dir_aerei = $target_dir_aerei . $immatricolazione . ".jpeg";
            $target_dir_compagnie = $target_dir_compagnie . $compagnia . ".jpeg";    
            if ($_FILES["foto_aereo"]["name"] != NULL and $_FILES["foto_compagnia"]["name"] != NULL) {
            //if($_FILES['foto_aereo'] != '' and $_FILES['foto_compagnia'] != ''){
                $check1 = getimagesize($_FILES["foto_aereo"]["tmp_name"]);
                $check2 = getimagesize($_FILES["foto_compagnia"]["tmp_name"]);
                if($check1 !== false and $check2 !== false) {
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }

                if ($_FILES["foto_aereo"]["size"] > 10000000 or $_FILES["foto_compagnia"]["size"] > 10000000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }
            }else{
                $foto_aereo = NULL;
                $foto_compagnia = NULL;
                $uploadOk = 0;
            }
            
            if($connessione->query("SELECT * FROM aerei WHERE immatricolazione = '$immatricolazione'")->num_rows > 0){
                header("location: aggiungi_aereo?err=Immatricolazione%20gi%C3%A1%20in%20uso");
            }else{
                  
            if ($uploadOk == 0) {
                $connessione->query("INSERT INTO aerei (immatricolazione, modello, compagnia, stato, luogo) VALUES ('$immatricolazione', '$modello', '$compagnia', '$stato', '$luogo')");
                header("Location: index");
            }else {
                if (move_uploaded_file($_FILES["foto_aereo"]["tmp_name"], $target_file_aereo) and move_uploaded_file($_FILES["foto_compagnia"]["tmp_name"], $target_file_compagnia)) {
                  echo "The files have been uploaded.";
                  $foto_aereo = $target_file_aereo;
                  $foto_compagnia = $target_file_compagnia;
                  $connessione->query("INSERT INTO aerei (immatricolazione, modello, compagnia, foto_aereo, foto_compagnia, posizione, stato, pista_id, parcheggio_id, aeroporto_id) VALUES ('$immatricolazione', '$modello', '$compagnia', '$foto_aereo', '$foto_compagnia', '$posizione', '$stato', '$pista_id', $parcheggio_id, '$aeroporto_id')");
                  header("Location: index");      
                } else {
                  echo "Sorry, there was an error uploading your file.";
                  echo $target_file_aereo;
                }
            }

            }
        }
        catch(Exception $e){
            echo("Errore nella query: ".$e->getMessage());
        }
    }
?>