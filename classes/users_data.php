<?php

class users_data {

    public function get_farmer_data($id) {

        $query = "SELECT * from farmer where user_id = '$id' limit 1";

        $db = new Database();
        $result = $db->read($query);

        if($result){

            $row = $result[0];
            return $row;
        }
        else{

            return false;
        }
    }


    public function get_vet_data($id) {

        $query = "SELECT * from veterinary where user_id = '$id' limit 1";

        $db = new Database();
        $result = $db->read($query);

        if($result){

            $row = $result[0];
            return $row;
        }
        else{

            return false;
        }
    }

    public function get_info_post($id){

        $qeury = "SELECT * FROM users WHERE user_id = '$id' limit 1";
        $db = new Database();
        $result = $db->read($qeury);

        if($result){
            return $result[0];
        }
        else {
            return false;
        }
    }

    public function get_vet($id) {

        $query = "SELECT * from veterinary order by id";

        $db = new Database();
        $result = $db->read($query);

        if($result){
 
            return $result;
        }
        else{

            return false;
        }
    }

    public function get_farmer($id) {

        $query = "SELECT * from farmer order by id";

        $db = new Database();
        $result = $db->read($query);

        if($result){
 
            return $result;
        }
        else{

            return false;
        }
    }

}

?>