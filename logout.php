<?php

    include('./DatabaseController.php');
    include('./UserController.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $db = connectDb();
        logout($db);
    }
?>