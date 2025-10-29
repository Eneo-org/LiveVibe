
<html>
    <head>
    <?php
        session_start(); 
        if(!isset($_SESSION['user_id'])){
            header("Location: index.php");
            exit;    
        }

    ?>
        <?php 
        include('header.php');
        require('db_conn.php');
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
       
        function caricaSelect($conn, $tabella, $nomeId, $nomeDescrizione){
            if($tabella == 'artista'){
                $output = "<option value='9'>Nessuno</option>";
                $output .= "<option value='10'>Altro</option>";

                $sql = "SELECT * FROM $tabella WHERE $nomeId NOT IN (9, 10)";
            }else{
                $sql = "SELECT * from $tabella"; 
                $output = '';
            }
            $resp = $conn->query($sql);

            
            while ($row = $resp->fetch_assoc()) {
                $id = $row[$nomeId];
                $nome = $row[$nomeDescrizione];
                $output .= "<option value='$id' id='$id'> $nome </option> ";
            } 
            return $output;
        }
        ?>
    </head> 
    <body>
        <div class='container_bg_create'>
        <div class='container_mid_create'>
            <form action="get_new_event.php" method="POST" class="container_info_post" enctype="multipart/form-data">

                <label class="nome">Crea un nuovo evento</label>
                <input type="text" placeholder='Titolo' name='titolo' class='text' required>
                <input type="text" placeholder='luogo' name='luogo' class='text' required>
                <div class='data_container'>
                    <div class='data_row'><label>Data </label><input type="date" name='data' required class='input_date'></div>
                    <div class='data_row'><label>Ora </label><input type="time" name='ora' required class='input_date'></div>
                </div>
                <input type="file" name="fileToUpload" id="fileToUpload" required >

                <label>Categoria</label>
                <select id="cat" name="categoria" class='white text'><?php echo caricaSelect($conn, 'categoria', 'IdCategoria', 'descrizione');?></select>

                <label>Artista</label>
                <select id="artista" name='artista' class='white text'><?php echo caricaSelect($conn, 'artista', 'IdArtista', 'nomeDarte');?></select>
                

                <div id="additional-inputs" calss='contaier_info_post'>
                </div>

                <div class='container_container_date'><input type='submit' value='Invia' class='button-40' role='button'/></div>
            </form>   
        </div>
        </div>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const artistaSelect = document.getElementById('artista');
            const additionalInputsContainer = document.getElementById('additional-inputs');

            artistaSelect.addEventListener('change', function() {
                if (this.value === '10') { // Verifica se l'opzione "Altro" è selezionata
                    // Crea gli input aggiuntivi
                    additionalInputsContainer.innerHTML = `
                        <div>                            
                            <input type="text" name="nome" class='text' placeholder='Nome' required>
                        </div> <br>
                        <div>                         
                            <input type="text" name="cognome" class='text' placeholder='Cognome' required>
                        </div><br>
                        <div>
                            <input type="text" name="nomeDarte" class='text' placeholder='Nome D Arte' required>
                        </div>
                    `;
                } else {
                    // Rimuovi gli input aggiuntivi se un'altra opzione viene selezionata
                    additionalInputsContainer.innerHTML = '';
                }
            });
        });
    </script>
    </body>
    
</html>