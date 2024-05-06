<?php
    session_start();
    if(!isset($_SESSION['nome_utente'])){
        header("Location: login");
    }
    if($_SESSION['ruolo'] == "Amministratore"){
        $nome_utente = $_SESSION['nome_utente'];
        $connessione = new mysqli('localhost', 'root', '', 'progetto');
        if($connessione->connect_errno){
            echo("Connessione fallita: ".$connessione->connect_error.".");
            exit();
        }else{
            $id = $_POST['id'];
            $immatricolazione = $_POST['immatricolazione'];
            $immatricolazione = strtoupper($immatricolazione);
            $modello = $_POST['modello'];
            $compagnia = $_POST['compagnia'];
            /*if(!is_int($pista_id)){
                $pista_id = NULL;
            }
            if(!is_int($parcheggio_id)){
                $parcheggio_id = NULL;
            }*/
            /*$target_dir_aerei = "../IMG/Aerei/";
            $target_dir_compagnie = "../IMG/Compagnie/";
            $target_file_aereo = $target_dir_aerei . $modello;
            $target_file_compagnia = $target_dir_compagnie . $compagnia;
            $uploadOk = 1;        
            $imageFileType_aereo = strtolower(pathinfo($target_file_aereo,PATHINFO_EXTENSION));
            $imageFileType_compagnia = strtolower(pathinfo($target_file_compagnia,PATHINFO_EXTENSION));  
            $target_dir_aerei = $target_dir_aerei . $immatricolazione . ".jpeg";
            $target_dir_compagnie = $target_dir_compagnie . $compagnia . ".jpeg";  */
            $connessione->query("UPDATE aerei SET immatricolazione = '".$immatricolazione."' WHERE id = '".$id."'");
            $connessione->query("UPDATE aerei SET modello = '".$modello."', compagnia = '".$compagnia."' WHERE id = '".$id."'");
            header("Location: index");
        }
    }else{
        header("Location: index");
    }
?>