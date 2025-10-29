<html> 
<link rel='stylesheet' href='css/login.css'>
<head>

</head>
<?php require 'db_conn.php';?>

<body>
<div class='container'>
<form action='register.php' method='POST' class='box'>
    <h1> REGISTRAZIONE </h1>
    <div> Nome: <br><input type='text' name='nome' required> </div>
    <div> Cognome: <br><input type='text' name='cognome' required> </div>
    <div> Username: <br><input type='text' name='username' required> </div>
    <div> Email: <br><input type='email' name='email' required> </div>
    <div> Password: <br><input type='password' name='password' required> </div> 
    <input type='submit' value='REGISTRATI'>

    <label> <a href='logIn.php'> Log in </a></label>
</form>

<?php
    if($_POST){
        $flag = true;
        $nomePOST =  $_POST['nome'];
        $cognomePOST =  $_POST['cognome'];
        $userPOST = $_POST['username'];
        $emailPOST =  $_POST['email'];
        $passTemp = $_POST['password'];
        $passPOST = password_hash($passTemp, PASSWORD_DEFAULT);
        // echo "<script>console.log('$dbname - $nomePOST - $cognomePOST - $userPOST - $emailPOST - $passPOST');</script>";
        $conn->select_db($dbname);

        if ($conn->connect_error) {
            echo 'Errore di connessione a MySQL: ' . $conn->connect_error;
            exit;
        }
        
        //controllo esistenza utente
        $sql = 'SELECT username FROM utente';
        
        $result = $conn->query($sql);
     
        if ($result->num_rows > 0) { 
            $flag = true;
            while(($row = $result->fetch_array(MYSQLI_ASSOC)) && $flag == true){
                if($row['username'] == $userPOST){
                    $flag = false;
                }
            } 
        }else{
            $flag = true;
        }
        
        if($flag == true){
            //salvataggio dati in database
            $sql = "INSERT INTO utente (username, nome, cognome, email, password)
            VALUES ('$userPOST', '$nomePOST', '$cognomePOST', '$emailPOST', '$passPOST')";

            $result = $conn->query($sql);
           
            echo '<label class="correct-message"> REGISTRAZIONE EFFETTUATA </label>';
        }else{
            echo "<div class='error-message'> l'utente è gia stato registrato </div>";
        }
        $conn->close();
    }
?>
</div>
</body>
</html>
