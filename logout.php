<?php
session_start();
session_destroy();
header("Location: http://localhost/tugas7_pemweb/login.php");
exit;
?>
