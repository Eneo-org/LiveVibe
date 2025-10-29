<?php
session_start();
// Elimina tutte le variabili di sessione
unset($_SESSION['user_id']);
// Reindirizza alla pagina di login o a una pagina di destinazione desiderata
header("Location: index.php");
exit;
?>
