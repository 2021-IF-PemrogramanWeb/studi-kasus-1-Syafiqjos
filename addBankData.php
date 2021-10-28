<?php

    include('./DatabaseController.php');
    include('./UserController.php');
    include('./BankController.php');

    function getSendedBankData() {
        if (isset($_POST['description']) && isset($_POST['value']) && isset($_POST['date'])) {
            if (!empty($_POST['description']) && !empty($_POST['value']) && !empty($_POST['date'])) {
                return array(
                    "status" => 0,
                    "data" => array(
                        "description" => $_POST['description'],
                        "value" => $_POST['value'],
                        "date" => $_POST['date']
                    )
                );
            }
        }

        return array(
            "status" => 1,
            "data" => null
        );
    }

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $db = connectDb();
        
        $email = $_COOKIE['email'];
        $pass = $_COOKIE['pass'];

        $login = checkLogin($db, $email, $pass);
        $status = $login['status'];
        $user = $login['data'];
        
        if ($status == 0){
            // if login
            $bankStatus = getSendedBankData();
            if ($bankStatus['status'] == 0) {
                $bankData = $bankStatus['data'];
                addBankData($db, $user['id'], $bankData);
            } else {
                // error
            }
        }

        closeDb($db);
    }

    header('Location: /dashboard-table.php');

?>