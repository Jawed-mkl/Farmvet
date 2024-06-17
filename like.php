<?php
session_start();
include("classes/connect.php");
include("classes/log-in.php");
include("classes/users_data.php");
include("classes/posts.php");

function handle_login_error($error) {
    echo "Error: " . $error;
    die;
}

function get_redirect_url($default) {
    return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $default;
}

function handle_like_action($id, $type, $user_id) {
    $allowed = ['post', 'user', 'comment'];
    if (is_numeric($id) && in_array($type, $allowed)) {
        $post = new Posts();
        $post->like_post($id, $type, $user_id);
    }
}

function redirect_to($url) {
    header("Location: " . $url);
    die;
}

function handle_user_type($type, $id, $default_redirect) {
    $users = new users_data();
    $redirect_url = get_redirect_url($default_redirect);

    if ($type === 'farmer') {
        $user_data = $users->get_farmer_data($id);
    } elseif ($type === 'veterinary') {
        $user_data = $users->get_vet_data($id);
    } else {
        echo "Unknown user type!";
        die;
    }

    if (!$user_data) {
        redirect_to("log-in.php");
    }

    if (isset($_GET['type']) && isset($_GET['id'])) {
        handle_like_action($_GET['id'], $_GET['type'], $_SESSION['users_id']);
    }

    redirect_to($redirect_url);
}

// Check if the user is logged in
if (isset($_SESSION['users_id']) && is_numeric($_SESSION['users_id'])) {
    $id = $_SESSION['users_id'];
    $login = new login();
    $result = $login->check_login($id);

    if (is_array($result) && array_key_exists('error', $result)) {
        handle_login_error($result['error']);
    } elseif ($result) {
        handle_user_type($result['type'], $id, $result['type'] === 'farmer' ? 'farmer.php' : 'veterinary.php');
    } else {
        redirect_to("log-in.php");
    }
} else {
    redirect_to("log-in.php");
}
?>
