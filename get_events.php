<?php

require_once("./db_conn.php");
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_GET['categories']) && !empty($_GET['categories'])) {

    $selectedCategories = explode(',', $_GET['categories']); //trasforma la stringa nel get in un array tramite il divisore ','
    $categoryConditions = '';
    foreach ($selectedCategories as $category) { //crea il where della qery
        $categoryConditions .= ($categoryConditions == '') ? "categoria.descrizione = '$category'" : " OR categoria.descrizione = '$category'";
    }
    $sql = "SELECT evento.*, categoria.descrizione, artista.nomeDarte, utente.username, 
                   DATE_FORMAT(evento.data, '%d-%m-%Y') AS data_formattata 
            FROM evento 
            JOIN categoria ON evento.IdCategoria = categoria.IdCategoria 
            JOIN artista ON evento.IdArtista = artista.IdArtista 
            JOIN utente ON evento.IdUtente = utente.IdUtente 
            WHERE $categoryConditions";
} else {
    // Se non sono state selezionate categorie, seleziona tutti gli eventi
    $sql = "SELECT evento.*, categoria.descrizione, artista.nomeDarte, utente.username, 
                   DATE_FORMAT(evento.data, '%d-%m-%Y') AS data_formattata 
            FROM evento 
            JOIN categoria ON evento.IdCategoria = categoria.IdCategoria 
            JOIN artista ON evento.IdArtista = artista.IdArtista 
            JOIN utente ON evento.IdUtente = utente.IdUtente";
}

// Verifica se è stato specificato un luogo
if (isset($_GET['luogo']) && !empty($_GET['luogo'])) {
    $luogo = $_GET['luogo'];
    if (strpos($sql, 'WHERE') === false) {
        $sql .= " WHERE luogo LIKE '%$luogo%'"; // Se non ci sono condizioni prima, aggiungi WHERE
    } else {
        $sql .= " AND luogo LIKE '%$luogo%'"; // Altrimenti aggiungi AND
    }
}

//titolo
if (isset($_GET['titolo']) && !empty($_GET['titolo'])) {
    $titolo = $_GET['titolo'];
    if (strpos($sql, 'WHERE') === false) {
        $sql .= " WHERE titolo LIKE '$titolo%'"; // Se non ci sono condizioni prima, aggiungi WHERE
    } else {
        $sql .= " AND titolo LIKE '$titolo%'"; // Altrimenti aggiungi AND
    }
}

// Verifica se sono state specificate le date di inizio e fine
if (isset($_GET['data_inizio']) && !empty($_GET['data_inizio']) && isset($_GET['data_fine']) && !empty($_GET['data_fine'])) {
    $dataInizio = $_GET['data_inizio'];
    $dataFine = $_GET['data_fine'];
    if (strpos($sql, 'WHERE') === false) {
        $sql .= " WHERE data BETWEEN '$dataInizio' AND '$dataFine'"; // Se non ci sono condizioni prima, aggiungi WHERE
    } else {
        $sql .= " AND data BETWEEN '$dataInizio' AND '$dataFine'"; // Altrimenti aggiungi AND
    }
}
$resp = $conn->query($sql);

//output
$output = '';
if ($resp === false) {
    // Gestione degli errori della query
    $output = "Errore nella query: " . $conn->error;
} elseif ($resp->num_rows === 0) {
    $output = "
    <div class='container_post'>        
        <div class='container_error_cat'>
            <div class='nome'> Non sono presenti eventi per le categorie selezionate </div>
        </div>
    </div>
    ";
}else{
    // Ciclo per generare gli eventi
    while ($row = $resp->fetch_assoc()) {
        $eventId = $row['IdEvento'];  // ID unico dell'evento
        $img = $row['immagine'];
        $titolo = $row['titolo'];
        $data = $row['data_formattata'];
        $ora = $row['ora'];
        $luogo = $row['luogo'];
        $categoria = $row['descrizione'];
        $artista = $row['nomeDarte'];
        $username = $row['username'];
        // Usa un nome unico per i radio button basato sull'ID dell'evento
        $radioName = "c4l-rating-$eventId";
        $output .= "
            <div class='container_all'>
                <div class='container_post' id='commentIcon' data-event-id='$eventId'>
                    <div class='container_img'>
                        <img src='./assets/img/$img' class='event_img'> 
                    </div>
                    <div class='container_info_post'>
                        <div class='nome'>$titolo</div>
                        <div class='posizione'>$luogo</div>
                        <div class='quando'>$data - $ora</div>
                        <div class='quando'>$categoria</div>
                        <div class='quando'>$artista</div>
                        <div class='quando'>Creato da: $username</div>
                    </div>

                    <div class='container_icons'>
                        <div class='comment'>
                            <img src='./assets/Chat.svg'>
                        </div>
                    </div>

                    <div class='container_comment'>
                        <div class='info_comments'>
                            <div class='container_arrow' id='arrow'>
                                <img src='./assets/Arrow_alt_left.svg'>
                            </div>

                            <div class='input_comment'>
                                <div class='nome'>$titolo</div> ";
                            if(!isset($_SESSION['user_id'])){
                                $output .="<div class='form_comment'> effettua il logIn per inserire un commento </div>";
                            }else{
                            $output .="   <form class='form_comment' action='get_comment.php' method='POST'>
                                    <input type='hidden' name='evento_id' value='$eventId' />
                                    <div class='c4l-rating'>
                                        <input name='$radioName' type='radio' id='c4l-rate-$eventId-1' value='1' checked />
                                        <label for='c4l-rate-$eventId-1'></label>

                                        <input name='$radioName' type='radio' id='c4l-rate-$eventId-2' value='2' />
                                        <label for='c4l-rate-$eventId-2'></label>

                                        <input name='$radioName' type='radio' id='c4l-rate-$eventId-3' value='3' />
                                        <label for='c4l-rate-$eventId-3'></label>

                                        <input name='$radioName' type='radio' id='c4l-rate-$eventId-4' value='4' />
                                        <label for='c4l-rate-$eventId-4'></label>

                                        <input name='$radioName' type='radio' id='c4l-rate-$eventId-5' value='5' />
                                        <label for='c4l-rate-$eventId-5'></label>
                                    </div>

                                    <div>
                                        <input type='text' name='testo' class='input-styled' placeholder='Scrivi un commento...'></input>
                                    </div>
                                    <div class='invio'>
                                        <input type='submit' value='post' class='submit-button'/>
                                    </div>
                                </form>";
                            }
                         $output .="   </div>

                            <div class='all_comments'>
                                <!-- Altri commenti -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ";
    }
}
echo $output;

$conn->close();
?>
