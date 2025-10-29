<?php
require_once("./db_conn.php");
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);


if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $eventoId = $_POST['evento_id']; 
    $testo = '';
    $stelle = $_POST["c4l-rating-$eventoId"];

    $user = $_SESSION['user_id'];

    if(isset($_POST['testo']) && $_POST['testo'] != ''){
        $testo = $_POST['testo'];
    }
    
    $query = "INSERT INTO commento (voto, descrizione, IdUtente, IdEvento) VALUES (?, ?, ?, ?)";

    $stmt = $conn -> prepare ($query) ;
    $stmt -> bind_param("isii", $stelle, $testo, $user, $eventoId);

    $stmt -> execute();

    $stmt -> close();

    $conn -> close();
    echo "<script>console.log('commento salvato') </script>";
    header('Location: index.php');
    exit();
}
?>