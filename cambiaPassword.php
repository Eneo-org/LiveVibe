



<?php  

include 'db_conn.php';


//connessione db
$conn->select_db($dbname);
session_start();

if (!($_SERVER["REQUEST_METHOD"] == "POST")){
    if ($conn->connect_error) {
        echo 'Errore di connessione a MySQL: ' . $conn->connect_error;
        exit;
    }

    $ciao = $_GET['token'];
    echo "<script>console.log('codice: $ciao');</script>";

    $noToken = false;
    if(isset($_GET['token'])){
        //query

        $sql = "SELECT IdUtente FROM utente WHERE codiceUnivoco = '" . $_GET['token'] . "'";
        

        $result = $conn->query($sql);
        if ($result->num_rows > 0){
            $row = $result->fetch_array(MYSQLI_ASSOC);

            //se il link ha funzionato bisogna caricare la pagina e permettere di cambiare la password
            include('cambiaPasswordPerDavvero.php');

            $_SESSION['user_id'] = $row['IdUtente'];
        }else{
            $noToken = true;
        } 
    }else{
        $noToken = true;
    }

}else{

    $passPOST = $_POST['password'];
    
    $user_id = $_SESSION['user_id'];
    
    //cambiamento password
    echo "<script>console.log('$passPOST - $user_id');</script>";

    $sql = "UPDATE utente SET password = '" . $passPOST . "' WHERE IdUtente = '" . $user_id  . "'";
    $conn->query($sql);
    //eliminazione del codice temporaneo
    $sql = "UPDATE utente SET codiceUnivoco = '' WHERE IdUtente = '" . $user_id  . "'";
    $conn->query($sql); 
    echo "<script>
        alert('Password modificata con successo');
        window.location.href = 'logIn.php';
    </script>";  
    $noToken = false;
}

if($noToken){
    echo '<h1>sessione scaduta, richiedere un altro link.</h1>';
} 
?>