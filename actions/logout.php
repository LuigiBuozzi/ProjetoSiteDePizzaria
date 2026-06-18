<?php
// actions/logout.php
session_start();
session_destroy(); // Destrói todas as informações da sessão
header("Location: ../index.php"); // Manda de volta para o início
exit;
?>