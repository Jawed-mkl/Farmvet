<?php
session_start();
include("classes/connect.php");
include("classes/log-in.php");
include("classes/users_data.php");
include("classes/posts.php");

// Check if the user is logged in
if (isset($_SESSION['users_id']) && is_numeric($_SESSION['users_id'])) {

    $id = $_SESSION['users_id'];
    $login = new login();
    $result = $login->check_login($id);

    if (is_array($result) && array_key_exists('error', $result)) {
        // Handle the error case
        echo "Error: " . $result['error'];
    } elseif ($result) {
        $type = $result['type'];

        // Redirect based on user type
        if ($type === 'farmer') {
            $users = new users_data();
            $users_d = $users -> get_farmer_data($id);

            if(isset($_GET['postid'])) {

                $postid = $_GET['postid'];
                $posts = new Posts();
                $posts->delete_post($postid);
            
                $_SESSION['message'] = 'Delete Post Successful';
                header("location: farmerProfile.php");
                exit;
            } else {
            
                
                header("location: farmerProfile.php");
                exit;
            }

            if(!$users_d){
                header("Location: log-in.php");
                die;
            }

            
        } elseif ($type === 'veterinary') {

            $users = new users_data();
            $users_d = $users -> get_vet_data($id);
            if(isset($_GET['postid'])) {

                $postid = $_GET['postid'];
                $posts = new Posts();
                $posts->delete_post($postid);
            
                $_SESSION['message'] = 'Delete Post Successful';
                header("location: veterinaryProfile.php");
                exit;
            } else {
            
                $_SESSION['message'] = 'Post not Found';
                header("location: veterinaryProfile.php");
                exit;
            }

            if(!$users_d){
                header("Location: log-in.php");
                die;
            }
        } else {
            // Handle other user types or show an error
            echo "Unknown user type!";
        }
    } else {
        header("Location: log-in.php");
        die;
    }
} else {
    header("Location: log-in.php");
    die;
}


?>
