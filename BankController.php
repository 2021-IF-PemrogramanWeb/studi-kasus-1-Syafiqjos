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
?>