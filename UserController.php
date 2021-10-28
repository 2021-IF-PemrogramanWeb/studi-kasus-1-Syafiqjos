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

    function checkLogin($db, $email, $password) {
        if ($res = $db->query("select * from users where email = \"$email\";")) {
            if ($res->num_rows == 1) {
                // exist
                $row = $res->fetch_row();
                if ($row[2] == $password) {
                    // password same
                    return 0;
                } else {
                    return 2;
                }
            }

            $res->free_result();
            
            return 1;
        }

        return -1;
    }
?>