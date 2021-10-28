<?php

    function getBankData($db, $userId) {
        if ($res = $db->query("select * from banks where user_id = $userId order by date;")) {
            $data = array();
            while($row = mysqli_fetch_assoc($res)) {
                array_push($data, $row);
            }

            return $data;
        }

        return null;
    }

    function addBankData($db, $user_id, $data){
        $desc = $data['description'];
        $val = $data['value'];
        $date = $data['date'];

        $res = $db->query("INSERT INTO banks(user_id, description, value, date) VALUES ('$user_id','$desc','$val','$date')");
    }

    function deleteBankData($db, $user_id, $data) {
        $id = $data['id'];

        $res = $db->query("DELETE FROM banks WHERE user_id = $user_id AND id = $id;");
    }
?>