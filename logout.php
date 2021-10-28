<?php

    include('./DatabaseController.php');
    include('./UserController.php');

    $db = connectDb();
    logout($db);

?>