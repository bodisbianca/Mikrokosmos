<?php
session_start();
unset($_SESSION['loggedin']);
header('Location: ../magazin/magazin_index.php');
?>