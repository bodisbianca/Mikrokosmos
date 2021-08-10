<?php
session_start();
unset($_SESSION['adminlogged']);
header('Location: ../admin/autentificare-admin.php');
?>