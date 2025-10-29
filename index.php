<html>
<head>
    <?php 
        require_once("./db_conn.php");
//         error_reporting(E_ALL);
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

    ?>


    <script src="https://kit.fontawesome.com/eafaf09e8d.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@500&display=swap" rel="stylesheet">

    <script> 

    document.addEventListener("DOMContentLoaded", function() {
        // Funzione per gestire il cambio di categoria, luogo e date
        function handleFormChange() {
            handleAjaxRequest();
        }

        // Carica tutti gli eventi al caricamento iniziale della pagina
        handleFormChange();

        // Event listeners per il cambio di categoria
        document.querySelectorAll('input[type=checkbox][name=category]').forEach(function(checkbox) {
            checkbox.addEventListener('change', handleFormChange);
        });

        // Event listener per il cambio del luogo
        document.getElementById('luogo').addEventListener('input', handleFormChange);

        // Event listener per il cambio del search
        document.getElementById('search').addEventListener('input', handleFormChange);

        // Event listener per il cambio della data di inizio
        document.getElementById('data_inizio').addEventListener('input', handleFormChange);

        // Event listener per il cambio della data di fine
        document.getElementById('data_fine').addEventListener('input', handleFormChange);
    });

    // Funzione per gestire la richiesta AJAX
    function handleAjaxRequest() {
        var selectedCategories = [];
        document.querySelectorAll('input[type=checkbox][name=category]:checked').forEach(function(checkedCheckbox) {
            selectedCategories.push(checkedCheckbox.value);
        });

        var luogo = document.getElementById('luogo').value;
        var search = document.getElementById('search').value;
        var dataInizio = document.getElementById('data_inizio').value;
        var dataFine = document.getElementById('data_fine').value;

        var xhr = new XMLHttpRequest();
        var url = 'get_events.php';
        var params = 'categories=' + encodeURIComponent(selectedCategories.join(','));
        params += '&luogo=' + encodeURIComponent(luogo);
        params += '&data_inizio=' + encodeURIComponent(dataInizio);
        params += '&data_fine=' + encodeURIComponent(dataFine);
        params += '&titolo=' + encodeURIComponent(search);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    document.getElementById('container_mid').innerHTML = xhr.responseText;
                    handleAjaxResponse(xhr.responseText);
                } else {
                    console.error('Errore durante la richiesta AJAX:', xhr.status);
                }
            }
        };

        xhr.open('GET', url + '?' + params, true);
        xhr.send();
    }



    </script>
</head>
<body>
    <?php 
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        
        include_once("header.php");

        
        $sql = "SELECT * from categoria";
        $resp = $conn->query($sql); 
    ?>
    <div class='container_bg'>
        <div class='container_categorie'>
            <div class='nome'> Filtri: </div> 
            
            <input type="text" id="luogo" placeholder="Luogo..." class='text'/>
            
            
                
            <div class='container_container_date'> 
                <div class='container_date'>Da: <input type='date'  id='data_inizio' class='input_date'/></div>
                <div class='container_date'>A: <input type='date'  id='data_fine' class='input_date'/></div>
            </div>
          
            <div class='nome'> Categorie: </div>
            <div class='elenco_categorie'>
            <?php 
            while($row = $resp->fetch_assoc()) { 
                $nome = $row['descrizione'];
                echo
                "
                <div class='checkbox-wrapper-53'>
                    <label class='container_check'> 
                        <input type='checkbox' name='category' id='$nome' value='$nome'></input>
                        <div class='checkmark'></div>
                    </label>
                    <div class='nome_check'> $nome</div>
                </div>
                
                ";
                
            }
            ?>
            </div>
        </div>
        <div id='container_mid' class='container_mid'>
        
        </div>

        
        
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="script.js"></script>

    <?php
        $conn->close();
    ?>
</body>
</html>