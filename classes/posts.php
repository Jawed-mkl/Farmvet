<?php
  
class Posts {
    private $error= "";

    public function create_post($userid, $data, $files) {
        if(!empty($data['post'])) {
            // Check if there is an uploaded file
            if (!empty($files['image']['name'])) {
                $targetDirectory = "uploads/";
                $targetFile = $targetDirectory . basename($files['image']['name']);
                
                // Move the uploaded file to the target directory
                if (move_uploaded_file($files['image']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile;
                    $hasImage = 1;
                } else {
                    $this->error .= "Failed to upload image. ";
                    return $this->error;
                }
            } else {
                $imagePath = ''; // No image uploaded
            }
    
            $post = addslashes($data['post']);
            $postid = $this->create_postid();
            $parent = 0;

            if(isset($data['parent']) && is_numeric($data['parent'])){
                $parent = $data['parent'];
            }
    
            $query = "INSERT INTO posts (post_id, user_id, post, image, has_image, parent) VALUES ('$postid', '$userid', '$post', '$imagePath', '$hasImage', '$parent')";
    
            $db = new Database();
            $db->save($query);
        }
        else {
            $this->error .= "Please type something to post!";
        }
    
        return $this->error;
    }

    public function edit_post($data, $files) {
        if (!empty($data['post'])) {
            $hasImage = 0;
            $imagePath = "";

            // Check if there is an uploaded file
            if (!empty($files['file']['name'])) {
                $targetDirectory = "uploads/";
                $targetFile = $targetDirectory . basename($files['file']['name']);
                
                // Move the uploaded file to the target directory
                if (move_uploaded_file($files['file']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile;
                    $hasImage = 1;
                } else {
                    $this->error .= "Failed to upload image. ";
                    return $this->error;
                }
            }
    
            $post = addslashes($data['post']);
            $postid = addslashes($data['post_id']);
            
            // Update query based on whether an image is uploaded
            if ($hasImage) {
                $query = "UPDATE posts SET post = '$post', image = '$imagePath' WHERE post_id = '$postid' LIMIT 1";
            } else {
                $query = "UPDATE posts SET post = '$post' WHERE post_id = '$postid' LIMIT 1";
            }
    
            $db = new Database();
            $db->save($query);
        } else {
            $this->error .= "Please type something to post!";
        }
    
        return $this->error;
    }

    public function get_posts($id){

        $query = "SELECT * FROM posts WHERE parent = 0  order by id desc";

        $db = new Database();
        $result = $db->read($query);

        if($result){
            return $result;
        }
        else {
            return false;
        }
    }

    public function get_comment($id){

        $query = "SELECT * FROM posts WHERE parent = '$id' order by id asc";

        $db = new Database();
        $result = $db->read($query);

        if($result){
            return $result;
        }
        else {
            return false;
        }
    }

    public function get_posts_user($id){

        $query = "SELECT * FROM posts WHERE user_id = '$id' AND parent = 0 order by id desc";

        $db = new Database();
        $result = $db->read($query);

        if($result){
            return $result;
        }
        else {
            return false;
        }
    }

    public function get_one_post($postid){

        if(!is_numeric($postid)){
            return false;
        }
        $query = "SELECT * FROM posts WHERE post_id = '$postid' limit 1";

        $db = new Database();
        $result = $db->read($query);

        if($result){
            return $result[0];
        }
        else{
            return false;
        }

    }

    public function delete_post($postid){

        $query = "DELETE FROM posts WHERE post_id = '$postid' limit 1";

        $db = new Database();
        $db->save($query);

    }

    public function like_post($id, $type, $users_id){
        if ($type === "post") {
            $db = new Database();

            // Fetch the current likes
            $likes = $this->get_likes($db, $id, $type);

            if ($likes) {
                $likes_array = json_decode($likes, true);
                $user_ids = array_column($likes_array, "user_id");

                if (!in_array($users_id, $user_ids)) {
                    // Add like
                    $this->add_like($db, $id, $users_id, $likes_array, $type);
                } else {
                    // Remove like
                    $this->remove_like($db, $id, $users_id, $likes_array, $type);
                }
            } else {
                // No likes yet, create new like entry
                $this->create_like($db, $id, $users_id, $type);
            }
        }
    }

    private function get_likes($db, $id, $type){
        $sql = "SELECT likes FROM likes WHERE type = '$type' AND contentid = '$id' LIMIT 1";
        $result = $db->read($sql);
        return is_array($result) ? $result[0]['likes'] : null;
    }

    private function add_like($db, $id, $users_id, &$likes_array, $type){
        $likes_array[] = [
            "user_id" => $users_id,
            "date" => date("Y-m-d H:i:s")
        ];

        $this->update_likes($db, $id, $likes_array, $type);
        $this->increment_post_likes($db, $id);
    }

    private function remove_like($db, $id, $users_id, &$likes_array, $type){
        $key = array_search($users_id, array_column($likes_array, "user_id"));
        unset($likes_array[$key]);

        $this->update_likes($db, $id, $likes_array, $type);
        $this->decrement_post_likes($db, $id);
    }

    private function create_like($db, $id, $users_id, $type){
        $likes_array = [[
            "user_id" => $users_id,
            "date" => date("Y-m-d H:i:s")
        ]];

        $likes = json_encode($likes_array);
        $sql = "INSERT INTO likes (type, contentid, likes) VALUES ('$type', '$id', '$likes')";
        $db->save($sql);

        $this->increment_post_likes($db, $id);
    }

    private function update_likes($db, $id, $likes_array, $type){
        $likes_string = json_encode($likes_array);
        $sql = "UPDATE likes SET likes = '$likes_string' WHERE type = '$type' AND contentid = '$id' LIMIT 1";
        $db->save($sql);
    }

    private function increment_post_likes($db, $id){
        $sql = "UPDATE posts SET likes = likes + 1 WHERE post_id = '$id' LIMIT 1";
        $db->save($sql);
    }

    private function decrement_post_likes($db, $id){
        $sql = "UPDATE posts SET likes = likes - 1 WHERE post_id = '$id' LIMIT 1";
        $db->save($sql);
    }


    private function create_postid(){
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