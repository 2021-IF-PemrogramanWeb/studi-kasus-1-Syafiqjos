<?php

    include('../Controllers/DatabaseController.php');
    include('../Controllers/UserController.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $db = connectDb();
        logout($db);
    }
?>