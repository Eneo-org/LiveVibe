<?php
require_once("./db_conn.php");

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    include('addImg.php');
    $artista = false;
    if(isset($_POST['nome']) && isset($_POST['cognome']) && isset($_POST['nomeDarte'])){

        $nomeArtista = $_POST['nome'];
        $cognomeArtista = $_POST['cognome'];
        $nomeDarte = $_POST['nomeDarte'];

        $sql = "SELECT * FROM artista WHERE nomeDarte=$nomeDarte"; 
        if ($conn->query($sql) === TRUE) {  //se l'artista già esiste non continua con il salvataggio dell'evento
            echo "<script> alert('l artista gia esiste') </script>";
            exit;
        }else{
            $sql = "INSERT INTO artista (nome, cognome, nomeDarte) 
            VALUES ('$nomeArtista', '$cognomeArtista', '$nomeDarte')";
            
            if ($conn->query($sql) === TRUE) {
                $artista = true;
            }  
        }

          
    }
    $titolo = $_POST['titolo'];
    $luogo = $_POST['luogo'];
    $data = $_POST['data'];
    $ora = $_POST['ora'];
    $categoria = $_POST['categoria'];
    $utente = $_SESSION['user_id'];
    if($uploadOk == 1){
        $fileName = $_FILES["fileToUpload"]["name"];
    }else{
        $fileName = 'image_not_found.png';
    }
    
    if(!$artista){
        $artista = $_POST['artista'];
    }else{
        $sql = "SELECT * FROM artista where nomeDarte='$nomeDarte'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $artista = $row['IdArtista'];   
        }
    }
   

    $sql = "INSERT INTO evento (immagine, data, ora, titolo, luogo, IdCategoria, IdArtista, IdUtente) 
            VALUES ('$fileName','$data', '$ora', '$titolo', '$luogo', '$categoria', '$artista', '$utente')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit;
    } else {
        echo "Errore durante l'inserimento dell'evento: " . $conn->error;
    }

}