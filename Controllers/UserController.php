<?php
    function checkLogin($db, $email, $password) {
        $password = md5($password);
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

    function tryRegister($db, $email, $password, $password_conf) {
        $password = md5($password);
        $password_conf = md5($password_conf);
        if ($res = $db->query("select * from users where email = \"$email\";")) {
            if ($res->num_rows == 1) {
                // email exist then error
                $row = $res->fetch_row();
                return array(
                    "status" => 1,
                    "data" => null
                );
            } else {
                if ($password == $password_conf) {
                    // password conf same
                    $res = $db->query("INSERT into users (email, password) values ('$email', '$password');");
                    return array(
                        "status" => 0,
                        "data" => null
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
        setcookie('email', '', 1, '/');
        setcookie('pass', '', 1, '/');

        header('Location: /');
    }
?>