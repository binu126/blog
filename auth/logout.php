<?php
include "../config/db.php";
session_start();
session_destroy();
header("Location: " . BASE_URL . "pages/index.php");
exit();
?>