<?php

    function getBankData($db, $userId) {
        $userId = $db->real_escape_string($userId);
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
        $user_id = $db->real_escape_string($user_id);
        $desc = $db->real_escape_string($data['description']);
        $val = $db->real_escape_string($data['value']);
        $date = $db->real_escape_string($data['date']);

        $res = $db->query("INSERT INTO banks(user_id, description, value, date) VALUES ('$user_id','$desc','$val','$date');");
    }

    function deleteBankData($db, $user_id, $data) {
        $user_id = $db->real_escape_string($user_id);
        $id = $db->real_escape_string($data['id']);

        $res = $db->query("DELETE FROM banks WHERE user_id = $user_id AND id = $id;");
    }
?>