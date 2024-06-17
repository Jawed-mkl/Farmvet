<?php
include("classes/autoload.php");

// Check if the user is logged in
if (isset($_SESSION['users_id']) && is_numeric($_SESSION['users_id'])) {
    $id = $_SESSION['users_id'];
    $login = new login();
    $result = $login->check_login($id);

    if (is_array($result) && array_key_exists('error', $result)) {
        // Handle the error case
        echo "Error: " . $result['error'];
        exit;
    } elseif ($result) {
        $type = $result['type'];

        // Redirect based on user type
        if ($type === 'farmer') {
            $users = new users_data();
            $users_d = $users->get_farmer_data($id);

            if (!$users_d) {
                header("Location: log-in.php");
                die;
            }
        } elseif ($type === 'veterinary') {
            header("Location: veterinary.php");
            die;
        } else {
            // Handle other user types or show an error
            echo "Unknown user type!";
            exit;
        }
    } else {
        header("Location: log-in.php");
        die;
    }
} else {
    header("Location: log-in.php");
    die;
}

$error_msg = "";
$ERROR = "";

$image = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
if (file_exists($users_d['image'])) {
    $image = $users_d['image'];
}

$user = new users_data();
if (isset($_GET['id'])) {
    
    $info = $user->get_info_post($_GET['id']);
    $_SESSION['receiver'] = $info['user_id'];

    if (!$info) {
        $ERROR = "No Such user Was Found";
    } else {
        if ($info['user_id'] != $_SESSION['users_id']) {
            $ERROR = "Access denied! You can't edit this user!";
        }
    }
} else {
    $ERROR = "No Such user Was Found!";
}

    $messages = new Messages();

    if(isset($_GET['id']) && $_GET['id'] == "new"){

        $old_thread = $messages->read($_SESSION['receiver']);
        if(is_array($old_thread)){

            header("Location: messages.php?id=" . $_SESSION['receiver']);
            die;
        }
    } 

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $ERROR = $messages->send($_POST, $_FILES);

        header("Location: messages.php?id=" . $_SESSION['receiver']);

        die;
    } else {
        // Handle the case where $_SESSION['receiver'] is not set
        $ERROR = "Receiver not found in session!";
    }

    $imges = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
    if(!empty($info['img'])){
        $imges = $info['img'];
    }
    $user = new users_data();
    $id = $_SESSION['users_id'];
    $vet = $user->get_vet($id);

    //collect pub
    $pub = new admin();
    $id = $_SESSION['users_id'];
    $pubs = $pub->get_pubs($id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>messages</title>
    <link rel="stylesheet" href="css/all.min.css" />

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/messages.css">
    <link rel="stylesheet" href="css/log-out.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;500&#038;display=swap" rel="stylesheet" />
</head>
<body>
    <div class="page ">
        
        <div class="sidebar">
            <div class="fix-sidebar">
                <h3 class="title">FarmVet</h3>
                <ul>
                    <li>
                    <a class="" href="farmer.php">
                        <i class="fa-solid fa-house fa-fw"></i>
                        <span>Home</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="farmerProfile.php">
                        <i class="fa-regular fa-user fa-fw"></i>
                        <span>Profile</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="all_vet.php">
                        <i class="fa-solid fa-user-doctor fa-fw"></i>
                        <span>veterinarians</span>
                    </a>
                    </li>
                    <li>
                    <a class="active" href="messages.php">
                        <i class="fa-solid fa-comments fa-fw"></i>
                        <span>Messages</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="farmer_shop.php">
                    <i class="fa-solid fa-store"></i>
                        <span>Store</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="contactf.php">
                        <i class="fa-solid fa-envelope fa-fw"></i>
                        <span>Contact Us</span>
                    </a>
                    </li>
                </ul>
                <div class="language">
                        <div class="language-selected" data-i18n="language">
                            Language
                        </div>
                        <ul class="ul">
                            <li class="li"><a href="#" class="en" onclick="changeLanguage('en')" data-i18n="en" selected>English</a></li>
                            <li class="li"><a href="#" class="fr" onclick="changeLanguage('fr')" data-i18n="fr">French</a></li>
                            <li class="li"><a href="#" class="ar" onclick="changeLanguage('ar')" data-i18n="ar">Arabic</a></li>
                        </ul>
                </div>
                <div class="box">
                    <img src="<?php echo $image; ?>" alt="">
                    <div class="info">
                        <span>@<?php echo $users_d['firstn'] . $users_d['lastn'] ?>
                            <br>
                            <p>Farmer</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="content">

        <div class="box1">
            
            <div class="head-box">
                <div class="title">
                    <a href="messages.php" class="active">messages</a>
                    <a href="all_vet.php" class="">veterinarians</a>
                    <span class="notification">
                        <i class="fa-regular fa-bell fa-lg"></i>
                    </span>
                </div>
            </div>
            <div class="body-box">
               
                <h2>Chat :</h2>          
                <div class="chat-container">
                    <div class="chat-sidebar">
                        <div class="search-bar">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" placeholder="Search...">
                        </div>
                        <?php
                            if($vet){

                                foreach ($vet as $vet_row){
                                    $user = new users_data();
                                    $row = $user->get_info_post($vet_row['user_id']);
                                    $img = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
                        ?>
                        <div class="contacts">
                            <a class="contact" href="messages.php?id=<?php echo $vet_row['user_id']; ?>" style="color: black;">
                                
                                <img src="<?php if(empty($vet_row['image'])){
                                            echo $img;
                                        }
                                        else {
                                            echo $vet_row['image'];
                                        } ?>" >
                                <div class="contact-info">
                                    <span class="contact-name"><?php echo $vet_row['firstn'] . " " . $vet_row['lastn'] ?></span>
                                    <span class="contact-status"><?php echo $row['type'] ?></span>
                                </div>
                            </a>
                            
                        </div>
                    <?php
                        }
                    }
                    ?>
                    </div>
                    
                    <div class="chat-area">
                        <div class="chat-header">
                            <img src="<?php echo $imges; ?>" alt="Khalid Charif">
                            <div class="chat-info">

                                <span class="chat-name"><?php echo $info['firstn'] . ' ' . $info['lastn'] ?></span>


                                <span class="chat-details"><?php echo $info['type'] ?></span>
                            </div>
                            <div class="chat-actions">
                                <button><i class="fa-solid fa-video"></i></button>
                                <button><i class="fa-solid fa-phone"></i></button>
                            </div>
                        </div>
                        <div class="messages">
                            <?php

                                        $data = $messages->read($_SESSION['receiver']);

                                        echo '
                                        <div>';

                                            if(is_array($data)){
                                                foreach ($data as $msg) {
                                                    $user = new users_data();   
                                                    $row_info = $user->get_info_post($_SESSION['users_id']);
                                                    $row_info_receiver = $user->get_info_post($_SESSION['receiver']);
                                                    if(i_own_content($msg)){
                                                        include "right_msg.php";
                                                    }else{

                                                        include "left_msg.php";
                                                }
                                                    
                                                }
                                            }

                                        echo '
                                        </div>';


                            ?>
                            
                        </div>
                        <div class="message-input">
                                <form method="post" enctype="multipart/form-data">
                                    <i class="fa-solid fa-circle-plus"></i>
                                    <input class="file" type="file" name="file">
                                    <textarea type="text" placeholder="Type your message..." name="message" ></textarea>
                                    <input value="➤" class="button">
                                    <input class="submit" type="submit" value="Send">
                                </form>
                            
                        </div>
                    </div>
                </div>
                
                <?php
                    echo "<div style='color: red;font-size: 16px;font-weight: bold;margin: 50px';>";
                    echo $error_msg ;
                    echo "</div>";
                ?>
                
                

            </div>
        </div>

        <div class="box2">
            <div class="head-box">
                <div class="search ">
                    <input class="p-10" type="search" placeholder="Type A Keyword" />
                    <button class="Btn">
                        <div class="sign"><svg viewBox="0 0 512 512"><path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path></svg></div>
                        <a href="logout.php" class="text" >Logout</a>
                    </button>
                </div>
            </div>
            <div class="body-box">
            <?php
                    if($pubs){
                        $count = 1;
                        foreach ($pubs as $rowss){
?>
                        <div class="pub">
                            <h1 style="text-decoration: underline;color: red;font-size: 16px;">publication <?php echo $count; ?>:</h1>
                            <div class="title">
                                <h3><?php echo $rowss['title']; ?></h3>
                                <span><?php echo $rowss['date']; ?></span>
                            </div>
                            <span><?php echo $rowss['texte']; ?></span>
                            <img src="<?php echo $rowss['image']; ?>" alt="">

                        </div>
                            
                            <?php
                        }
                    }
                    
                ?>
                
            </div>

        </div>
        
        </div>
    </div>

    

</body>
</html>