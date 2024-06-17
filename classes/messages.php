<?php
class Messages {

    private $error = "";

    public function send($data, $files) {
        if (!empty($data['message']) || !empty($files['file'])) {
            $imagePath = '';
    
            // Check if there is an uploaded file
            if (!empty($files['file']['name'])) {
                $targetDirectory = "uploads/";
                $targetFile = $targetDirectory . basename($files['file']['name']);
                
                // Move the uploaded file to the target directory
                if (move_uploaded_file($files['file']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile;
                } else {
                    $this->error .= "Failed to upload image. ";
                    return $this->error;
                }
            }
            
            $message = trim(addslashes($data['message']));
            
            if ($message == "" && $imagePath == '') {
                $this->error .= "Please type something to send!";
            }
            
            if ($this->error == "") {
                $db = new Database();
                $msgid = $this->create_message_id(60);
                $sender = addslashes($_SESSION['users_id']);
                $receiver = addslashes($_SESSION['receiver']);
    
                $query = "SELECT msgid FROM messages WHERE (sender = '$sender' AND receiver = '$receiver') OR (receiver = '$sender' AND sender = '$receiver') LIMIT 1";
                $data = $db->read($query);
    
                if (is_array($data) && !empty($data)) {
                    $msgid = $data[0]['msgid'];
                }
    
                $file = addslashes($imagePath);
                $query = "INSERT INTO messages (msgid, sender, receiver, message, file) VALUES (?, ?, ?, ?, ?)";
                
                $con = $db->connect();
                $stmt = $con->prepare($query);
                
                if ($stmt) {
                    $stmt->bind_param('sssss', $msgid, $sender, $receiver, $message, $file);
                    if (!$stmt->execute()) {
                        $this->error .= "Database error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    $this->error .= "Database error: " . $con->error;
                }
            }
        } else {
            $this->error .= "Please type something to send!";
        }
    
        return $this->error;
    }
    

    public function read($user_id){

        $db = new Database();
        $me = addslashes($_SESSION['users_id']);
        $userid= addslashes($user_id);

        $query = "SELECT * FROM messages WHERE ((sender = '$me' && receiver = '$userid') || (receiver = '$me' && sender = '$userid') && delete_sender = 0) order by id desc limit 20";
        $data = $db->read($query);

        if(is_array($data)){

            //set seen to 1
            $msgid = $data[0]['msgid'];
            $query = "update messages set seen = 1 where receiver = '$me' && msgid = '$msgid' ";
            $db->save($query);

            sort($data);
        }

        return $data;
    }

    private function create_message_id($length) {
        $array = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'), str_split('!@#$%^&*()-_=+'));
        $text = "";

        $length = rand(6, $length); // Ensure length is set correctly
        for ($i = 0; $i < $length; $i++) {
            $random = rand(0, count($array) - 1);
            $text .= $array[$random];
        }
        return $text;
    }
}
?>
