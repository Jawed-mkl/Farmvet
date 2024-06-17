<?php
session_start();
    include("classes/connect.php");
    include("classes/log-in.php");
    include("classes/users_data.php");
    include("classes/posts.php");
    include("classes/admin.php");
    $admin = new admin();

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
            if ($type === 'admin') {

                $users = new users_data();
                $users_d = $users -> get_info_post($id);

                if(!$users_d){
                    header("Location: log-in.php");
                    die;
                }
                
            }
            else {
                // Handle other user types or show an error
                echo "Unknown user type!";
                header("Location: log-in.php");
                    die;
            } 
        } else {
                // Handle other user types or show an error
            echo "Unknown user type!";
            header("Location: log-in.php");
            die;
        }
    } else {
            header("Location: log-in.php");
            die;
    }

    //Start posts
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $post = new admin();
        $id = $_SESSION['users_id'];
        // Pass $_FILES along with $_POST to create_post method
        $result = $post->create_publication($id, $_POST, $_FILES);

        if($result == ""){
            header("Location: admin.php");
            die;
        }
        else {
            $error_msg = $result;
        }

    }
    $user_id = $_SESSION['users_id'];
    $publication_count = $admin->count_publications($user_id);

    $info = new users_data();

    $row = $info->get_info_post($user_id);

    $image = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
    if(file_exists($row['img'])){
        $image = $row['img'];
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="css/all.min.css" />
    <link rel="stylesheet" href="css/lights.css" id="light-mode-stylesheet">
    <link rel="stylesheet" href="css/dark.css" id="dark-mode-stylesheet" disabled>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&#038;display=swap" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <title>Dashboard admin</title> 
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="<?php echo $image; ?>" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name"><?php echo $row['firstn'] . " " . $row['lastn']; ?></span>
                    <span class="profession"><?php echo $row['mail']; ?></span>
                </div>
            </div>

            <i class='bx bx-chevron-right toggle'></i>
        </header>

        <div class="menu-bar">
            <div class="menu">

                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search...">
                </li>

                <ul class="menu-links">
                <li class="nav-link">
                        <a href="admin.php">
                            <i class="fa-solid fa-house icon"></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="admin_settings.php">
                            <i class='bx bxs-cog icon'></i>
                            <span class="text nav-text">Settings</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="admin_contact.php">
                            <i class="fa-solid fa-envelope icon"></i>
                            <span class="text nav-text">Contact Us</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="logout.php">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
                
            </div>
        </div>

    </nav>

    <section class="home">
        <!-- Start Head -->
        <div class="head ">
            <div class="search ">
             <img src="imgs/Farmvetlogo_white.png" alt="">
            </div>
            <div class="icons ">
              <img src="<?php echo $image; ?>" alt="" />
            </div>
          </div>
          <!-- End Head -->

        <h2>Dashboard</h2>
        <div class="main">
                    <ul class="box-info">
                        <li>
                            <i class="fa-solid fa-user"></i>
                            <span class="text">
                                <h3><?php $admin->farmer_number(); ?></h3>
                                <p>Farmer</p>
                            </span>
                        </li>
                        <li>
                            <i class="fa-solid fa-user-doctor"></i>
                            <span class="text">
                                <h3><?php $admin->vet_number(); ?></h3>

                                <p>Veterinary</p>
                            </span>
                        </li>
                        <li>
                            <i class="fa-solid fa-file-export"></i>
                            <span class="text">
                                <h3><?php echo "Total number of publications: " . $publication_count; ?></h3>
                                <p></p>
                            </span>
                        </li>
                    </ul>
        </div>			
        <div class="post">
            <div class="form-container" id="add-card">
                <form class="form" method="post" enctype="multipart/form-data">
                    <span class="heading">Add publication</span>
                    <input placeholder="Title" type="text" class="input" name="title">

                    <div class="input-file">
                        <input type="file" name="image" class="file">
                        <i class="fa-regular fa-file-image fa-2x"></i>
                    </div>
                    <textarea placeholder="Type your publication..." rows="10" cols="40" id="message" name="texte" class="textarea"></textarea>
                    <div class="button-container">
                        <input class="send-button" type="submit" value="Add publication">
                        
                    </div>
                </form>
            </div>
        </div>
        
            <?php
                $id = $_SESSION['users_id'];
                $pub = new admin();
                $rows = $pub->get_admin_pub($id);

                if($rows){

                    foreach ($rows as $row_pub){ 

                ?>
            <div class="display">
                <div class="display-post">
                    <div class="title">
                        <h2><?php echo $row_pub['title']; ?></h2>
                        <span><?php echo $row_pub['date']; ?></span>
                    </div>
                    <div class="texte"><?php echo $row_pub['texte']; ?></div>
                    <img src="<?php echo $row_pub['image']; ?>" alt="">
                </div>
            </div>


            <?php
                        
                    }
                }
            ?>
            
        
    </section>

    <script src="js/admin.js"></script>

</body>
</html>