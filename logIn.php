<html> 
<link rel='stylesheet' href='css/login.css'>
<head>

</head>
<?php include 'db_conn.php';
  session_start();
  ?>

<body>


<div  class='container'>
    <form action='logIn.php' method='POST' class='box'>
        <div> Username: <br><input type='text' name='username' required> </div>
        <div> Email: <br><input type='email' name='email' required> </div>
        <div> Password: <br><input type='password' name='password' required> </div>
        <input type='submit' value='Login'></input>
        
        <label> Non hai un account?</label> <label> <a href='register.php'> Registrati </a></label> <br>
        <a href='richiediPSW.php' target='_blank'> Hai dimenticato la password? </a>
        
    </form>
    

<?php
if($_POST){
    $userPOST = $conn -> real_escape_string($_POST['username']);
    $emailPOST = $conn -> real_escape_string($_POST['email']);
    $passPOST = $conn -> real_escape_string($_POST['password']);

    $conn->select_db($dbname);
    
    if ($conn->connect_error) {
        echo 'Errore di connessione a MySQL: ' . $conn->connect_error;
        exit;
    }
    
    $sql = "SELECT IdUtente, username, password FROM utente WHERE username = '$userPOST' AND email = '$emailPOST'";
    $result = $conn->query($sql);
    $accesso = false;

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];
        
        if (password_verify($passPOST, $hashedPassword)) {
            $accesso = true;
            // Memorizza l'ID dell'utente nella sessione
            $_SESSION['user_id'] = $row['IdUtente'];
        }
    }
    
    if ($accesso) {
        header("Location: index.php");
        exit();
    } else {
        echo '<label class="error-message">Email o password errati</label>';
    }
}


?>

</div>

</body>
</html>
