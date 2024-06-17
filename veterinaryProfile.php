<?php
include("classes/autoload.php");

if (isset($_SESSION['users_id']) && is_numeric($_SESSION['users_id'])) {
    $id = $_SESSION['users_id'];
    $login = new login();
    $result = $login->check_login($id);

    if (is_array($result) && array_key_exists('error', $result)) {
        echo "Error: " . $result['error'];
    } elseif ($result) {
        $type = $result['type'];

        if ($type === 'farmer') {
            header("Location: farmer.php");
            die;
        } elseif ($type === 'veterinary') {
            $users = new users_data();
            $users_d = $users->get_vet_data($id);

            if(!$users_d){
                header("Location: log-in.php");
                die;
            }
        } else {
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

if ($_SERVER['REQUEST_METHOD'] == "POST" ) {

    $firstn = $_POST['firstn'];
    $lastn = $_POST['lastn'];
    $mail = $_POST['mail'];

    $password = $_POST['password'];
    $password = hash("sha1", $password);

    $loc = $_POST['location'];
    $bio = $_POST['bio'];
    $date = $_POST['date'];

    $targetDir = "uploads/"; // Directory where images will be stored
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if ($_FILES["image"]["tmp_name"]) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            // Image is valid, move it to the target directory
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
            $imagePath = $targetFile; // Save the path of the uploaded image
        } else {
            echo "Error: File is not an image.";
            exit;
        }
    } else {
        $imagePath = ""; // No image uploaded, set image path to empty
    }


    $userid = $users_d['user_id'];
    if(!empty($imagePath)){
        $query = "UPDATE veterinary 
                SET firstn='$firstn', lastn='$lastn', mail='$mail',
                password='$password', image='$imagePath', location='$loc',date='$date', bio='$bio' 
                WHERE user_id='$userid' LIMIT 1";
    }
    else {
    $query = "UPDATE veterinary 
                SET firstn='$firstn', lastn='$lastn', mail='$mail',
                password='$password', location='$loc',date='$date', bio='$bio' 
                WHERE user_id='$userid' LIMIT 1";
    }

    $query2 = "UPDATE users 
                SET firstn='$firstn', lastn='$lastn', mail='$mail',
                password='$password', img='$imagePath' WHERE user_id='$userid' LIMIT 1";

    $db = new Database(); // Assuming you have a Database class
    $db->save($query); // Assuming you have a method to execute SQL queries
    $db->save($query2);
    header("Location: veterinaryProfile.php");
    exit;
}


$image = "imgs/1000_F_346839683_6nAPzbhpSkIpb8pmAwufkC7c5eD7wYws.jpg";
if (file_exists($users_d['image'])) {
    $image = $users_d['image'];
}

$post = new Posts();
$id = $_SESSION['users_id'];
$posts = $post->get_posts_user($id);

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
    <title>veterinary Profile</title>
    <link rel="stylesheet" href="css/all.min.css" />

    <link rel="stylesheet" href="css/styles.css">
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
                    <a class="" href="veterinary.php">
                        <i class="fa-solid fa-house fa-fw"></i>
                        <span>Home</span>
                    </a>
                    </li>
                    <li>
                    <a class="active" href="veterinaryProfile.php">
                        <i class="fa-regular fa-user fa-fw"></i>
                        <span>Profile</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="vet_msg.php">
                        <i class="fa-solid fa-comments fa-fw"></i>
                        <span>Messages</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="vet_store.php">
                        <i class="fa-solid fa-store"></i>
                        <span>Store</span>
                    </a>
                    </li>
                    <li>
                    <a class="" href="contactv.php">
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
                            <p>veterinary</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="content">

        <div class="box1">
            
            <div class="head-box">
                <div class="title">
                    <a href="veterinary.php" class="">Home</a>
                    <a href="veterinaryProfile.php" class="active">Your Profile</a>
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
                <div class="card" id="card">

                    <div class="info">
                    <img src="<?php echo $image; ?>" alt="">
                    <h2><?php echo $users_d['firstn'] . " " . $users_d['lastn'] ?></h2>
                    <p>veterinary</p>
                    </div>

                    <div class="text">
                        <span>Your Id:</span>
                        <p><?php echo $users_d['user_id'] ?></p>
                    </div>
                    <div class="text">
                        <span>E-mail:</span>
                        <p><?php echo $users_d['mail']?></p>
                    </div>
                    <div class="text">
                        <span>Date of birth:</span>
                        <p><?php echo $users_d['date']?></p>
                    </div>
                    <div class="text">
                        <span>location:</span>
                        <p><?php echo $users_d['location'] ?></p>
                    </div>
                    <div class="text">
                        <span>Bio:</span>
                        <p><?php echo $users_d['bio']?></p>
                    </div>

                    <input id="showupdatecard" type="submit" class="button" value="Update">
                    

                </div>

                <form action="#" method="POST" enctype="multipart/form-data">
                
                    <div class="update-card" id="update-card">
                        <span id="close-card" class="close-icon">
                            <i class="fa-solid fa-xmark"></i>
                        </span>
                        <h1>Update Your Info</h1>
                        

                        <div class="lab">
                            <label>The New Image:</label>
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                <input class="upload" type="file" name="image" >

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

                        <div class="lab">
                            <label >bio:</label>
                            <input type="text" name="bio" value="<?php echo $users_d['bio']; ?>">
                            
                        </div>
                        <br>

                        <div class="lab">
                            <label >date of birth</label>
                            <input type="date" name="date" value="<?php echo $users_d['date'] ?>">
                        </div>
                        <br>

                        <div class="lab">
                            <label for="location">location:</label>
                            <input type="text" name="location" value="<?php echo $users_d['location'] ?>">
                        </div>
                        <br>


                        <input class="button" type="submit" name="update" value="Update">
                        
                    </div>

                </form>


                <?php
                    if($posts){
                        foreach ($posts as $row){ 

                            $users = new users_data();
                            $row_users = $users->get_info_post($row['user_id']);
                            $row_farmer = $users->get_farmer_data($row['user_id']);
                            $row_vet = $users->get_vet_data($row['user_id']);

                            include("user_posts.php");
                        }
                    }
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

    <script>

            const card = document.getElementById('card');
            const updateCard = document.getElementById('update-card');
            const showupdatecard = document.getElementById('showupdatecard');
            const hide = document.getElementById('close-card');
            showupdatecard.addEventListener('click', function (event) {
            
                event.preventDefault();
                updateCard.style.display = 'block';
            });

            hide.addEventListener('click', function (event) {
            
            event.preventDefault();
            updateCard.style.display = 'none';
            });



    </script>
    

</body>
</html>