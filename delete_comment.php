<?php
session_start();
require_once("./db_conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $commentId = $_POST['commentId'];

    $deleteQuery = "DELETE FROM commento WHERE IdCommento = $commentId";
    
    if ($conn->query($deleteQuery) === TRUE) {
        // Eliminazione riuscita
        header("Location: {$_SERVER['HTTP_REFERER']}"); // Reindirizza l'utente alla pagina precedente
        exit();
    } else {
        // Se si verifica un errore durante l'eliminazione del commento
        echo "Errore durante l'eliminazione del commento: " . $conn->error;
    }
    
} else {
    // Se l'ID del commento non è stato ricevuto correttamente
    echo "Errore: ID del commento non ricevuto.";
}
?>
