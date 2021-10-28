<?php
    function checkLogin($db, $email, $password) {
        if ($res = $db->query("select * from users where email = \"$email\";")) {
            if ($res->num_rows == 1) {
                // exist
                $row = $res->fetch_row();
                if ($row[2] == $password) {
                    // password same
                    return array(
                        "status" => 0,
                        "data" => array(
                            "id" => $row[0],
                            "email" => $row[1],
                            "password" => $row[2]
                        )
                    );
                } else {
                    return array(
                        "status" => 2,
                        "data" => null
                    );
                }
            }

            $res->free_result();
            
            return array(
                "status" => 1,
                "data" => null
            );
        }

        return array(
            "status" => -1,
            "data" => null
        );
    }

    function logout($db) {
        setcookie('email', null);
        setcookie('pass', null);

        header('Location: /');
    }
?>