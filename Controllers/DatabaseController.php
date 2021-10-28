<?php
    function connectDb() {
        $host = 'localhost';
        $uname = 'root';
        $pass = '';
        $db = 'pweb_bank';
        $mysqli = mysqli_connect($host, $uname, $pass, $db);

        if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit();
        }

        return $mysqli;
    }

    function closeDb($db) {
        mysqli_close($db);
    }
?>