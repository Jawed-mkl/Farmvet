<?php

class Signup {

    private $error = "";

    public function evaluate($data){
        foreach ($data as $key => $value){
            if(empty($value)){
                $this->error .= $key . " is empty!<br>";
            }

            if($key == "mail"){
                if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value)) {
                    $this->error = $this->error . "Invalid email address!<br>";
                } else if (!$this->isEmailUnique($value)) {
                    $this->error = $this->error . "Email address already exists!<br>";
                }
            }

            if($key == "firstn" || strstr($value, " ")){
                if(is_numeric($value)) {
                    $this->error = $this->error . "First name can't be a number or have space<br>";
                }
            }

            if($key == "lastn" || strstr($value, " ")){
                if(is_numeric($value)) {
                    $this->error = $this->error . "Last name can't be a number or have space<br>";
                }
            }
        }

        if($this->error == ""){
            $this->create_users($data);
        }
        else {
            return $this->error;
        }
    }

    public function create_users($data){
        $firstn = ucfirst($data['firstn']);
        $lastn = ucfirst($data['lastn']);
        $mail = $data['mail'];
        $password = $data['password'];
        $password = hash("sha1", $password);
        $type = $data['type'];

        $url_address = strtolower($firstn) . "." . strtolower($lastn); 
        $userid = $this->create_userid();

        $query = "INSERT INTO users 
        (user_id, firstn, lastn, mail, password, type, url_address) 
        VALUES ('$userid', '$firstn', '$lastn', '$mail', '$password', '$type', '$url_address')";

        $db = new Database();
        $db->save($query);

        // Insert into farmer or veterinary table based on user type
        if($type == "farmer"){
            $queryFarmer = "INSERT INTO farmer 
            (user_id, firstn, lastn, mail, password, url_address) 
            VALUES ('$userid', '$firstn', '$lastn', '$mail', '$password', '$url_address')";
            $db->save($queryFarmer);
        }
        elseif($type == "veterinary"){
            $queryVeterinary = "INSERT INTO veterinary 
            (user_id, firstn, lastn, mail, password, url_address) 
            VALUES ('$userid', '$firstn', '$lastn', '$mail', '$password', '$url_address')";
            
            $db->save($queryVeterinary);
        }
    }

    private function isEmailUnique($email) {
        $db = new Database();
        $conn = $db->connect();
        
        $sql = "SELECT COUNT(*) AS count FROM users WHERE mail = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            return $row['count'] == 0; // If count is 0, the email is unique
        } else {
            // Handle database query error
            return false;
        }
    }

    private function create_userid(){
        $length = rand(4, 19);
        $number = "";
        for ($i=0; $i < $length; $i++){
            $new_rand = rand(0, 9);
            $number .= $new_rand;
        }
        return $number;
    }
}
?>
