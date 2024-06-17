<?php

class login{

    private $error = "";

    public function evaluate($data){
        
        //addslashes is for sucerete
        $mail = addslashes($data['mail']);
        $password = addslashes($data['password']);

        $query = "select * from users where mail = '$mail' limit 1";

        $db = new Database();
        $result = $db->read($query);
        if($result){
            $row = $result[0];

            if($this->hash_text($password) == $row['password']){
                
                $_SESSION['users_id'] = $row['user_id'];
            }
            else {
                $this->error .= "wrong password<br>";
            }
        }
        else {
            $this->error .= "No such email was found<br>";
        }
        return $this->error;

    }

    private function hash_text($text){

		$text = hash("sha1", $text);
		return $text;
	}

    public function check_login($id){
        $query = "SELECT user_id, type FROM users WHERE user_id = '$id' LIMIT 1";

        $db = new Database();
        $result = $db->read($query);
        
        if ($result === false) {
            // Return an error message or log the error
            return ['error' => 'Error executing the SQL query'];
        }

        if (empty($result)) {
            // Return an error message or log the error
            return ['error' => 'User not found in the database'];
        }

        return $result[0];
    }


}
?>
