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
    if ($_SERVER['REQUEST_METHOD'] == "POST" ) {

        $firstn = $_POST['firstn'];
        $lastn = $_POST['lastn'];
        $mail = $_POST['mail'];

        $password = $_POST['password'];
        $password = hash("sha1", $password);

        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
        if ($_FILES["image"]["tmp_name"]) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {

                move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
                $imagePath = $targetFile; // Save the path of the uploaded image
            } else {
                echo "Error: File is not an image.";
                exit;
            }
        } else {
            $imagePath = ""; 
        }

        $userid = $users_d['user_id'];

        $query = "UPDATE users 
                    SET firstn='$firstn', lastn='$lastn', mail='$mail',
                    password='$password', img='$imagePath' WHERE user_id='$userid' LIMIT 1";

        $db = new Database(); 
        $db->save($query); 

        header("Location: admin_settings.php");
        exit;

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

        <h2>Settings</h2>
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

            <form action="#" method="POST" enctype="multipart/form-data">

                <div class="update-card" id="update-card">

                    <h1>Update Your Info</h1>
                    

                    <div class="lab">
                        <label>The New Image:</label>
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <input class="upload" type="file" name="image" id="image">

                    </div>
                    <br>

                    <div class="lab">
                        <label>First Name:</label>
                        <input type="text" name="firstn" value="<?php echo $users_d['firstn'] ?>">
                    </div>
                    <br>

                    <div class="lab">
                        <label >Last Name:</label>
                        <input type="text" name="lastn" value="<?php echo $users_d['lastn'] ?>">
                    </div>
                    <br>

                    <div class="lab">
                        <label>Email:</label>
                        <input type="mail" name="mail" value="<?php echo $users_d['mail'] ?>">
                    </div>
                    <br>

                    <div class="lab">
                        <label >Password:</label>
                        <input type="password" name="password" value="">
                    </div>
                    <br>

                    <br>
                    <br>
                    <input class="button" type="submit"  value="Update">
                    
                </div>

                </form>
            </div>
        </div>
    </section>

    <script src="js/admin.js"></script>

</body>
</html>