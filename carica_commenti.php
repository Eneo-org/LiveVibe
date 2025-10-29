<?php
session_start();
require_once("./db_conn.php");
include("admin.php");

if (isset($_GET['eventId'])) {
    $eventId = $_GET['eventId'];

    $commentsQuery = "SELECT utente.username, commento.descrizione, commento.voto, commento.IdCommento
                      FROM commento 
                      JOIN utente ON commento.IdUtente = utente.IdUtente 
                      WHERE commento.IdEvento = $eventId";
    $commentsResult = $conn->query($commentsQuery);

    if ($commentsResult->num_rows > 0) {
        $commentsOutput = '';
        while ($commentRow = $commentsResult->fetch_assoc()) {
            $commentUsername = $commentRow['username'];
            $commentDescription = $commentRow['descrizione'];
            $commentId = $commentRow['IdCommento']; 
            $voto = $commentRow['voto'];
            $radioButtons ='';
            $radioButtons .= "<div class='c4l-rating'>";  

            $uniqueId = uniqid();  // Genera un identificatore unico

            $radioButtons = "<div class='c4l-rating'>";  

            for ($i = 1; $i <= 5; $i++) {
                $checked = ($i == $voto) ? 'checked' : '';  

                $radioButtons .= "
                    <input name='c4l-rating-$uniqueId' type='radio' value='$i' disabled $checked />
                    <label></label>
                ";
            }

            $radioButtons .= "</div>"; 


            // Se l'utente è l'amministratore, mostra il pulsante per eliminare il commento
            if ($_SESSION['user_id'] == $adminId) {
                $deleteButton = "
                <form action='delete_comment.php' method='POST'>
                    <input type='hidden' name='commentId' value='$commentId'>
                    <input type='submit' value='Elimina'>
                </form>";
            } else {
                $deleteButton = ""; // Se non è l'amministratore, non mostrare alcun pulsante
            }


            $commentsOutput .= "
            <div class='single_comment'>
            <strong>$commentUsername:</strong> 
            $radioButtons
            <div class='testo_commento'>$commentDescription </div>
            <div class='testo_commento'>$deleteButton </div>
            </div>";
        }
        echo $commentsOutput;
        
    } else {
        echo "<div class='single_comment'>Nessun commento disponibile per questo evento.</div>";
    }
} else {
    echo "Errore: ID evento non specificato.";
}
?>
