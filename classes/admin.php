<?php

class admin {
    private $error= "";

    public function create_publication($userid, $data, $file){
        // Validate text and file input
        if(!empty($data['texte']) || !empty($file['image']['name'])) {
            // Initialize image path
            $imagePath = null;

            // Check if an image file is uploaded
            if (!empty($file['image']['name'])) {
                $targetDirectory = "uploads/";
                
                // Ensure directory exists and is writable
                if (!is_dir($targetDirectory)) {
                    mkdir($targetDirectory, 0777, true);
                }

                $targetFile = $targetDirectory . basename($file['image']['name']);
                $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                // Validate file type (only allow certain formats)
                $validTypes = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($imageFileType, $validTypes)) {
                    $this->error .= "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed. ";
                    return $this->error;
                }

                // Check file size (example: limit to 5MB)
                if ($file['image']['size'] > 5000000) {
                    $this->error .= "File size is too large. ";
                    return $this->error;
                }

                // Move the uploaded file to the target directory
                if (move_uploaded_file($file['image']['tmp_name'], $targetFile)) {
                    $imagePath = $targetFile;
                } else {
                    $this->error .= "Failed to upload image. ";
                    return $this->error;
                }
            }

            // Escape input to prevent SQL injection
            $texte = addslashes($data['texte']);
            $title = addslashes($data['title']);
            $publicationid = $this->create_publicationid();

            // Insert into the database, handle null image path
            $imagePathSQL = $imagePath ? "'$imagePath'" : "NULL";
            $query = "INSERT INTO publication (publication_id, admin_id, texte, title, image) VALUES ('$publicationid', '$userid', '$texte', '$title', $imagePathSQL)";

            // Assuming Database class and save method exist and work properly
            $db = new Database();
            if (!$db->save($query)) {
                $this->error .= "Failed to save publication to the database. ";
                return $this->error;
            }

        } else {
            $this->error .= "Please provide text and/or an image to post!";
        }

        return $this->error;
    }

    public function get_pubs($id){

        $query = "SELECT * FROM publication order by id desc";

        $db = new Database();
        $result = $db->read($query);

        if($result){
            return $result;
        }
        else {
            return false;
        }
    }

    public function get_admin_pub($id){

        $query = "SELECT * FROM publication WHERE admin_id = '$id' order by id desc";

        $db = new Database();
        $result = $db->read($query);

        if($result){
            return $result;
        }
        else {
            return false;
        }
    }


    // Generate a unique publication ID
    private function create_publicationid(){
        $length = rand(4, 19);
        $number = "";
        for ($i = 0; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number .= $new_rand;
        }
        return $number;
    }

    function farmer_number() {
        // Create an instance of the Database class
        $db = new Database();
    
        // SQL query to count the number of rows in the farmer table
        $query = "SELECT COUNT(*) AS farmer_count FROM farmer";
    
        // Execute the query using the read method
        $result = $db->read($query);
    
        // Check if the query was successful and fetch the count
        if ($result && isset($result[0]['farmer_count'])) {
            echo "Total number of farmers: " . $result[0]['farmer_count'];
        } else {
            echo "Error retrieving farmer count.";
        }
    }

    function vet_number() {
        // Create an instance of the Database class
        $db = new Database();
    
        // SQL query to count the number of rows in the farmer table
        $query = "SELECT COUNT(*) AS vet_count FROM veterinary";
    
        // Execute the query using the read method
        $result = $db->read($query);
    
        // Check if the query was successful and fetch the count
        if ($result && isset($result[0]['vet_count'])) {
            echo "Total number of veterinary: " . $result[0]['vet_count'];
        } else {
            echo "Error retrieving vet count.";
        }
    }

    public function count_publications($user_id) {
        $db = new Database();
        $query = "SELECT COUNT(*) AS publication_count FROM publication WHERE admin_id = '$user_id'";
        $result = $db->read($query);

        if ($result && isset($result[0]['publication_count'])) {
            return $result[0]['publication_count'];
        } else {
            return 0;
        }
    }
}
