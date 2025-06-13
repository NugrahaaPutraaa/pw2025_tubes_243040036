<?php
// Memulai sesi PHP
session_start();

// Mengecek apakah pengguna sudah login, jika tidak maka redirect ke halaman login
if ($_SESSION['login'] == false) {
    header('location:login.php');
}
