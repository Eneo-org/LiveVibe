<html> 

<head>
    <link rel='stylesheet' href='css/login.css'>

</head>
<?php include 'db_conn.php';
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php'; 
?>

<body>
<div  class='container'>
<form action='richiediPSW.php' method='POST' class='box'>
    <h1> Richiedi email </h1>
    <div> Username: <br><input type='text' name='username' required> </div>
    <div> Email: <br><input type='email' name='email' required> </div>

    <input type='submit' value='invia'></input>
</form>
<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if($_POST){
    $flag = false;
    $userPOST = $_POST['username'];
    $emailPOST = $_POST['email'];
    //connessione db
    $conn = new mysqli($hostname, $username, $password);
    $conn->select_db($dbname);
    
    if ($conn->connect_error) {
        echo 'Errore di connessione a MySQL: ' . $conn->connect_error;
        exit;
    }
    
    //query
    $sql = "SELECT username FROM utente where username = '$userPOST' AND email='$emailPOST'";

    //controllo esistenza utente
    $result = $conn->query($sql);

    if ($result->num_rows > 0) { 
        $flag = true;
    }
    
    if($flag == false){
        echo '<label class="error-message"> email o password errati</label>';
        exit;
    }else{ 
        //creazione token temporaneo 
        include 'phpKey.php';
        $token = md5($userPOST);

        session_start();
        // Memorizza l'ID dell'utente nella sessione
        $_SESSION['user_id'] = $userPOST;

        //inserimento nel db del codice univoco
        $sql = "UPDATE utente SET codiceUnivoco = '$token' WHERE username = '$userPOST'";

        $conn->query($sql);

        // link da inviare
        $link = 'http://localhost/gestioneEventi/cambiaPassword.php?token='.$token;
        $messaggio = '<a href = '.$link.'>Clicca qui</a> per cambiare la password.';
        
        //invio mail
        
        $mail = new PHPMailer(true);
        $mail -> isSMTP();

        $mail -> Host = 'smtp.gmail.com';
        $mail -> SMTPAuth = true;
        $mail -> Username = '@gmail.com'; //insert your mail
        $mail -> Password = $phpMailerKey; //password email 
        $mail -> Port = 587;
    
        $mail -> setFrom('@gmail.com'); //insert your mail
        $mail->addReplyTo('@gmail.com'); //insert your mail
        $mail -> addAddress($emailPOST); //da completare con email inserita dall'utente
   
        $mail -> isHTML(true); 
    
        $mail -> Subject = 'Resetta password';//da completare con l'intestazione 
        $mail -> Body = $messaggio; //da completare con il messaggio
 
        if($mail->send()) {
            echo 'Email inviata con successo. Controlla la tua casella di posta.';
        } else {
            echo 'Si è verificato un errore durante l\'invio dell\'email.';
        } 
    }

}
?>
</div>
</body>
</html>
