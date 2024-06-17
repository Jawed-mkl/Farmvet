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
        } elseif ($result) {
            $type = $result['type'];

            // Redirect based on user type
            if ($type === 'farmer') {
                $users = new users_data();
                $users_d = $users -> get_farmer_data($id);

                $post = new Posts();
                // Check if the post ID is set in the GET request
                if (isset($_GET['id'])) {
                    
                    $row = $post->get_one_post($_GET['id']);

                    if (!$row) {
                        $ERROR = "No Such Post Was Found";
                    } else {
                        // Check if the current user has permission to edit the post
                        if ($row['user_id'] != $_SESSION['users_id']) {
                            $ERROR = "Access denied! You can't edit this post!";
                        }
                    }
                } else {
                    $ERROR = "No Such Post Was Found!";
                }

                // Save the return URL to redirect after editing
                if (isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "edit.php")) {
                    $_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
                }

                // Handle form submission
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $result = $post->edit_post($_POST, $_FILES);

                    if ($result === "") {
                        header("Location: " . $_SESSION['return_to']);
                        die;
                    } else {
                        $ERROR = $result;
                    }
                }

                if(!$users_d){
                    header("Location: log-in.php");
                    die;
                }

                
            } elseif ($type === 'veterinary') {

                $users = new users_data();
                $users_d = $users -> get_vet_data($id);

                $post = new Posts();
                // Check if the post ID is set in the GET request
                if (isset($_GET['id'])) {
                    $row = $post->get_one_post($_GET['id']);

                    if (!$row) {
                        $ERROR = "No Such Post Was Found";
                    } else {
                        // Check if the current user has permission to edit the post
                        if ($row['user_id'] != $_SESSION['users_id']) {
                            $ERROR = "Access denied! You can't edit this post!";
                        }
                    }
                } else {
                    $ERROR = "No Such Post Was Found!";
                }

                // Save the return URL to redirect after editing
                if (isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "edit.php")) {
                    $_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
                }

                // Handle form submission
                if ($_SERVER['REQUEST_METHOD'] == "POST") {
                    $result = $post->edit_post($_POST, $_FILES);

                    if ($result === "") {
                        header("Location: " . $_SESSION['return_to']);
                        die;
                    } else {
                        $ERROR = $result;
                    }
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
    $error_msg = "";
    $ERROR = "";

    $image = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
    if(file_exists($users_d['image'])){
        $image = $users_d['image'];
    }

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
    <title>Farmer Profile</title>
    <link rel="stylesheet" href="css/all.min.css" />

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/user_profile.css">
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
                    <a class="active" href="farmerProfile.php">
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
                    <a class="" href="messages.html">
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
                    <a class="" href="contact.html">
                        <i class="fa-solid fa-envelope fa-fw"></i>
                        <span>Contact Us</span>
                    </a>
                    </li>
                </ul>
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
                    <a href="farmer.php" class="active">Edit</a>
                    <a href="all_vet.php" class="">---</a>
                    <span class="notification">
                        <i class="fa-regular fa-bell fa-lg"></i>
                    </span>
                </div>
            </div>
            <div class="body-box">
                
                <?php
                    echo "<div style='color: red;font-size: 16px;font-weight: bold;margin: 50px';>";
                    echo $error_msg ;
                    echo "</div>";
                ?>
                
                
                <form method="POST" enctype="multipart/form-data">
        <?php
        if ($ERROR != "") {
            echo "<div style='color: red;'>$ERROR</div>";
        } else {
            echo "<div class='edit-post' style='width: 650px; margin: 100px auto 0;'>";
            echo "<h2 style='color: white; text-decoration: underline;'>Editing your post :</h2>";
            echo "<br>";
            echo "<div class='info'>";
            echo '<textarea name="post" style="width: 80%; background: transparent; resize: none; height: 50px;
                                                    border: none; border-left: 1px solid black;
                                                    border-bottom: 1px solid black; color: white;
                                                    font-size: 18px;">' . htmlspecialchars($row['post']) . '</textarea>';
            echo "</div>";
            echo "<input type='hidden' name='post_id' value='" . htmlspecialchars($row['post_id']) . "'>";
            echo "<input type='file' name='file' style='margin: 10px 0;'>";
            
            if ($row['has_image'] == 1) {
                $img = htmlspecialchars($row['image']);
                echo "<img src='$img' style='width: 80%; display: block; margin: 0 0 10px 0;'/>";
            }
            
            echo "<input type='submit' id='post_button' value='Save' 
                                        style='margin-left: auto;
                                                width: fit-content;
                                                color: white;
                                                background-color: #c59522;
                                                border-radius: 6px;
                                                border: 0;
                                                padding: 4px 12px;
                                                cursor: pointer;'>";
            echo "</div>";
        }
        ?>
    </form>
                
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