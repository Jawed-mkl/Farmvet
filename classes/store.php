<?php

class Store {
    private $error = "";

    public function add_product($userid, $data, $files) {
        if (!empty($data['name']) && !empty($data['price']) && !empty($data['descreption'])) {
            // Check if there is an uploaded file
            if (!empty($files['image']['name'])) {
                $targetDirectory = "uploads/";
                $targetFile = $targetDirectory . basename($files['image']['name']);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Check file size (limit to 5MB)
                if ($files['image']['size'] > 5000000) {
                    $this->error .= "Sorry, your file is too large. ";
                    return $this->error;
                }

                // Allow certain file formats
                $allowedFormats = ["jpg", "jpeg", "png", "gif"];
                if (!in_array($imageFileType, $allowedFormats)) {
                    $this->error .= "Sorry, only JPG, JPEG, PNG & GIF files are allowed. ";
                    return $this->error;
                }

                // Move the uploaded file to the target directory
                if (move_uploaded_file($files['image']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile;
                } else {
                    $this->error .= "Failed to upload image. ";
                    return $this->error;
                }
            } else {
                $imagePath = ''; // No image uploaded
            }

            $product_id = $this->create_product_id();
            $name = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
            $price = htmlspecialchars($data['price'], ENT_QUOTES, 'UTF-8');
            $descreption = htmlspecialchars($data['descreption'], ENT_QUOTES, 'UTF-8');

            $query = "INSERT INTO store (product_id, vet_id, name, price, image, descreption) VALUES ('$product_id', '$userid', '$name', '$price', '$imagePath', '$descreption')";

            $db = new Database();
            $db->save($query);
        } else {
            $this->error .= "Please fill in all the fields!";
        }

        return $this->error;
    }

    public function get_product($id){

        $query = "SELECT * FROM store order by id desc";

        $db = new Database();
        $result = $db->read($query);

        if($result){
            return $result;
        }
        else {
            return false;
        }
    }

    public function get_my_product($id){

        $query = "SELECT * FROM store WHERE vet_id = '$id' order by id desc";

        $db = new Database();
        $result = $db->read($query);

        if($result){
            return $result;
        }
        else {
            return false;
        }
    }

    private function create_product_id() {
        $length = rand(4, 19);
        $number = "";
        for ($i = 0; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number .= $new_rand;
        }
        return $number;
    }
}
?>
