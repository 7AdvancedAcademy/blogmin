<?php
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    header("Location: /admin/login.php");
}
