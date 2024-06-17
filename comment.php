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

                if(!$users_d){
                    header("Location: log-in.php");
                    die;
                }
                
            } elseif ($type === 'veterinary') {

                $users = new users_data();
                $users_d = $users -> get_vet_data($id);

                if(!$users_d){
                    header("Location: log-in.php");
                    die;
            } 
        } else {
            header("Location: log-in.php");
            die;
        }
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
     //collect posts
    $post = new Posts();
    $id = $_SESSION['users_id'];
    $posts = $post->get_posts($id);

    if (isset($_GET['id'])) {
                    
        $comment = $post->get_one_post($_GET['id']);

        $users = new users_data();
        $row_comment = $users->get_info_post($comment['user_id']);
        $commentf = $users->get_farmer_data($comment['user_id']);
        $commentv = $users->get_vet_data($comment['user_id']);

        if (!$comment) {
            $ERROR = "No Such Post Was Found";
        } else {
            // Check if the current user has permission to edit the post
            if ($comment['user_id'] != $_SESSION['users_id']) {
                $ERROR = "Access denied! You can't edit this post!";
            }
        }
    } else {
        $ERROR = "No Such Post Was Found!";
    }

    $users = new users_data();
    $row_users = $users->get_info_post($comment['user_id']);

    if($_SERVER['REQUEST_METHOD'] == "POST"){


        $id = $_SESSION['users_id'];
        // Pass $_FILES along with $_POST to create_post method
        $result = $post->create_post($id, $_POST, $_FILES);

        if($result == ""){
            
            $check = $row_users['type'];
            if($check === 'farmer'){
                header("Location: farmer.php");
                die;
            }
            elseif($check === 'veterinary'){
                header("Location: veterinary.php");
                die;
            }
            
        }
        else {
            $error_msg = $result;
        }

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
    <link rel="stylesheet" href="css/comment.css">

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
                    <a class="active" href="#">
                        <i class="fa-solid fa-house fa-fw"></i>
                        <span>Home</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="#">
                        <i class="fa-regular fa-user fa-fw"></i>
                        <span>Profile</span>
                    </a>
                    </li>
                    
                        <?php
                        $id = $_SESSION['users_id'];
                        $login = new login();
                        $result = $login->check_login($id);
                        $type = $result['type'];
                        if($type === 'farmer'){
                            echo '<li>
                                    <a class="" href="#">
                                        <i class="fa-solid fa-user-doctor fa-fw"></i>
                                        <span>veterinarians</span>
                                    </a>
                                </li>';
                        }
                        ?>
                    
                    
                    <li>
                    <a class="" href="#">
                        <i class="fa-solid fa-comments fa-fw"></i>
                        <span>Messages</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="#">
                    <i class="fa-solid fa-store"></i>
                        <span>Store</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="#">
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
                    <a href="farmer.php" class="active">Comment</a>
                    <a href="all_vet.php" class="">---</a>
                    <span class="notification">
                        <i class="fa-regular fa-bell fa-lg"></i>
                    </span>
                </div>
            </div>
            <div class="body-box">
                <div class="post">
                    <form >
                        <div class="text">
                            <img src="<?php echo $image; ?>" alt="">
                            <div class="input-field">
                                <textarea name="post" cols="30" rows="3" placeholder="What's new"></textarea>
                            </div>
                        </div>
                        <div class="posting">
                            <div class="icons">
                                <div class="input-div">
                                    <input name="image" type="file">
                                </div>
                                <i class="fa-solid fa-face-smile-beam"></i>
                            </div>
                            <?php
                                echo "<div style='color: red;font-size: 12px;margin: 0 0 5px 0'>";
                                echo $error_msg ;
                                echo "</div>";
                            ?>
                            <div class="button">
                                <input type="submit" value="Share">
                            </div>
                        </div>
                    </form>
                </div>

                <?php
                    if($posts){

                        foreach ($posts as $row){ 

                            $users = new users_data();
                            $row_users = $users->get_info_post($row['user_id']);
                            $row_farmer = $users->get_farmer_data($row['user_id']);
                            $row_vet = $users->get_vet_data($row['user_id']);
                            

                            include("post.php");
                        }
                    }
                    
                ?>

                <div id="comment" class="comment" >
                    <div class="one-comment">
                        <div class="info">
                            <?php
                        $img = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
                        if (isset($row_comment['type'])) {
                                if ($row_comment['type'] === 'farmer' && isset($commentf['image']) && file_exists($commentf['image'])) {
                                    $img = $commentf['image'];
                                } elseif ($row_comment['type'] === 'veterinary' && isset($commentv['image']) && file_exists($commentv['image'])) {
                                    $img = $commentv['image'];
                                }
                            }
    ?>
                            <img src="<?php echo $img; ?>" alt="">
                            <span> @<?php echo $row_comment['firstn'] . " " . $row_comment['lastn'] ?> 
                                <br><p><?php echo $row_comment['type'] ?> </p>
                            </span>
                            <p><?php echo $comment['date'] ?></p>
                            <a id="close-card" class="close-icon" href="<?php echo $row_users['type']; ?>.php">
                                <i class="fa-solid fa-xmark" style= "color: white;" ></i>
                            </a>
                            
                        </div>
                        <div class="text">
                            <p><?php echo $comment['post'] ?></p>
                        </div>
                        <div class="image">
                            <?php if ($comment['has_image'] == 1): ?>
                                <img src="<?php echo $comment['image']; ?>" alt="">
                            <?php endif; ?>
                        </div>
                        <div class="icons">
                            <?php 
                                $likes = "";

                                if($comment['likes'] > 0){

                                    $likes = "(" .$comment['likes']. ")";
                                }
                                else {
                                    $likes = "";
                                }
                            ?>
                            <a class="like-button" href="like.php?type=post&id=<?php echo $row['post_id'] ?>">
                                <i id="heart-icon" class="heart-icon fa-regular fa-heart"></i>
                                <?php 
                                    echo "<div style='color: darkgray;font-size: 14px;margin: 0 15px 0 0'>";
                                    echo  $likes ;
                                    echo "</div>";
                                ?>
                                
                            </a>
                            <a id="comment-icon" class="like-button" href="comment.php?type=post&id=<?php echo $row['post_id'] ?>">
                                <i class="fa-regular fa-comment"></i>
                                <?php 
                                    echo "<div style='color: darkgray;font-size: 14px;margin: 0 15px 0 0'>";

                                    echo "</div>";
                                ?>
                                
                            </a>
                            
                        </div>
                    </div>
                    <div class="display-comment">
                        <?php
                        
                            $comments = $post->get_comment($comment['post_id']);
                            if(is_array($comments)){
                                foreach ($comments as $comment_row){
                                    $users = new users_data();
                                    $row_users = $users->get_info_post($comment_row['user_id']);
                                    $img = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
                                    if(file_exists($row_users['img'])){
                                        $img = $row_users['img'];
                                    }
                        ?>
                                    <div class="post-list">
                                    <div class="info">
                                        <img src="<?php echo $img; ?>" alt="">
                                        <span> @<?php echo $row_users['firstn'] . " " . $row_users['lastn'] ?> 
                                            <br><p><?php echo $row_users['type'] ?> </p>
                                        </span>
                                        <p><?php echo $comment_row['date'] ?></p>
                                        <span class="setting" style="display: flex;">
                                            <p style="margin-right: 10px;">
                                            <?php
                                                echo "<a style='color: red;'  onClick=\" javascript:return confirm('Are You Sur To DELETE This comment')\" href='delete_post.php?postid={$comment_row['post_id']}'>Delete</a>";
                                            ?>
                                            </p>
                                        </span>
                                        
                                        
                                    </div>
                                    <div class="text">
                                        <p styyle="color: black;"><?php echo $comment_row['post'] ?></p>
                                    </div>
                                    <div class="image">
                                        <?php if ($comment_row['has_image'] == 1): ?>
                                            <img src="<?php echo $comment_row['image']; ?>" style="width: 650px;margin: 5px auto !important;">
                                        <?php endif; ?>
                                    </div>
                                    <div class="icons">
                                        <?php 
                                            $likes = "";
                            
                                            if($comment_row['likes'] > 0){
                            
                                                $likes = "(" .$comment_row['likes']. ")";
                                            }
                                            else {
                                                $likes = "";
                                            }
                                        ?>
                                        <a class="like-button" href="like.php?type=post&id=<?php echo $comment_row['post_id'] ?>">
                                            <i id="heart-icon" class="heart-icon fa-regular fa-heart"></i>
                                            <?php 
                                                echo "<div style='color: darkgray;font-size: 14px;margin: 0 15px 0 0'>";
                                                echo  $likes ;
                                                echo "</div>";
                                            ?>
                                            
                                        </a>
                                        <a id="comment-icon" class="like-button" href="comment.php?type=post&id=<?php echo $comment_row['post_id'] ?>">
                                            <i class="fa-regular fa-comment"></i>
                                            <?php 
                                                echo "<div style='color: darkgray;font-size: 14px;margin: 0 15px 0 0'>";
                            
                                                echo "</div>";
                                            ?>
                                            
                                        </a>
                                        
                                    </div>
                                </div>
                        <?php
                                }
                            }


                        ?>

                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="messageBox">
                            <div class="fileUploadWrapper">
                                <label for="file">
                                <i class="add fa-solid fa-circle-plus"></i>
                                    <span class="tooltip">Add an image</span>
                                </label>
                                <input type="file" id="file" name="file" />
                            </div>
                            <input class="input" required placeholder="Write here..." type="text" name="post"/>
                            <input type="hidden" name="parent" value="<?php echo $comment['post_id']; ?>">
                            <input class="submit" type="submit" id="sendButton" value="Send">
                            <label for="sendButton">
                                <i class="send fa-solid fa-paper-plane"></i>
                            </label>
                        </div>
                    </form>





                </div>

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