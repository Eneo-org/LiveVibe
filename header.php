<html>
<head>
    <link rel='stylesheet' href='css/style.css'>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet"> <!-- per aggiungere icona ricerca-->
    
</head>
<body>
    <div class='header'>
        <div class="titolo">
            <h1><a href='index.php' >LiveVibe</a></h1>
        </div>
        
        <div class="container-4">
            <input type="search" id="search" placeholder="Search..." />
            <button class="icon"><i class="fa fa-search"></i></button>
        </div>
        
        <?php 
            session_start();
            require_once('db_conn.php');
            
            
            // Verifica se lo username è in sessione
            if (!isset($_SESSION['user_id'])) {
                
                echo "
                    <button class='button-30' role='button' onclick='redirect()'>Log In</button>
                ";
            }else{
                $utente = $_SESSION['user_id'];
                $sql = "SELECT * from utente where IdUtente = '$utente'";
                $resp = $conn->query($sql);
                $row = $resp->fetch_assoc();
                $nick = $row['username'];
                echo "
                <div class='create'>
                <button class='button-30' role='button' onclick='redirectCreate()'>Create +</button>
                <div class='logo'>
                    <img src='./assets/User.svg'>
                    <div class='dropdown-content'>
                        <form method='post' action='logOut.php'>
                            <div class='titolo'> $nick </div>
                            <button type='submit' class='submit-button'>Esci</button>
                        </form>
                    </div>
                </div>
                
                </div>
                ";
            }
        ?>
        
    </div>
    <script>
        function redirect() {
            var url = "logIn.php"; 
            window.location.href = url;
        }
        function redirectCreate() {
            var url = "addEvent.php"; 
            window.location.href = url;
        }
    </script>
</body>
</html>