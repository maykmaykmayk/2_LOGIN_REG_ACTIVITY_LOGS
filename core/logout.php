<?php
session_start();
unset($_SESSION['applicantID']);
header("Location: ../login.php");
?>