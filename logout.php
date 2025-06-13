<?php
session_start();
session_unset();
session_destroy();
header("Location: login.php"); // kembali ke login (karena login.php ada di root)
exit;
